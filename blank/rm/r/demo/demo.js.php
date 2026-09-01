<?
include_once dirname(dirname(dirname(__FILE__))).'/iq.inc';
_needphp('headers');
headers('js', 'utf8', 'nosniff', 'cache-off', etag::ctx(__FILE__));
?>
(() => {
    'use strict';

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init, { once: true });
    } else {
        init();
    }

    function init() {
        const root = document.querySelector('[data-rm-test-root]');
        const status = document.querySelector('[data-client-status]');
        const diagnostics = readDiagnostics();

        console.log('[blank/rm] page:ready', {
            rm: diagnostics.rm,
            component: diagnostics.component,
        });

        Object.entries(diagnostics.checks || {}).forEach(([stage, passed]) => {
            const method = passed ? 'log' : 'error';
            console[method](`[blank/rm] ${stage}:${passed ? 'success' : 'error'}`, { passed });
        });

        if (diagnostics.errorCode) {
            console.error('[blank/rm] server:error', { code: diagnostics.errorCode });
        }

        runClientCheck();
        const button = document.querySelector('[data-run-check]');
        if (button) button.addEventListener('click', runClientCheck);

        function runClientCheck() {
            const cardCount = root ? root.querySelectorAll('[data-check]').length : 0;
            const cssLoaded = root
                ? getComputedStyle(root).getPropertyValue('--blank-rm-asset').trim() === '1'
                : false;
            const passed = Boolean(root && diagnostics.ok && cardCount === 6 && cssLoaded);
            if (status) status.textContent = passed ? 'Client DOM + assets: PASS' : 'Client DOM + assets: FAIL';
            const overall = document.querySelector('[data-overall-status]');
            if (overall) overall.textContent = passed ? 'PASS' : 'FAIL';
            console[cssLoaded ? 'log' : 'error']('[blank/rm] css-asset', { loaded: cssLoaded });
            console[passed ? 'log' : 'error']('[blank/rm] client-check', { passed, cardCount, cssLoaded });
        }
    }

    function readDiagnostics() {
        try {
            return JSON.parse(document.body.dataset.rmDiagnostics || '{}');
        } catch (error) {
            console.error('[blank/rm] diagnostics:parse-error', { name: error.name });
            return { ok: false, checks: {}, errorCode: 'diagnostics-invalid' };
        }
    }

})();
