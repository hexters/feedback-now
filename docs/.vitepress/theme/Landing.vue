<script setup lang="ts">
import { onMounted } from 'vue'
import { withBase } from 'vitepress'

const repo = 'https://github.com/hexters/feedback-now'
const img = (p: string) => withBase(p)

const steps = [
  { c: 'info', n: '1', t: 'Client clicks Report', d: 'A floating button sits on every page. They type what went wrong; the page path is captured automatically.' },
  { c: 'success', n: '2', t: 'They mark it up', d: 'Draw on the problem in four colors and drop a note right where they drew. Add as many screenshots as needed.' },
  { c: 'danger', n: '3', t: 'It becomes an issue', d: 'Filed straight into your GitHub or GitLab repo, with the annotated image and notes. Your agent takes it from there.' },
]

const features = [
  { t: 'Every page, no edits', d: 'A global middleware injects the button before </body>. No layouts to touch, no build step.' },
  { t: 'Off in production', d: 'Active only where a token is set. Leave it out of your production .env and it never shows.' },
  { t: 'GitHub & GitLab', d: 'One token, one repo. Self-hosted GitLab supported through a single host setting.' },
  { t: 'No frontend framework', d: "Plain vanilla JS and scoped CSS. It won't touch your app's styles or pull in a thing." },
  { t: 'Rate limited', d: 'The submit endpoint is throttled and validates uploads, so it cannot be hammered.' },
  { t: 'Laravel 11, 12, 13', d: 'PHP 8.2+. Tested across the matrix, MIT licensed, and open source.' },
]

onMounted(() => {
  const els = document.querySelectorAll<HTMLElement>('.fn-landing [data-reveal]')
  if (!('IntersectionObserver' in window)) { els.forEach((e) => e.classList.add('in')); return }
  const io = new IntersectionObserver((es) => {
    es.forEach((e) => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target) } })
  }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' })
  els.forEach((e) => io.observe(e))

  document.querySelectorAll<HTMLElement>('.fn-landing [data-copy]').forEach((b) => {
    b.addEventListener('click', () => {
      navigator.clipboard.writeText(b.dataset.copy || '').then(() => {
        const t = b.textContent; b.textContent = 'Copied'
        setTimeout(() => { b.textContent = t }, 1200)
      })
    })
  })
})
</script>

<template>
  <div class="fn-landing">
    <!-- hero -->
    <section class="hero">
      <div class="bg" aria-hidden="true"></div>
      <div class="wrap grid">
        <div class="copy">
          <span class="eyebrow">Laravel · in-app feedback</span>
          <h1>Client feedback your AI can <em>actually fix</em>.</h1>
          <p class="lede">A floating button on every page. Clients draw on what's wrong and write a note. It lands as a GitHub or GitLab issue your coding agent picks up.</p>
          <div class="actions">
            <span class="cmd">composer require hexters/feedback-now <button data-copy="composer require hexters/feedback-now">Copy</button></span>
            <a class="btn ghost" :href="withBase('/guide/installation')">Read the setup</a>
          </div>
        </div>
        <div class="media" data-reveal>
          <div class="frame">
            <div class="bar"><i></i><i></i><i></i><span class="url">your-app.test/profile</span></div>
            <img :src="img('/report.png')" alt="The Report an issue form a client sees on any page">
          </div>
        </div>
      </div>
    </section>

    <!-- the loop -->
    <section class="band">
      <div class="wrap">
        <div class="head" data-reveal>
          <span class="kicker"><span class="dots"><i class="d1"></i><i class="d2"></i><i class="d3"></i><i class="d4"></i></span> The loop</span>
          <h2>From “the thing is broken” to a fixable issue.</h2>
          <p>No more vague bug reports over chat. The client gives you the page, the words, and a marked-up screenshot — structured enough for an agent to act on.</p>
        </div>
        <div class="steps">
          <div class="step" v-for="(s, i) in steps" :key="s.n" data-reveal :style="{ transitionDelay: i * 0.06 + 's' }">
            <div class="n" :style="{ background: `var(--fn-${s.c})` }">{{ s.n }}</div>
            <h3>{{ s.t }}</h3>
            <p>{{ s.d }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- markup -->
    <section class="band">
      <div class="wrap split">
        <div data-reveal>
          <span class="eyebrow">Mark up the screenshot</span>
          <h2 class="h2sm">Point at the problem, in plain sight.</h2>
          <p class="muted">This is the part clients actually enjoy. Pick a color, draw, and a note box pops up exactly where they drew. Every mark is numbered and color-coded, then burned into the image and listed in the issue — so each note points to its mark.</p>
          <ul class="flist">
            <li><span class="dot" style="background:var(--fn-info)"></span> Four meanings: info, success, warning, danger.</li>
            <li><span class="dot" style="background:var(--fn-success)"></span> Numbered marks matched to numbered notes.</li>
            <li><span class="dot" style="background:var(--fn-warning)"></span> Draw, drop a file, or paste from the clipboard.</li>
            <li><span class="dot" style="background:var(--fn-danger)"></span> Roomy two-pane editor on desktop, simple on mobile.</li>
          </ul>
        </div>
        <div class="media stack" data-reveal>
          <div class="frame"><img :src="img('/markup.png')" alt="Drawing on a screenshot and adding a note"></div>
          <div class="frame"><img :src="img('/result.png')" alt="Each mark numbered and matched to its note"></div>
        </div>
      </div>
    </section>

    <!-- setup -->
    <section class="band">
      <div class="wrap">
        <div class="head" data-reveal>
          <span class="eyebrow">Setup</span>
          <h2>Three lines of env. That's it.</h2>
          <p>The button switches on wherever a token is set, so leaving the token out of production keeps it off there.</p>
        </div>
        <div class="code" data-reveal>
          <div class="clabel">Install</div>
<pre><code>composer require hexters/feedback-now
php artisan vendor:publish --tag=feedback-now-config</code></pre>
        </div>
        <div class="cols2">
          <div class="code" data-reveal>
            <div class="clabel"><span class="dots"><i class="d1"></i></span> .env · GitHub</div>
<pre><code><span class="k">FEEDBACK_NOW_PROVIDER</span>=<span class="v">github</span>
<span class="k">FEEDBACK_NOW_TOKEN</span>=<span class="v">ghp_xxx</span>
<span class="k">FEEDBACK_NOW_REPO</span>=<span class="v">owner/repo</span></code></pre>
          </div>
          <div class="code" data-reveal :style="{ transitionDelay: '.06s' }">
            <div class="clabel"><span class="dots"><i class="d2"></i></span> .env · GitLab</div>
<pre><code><span class="k">FEEDBACK_NOW_PROVIDER</span>=<span class="v">gitlab</span>
<span class="k">FEEDBACK_NOW_TOKEN</span>=<span class="v">glpat-xxx</span>
<span class="k">FEEDBACK_NOW_REPO</span>=<span class="v">12345</span></code></pre>
          </div>
        </div>
        <p class="note" data-reveal><b>Token:</b> on GitHub use a <b>classic</b> personal access token with the <code>repo</code> scope, and give it an expiry that matches the job — 6 months, or just the testing window. <a :href="withBase('/guide/providers')">More on providers and tokens →</a></p>
      </div>
    </section>

    <!-- issue -->
    <section class="band">
      <div class="wrap split rev">
        <div class="media" data-reveal>
          <div class="frame">
            <div class="bar"><i></i><i></i><i></i><span class="url">github.com/owner/repo/issues/3</span></div>
            <img :src="img('/issue.png')" alt="The created issue on GitHub with the annotated screenshot and notes">
          </div>
        </div>
        <div data-reveal>
          <span class="eyebrow">What lands in the issue</span>
          <h2 class="h2sm">Clean enough for an agent to act on.</h2>
          <ul class="flist">
            <li><span class="dot" style="background:var(--fn-info)"></span> The page path where it happened.</li>
            <li><span class="dot" style="background:var(--fn-success)"></span> The client's words as the title and body.</li>
            <li><span class="dot" style="background:var(--fn-warning)"></span> The annotated screenshot, marks burned in.</li>
            <li><span class="dot" style="background:var(--fn-danger)"></span> A numbered, color-coded note list, plus page and browser metadata.</li>
          </ul>
          <p class="muted">On GitHub the screenshots are committed and embedded; on GitLab they go through the upload API. Either way, hand the issue to Claude Code, Cursor, or whatever you run.</p>
        </div>
      </div>
    </section>

    <!-- features -->
    <section class="band">
      <div class="wrap">
        <div class="head" data-reveal>
          <span class="eyebrow">Built to stay out of the way</span>
          <h2>Small, safe, and zero-config on the frontend.</h2>
        </div>
        <div class="grid3">
          <div class="cell" v-for="(f, i) in features" :key="f.t" data-reveal :style="{ transitionDelay: (i % 3) * 0.04 + 's' }">
            <h3>{{ f.t }}</h3>
            <p>{{ f.d }}</p>
          </div>
        </div>

        <div class="cta" data-reveal>
          <h2>Ship it to your next client.</h2>
          <p>Turn vague bug reports into issues your AI can fix — in about a minute of setup.</p>
          <div class="cta-actions">
            <span class="cmd dark">composer require hexters/feedback-now <button data-copy="composer require hexters/feedback-now">Copy</button></span>
            <a class="btn ghost light" :href="repo" target="_blank" rel="noopener">View on GitHub</a>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<style scoped>
.fn-landing { color: var(--fn-ink); background: var(--fn-bg); }
.wrap { max-width: 1080px; margin: 0 auto; padding: 0 24px; }
.eyebrow { font-size: 13px; font-weight: 600; letter-spacing: .12em; text-transform: uppercase; color: var(--fn-accent); }
.muted { color: var(--fn-muted); }
.dots { display: inline-flex; gap: 5px; align-items: center; }
.dots i { width: 9px; height: 9px; border-radius: 99px; display: block; }
.dots .d1 { background: var(--fn-info); } .dots .d2 { background: var(--fn-success); }
.dots .d3 { background: var(--fn-warning); } .dots .d4 { background: var(--fn-danger); }
.btn { display: inline-flex; align-items: center; gap: 8px; font-weight: 600; font-size: 15px; border-radius: 10px; padding: 10px 17px; border: 1px solid var(--fn-line); background: transparent; color: var(--fn-ink); transition: border-color .15s; }
.btn.ghost:hover { border-color: var(--fn-ink); }
.btn.light { color: #fff; border-color: #3a3f4b; }

.hero { position: relative; padding: 70px 0 40px; overflow: hidden; }
.hero .bg { position: absolute; inset: 0; background-image: radial-gradient(circle at 1px 1px, rgba(20,23,31,.06) 1px, transparent 0); background-size: 26px 26px; -webkit-mask-image: radial-gradient(ellipse 70% 60% at 50% 30%, #000, transparent); mask-image: radial-gradient(ellipse 70% 60% at 50% 30%, #000, transparent); }
.grid { position: relative; display: grid; grid-template-columns: 1.04fr .96fr; gap: 48px; align-items: center; }
.hero h1 { font-size: clamp(36px, 5vw, 56px); font-weight: 800; margin-top: 16px; }
.hero h1 em { font-style: normal; color: var(--fn-accent); }
.lede { font-size: 19px; color: var(--fn-muted); margin: 18px 0 26px; max-width: 33ch; }
.actions { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.cmd { display: inline-flex; align-items: center; gap: 12px; background: var(--fn-code); color: #e9edf5; border-radius: 11px; padding: 11px 14px; font-family: 'JetBrains Mono', monospace; font-size: 13.5px; }
.cmd.dark { background: #000; }
.cmd button { border: 0; background: #252a36; color: #aeb6c6; border-radius: 7px; padding: 5px 9px; font-size: 11px; font-weight: 600; cursor: pointer; font-family: inherit; }
.cmd button:hover { color: #fff; }

.frame { border: 1px solid var(--fn-line); border-radius: 15px; overflow: hidden; background: #fff; box-shadow: 0 30px 60px -30px rgba(20,23,31,.28), 0 6px 18px -10px rgba(20,23,31,.18); }
.bar { display: flex; align-items: center; gap: 7px; padding: 11px 13px; border-bottom: 1px solid var(--fn-line); background: #fcfbf9; }
.bar i { width: 11px; height: 11px; border-radius: 99px; background: #e2ddd2; display: block; }
.bar .url { margin-left: 10px; font-family: 'JetBrains Mono', monospace; font-size: 11.5px; color: #9aa1ad; background: #fff; border: 1px solid var(--fn-line); border-radius: 6px; padding: 3px 10px; flex: 1; }
.frame img { display: block; width: 100%; }

.band { padding: 60px 0; border-top: 1px solid var(--fn-line); }
.head { max-width: 62ch; }
.head h2 { font-size: clamp(26px, 3.6vw, 35px); font-weight: 700; }
.head p { color: var(--fn-muted); font-size: 18px; margin-top: 12px; }
.kicker { display: inline-flex; align-items: center; gap: 9px; margin-bottom: 14px; font-size: 13px; font-weight: 600; letter-spacing: .12em; text-transform: uppercase; color: var(--fn-accent); }
.h2sm { font-size: clamp(25px, 3.3vw, 33px); margin-top: 12px; }

.steps { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 38px; }
.step { background: var(--fn-card); border: 1px solid var(--fn-line); border-radius: 16px; padding: 24px; }
.step .n { width: 34px; height: 34px; border-radius: 10px; display: grid; place-items: center; font-weight: 700; color: #fff; font-size: 15px; }
.step h3 { font-size: 18px; margin: 16px 0 7px; }
.step p { margin: 0; color: var(--fn-muted); font-size: 15.5px; }

.split { display: grid; grid-template-columns: 1fr 1fr; gap: 46px; align-items: center; }
.split.rev .media { order: -1; }
.media.stack { display: grid; gap: 16px; }
.flist { list-style: none; margin: 22px 0 0; padding: 0; display: grid; gap: 13px; }
.flist li { display: flex; gap: 12px; align-items: flex-start; font-size: 16px; }
.flist .dot { width: 11px; height: 11px; border-radius: 99px; margin-top: 7px; flex: none; }

.code { background: var(--fn-code); border-radius: 14px; padding: 6px 4px; overflow: hidden; margin-top: 22px; }
.clabel { display: flex; align-items: center; gap: 8px; padding: 11px 16px 6px; color: #8b93a4; font-size: 12px; font-weight: 600; letter-spacing: .04em; text-transform: uppercase; }
.code pre { margin: 0; padding: 6px 18px 16px; overflow-x: auto; }
.code code { font-family: 'JetBrains Mono', monospace; font-size: 13.5px; line-height: 1.75; color: #e9edf5; white-space: pre; }
.code .k { color: #7fb4ff; } .code .v { color: #a7e0b0; }
.cols2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-top: 18px; }
.note { margin-top: 20px; background: #fff; border: 1px solid var(--fn-line); border-left: 3px solid var(--fn-accent); border-radius: 10px; padding: 14px 16px; font-size: 15px; color: #3c4452; }
.note b { color: var(--fn-ink); } .note a { color: var(--fn-accent); font-weight: 600; }
.note code { font-family: 'JetBrains Mono', monospace; font-size: 13px; background: #f1efe8; padding: 1px 6px; border-radius: 5px; }

.grid3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; margin-top: 38px; }
.cell { background: var(--fn-card); border: 1px solid var(--fn-line); border-radius: 14px; padding: 22px; }
.cell h3 { font-size: 16.5px; margin: 0 0 7px; }
.cell p { margin: 0; color: var(--fn-muted); font-size: 15px; }

.cta { margin: 56px 0 8px; background: var(--fn-ink); color: #fff; border-radius: 22px; padding: 52px 40px; text-align: center; }
.cta h2 { font-size: clamp(25px, 3.4vw, 36px); color: #fff; }
.cta p { color: #aab2c2; margin: 14px auto 26px; max-width: 46ch; }
.cta-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

[data-reveal] { opacity: 0; transform: translateY(18px); transition: opacity .6s cubic-bezier(.22,1,.36,1), transform .6s cubic-bezier(.22,1,.36,1); }
[data-reveal].in { opacity: 1; transform: none; }
@media (prefers-reduced-motion: reduce) { [data-reveal] { opacity: 1; transform: none; transition: none; } }

@media (max-width: 860px) {
  .grid { grid-template-columns: 1fr; gap: 34px; }
  .lede { max-width: none; }
  .split { grid-template-columns: 1fr; gap: 26px; }
  .split.rev .media { order: 0; }
}
@media (max-width: 780px) {
  .steps, .grid3, .cols2 { grid-template-columns: 1fr; }
}
</style>
