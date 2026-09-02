(() => {
    'use strict';

    const state = {
        manifest: null,
        currentId: null,
        abortController: null,
        toastTimer: null,
        journalMode: 'pages',
    };

    const dom = {};

    document.addEventListener('DOMContentLoaded', init);

    async function init() {
        cacheDom();
        bindEvents();
        setLoading('Загружаем карту документации…');

        const startedAt = performance.now();
        console.log('[WM Docs] manifest:request', { url: '../manifest.json' });

        try {
            const response = { ok: true, manifest: await fetch('../manifest.json').then((r) => r.json()) };
            validatePublicManifest(response.manifest);
            state.manifest = response.manifest;
            renderNavigation();
            const requestedId = new URL(window.location.href).searchParams.get('doc');
            const defaultId = document.body.dataset.defaultDoc || state.manifest.site.defaultDocument;
            const firstId = hasDocument(requestedId) ? requestedId : defaultId;

            console.log('[WM Docs] manifest:success', {
                documents: Object.keys(state.manifest.documents).length,
                durationMs: Math.round(performance.now() - startedAt),
            });

            await navigate(firstId, { replace: !hasDocument(requestedId), focus: false });
        } catch (error) {
            console.error('[WM Docs] manifest:error', errorDetails(error));
            showFatalError('Карта документации не загрузилась.', () => window.location.reload());
        }
    }

    function cacheDom() {
        dom.navigation = document.querySelector('[data-navigation]');
        dom.document = document.querySelector('[data-document]');
        dom.context = document.querySelector('[data-context]');
        dom.breadcrumbs = document.querySelector('[data-breadcrumbs]');
        dom.status = document.querySelector('[data-status]');
        dom.search = document.querySelector('[data-search]');
        dom.docCount = document.querySelector('[data-doc-count]');
        dom.navToggle = document.querySelector('[data-nav-toggle]');
        dom.navScrim = document.querySelector('[data-nav-scrim]');
        dom.toast = document.querySelector('[data-toast]');
    }

    function bindEvents() {
        document.addEventListener('click', handleClick);
        dom.search.addEventListener('input', filterNavigation);
        dom.navToggle.addEventListener('click', () => setNavOpen(!document.body.classList.contains('nav-open')));
        dom.navScrim.addEventListener('click', () => setNavOpen(false));
        window.addEventListener('popstate', () => {
            const requestedId = new URL(window.location.href).searchParams.get('doc');
            if (hasDocument(requestedId)) {
                navigate(requestedId, { history: false, focus: false });
            }
        });
        window.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                setNavOpen(false);
            }
        });
    }

    function handleClick(event) {
        const docLink = event.target.closest('[data-doc-id]');
        if (docLink) {
            event.preventDefault();
            navigate(docLink.dataset.docId, { push: true, focus: true });
            setNavOpen(false);
            return;
        }

        const copyButton = event.target.closest('[data-copy-code]');
        if (copyButton) {
            copyCode(copyButton);
            return;
        }

        const retryButton = event.target.closest('[data-retry-document]');
        if (retryButton && state.currentId) {
            navigate(state.currentId, { history: false, focus: false });
            return;
        }

        const journalModeButton = event.target.closest('[data-journal-mode]');
        if (journalModeButton) {
            state.journalMode = journalModeButton.dataset.journalMode;
            renderJournalExplorer();
            console.log('[WM Docs] journal:group-mode', { mode: state.journalMode });
        }
    }

    async function navigate(id, options = {}) {
        if (!hasDocument(id)) {
            console.error('[WM Docs] navigation:unknown-document', { id });
            showToast('Документ отсутствует в карте man.');
            return;
        }

        if (state.abortController) {
            state.abortController.abort();
        }

        state.abortController = new AbortController();
        state.currentId = id;
        updateActiveNavigation();
        setLoading(`Загружаем «${state.manifest.documents[id].title}»…`);
        const startedAt = performance.now();

        if (options.push || options.replace) {
            const url = new URL(window.location.href);
            url.searchParams.set('doc', id);
            window.history[options.replace ? 'replaceState' : 'pushState']({ doc: id }, '', url);
        }

        console.log('[WM Docs] document:request', { id });

        try {
            const documentData = state.manifest.documents[id];
            const markdown = await fetch(`../${documentData.file}`, { signal: state.abortController.signal }).then((r) => r.text());
            const asideMarkdown = documentData.aside
                ? await fetch(`../${documentData.aside}`, { signal: state.abortController.signal }).then((r) => r.text())
                : '';
            const response = { id, document: documentData, markdown, asideMarkdown };

            if (id !== state.currentId) {
                return;
            }

            renderDocument(response);
            console.log('[WM Docs] document:success', {
                id,
                status: response.document.status,
                bytes: response.markdown.length + response.asideMarkdown.length,
                durationMs: Math.round(performance.now() - startedAt),
            });

            if (options.focus) {
                document.querySelector('#document').focus({ preventScroll: true });
            }
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } catch (error) {
            if (error.name === 'AbortError') {
                console.log('[WM Docs] document:aborted', { id });
                return;
            }
            console.error('[WM Docs] document:error', { id, ...errorDetails(error) });
            showDocumentError('Не удалось прочитать документ.');
        }
    }

    async function fetchJson(url, options = {}) {
        const response = await fetch(url, {
            credentials: 'same-origin',
            headers: { Accept: 'application/json' },
            ...options,
        });
        let payload = null;
        try {
            payload = await response.json();
        } catch (error) {
            throw makeHttpError(response.status, 'invalid-json', 'Сервер вернул некорректный JSON.');
        }
        if (!response.ok || !payload.ok) {
            const code = payload && payload.error ? payload.error.code : 'request-failed';
            const message = payload && payload.error ? payload.error.message : 'Запрос не выполнен.';
            throw makeHttpError(response.status, code, message);
        }
        return payload;
    }

    function makeHttpError(status, code, message) {
        const error = new Error(message);
        error.status = status;
        error.code = code;
        return error;
    }

    function validatePublicManifest(manifest) {
        const valid = manifest
            && manifest.site
            && typeof manifest.site.title === 'string'
            && typeof manifest.site.defaultDocument === 'string'
            && Array.isArray(manifest.sections)
            && manifest.documents
            && typeof manifest.documents === 'object'
            && manifest.documents[manifest.site.defaultDocument]
            && manifest.sections.every((section) => Array.isArray(section.items)
                && section.items.every((id) => Boolean(manifest.documents[id])));

        if (!valid) {
            throw makeHttpError(0, 'manifest-schema-invalid', 'Карта документации имеет некорректную структуру.');
        }
    }

    function errorDetails(error) {
        return {
            name: error.name,
            code: error.code || 'runtime-error',
            status: error.status || 0,
            message: error.message,
        };
    }

    function hasDocument(id) {
        return Boolean(id && state.manifest && state.manifest.documents[id]);
    }

    function renderNavigation() {
        dom.navigation.replaceChildren();
        const documentCount = Object.keys(state.manifest.documents).length;

        state.manifest.sections.forEach((section) => {
            const sectionElement = document.createElement('section');
            sectionElement.className = 'nav-section';
            sectionElement.dataset.sectionId = section.id;

            const title = document.createElement('h2');
            title.className = 'nav-section-title';
            title.textContent = section.title;
            sectionElement.appendChild(title);

            section.items.forEach((id) => {
                const documentData = state.manifest.documents[id];
                if (!documentData) {
                    console.warn('[WM Docs] manifest:missing-nav-document', { section: section.id, id });
                    return;
                }
                const link = document.createElement('a');
                link.className = 'nav-link';
                link.href = `?doc=${encodeURIComponent(id)}`;
                link.dataset.docId = id;
                link.dataset.searchText = normalizeSearch([
                    documentData.title,
                    documentData.navTitle,
                    documentData.summary,
                    ...(documentData.tags || []),
                ].join(' '));
                link.textContent = documentData.navTitle || documentData.title;
                link.title = documentData.summary || `Открыть «${documentData.title}»`;
                sectionElement.appendChild(link);
            });

            dom.navigation.appendChild(sectionElement);
        });

        dom.docCount.textContent = `${documentCount} ${pluralize(documentCount, 'документ', 'документа', 'документов')}`;
    }

    function filterNavigation() {
        const query = normalizeSearch(dom.search.value.trim());
        let visibleCount = 0;

        dom.navigation.querySelectorAll('.nav-section').forEach((section) => {
            let sectionVisible = 0;
            section.querySelectorAll('.nav-link').forEach((link) => {
                const visible = !query || link.dataset.searchText.includes(query);
                link.hidden = !visible;
                sectionVisible += visible ? 1 : 0;
                visibleCount += visible ? 1 : 0;
            });
            section.hidden = sectionVisible === 0;
        });

        dom.docCount.textContent = query
            ? `${visibleCount} ${pluralize(visibleCount, 'совпадение', 'совпадения', 'совпадений')}`
            : (() => {
                const count = Object.keys(state.manifest.documents).length;
                return `${count} ${pluralize(count, 'документ', 'документа', 'документов')}`;
            })();
        console.log('[WM Docs] navigation:filter', { queryLength: query.length, visible: visibleCount });
    }

    function updateActiveNavigation() {
        dom.navigation.querySelectorAll('.nav-link').forEach((link) => {
            const active = link.dataset.docId === state.currentId;
            link.classList.toggle('is-active', active);
            if (active) {
                link.setAttribute('aria-current', 'page');
            } else {
                link.removeAttribute('aria-current');
            }
        });
    }

    function renderDocument(response) {
        const documentData = response.document;
        const rendered = renderMarkdown(response.markdown);
        dom.document.innerHTML = rendered.html;

        if (documentData.kind === 'log-index') {
            renderJournalExplorer();
        }

        const section = findSection(response.id);
        renderBreadcrumbs(section, documentData);
        renderStatus(documentData.status || 'current');
        renderContext(response, rendered.headings);

        document.title = `${documentData.title} — ${state.manifest.site.title}`;
        updateActiveNavigation();
    }

    function renderJournalExplorer() {
        const oldExplorer = dom.document.querySelector('[data-journal-explorer]');
        if (oldExplorer) {
            oldExplorer.remove();
        }

        const explorer = document.createElement('section');
        explorer.className = 'journal-explorer';
        explorer.dataset.journalExplorer = '';

        const heading = document.createElement('div');
        heading.className = 'journal-head';
        const title = document.createElement('h2');
        title.textContent = 'Карта журнала';
        heading.appendChild(title);

        const modes = document.createElement('div');
        modes.className = 'journal-modes';
        modes.setAttribute('aria-label', 'Способ группировки журнала');
        [
            ['pages', 'По страницам'],
            ['modules', 'По модулям'],
        ].forEach(([mode, label]) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.dataset.journalMode = mode;
            button.textContent = label;
            button.title = `Сгруппировать записи ${label.toLocaleLowerCase('ru-RU')}`;
            button.classList.toggle('is-active', state.journalMode === mode);
            button.setAttribute('aria-pressed', String(state.journalMode === mode));
            modes.appendChild(button);
        });
        heading.appendChild(modes);
        explorer.appendChild(heading);

        const entries = Object.entries(state.manifest.documents)
            .filter(([, documentData]) => documentData.kind === 'log')
            .sort((a, b) => String(b[1].date).localeCompare(String(a[1].date)));
        const groups = new Map();

        entries.forEach(([id, documentData]) => {
            const keys = documentData[state.journalMode] || ['other'];
            keys.forEach((key) => {
                if (!groups.has(key)) {
                    groups.set(key, []);
                }
                groups.get(key).push([id, documentData]);
            });
        });

        const groupGrid = document.createElement('div');
        groupGrid.className = 'journal-groups';
        Array.from(groups.entries())
            .sort((a, b) => journalGroupTitle(a[0]).localeCompare(journalGroupTitle(b[0]), 'ru'))
            .forEach(([groupId, groupEntries]) => {
                const group = document.createElement('section');
                group.className = 'journal-group';
                const groupTitle = document.createElement('h3');
                groupTitle.textContent = journalGroupTitle(groupId);
                group.appendChild(groupTitle);

                groupEntries.forEach(([id, documentData]) => {
                    const link = document.createElement('a');
                    link.className = 'journal-card';
                    link.href = `?doc=${encodeURIComponent(id)}`;
                    link.dataset.docId = id;
                    link.title = `Открыть запись «${documentData.title}»`;

                    const date = document.createElement('time');
                    date.dateTime = documentData.date;
                    date.textContent = formatDate(documentData.date);
                    link.appendChild(date);

                    const cardTitle = document.createElement('strong');
                    cardTitle.textContent = documentData.title;
                    link.appendChild(cardTitle);

                    const summary = document.createElement('span');
                    summary.textContent = documentData.summary;
                    link.appendChild(summary);
                    group.appendChild(link);
                });

                groupGrid.appendChild(group);
            });
        explorer.appendChild(groupGrid);
        dom.document.appendChild(explorer);
    }

    function journalGroupTitle(groupId) {
        if (state.journalMode === 'pages' && hasDocument(groupId)) {
            return state.manifest.documents[groupId].title;
        }
        return String(groupId).replace(/-/g, ' ');
    }

    function formatDate(value) {
        const parts = String(value || '').split('-');
        return parts.length === 3 ? `${parts[2]}.${parts[1]}.${parts[0]}` : String(value || '');
    }

    function renderBreadcrumbs(section, documentData) {
        dom.breadcrumbs.replaceChildren();
        [section ? section.title : 'Документация', documentData.title].forEach((part) => {
            const span = document.createElement('span');
            span.textContent = part;
            dom.breadcrumbs.appendChild(span);
        });
    }

    function renderStatus(status) {
        dom.status.textContent = status;
        dom.status.dataset.kind = status;
        dom.status.title = `Статус документа: ${status}`;
    }

    function renderContext(response, headings) {
        dom.context.replaceChildren();

        if (response.asideMarkdown) {
            const aside = document.createElement('div');
            aside.className = 'context-markdown';
            aside.innerHTML = renderMarkdown(response.asideMarkdown, { headingPrefix: 'aside-' }).html;
            dom.context.appendChild(aside);
        }

        if (headings.length) {
            const toc = document.createElement('nav');
            toc.className = 'toc';
            toc.setAttribute('aria-label', 'Содержание документа');
            const title = document.createElement('p');
            title.className = 'toc-title';
            title.textContent = 'На этой странице';
            toc.appendChild(title);
            headings.filter((heading) => heading.level > 1).forEach((heading) => {
                const link = document.createElement('a');
                link.href = `#${heading.id}`;
                link.dataset.level = String(heading.level);
                link.textContent = heading.text;
                link.title = `Перейти к разделу «${heading.text}»`;
                toc.appendChild(link);
            });
            dom.context.appendChild(toc);
        }

        const related = response.document.related || [];
        if (related.length) {
            const block = document.createElement('section');
            block.className = 'toc';
            const title = document.createElement('p');
            title.className = 'toc-title';
            title.textContent = 'Связанные документы';
            block.appendChild(title);
            const list = document.createElement('div');
            list.className = 'related-list';
            related.forEach((id) => {
                if (!hasDocument(id)) {
                    return;
                }
                const link = document.createElement('a');
                link.className = 'related-card';
                link.href = `?doc=${encodeURIComponent(id)}`;
                link.dataset.docId = id;
                link.textContent = state.manifest.documents[id].title;
                link.title = state.manifest.documents[id].summary || link.textContent;
                list.appendChild(link);
            });
            block.appendChild(list);
            dom.context.appendChild(block);
        }
    }

    function renderMarkdown(markdown, options = {}) {
        const lines = String(markdown || '').replace(/\r\n?/g, '\n').split('\n');
        const html = [];
        const headings = [];
        const headingIds = new Map();
        const prefix = options.headingPrefix || '';
        let index = 0;

        while (index < lines.length) {
            const line = lines[index];
            if (!line.trim()) {
                index += 1;
                continue;
            }

            const fence = line.match(/^```([a-z0-9_-]+)?\s*$/i);
            if (fence) {
                const codeLines = [];
                index += 1;
                while (index < lines.length && !/^```\s*$/.test(lines[index])) {
                    codeLines.push(lines[index]);
                    index += 1;
                }
                index += index < lines.length ? 1 : 0;
                html.push(renderCodeBlock(codeLines.join('\n'), fence[1] || 'text'));
                continue;
            }

            const heading = line.match(/^(#{1,4})\s+(.+)$/);
            if (heading) {
                const level = heading[1].length;
                const text = stripInlineMarkup(heading[2]);
                const baseId = `${prefix}${slugify(text) || 'section'}`;
                const seen = headingIds.get(baseId) || 0;
                headingIds.set(baseId, seen + 1);
                const id = seen ? `${baseId}-${seen + 1}` : baseId;
                headings.push({ level, text, id });
                html.push(`<h${level} id="${escapeAttr(id)}">${renderInline(heading[2])}</h${level}>`);
                index += 1;
                continue;
            }

            if (/^---+$/.test(line.trim())) {
                html.push('<hr>');
                index += 1;
                continue;
            }

            const notice = line.match(/^>\s*\[!([A-Z-]+)\]\s*(.*)$/);
            if (notice) {
                const body = [];
                if (notice[2]) {
                    body.push(notice[2]);
                }
                index += 1;
                while (index < lines.length && /^>/.test(lines[index])) {
                    body.push(lines[index].replace(/^>\s?/, ''));
                    index += 1;
                }
                html.push(renderNotice(notice[1], body.join(' ')));
                continue;
            }

            if (isTableStart(lines, index)) {
                const headerCells = splitTableRow(lines[index]);
                index += 2;
                const rows = [];
                while (index < lines.length && /^\s*\|?.+\|.+\|?\s*$/.test(lines[index]) && lines[index].trim()) {
                    rows.push(splitTableRow(lines[index]));
                    index += 1;
                }
                html.push(renderTable(headerCells, rows));
                continue;
            }

            const unordered = line.match(/^\s*[-*+]\s+(.+)$/);
            const ordered = line.match(/^\s*\d+[.)]\s+(.+)$/);
            if (unordered || ordered) {
                const tag = unordered ? 'ul' : 'ol';
                const items = [];
                const itemPattern = unordered ? /^\s*[-*+]\s+(.+)$/ : /^\s*\d+[.)]\s+(.+)$/;
                while (index < lines.length) {
                    const match = lines[index].match(itemPattern);
                    if (!match) {
                        break;
                    }
                    items.push(`<li>${renderInline(match[1])}</li>`);
                    index += 1;
                }
                html.push(`<${tag}>${items.join('')}</${tag}>`);
                continue;
            }

            if (/^>\s?/.test(line)) {
                const quote = [];
                while (index < lines.length && /^>\s?/.test(lines[index])) {
                    quote.push(lines[index].replace(/^>\s?/, ''));
                    index += 1;
                }
                html.push(`<blockquote>${renderInline(quote.join(' '))}</blockquote>`);
                continue;
            }

            const paragraph = [line.trim()];
            index += 1;
            while (index < lines.length && lines[index].trim() && !isBlockStart(lines, index)) {
                paragraph.push(lines[index].trim());
                index += 1;
            }
            html.push(`<p>${renderInline(paragraph.join(' '))}</p>`);
        }

        return { html: html.join('\n'), headings };
    }

    function isBlockStart(lines, index) {
        const line = lines[index];
        return /^```/.test(line)
            || /^#{1,4}\s+/.test(line)
            || /^---+$/.test(line.trim())
            || /^>/.test(line)
            || /^\s*[-*+]\s+/.test(line)
            || /^\s*\d+[.)]\s+/.test(line)
            || isTableStart(lines, index);
    }

    function isTableStart(lines, index) {
        return index + 1 < lines.length
            && lines[index].includes('|')
            && /^\s*\|?\s*:?-{3,}/.test(lines[index + 1]);
    }

    function splitTableRow(line) {
        return line.trim().replace(/^\||\|$/g, '').split('|').map((cell) => cell.trim());
    }

    function renderTable(headers, rows) {
        const head = headers.map((cell) => `<th>${renderInline(cell)}</th>`).join('');
        const body = rows.map((row) => {
            const cells = headers.map((_, index) => `<td>${renderInline(row[index] || '')}</td>`).join('');
            return `<tr>${cells}</tr>`;
        }).join('');
        return `<div class="table-wrap"><table><thead><tr>${head}</tr></thead><tbody>${body}</tbody></table></div>`;
    }

    function renderNotice(kind, body) {
        const normalized = kind.toLowerCase();
        const titles = {
            note: 'Примечание',
            tip: 'Практика',
            warning: 'Важно',
            danger: 'Опасность',
            legacy: 'Legacy',
            unresolved: 'Unresolved',
        };
        return `<aside class="notice notice-${escapeAttr(normalized)}"><div class="notice-title">${titles[normalized] || escapeHtml(kind)}</div><p>${renderInline(body)}</p></aside>`;
    }

    function renderCodeBlock(code, language) {
        const safeLanguage = /^[a-z0-9_-]+$/i.test(language) ? language.toLowerCase() : 'text';
        return `<div class="code-card"><div class="code-head"><span>${escapeHtml(safeLanguage)}</span><button type="button" data-copy-code title="Скопировать пример в буфер обмена">Копировать</button></div><pre><code data-language="${escapeAttr(safeLanguage)}">${highlightCode(code, safeLanguage)}</code></pre></div>`;
    }

    function highlightCode(code, language) {
        const keywordSets = {
            php: ['array', 'class', 'const', 'else', 'extends', 'false', 'function', 'if', 'include', 'include_once', 'new', 'null', 'private', 'protected', 'public', 'return', 'static', 'true', 'try', 'catch'],
            js: ['async', 'await', 'class', 'const', 'else', 'export', 'false', 'function', 'if', 'import', 'let', 'new', 'null', 'return', 'true', 'try', 'catch'],
            javascript: ['async', 'await', 'class', 'const', 'else', 'export', 'false', 'function', 'if', 'import', 'let', 'new', 'null', 'return', 'true', 'try', 'catch'],
            json: ['true', 'false', 'null'],
            css: ['@media', '@supports', 'var'],
        };
        const keywords = new Set(keywordSets[language] || []);
        const tokenParts = [
            String.raw`\/\*[\s\S]*?\*\/`,
            String.raw`\/\/[^\n]*`,
            ...(language === 'php' ? [String.raw`#[^\n]*`] : []),
            String.raw`#[A-Fa-f0-9]{3,8}\b`,
            String.raw`@[A-Za-z-]+`,
            String.raw`"(?:\\.|[^"\\])*"`,
            String.raw`'(?:\\.|[^'\\])*'`,
            String.raw`\$[A-Za-z_][A-Za-z0-9_]*`,
            String.raw`\b\d+(?:\.\d+)?\b`,
            String.raw`\b[A-Za-z_][A-Za-z0-9_-]*\b`,
            String.raw`<\/?[A-Za-z][^>]*>`,
        ];
        const tokenPattern = new RegExp(tokenParts.join('|'), 'g');
        let result = '';
        let cursor = 0;
        let match;

        while ((match = tokenPattern.exec(code)) !== null) {
            result += escapeHtml(code.slice(cursor, match.index));
            const token = match[0];
            let tokenClass = '';
            if (/^(?:\/\*|\/\/)/.test(token) || (language === 'php' && /^#/.test(token))) {
                tokenClass = 'tok-comment';
            } else if (/^["']/.test(token)) {
                tokenClass = language === 'json' && /^"[^"\\]+"$/.test(token) && /^\s*:/.test(code.slice(tokenPattern.lastIndex))
                    ? 'tok-property'
                    : 'tok-string';
            } else if (/^\$/.test(token)) {
                tokenClass = 'tok-variable';
            } else if (/^\d/.test(token) || (language === 'css' && /^#[a-f0-9]{3,8}$/i.test(token))) {
                tokenClass = 'tok-number';
            } else if (/^</.test(token)) {
                tokenClass = 'tok-tag';
            } else if (keywords.has(token)) {
                tokenClass = 'tok-keyword';
            }
            result += tokenClass
                ? `<span class="${tokenClass}">${escapeHtml(token)}</span>`
                : escapeHtml(token);
            cursor = tokenPattern.lastIndex;
        }
        return result + escapeHtml(code.slice(cursor));
    }

    function renderInline(value) {
        const tokens = [];
        const marker = (html) => {
            const id = `\u0000${tokens.length}\u0000`;
            tokens.push(html);
            return id;
        };
        let text = String(value || '');

        text = text.replace(/`([^`]+)`/g, (_, code) => marker(`<code>${escapeHtml(code)}</code>`));
        text = text.replace(/\[([^\]]+)]\(([^)]+)\)/g, (_, label, href) => {
            const safeLink = linkAttributes(href.trim());
            if (!safeLink) {
                return escapeHtml(label);
            }
            return marker(`<a ${safeLink}>${escapeHtml(label)}</a>`);
        });
        text = escapeHtml(text)
            .replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>')
            .replace(/__([^_]+)__/g, '<strong>$1</strong>')
            .replace(/(^|\s)\*([^*]+)\*(?=\s|[.,;:!?]|$)/g, '$1<em>$2</em>');

        return text.replace(/\u0000(\d+)\u0000/g, (_, index) => tokens[Number(index)] || '');
    }

    function linkAttributes(href) {
        if (/^doc:[a-z0-9][a-z0-9/-]{0,119}$/.test(href)) {
            const id = href.slice(4);
            return `href="?doc=${encodeURIComponent(id)}" data-doc-id="${escapeAttr(id)}"`;
        }
        if (/^#[a-z0-9_-]+$/i.test(href)) {
            return `href="${escapeAttr(href)}"`;
        }
        if (/^https:\/\//i.test(href) || /^mailto:/i.test(href)) {
            return `href="${escapeAttr(href)}" rel="noreferrer"`;
        }
        return '';
    }

    function stripInlineMarkup(value) {
        return String(value || '')
            .replace(/`([^`]+)`/g, '$1')
            .replace(/\[([^\]]+)]\([^)]+\)/g, '$1')
            .replace(/[*_~]/g, '')
            .trim();
    }

    function slugify(value) {
        return String(value || '')
            .toLocaleLowerCase('ru-RU')
            .replace(/[^a-zа-яё0-9]+/gi, '-')
            .replace(/^-+|-+$/g, '')
            .slice(0, 72);
    }

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function escapeAttr(value) {
        return escapeHtml(value).replace(/`/g, '&#096;');
    }

    function normalizeSearch(value) {
        return String(value || '').toLocaleLowerCase('ru-RU').replace(/ё/g, 'е');
    }

    function findSection(documentId) {
        return state.manifest.sections.find((section) => section.items.includes(documentId)) || null;
    }

    function pluralize(value, one, few, many) {
        const mod10 = value % 10;
        const mod100 = value % 100;
        if (mod10 === 1 && mod100 !== 11) {
            return one;
        }
        if (mod10 >= 2 && mod10 <= 4 && (mod100 < 12 || mod100 > 14)) {
            return few;
        }
        return many;
    }

    function setLoading(message) {
        dom.document.innerHTML = `<div class="loading-state"><span class="loading-dot" aria-hidden="true"></span>${escapeHtml(message)}</div>`;
        dom.context.innerHTML = '<div class="context-loading">Готовим примеры и оглавление…</div>';
        dom.status.textContent = 'loading';
        dom.status.dataset.kind = 'loading';
    }

    function showDocumentError(message) {
        dom.document.innerHTML = `<div class="error-state"><strong>${escapeHtml(message)}</strong><span>Проверьте PHP-сервер и повторите загрузку.</span><button type="button" data-retry-document>Повторить</button></div>`;
        dom.context.innerHTML = '<div class="context-loading">Ошибка чтения Markdown зафиксирована в console.</div>';
        dom.status.textContent = 'error';
        dom.status.dataset.kind = 'unresolved';
    }

    function showFatalError(message, retry) {
        dom.document.innerHTML = `<div class="error-state"><strong>${escapeHtml(message)}</strong><span>Произвольный путь не используется: документы читаются только из manifest.</span><button type="button" data-retry-fatal>Повторить</button></div>`;
        const button = dom.document.querySelector('[data-retry-fatal]');
        button.addEventListener('click', retry, { once: true });
        dom.context.innerHTML = '<div class="context-loading">Ошибка и детали запроса записаны в console.</div>';
        dom.status.textContent = 'error';
        dom.status.dataset.kind = 'unresolved';
    }

    async function copyCode(button) {
        const code = button.closest('.code-card').querySelector('code').textContent;
        try {
            await navigator.clipboard.writeText(code);
            showToast('Пример скопирован.');
            console.log('[WM Docs] code:copied', { characters: code.length });
        } catch (error) {
            console.error('[WM Docs] code:copy-error', errorDetails(error));
            showToast('Не удалось скопировать пример.');
        }
    }

    function showToast(message) {
        window.clearTimeout(state.toastTimer);
        dom.toast.textContent = message;
        dom.toast.hidden = false;
        state.toastTimer = window.setTimeout(() => {
            dom.toast.hidden = true;
        }, 2400);
    }

    function setNavOpen(open) {
        const wasOpen = document.body.classList.contains('nav-open');
        const label = open ? 'Закрыть навигацию' : 'Открыть навигацию';
        document.body.classList.toggle('nav-open', open);
        dom.navToggle.setAttribute('aria-expanded', String(open));
        dom.navToggle.title = label;
        dom.navToggle.querySelector('[data-nav-label]').textContent = label;
        dom.navScrim.hidden = !open;
        if (open) {
            window.setTimeout(() => dom.search.focus(), 40);
        } else if (wasOpen && !dom.navToggle.contains(document.activeElement)) {
            dom.navToggle.focus();
        }
    }
})();
