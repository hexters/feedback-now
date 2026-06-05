import { defineConfig } from 'vitepress'

const site = 'https://hexters.github.io/feedback-now'
const desc =
  'In-app feedback and bug reporting for Laravel. A floating button lets clients report bugs with annotated screenshots; it files them as GitHub or GitLab issues your coding agent can fix.'

export default defineConfig({
  lang: 'en-US',
  title: 'Feedback Now for Laravel',
  description: desc,
  base: '/feedback-now/',
  cleanUrls: true,
  lastUpdated: true,
  sitemap: { hostname: site },

  // Canonical URL on every page (SEO / duplicate-content).
  transformPageData(pageData) {
    const path = pageData.relativePath.replace(/(^|\/)index\.md$/, '$1').replace(/\.md$/, '')
    pageData.frontmatter.head ??= []
    pageData.frontmatter.head.push(['link', { rel: 'canonical', href: `${site}/${path}` }])
  },

  head: [
    ['link', { rel: 'icon', href: '/feedback-now/favicon.svg', type: 'image/svg+xml' }],
    ['link', { rel: 'preconnect', href: 'https://fonts.googleapis.com' }],
    ['link', { rel: 'preconnect', href: 'https://fonts.gstatic.com', crossorigin: '' }],
    ['link', {
      rel: 'stylesheet',
      href: 'https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&display=swap',
    }],
    ['meta', { name: 'theme-color', content: '#2f6fed' }],
    ['meta', { name: 'author', content: 'Asep SS (hexters)' }],
    ['meta', { name: 'keywords', content: 'laravel, feedback, in-app feedback, bug report, issue tracker, github, gitlab, screenshot annotation, php, developer tools' }],
    ['meta', { property: 'og:type', content: 'website' }],
    ['meta', { property: 'og:site_name', content: 'Feedback Now for Laravel' }],
    ['meta', { property: 'og:title', content: 'Feedback Now — in-app feedback for Laravel your AI can fix' }],
    ['meta', { property: 'og:description', content: desc }],
    ['meta', { property: 'og:image', content: site + '/og.png' }],
    ['meta', { property: 'og:url', content: site + '/' }],
    ['meta', { name: 'twitter:card', content: 'summary_large_image' }],
    ['meta', { name: 'twitter:title', content: 'Feedback Now — in-app feedback for Laravel' }],
    ['meta', { name: 'twitter:description', content: desc }],
    ['meta', { name: 'twitter:image', content: site + '/og.png' }],
  ],

  themeConfig: {
    siteTitle: 'Feedback Now',
    logo: '/favicon.svg',

    nav: [
      { text: 'Guide', link: '/guide/introduction', activeMatch: '/guide/' },
      { text: 'Setup', link: '/guide/installation' },
      { text: 'Mark up', link: '/guide/markup' },
      { text: 'Configuration', link: '/guide/configuration' },
      {
        text: 'Links',
        items: [
          { text: 'GitHub', link: 'https://github.com/hexters/feedback-now' },
          { text: 'Packagist', link: 'https://packagist.org/packages/hexters/feedback-now' },
          { text: 'Report an issue', link: 'https://github.com/hexters/feedback-now/issues' },
        ],
      },
    ],

    sidebar: {
      '/guide/': [
        {
          text: 'Getting started',
          items: [
            { text: 'Introduction', link: '/guide/introduction' },
            { text: 'Installation', link: '/guide/installation' },
          ],
        },
        {
          text: 'Using it',
          items: [
            { text: 'The report button', link: '/guide/usage' },
            { text: 'Marking up screenshots', link: '/guide/markup' },
          ],
        },
        {
          text: 'Providers',
          items: [
            { text: 'GitHub & GitLab', link: '/guide/providers' },
          ],
        },
        {
          text: 'Reference',
          items: [
            { text: 'Configuration', link: '/guide/configuration' },
            { text: 'The created issue', link: '/guide/issue' },
          ],
        },
      ],
    },

    socialLinks: [{ icon: 'github', link: 'https://github.com/hexters/feedback-now' }],
    search: { provider: 'local' },
    editLink: {
      pattern: 'https://github.com/hexters/feedback-now/edit/main/docs/:path',
      text: 'Edit this page on GitHub',
    },
    footer: {
      message: 'In-app feedback for Laravel. MIT licensed, open source.',
      copyright: '© 2026 Asep SS (hexters)',
    },
  },
})
