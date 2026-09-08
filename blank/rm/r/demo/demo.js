(() => {
    'use strict';
    function init() {
        console.log('[blank/rm] js-loaded');
        const button = document.querySelector('[data-check-again]');
        function check() {
            const diagnostics = JSON.parse(document.body.dataset.rmDiagnostics);
            const card = document.querySelector('[data-rm-card]');
            const cssLoaded = Boolean(card && getComputedStyle(card).getPropertyValue('--rm-demo-loaded').trim() === '1');
            const rows = Array.from(document.querySelectorAll('[data-check]'));
            const passed = diagnostics.ok && Object.values(diagnostics.checks).every(value => value === true)
                && rows.length === 6 && rows.every(row => row.dataset.passed === 'true') && cssLoaded;
            const status = document.querySelector('[data-overall-status]');
            status.textContent = passed ? 'PASS · сервер, шаблон, CSS и JavaScript' : 'FAIL · подробности в консоли';
            status.dataset.result = passed ? 'pass' : 'fail';
            console.log('[blank/rm] client-check', { passed, cssLoaded, cardCount: rows.length });
        }
        check();
        button.hidden = false;
        button.addEventListener('click', check);
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init, { once: true });
    else init();
})();
