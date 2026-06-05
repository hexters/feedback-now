@php
    $positions = [
        'top-left'      => 'top:22px;left:22px',
        'top-center'    => 'top:22px;left:50%;--fbn-tf:translateX(-50%)',
        'top-right'     => 'top:22px;right:22px',
        'middle-left'   => 'top:50%;left:22px;--fbn-tf:translateY(-50%)',
        'middle-right'  => 'top:50%;right:22px;--fbn-tf:translateY(-50%)',
        'bottom-left'   => 'bottom:22px;left:22px',
        'bottom-center' => 'bottom:22px;left:50%;--fbn-tf:translateX(-50%)',
        'bottom-right'  => 'bottom:22px;right:22px',
    ];
    $pos = $positions[$button['position'] ?? 'bottom-right'] ?? $positions['bottom-right'];
    $accent = $accent ?? '#2f6fed';
    $fab = $button['color'] ?? $accent;
    $label = $button['label'] ?? 'Report issue';
@endphp
<div id="fbn-root" style="--fbn-accent: {{ $accent }}; --fbn-fab: {{ $fab }};"
     data-endpoint="{{ $endpoint }}" data-csrf="{{ $csrf }}" data-max="{{ $maxKb }}">

    <button type="button" class="fbn-fab" style="{{ $pos }}" aria-label="{{ $label }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18h6M10 22h4M12 2a7 7 0 0 0-4 12.7V17h8v-2.3A7 7 0 0 0 12 2Z"/></svg>
        <span>{{ $label }}</span>
    </button>

    <div class="fbn-overlay" hidden>
        <div class="fbn-modal" role="dialog" aria-modal="true" aria-label="Report an issue">
            <div class="fbn-grab" aria-hidden="true"></div>
            <div class="fbn-head">
                <div>
                    <h2>Report an issue</h2>
                    <p>It goes straight to the repository.</p>
                </div>
                <button type="button" class="fbn-x" data-close aria-label="Close">&times;</button>
            </div>

            <div class="fbn-body">
                <label class="fbn-l">Path</label>
                <input type="text" class="fbn-in" data-url spellcheck="false">

                <label class="fbn-l">What went wrong?</label>
                <textarea class="fbn-in fbn-ta" data-desc rows="4" placeholder="Describe the issue, what you expected, steps to reproduce…"></textarea>

                <label class="fbn-l">Screenshots <span class="fbn-opt">(optional — add, then mark up &amp; note)</span></label>
                <div class="fbn-shots" data-shots></div>
                <div class="fbn-drop" data-drop tabindex="0">
                    <input type="file" accept="image/*" data-file hidden multiple>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0 4 4m-4-4-4 4M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
                    <span>Click to add, drop, or paste (Ctrl/Cmd + V)</span>
                </div>

                <p class="fbn-msg" data-msg hidden></p>
            </div>

            <div class="fbn-foot">
                <button type="button" class="fbn-btn fbn-ghost" data-close>Cancel</button>
                <button type="button" class="fbn-btn fbn-primary" data-send>
                    <span data-send-label>Send issue</span>
                </button>
            </div>
        </div>
    </div>

    <div class="fbn-annot" hidden>
        <div class="fbn-annot-modal" role="dialog" aria-modal="true" aria-label="Mark up the screenshot">
            <div class="fbn-grab" aria-hidden="true"></div>
            <div class="fbn-head">
                <div>
                    <h2>Mark up the screenshot</h2>
                    <p>Pick a color, draw on the problem, then write a note when you let go.</p>
                </div>
                <button type="button" class="fbn-x" data-annot-cancel aria-label="Close">&times;</button>
            </div>

            <div class="fbn-annot-body">
                <div class="fbn-annot-main">
                    <span class="fbn-canvas-wrap" data-wrap>
                        <img data-annot-img alt="">
                        <canvas data-annot-canvas></canvas>
                        <div class="fbn-pop" data-pop hidden>
                            <div class="fbn-note-colors" data-pop-colors></div>
                            <input type="text" class="fbn-in fbn-pop-text" data-pop-text placeholder="Add a note…">
                            <div class="fbn-pop-actions">
                                <button type="button" class="fbn-pop-del" data-pop-remove>Remove</button>
                                <button type="button" class="fbn-pop-save" data-pop-save>Save</button>
                            </div>
                        </div>
                    </span>
                </div>

                <div class="fbn-annot-side">
                    <div class="fbn-tools">
                        <div class="fbn-colors">
                            <button type="button" class="fbn-sw" data-color="info"    style="--c:#2f6fed" title="Info" aria-label="Info"></button>
                            <button type="button" class="fbn-sw" data-color="success" style="--c:#16a34a" title="Success" aria-label="Success"></button>
                            <button type="button" class="fbn-sw" data-color="warning" style="--c:#f59e0b" title="Warning" aria-label="Warning"></button>
                            <button type="button" class="fbn-sw" data-color="danger"  style="--c:#dc2626" title="Danger" aria-label="Danger"></button>
                        </div>
                        <div class="fbn-tool-actions">
                            <button type="button" class="fbn-tbtn" data-undo>Undo</button>
                            <button type="button" class="fbn-tbtn" data-clear>Clear</button>
                        </div>
                    </div>
                    <div class="fbn-notes" data-notes></div>

                    <div class="fbn-foot">
                        <button type="button" class="fbn-btn fbn-ghost" data-annot-cancel>Cancel</button>
                        <button type="button" class="fbn-btn fbn-primary" data-annot-done>Done</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
#fbn-root, #fbn-root * { box-sizing: border-box; }
#fbn-root { font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, sans-serif; }
.fbn-fab {
    position: fixed; z-index: 2147483000; display: inline-flex; align-items: center; gap: 9px;
    height: 48px; padding: 0 18px 0 15px; border: 0; border-radius: 999px; cursor: pointer;
    background: var(--fbn-fab, var(--fbn-accent)); color: #fff; font-size: 14px; font-weight: 600;
    box-shadow: 0 10px 26px -8px color-mix(in srgb, var(--fbn-fab, var(--fbn-accent)) 70%, transparent);
    transform: var(--fbn-tf, none);
    transition: filter .15s;
}
.fbn-fab:hover { filter: brightness(1.07); }
.fbn-fab:active { transform: var(--fbn-tf, none) translateY(1px); }
.fbn-fab svg { width: 19px; height: 19px; }
.fbn-overlay, .fbn-annot {
    position: fixed; inset: 0; display: none; align-items: center; justify-content: center;
    padding: 16px; background: rgba(12, 18, 30, .55); backdrop-filter: blur(3px);
}
.fbn-overlay { z-index: 2147483001; }
.fbn-annot { z-index: 2147483002; }
.fbn-overlay:not([hidden]), .fbn-annot:not([hidden]) { display: flex; }
.fbn-modal, .fbn-annot-modal {
    width: 100%; max-height: 92vh; overflow-y: auto; background: #fff; color: #0f1729;
    border-radius: 18px; box-shadow: 0 30px 70px -20px rgba(0,0,0,.5);
    animation: fbn-pop .22s cubic-bezier(.22,1,.36,1);
    overscroll-behavior: contain; -webkit-overflow-scrolling: touch;
}
.fbn-modal { max-width: 440px; }
.fbn-annot-modal { max-width: 560px; }
@keyframes fbn-pop { from { opacity: 0; transform: translateY(10px) scale(.98); } to { opacity: 1; transform: none; } }
@keyframes fbn-sheet { from { transform: translateY(100%); } to { transform: translateY(0); } }
.fbn-grab { display: none; }
.fbn-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; padding: 18px 20px 12px; }
.fbn-head h2 { margin: 0; font-size: 17px; font-weight: 700; }
.fbn-head p { margin: 2px 0 0; font-size: 12.5px; color: #64748b; }
.fbn-x { border: 0; background: #f1f5f9; width: 30px; height: 30px; border-radius: 8px; font-size: 20px; line-height: 1; color: #64748b; cursor: pointer; }
.fbn-body { padding: 4px 20px 8px; }
.fbn-l { display: block; font-size: 12px; font-weight: 600; color: #475569; margin: 12px 0 6px; }
.fbn-opt { font-weight: 400; color: #94a3b8; }
.fbn-in { width: 100%; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 12px; font-size: 13.5px; color: #0f1729; outline: none; transition: border-color .15s, box-shadow .15s; }
.fbn-in:focus { border-color: var(--fbn-accent); box-shadow: 0 0 0 3px color-mix(in srgb, var(--fbn-accent) 20%, transparent); }
.fbn-ta { resize: vertical; min-height: 84px; font-family: inherit; }
.fbn-shots { display: grid; gap: 8px; margin-bottom: 8px; }
.fbn-shots:empty { display: none; }
.fbn-shot { display: flex; gap: 10px; align-items: center; border: 1px solid #e2e8f0; border-radius: 10px; padding: 8px; }
.fbn-shot > img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; background: #f8fafc; flex: none; cursor: pointer; }
.fbn-shot-meta { flex: 1; min-width: 0; }
.fbn-markbtn { border: 1px solid var(--fbn-accent); background: color-mix(in srgb, var(--fbn-accent) 8%, #fff); color: var(--fbn-accent); font-size: 12.5px; font-weight: 600; padding: 6px 12px; border-radius: 8px; cursor: pointer; }
.fbn-shot-info { font-size: 11.5px; color: #94a3b8; margin-top: 4px; }
.fbn-rm { flex: none; width: 28px; height: 28px; border: 0; border-radius: 8px; background: #f1f5f9; color: #64748b; font-size: 17px; cursor: pointer; }
.fbn-rm:hover { background: #fee2e2; color: #dc2626; }
.fbn-drop { display: flex; align-items: center; justify-content: center; gap: 9px; border: 1.5px dashed #cbd5e1; border-radius: 12px; padding: 13px; cursor: pointer; color: #94a3b8; font-size: 12.5px; transition: border-color .15s, background .15s; }
.fbn-drop:hover, .fbn-drop.fbn-over { border-color: var(--fbn-accent); background: color-mix(in srgb, var(--fbn-accent) 5%, transparent); }
.fbn-drop svg { width: 19px; height: 19px; flex: none; }
.fbn-msg { margin: 12px 0 0; font-size: 12.5px; border-radius: 8px; padding: 9px 11px; }
.fbn-msg.err { background: #fef2f2; color: #dc2626; }
.fbn-msg.ok { background: #ecfdf5; color: #059669; }
.fbn-msg.ok a { color: #047857; font-weight: 600; }
.fbn-foot { display: flex; gap: 8px; padding: 12px 20px 18px; }
.fbn-btn { flex: 1; height: 42px; border: 0; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: filter .15s, background .15s; }
.fbn-btn:disabled { opacity: .6; cursor: default; }
.fbn-ghost { background: #f1f5f9; color: #475569; }
.fbn-primary { background: var(--fbn-accent); color: #fff; }
.fbn-primary:hover:not(:disabled) { filter: brightness(1.07); }

/* annotator */
.fbn-tools { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 4px 20px 10px; flex-wrap: wrap; }
.fbn-colors { display: flex; gap: 10px; }
.fbn-sw { width: 30px; height: 30px; border-radius: 999px; border: 3px solid #fff; background: var(--c); cursor: pointer; box-shadow: 0 0 0 1px #e2e8f0; transition: transform .1s; }
.fbn-sw:hover { transform: scale(1.08); }
.fbn-sw.on { box-shadow: 0 0 0 3px var(--c); }
.fbn-tool-actions { display: flex; gap: 8px; }
.fbn-tbtn { border: 1px solid #e2e8f0; background: #f8fafc; color: #475569; font-size: 13px; font-weight: 600; padding: 7px 14px; border-radius: 8px; cursor: pointer; }
.fbn-tbtn:hover { background: #f1f5f9; }
.fbn-annot-body { display: flex; flex-direction: column; }
.fbn-annot-main { text-align: center; padding: 0 20px; }
.fbn-canvas-wrap { position: relative; display: inline-block; max-width: 100%; line-height: 0; }
.fbn-canvas-wrap img { display: block; max-width: 100%; max-height: 52vh; border-radius: 10px; }
.fbn-canvas-wrap canvas { position: absolute; inset: 0; width: 100%; height: 100%; cursor: crosshair; touch-action: none; }
.fbn-pop { position: absolute; z-index: 5; width: 232px; background: #fff; border-radius: 12px; box-shadow: 0 14px 34px -8px rgba(0,0,0,.45); padding: 10px; transform: translate(-50%, 12px); line-height: normal; text-align: left; }
.fbn-pop-actions { display: flex; gap: 6px; margin-top: 8px; }
.fbn-pop-actions button { flex: 1; height: 34px; border: 0; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; }
.fbn-pop-del { background: #f1f5f9; color: #dc2626; }
.fbn-pop-save { background: var(--fbn-accent); color: #fff; }
.fbn-notes { display: flex; flex-direction: column; gap: 6px; padding: 12px 20px 0; }
.fbn-notes:empty { display: none; }
.fbn-note { display: flex; align-items: center; gap: 8px; }
.fbn-note-colors { display: flex; gap: 5px; flex: none; }
.fbn-pop .fbn-note-colors { margin-bottom: 10px; }
.fbn-ncw { width: 20px; height: 20px; border-radius: 999px; border: 2px solid #fff; background: var(--c); cursor: pointer; box-shadow: 0 0 0 1px #e2e8f0; opacity: .45; }
.fbn-ncw.on { opacity: 1; box-shadow: 0 0 0 2px var(--c); }
.fbn-note-row { display: flex; align-items: center; gap: 8px; border: 1px solid #e2e8f0; border-radius: 9px; padding: 8px 10px; cursor: pointer; flex: none; }
.fbn-note-row:hover { border-color: var(--fbn-accent); }
.fbn-note-num { width: 20px; height: 20px; border-radius: 999px; background: var(--c); color: #fff; font-size: 11px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex: none; }
.fbn-note-label { flex: 1; min-width: 0; font-size: 12.5px; color: #334155; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
@media (min-width: 768px) {
    .fbn-annot-modal { max-width: min(1100px, 95vw); max-height: 90vh; overflow: hidden; display: flex; flex-direction: column; }
    .fbn-annot-modal .fbn-head h2 { font-size: 19px; }
    .fbn-annot-body { flex: 1; flex-direction: row-reverse; min-height: 0; }
    .fbn-annot-main { flex: 1; min-width: 0; display: flex; align-items: center; justify-content: center; padding: 18px; }
    .fbn-annot-main .fbn-canvas-wrap img { max-height: 66vh; }
    .fbn-annot-side { width: 300px; flex: none; display: flex; flex-direction: column; min-height: 0; border-right: 1px solid #eef2f7; }
    .fbn-annot-side .fbn-tools { padding: 16px 18px; border-bottom: 1px solid #f1f5f9; }
    .fbn-annot-side .fbn-notes { flex: 1; min-height: 0; overflow-y: auto; padding: 14px 18px; }
    .fbn-annot-side .fbn-foot { border-top: 1px solid #f1f5f9; }
}
@media (max-width: 640px) {
    /* a real bottom sheet: docked to the bottom edge, grab handle, slides up */
    .fbn-overlay, .fbn-annot { padding: 0; align-items: flex-end; }
    .fbn-modal, .fbn-annot-modal { max-width: 100%; max-height: 92vh; border-radius: 22px 22px 0 0; animation: fbn-sheet .3s cubic-bezier(.22,1,.36,1); }
    .fbn-grab { display: block; width: 40px; height: 4px; border-radius: 99px; background: #d8d4ca; margin: 9px auto 0; flex: none; }
    .fbn-grab, .fbn-head { touch-action: none; cursor: grab; }
    /* 16px inputs stop iOS from zooming in on focus */
    .fbn-in, .fbn-ta, .fbn-note-text, .fbn-pop-text { font-size: 16px; }
    /* keep Cancel/Send reachable while the body scrolls */
    .fbn-foot { position: sticky; bottom: 0; background: #fff; border-top: 1px solid #eef2f7; }
    /* keep the note popover inside narrow screens */
    .fbn-pop { width: min(232px, 84vw); }
    /* a touch more room for the drawing */
    .fbn-canvas-wrap img { max-height: 48vh; }
    .fbn-tools { justify-content: center; gap: 16px; }
}
@media (max-width: 480px) { .fbn-fab span { display: none; } .fbn-fab { padding: 0; width: 48px; justify-content: center; } }
</style>

<script>
(function () {
    if (window.__fbnLoaded) return;
    window.__fbnLoaded = true;

    var root = document.getElementById('fbn-root');
    if (!root) return;

    var COLORS = { info: '#2f6fed', success: '#16a34a', warning: '#f59e0b', danger: '#dc2626' };
    var COLOR_KEYS = ['info', 'success', 'warning', 'danger'];

    function clamp(v, a, b) { return Math.min(Math.max(v, a), b); }
    function bboxOf(st) {
        var minX = 1, minY = 1;
        st.points.forEach(function (p) { if (p.x < minX) minX = p.x; if (p.y < minY) minY = p.y; });
        return { x: minX, y: minY };
    }
    function drawBadge(c, x, y, r, color, num) {
        c.beginPath(); c.arc(x, y, r, 0, 6.2832); c.fillStyle = color; c.fill();
        c.lineWidth = Math.max(1.5, r * 0.16); c.strokeStyle = '#fff'; c.stroke();
        c.fillStyle = '#fff'; c.textAlign = 'center'; c.textBaseline = 'middle';
        c.font = '700 ' + Math.round(r * 1.2) + 'px ui-sans-serif, system-ui, sans-serif';
        c.fillText(String(num), x, y + r * 0.04);
    }

    var endpoint = root.dataset.endpoint,
        csrf = root.dataset.csrf,
        maxBytes = parseInt(root.dataset.max, 10) * 1024;

    var $ = function (sel) { return root.querySelector(sel); };
    var overlay = $('.fbn-overlay'),
        fab = $('.fbn-fab'),
        urlIn = $('[data-url]'),
        descIn = $('[data-desc]'),
        fileIn = $('[data-file]'),
        drop = $('[data-drop]'),
        shotsEl = $('[data-shots]'),
        msg = $('[data-msg]'),
        sendBtn = $('[data-send]'),
        sendLabel = $('[data-send-label]');

    var annot = $('.fbn-annot'),
        annotImg = $('[data-annot-img]'),
        canvas = $('[data-annot-canvas]'),
        ctx = canvas.getContext('2d'),
        notesEl = $('[data-notes]'),
        pop = $('[data-pop]'),
        popColors = $('[data-pop-colors]'),
        popText = $('[data-pop-text]');

    var shots = [], uid = 0;
    var current = null, snap = null, curColor = 'danger';
    var popStroke = null;

    /* lock the page behind the sheet so scrolling stays inside the modal */
    var scrollY = 0;
    function lockScroll() {
        scrollY = window.scrollY || window.pageYOffset || 0;
        var b = document.body;
        b.style.position = 'fixed';
        b.style.top = -scrollY + 'px';
        b.style.left = '0';
        b.style.right = '0';
        b.style.width = '100%';
        b.style.overflow = 'hidden';
    }
    function unlockScroll() {
        var b = document.body;
        b.style.position = ''; b.style.top = ''; b.style.left = '';
        b.style.right = ''; b.style.width = ''; b.style.overflow = '';
        window.scrollTo(0, scrollY);
    }

    /* ---------- main modal ---------- */
    function open() {
        urlIn.value = window.location.pathname + window.location.search + window.location.hash;
        overlay.hidden = false;
        lockScroll();
        setTimeout(function () { descIn.focus(); }, 50);
    }
    function close() { overlay.hidden = true; unlockScroll(); }

    function setMsg(text, type) {
        if (!text) { msg.hidden = true; return; }
        msg.hidden = false;
        msg.className = 'fbn-msg ' + (type || '');
        msg.innerHTML = text;
    }

    function addFiles(list) { Array.prototype.slice.call(list || []).forEach(addFile); }
    function addFile(f) {
        if (!f || !/^image\//.test(f.type)) { setMsg('Please choose image files only.', 'err'); return; }
        if (f.size > maxBytes) { setMsg('One of the images is too large.', 'err'); return; }
        shots.push({ id: ++uid, file: f, url: URL.createObjectURL(f), strokes: [] });
        setMsg('');
        renderShots();
    }
    function removeShot(id) {
        shots = shots.filter(function (s) { return s.id !== id; });
        renderShots();
    }
    function notedStrokes(s) {
        return (s.strokes || []).filter(function (st) { return (st.note || '').trim(); });
    }
    function countText(s) {
        var d = (s.strokes || []).length, n = notedStrokes(s).length, parts = [];
        if (d) parts.push(d + ' mark' + (d > 1 ? 's' : ''));
        if (n) parts.push(n + ' note' + (n > 1 ? 's' : ''));
        return parts.length ? parts.join(' · ') : 'No marks yet';
    }
    function renderShots() {
        shotsEl.innerHTML = '';
        shots.forEach(function (s) {
            var card = document.createElement('div'); card.className = 'fbn-shot';
            var img = document.createElement('img'); img.src = s.url; img.alt = ''; img.title = 'Mark up';
            img.addEventListener('click', function () { openAnnot(s); });
            var meta = document.createElement('div'); meta.className = 'fbn-shot-meta';
            var btn = document.createElement('button'); btn.type = 'button'; btn.className = 'fbn-markbtn'; btn.textContent = 'Mark up';
            btn.addEventListener('click', function () { openAnnot(s); });
            var info = document.createElement('div'); info.className = 'fbn-shot-info'; info.textContent = countText(s);
            meta.appendChild(btn); meta.appendChild(info);
            var rm = document.createElement('button'); rm.type = 'button'; rm.className = 'fbn-rm'; rm.innerHTML = '&times;'; rm.title = 'Remove';
            rm.addEventListener('click', function () { removeShot(s.id); });
            card.appendChild(img); card.appendChild(meta); card.appendChild(rm);
            shotsEl.appendChild(card);
        });
    }

    /* ---------- annotator ---------- */
    function openAnnot(s) {
        current = s;
        snap = JSON.stringify(s.strokes || []);
        curColor = 'danger';
        selectColorUI();
        hidePop();
        renderNotes();
        annot.hidden = false;
        annotImg.onload = function () { sizeCanvas(); redraw(); };
        annotImg.src = s.url;
        if (annotImg.complete && annotImg.naturalWidth) { sizeCanvas(); redraw(); }
    }
    function closeAnnot() { hidePop(); annot.hidden = true; current = null; renderShots(); }
    function cancelAnnot() {
        if (current && snap) current.strokes = JSON.parse(snap);
        closeAnnot();
    }

    function sizeCanvas() { canvas.width = annotImg.clientWidth; canvas.height = annotImg.clientHeight; }
    function lastPoint(st) { return st.points[st.points.length - 1]; }
    function redraw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        var lw = Math.max(3, canvas.width * 0.006);
        ctx.lineJoin = 'round'; ctx.lineCap = 'round'; ctx.lineWidth = lw;
        (current.strokes || []).forEach(function (st) {
            ctx.strokeStyle = ctx.fillStyle = COLORS[st.color] || COLORS.danger;
            if (st.points.length < 2) {
                var p = st.points[0];
                ctx.beginPath(); ctx.arc(p.x * canvas.width, p.y * canvas.height, lw, 0, 6.2832); ctx.fill();
                return;
            }
            ctx.beginPath();
            st.points.forEach(function (p, i) {
                var x = p.x * canvas.width, y = p.y * canvas.height;
                if (i === 0) ctx.moveTo(x, y); else ctx.lineTo(x, y);
            });
            ctx.stroke();
        });
        notedStrokes(current).forEach(function (st, i) {
            var bb = bboxOf(st), r = Math.max(11, canvas.width * 0.018);
            drawBadge(ctx, clamp(bb.x * canvas.width, r, canvas.width - r), clamp(bb.y * canvas.height, r, canvas.height - r), r, COLORS[st.color] || COLORS.danger, i + 1);
        });
    }
    function selectColorUI() {
        root.querySelectorAll('[data-color]').forEach(function (b) { b.classList.toggle('on', b.dataset.color === curColor); });
    }

    var drawing = false, stroke = null;
    function ptOf(e) {
        var r = canvas.getBoundingClientRect();
        return { x: (e.clientX - r.left) / r.width, y: (e.clientY - r.top) / r.height };
    }
    canvas.addEventListener('pointerdown', function (e) {
        if (!current) return;
        if (!pop.hidden) { hidePop(); return; }  // a click elsewhere closes the popover
        drawing = true;
        try { canvas.setPointerCapture(e.pointerId); } catch (err) {}
        stroke = { color: curColor, points: [ptOf(e)], note: '' };
        current.strokes.push(stroke);
        redraw();
    });
    canvas.addEventListener('pointermove', function (e) {
        if (!drawing || !stroke) return;
        stroke.points.push(ptOf(e));
        redraw();
    });
    ['pointerup', 'pointercancel'].forEach(function (ev) {
        canvas.addEventListener(ev, function () {
            if (drawing && stroke) { var s = stroke; drawing = false; stroke = null; openPop(s); }
            else { drawing = false; stroke = null; }
        });
    });

    root.querySelectorAll('[data-color]').forEach(function (b) {
        b.addEventListener('click', function () { curColor = b.dataset.color; selectColorUI(); });
    });
    $('[data-undo]').addEventListener('click', function () { if (current && current.strokes.length) { current.strokes.pop(); hidePop(); redraw(); renderNotes(); } });
    $('[data-clear]').addEventListener('click', function () { if (current) { current.strokes = []; hidePop(); redraw(); renderNotes(); } });

    /* popover: appears where the mark was drawn */
    function openPop(st) {
        popStroke = st;
        popText.value = st.note || '';
        buildPopColors();
        pop.hidden = false;
        var p = lastPoint(st);
        var w = canvas.clientWidth, h = canvas.clientHeight;
        var x = Math.min(Math.max(p.x * w, 120), w - 120);
        var y = p.y * h;
        var below = p.y < 0.62;
        pop.style.left = x + 'px';
        pop.style.top = y + 'px';
        pop.style.transform = below ? 'translate(-50%, 14px)' : 'translate(-50%, calc(-100% - 14px))';
        setTimeout(function () { popText.focus(); }, 30);
    }
    function hidePop() { pop.hidden = true; popStroke = null; }
    function buildPopColors() {
        popColors.innerHTML = '';
        COLOR_KEYS.forEach(function (c) {
            var sw = document.createElement('button'); sw.type = 'button';
            sw.className = 'fbn-ncw' + (popStroke && popStroke.color === c ? ' on' : '');
            sw.style.setProperty('--c', COLORS[c]); sw.title = c;
            sw.addEventListener('click', function () { if (popStroke) { popStroke.color = c; buildPopColors(); redraw(); } });
            popColors.appendChild(sw);
        });
    }
    $('[data-pop-save]').addEventListener('click', function () {
        if (popStroke) { popStroke.note = popText.value.trim(); }
        hidePop(); redraw(); renderNotes();
    });
    $('[data-pop-remove]').addEventListener('click', function () {
        if (popStroke && current) { current.strokes = current.strokes.filter(function (s) { return s !== popStroke; }); }
        hidePop(); redraw(); renderNotes();
    });
    popText.addEventListener('keydown', function (e) { if (e.key === 'Enter') { e.preventDefault(); $('[data-pop-save]').click(); } });

    /* summary list under the image — click a row to edit, x to remove */
    function renderNotes() {
        notesEl.innerHTML = '';
        notedStrokes(current).forEach(function (st, i) {
            var row = document.createElement('div'); row.className = 'fbn-note-row';
            var dot = document.createElement('span'); dot.className = 'fbn-note-num'; dot.style.setProperty('--c', COLORS[st.color]); dot.textContent = i + 1;
            var label = document.createElement('span'); label.className = 'fbn-note-label'; label.textContent = st.note;
            row.addEventListener('click', function (e) { if (e.target !== rm) openPop(st); });
            var rm = document.createElement('button'); rm.type = 'button'; rm.className = 'fbn-rm'; rm.innerHTML = '&times;';
            rm.addEventListener('click', function () { current.strokes = current.strokes.filter(function (s) { return s !== st; }); hidePop(); redraw(); renderNotes(); });
            row.appendChild(dot); row.appendChild(label); row.appendChild(rm);
            notesEl.appendChild(row);
        });
    }

    /* burn the strokes into the image at full resolution */
    function compositeShot(s) {
        return new Promise(function (resolve) {
            if (!s.strokes || !s.strokes.length) { resolve(s.file); return; }
            var img = new Image();
            img.onload = function () {
                var w = img.naturalWidth, h = img.naturalHeight;
                var cv = document.createElement('canvas'); cv.width = w; cv.height = h;
                var c = cv.getContext('2d');
                c.drawImage(img, 0, 0, w, h);
                var lw = Math.max(3, w * 0.006);
                c.lineJoin = 'round'; c.lineCap = 'round'; c.lineWidth = lw;
                s.strokes.forEach(function (st) {
                    c.strokeStyle = c.fillStyle = COLORS[st.color] || COLORS.danger;
                    if (st.points.length < 2) {
                        var p = st.points[0];
                        c.beginPath(); c.arc(p.x * w, p.y * h, lw, 0, 6.2832); c.fill();
                        return;
                    }
                    c.beginPath();
                    st.points.forEach(function (p, i) {
                        var x = p.x * w, y = p.y * h;
                        if (i === 0) c.moveTo(x, y); else c.lineTo(x, y);
                    });
                    c.stroke();
                });
                (s.strokes || []).filter(function (st) { return (st.note || '').trim(); }).forEach(function (st, i) {
                    var bb = bboxOf(st), r = Math.max(11, w * 0.018);
                    drawBadge(c, clamp(bb.x * w, r, w - r), clamp(bb.y * h, r, h - r), r, COLORS[st.color] || COLORS.danger, i + 1);
                });
                cv.toBlob(function (blob) {
                    var name = (s.file.name || 'screenshot').replace(/\.\w+$/, '') + '.png';
                    resolve(new File([blob], name, { type: 'image/png' }));
                }, 'image/png');
            };
            img.onerror = function () { resolve(s.file); };
            img.src = s.url;
        });
    }

    /* drag the handle/header down to dismiss, like a native bottom sheet */
    function makeSheet(modal, onDismiss) {
        var startY = 0, dy = 0, dragging = false;
        var isMobile = function () { return window.matchMedia('(max-width: 640px)').matches; };
        modal.addEventListener('pointerdown', function (e) {
            if (!isMobile() || !e.target.closest('.fbn-grab, .fbn-head')) return;
            dragging = true; startY = e.clientY; dy = 0; modal.style.transition = 'none';
        });
        window.addEventListener('pointermove', function (e) {
            if (!dragging) return;
            dy = Math.max(0, e.clientY - startY);
            modal.style.transform = 'translateY(' + dy + 'px)';
        });
        window.addEventListener('pointerup', function () {
            if (!dragging) return;
            dragging = false;
            modal.style.transition = 'transform .25s cubic-bezier(.22,1,.36,1)';
            modal.style.transform = '';
            if (dy > 110) onDismiss();
        });
    }
    makeSheet($('.fbn-modal'), close);
    makeSheet($('.fbn-annot-modal'), cancelAnnot);

    /* ---------- wiring ---------- */
    fab.addEventListener('click', open);
    root.querySelectorAll('[data-close]').forEach(function (b) { b.addEventListener('click', close); });
    overlay.addEventListener('click', function (e) { if (e.target === overlay) close(); });
    annot.addEventListener('click', function (e) { if (e.target === annot) cancelAnnot(); });
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        if (!pop.hidden) hidePop();
        else if (!annot.hidden) cancelAnnot();
        else if (!overlay.hidden) close();
    });
    root.querySelectorAll('[data-annot-cancel]').forEach(function (b) { b.addEventListener('click', cancelAnnot); });
    $('[data-annot-done]').addEventListener('click', closeAnnot);

    drop.addEventListener('click', function () { fileIn.click(); });
    drop.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); fileIn.click(); } });
    fileIn.addEventListener('change', function () { addFiles(fileIn.files); fileIn.value = ''; });
    ['dragover', 'dragenter'].forEach(function (ev) { drop.addEventListener(ev, function (e) { e.preventDefault(); drop.classList.add('fbn-over'); }); });
    ['dragleave', 'drop'].forEach(function (ev) { drop.addEventListener(ev, function (e) { e.preventDefault(); drop.classList.remove('fbn-over'); }); });
    drop.addEventListener('drop', function (e) { addFiles(e.dataTransfer.files); });
    document.addEventListener('paste', function (e) {
        if (overlay.hidden || !annot.hidden) return;
        var items = (e.clipboardData || {}).items || [], files = [];
        for (var i = 0; i < items.length; i++) {
            if (items[i].type && items[i].type.indexOf('image') === 0) files.push(items[i].getAsFile());
        }
        if (files.length) addFiles(files);
    });

    sendBtn.addEventListener('click', function () {
        var desc = descIn.value.trim();
        if (!desc) { setMsg('Please describe the issue.', 'err'); descIn.focus(); return; }

        sendBtn.disabled = true; sendLabel.textContent = 'Sending…'; setMsg('');

        Promise.all(shots.map(compositeShot)).then(function (files) {
            var fd = new FormData();
            fd.append('url', urlIn.value);
            fd.append('description', desc);
            files.forEach(function (f, i) {
                fd.append('screenshots[]', f);
                var notes = notedStrokes(shots[i]).map(function (st) { return { color: st.color, text: st.note.trim() }; });
                fd.append('notes[]', JSON.stringify(notes));
            });

            return fetch(endpoint, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: fd,
            });
        }).then(function (r) { return r.json().then(function (d) { return { ok: r.ok, d: d }; }); })
          .then(function (res) {
            if (res.ok && res.d.ok) {
                setMsg('Thank you! Your report has reached the team. We really appreciate it.', 'ok');
                descIn.value = ''; shots = []; renderShots();
            } else {
                var m = res.d.message || (res.d.errors ? Object.values(res.d.errors)[0][0] : 'Something went wrong.');
                setMsg(m, 'err');
            }
        }).catch(function () { setMsg('Network error. Please try again.', 'err'); })
          .finally(function () { sendBtn.disabled = false; sendLabel.textContent = 'Send issue'; });
    });
})();
</script>
