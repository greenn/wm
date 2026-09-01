<?
include_once dirname(dirname(dirname(__FILE__))).'/iq.inc';
_needphp('headers');
headers('css', 'utf8', 'nosniff', 'cache-off', etag::ctx(__FILE__));
?>
:root {
    color-scheme: dark;
    --ink: #f8f7fb;
    --muted: #aaa5b7;
    --panel: rgba(29, 25, 38, .88);
    --line: rgba(255, 255, 255, .1);
    --violet: #8f6fff;
    --cyan: #57e6d3;
    --amber: #ffcf66;
    --danger: #ff718f;
    font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

* { box-sizing: border-box; }

body {
    min-width: 320px;
    min-height: 100vh;
    margin: 0;
    color: var(--ink);
    background:
        radial-gradient(circle at 18% 8%, rgba(143, 111, 255, .26), transparent 34rem),
        radial-gradient(circle at 88% 86%, rgba(87, 230, 211, .14), transparent 30rem),
        #0e0c13;
}

body::before {
    position: fixed;
    inset: 0;
    pointer-events: none;
    content: "";
    opacity: .14;
    background-image: linear-gradient(var(--line) 1px, transparent 1px), linear-gradient(90deg, var(--line) 1px, transparent 1px);
    background-size: 42px 42px;
    mask-image: linear-gradient(to bottom, #000, transparent 78%);
}

.rblank-rm-demo {
    --blank-rm-asset: 1;
    position: relative;
    width: min(1120px, calc(100% - 40px));
    margin: 0 auto;
    padding: 56px 0 32px;
}

.test-hero {
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 24px;
    align-items: start;
    padding: 28px;
    border: 1px solid var(--line);
    border-radius: 28px;
    background: linear-gradient(135deg, rgba(45, 37, 63, .95), rgba(19, 17, 26, .92));
    box-shadow: 0 30px 90px rgba(0, 0, 0, .34);
}

.wm-mark {
    display: grid;
    place-items: center;
    width: 58px;
    height: 58px;
    color: var(--ink);
    border: 1px solid rgba(255, 255, 255, .18);
    border-radius: 17px;
    background: #17131f;
    font-size: 21px;
    font-weight: 850;
    letter-spacing: -.12em;
    text-decoration: none;
    cursor: pointer;
}

.wm-mark span { color: var(--cyan); }

.eyebrow {
    margin: 0 0 9px;
    color: var(--cyan);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .16em;
    text-transform: uppercase;
}

h1, h2, p { margin-top: 0; }
h1 { margin-bottom: 10px; font-size: clamp(28px, 5vw, 54px); line-height: .98; letter-spacing: -.055em; }
h2 { margin-bottom: 10px; font-size: clamp(20px, 3vw, 30px); letter-spacing: -.035em; }
.lead { max-width: 720px; margin-bottom: 0; color: var(--muted); font-size: 16px; line-height: 1.62; }

.overall-status {
    padding: 8px 11px;
    color: #071512;
    border-radius: 999px;
    background: var(--cyan);
    font: 800 11px/1 ui-monospace, SFMono-Regular, Consolas, monospace;
    letter-spacing: .12em;
}

.test-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
    margin: 18px 0;
}

.test-card {
    display: flex;
    gap: 12px;
    align-items: center;
    min-width: 0;
    padding: 17px 18px;
    border: 1px solid var(--line);
    border-radius: 17px;
    background: var(--panel);
}

.status-dot { flex: 0 0 auto; width: 10px; height: 10px; border-radius: 50%; background: var(--danger); box-shadow: 0 0 18px var(--danger); }
.is-pass .status-dot { background: var(--cyan); box-shadow: 0 0 18px rgba(87, 230, 211, .8); }
.test-card strong, .test-card small { display: block; overflow: hidden; text-overflow: ellipsis; }
.test-card strong { font: 700 13px/1.4 ui-monospace, SFMono-Regular, Consolas, monospace; }
.test-card small { margin-top: 3px; color: var(--muted); font-size: 11px; }

.contract-panel, .missing-panel {
    display: grid;
    grid-template-columns: minmax(0, 1.2fr) minmax(280px, .8fr);
    gap: 28px;
    padding: 28px;
    border: 1px solid var(--line);
    border-radius: 24px;
    background: var(--panel);
}

.contract-panel p, .missing-panel p { color: var(--muted); line-height: 1.6; }
code { color: #dfd7ff; font-family: ui-monospace, SFMono-Regular, Consolas, monospace; }
dl { margin: 0; }
dl div { display: grid; grid-template-columns: 92px minmax(0, 1fr); gap: 12px; padding: 10px 0; border-bottom: 1px solid var(--line); }
dt { color: var(--muted); font-size: 12px; }
dd { min-width: 0; margin: 0; overflow: hidden; font: 700 12px/1.45 ui-monospace, SFMono-Regular, Consolas, monospace; text-overflow: ellipsis; white-space: nowrap; }

.missing-panel {
    grid-template-columns: auto 1fr auto;
    align-items: center;
    margin-top: 18px;
    border-color: rgba(255, 207, 102, .28);
}

.missing-icon { display: grid; place-items: center; width: 46px; height: 46px; color: #1b1303; border-radius: 14px; background: var(--amber); font-size: 24px; font-weight: 900; }
.missing-panel h2, .missing-panel p { margin-bottom: 5px; }
button { padding: 11px 15px; color: var(--ink); border: 1px solid rgba(255,255,255,.18); border-radius: 12px; background: #2c2440; font-weight: 750; cursor: pointer; }
button:hover, button:focus-visible { border-color: var(--violet); outline: none; box-shadow: 0 0 0 3px rgba(143,111,255,.2); }

footer { display: flex; justify-content: space-between; gap: 16px; padding: 18px 4px 0; color: var(--muted); font: 600 11px/1.5 ui-monospace, SFMono-Regular, Consolas, monospace; }
.fallback-error { max-width: 720px; margin: 12vh auto; padding: 28px; }

@media (max-width: 820px) {
    .rblank-rm-demo { width: min(100% - 24px, 680px); padding-top: 24px; }
    .test-hero { grid-template-columns: auto 1fr; padding: 22px; }
    .overall-status { grid-column: 2; justify-self: start; }
    .test-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .contract-panel { grid-template-columns: 1fr; }
    .missing-panel { grid-template-columns: auto 1fr; }
    .missing-panel button { grid-column: 2; justify-self: start; }
}

@media (max-width: 520px) {
    .test-hero { grid-template-columns: 1fr; }
    .overall-status { grid-column: 1; }
    .test-grid { grid-template-columns: 1fr; }
    .missing-panel { grid-template-columns: 1fr; }
    .missing-panel button { grid-column: 1; }
    footer { flex-direction: column; }
}

@media (prefers-reduced-motion: no-preference) {
    .test-card { animation: test-card-in .42s both; }
    .test-card:nth-child(2) { animation-delay: .04s; }
    .test-card:nth-child(3) { animation-delay: .08s; }
    .test-card:nth-child(4) { animation-delay: .12s; }
    .test-card:nth-child(5) { animation-delay: .16s; }
    .test-card:nth-child(6) { animation-delay: .2s; }
    @keyframes test-card-in { from { opacity: 0; transform: translateY(8px); } }
}
