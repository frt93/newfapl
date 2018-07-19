module.exports = {
  /*
  ** Headers of the page
  */
  head: {
    titleTemplate: (titleChunk) => {
      // If undefined or blank then we don't need the hyphen
      return titleChunk ? `${titleChunk} - English Premier League` : 'English Premier League';
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'Site about English Football League' }
    ],
    script: [
      
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'stylesheet', href: '/resources/css/bootstrap.min.css' },
      { rel: 'stylesheet', href: '/resources/css/style.css' },
    ],
  },
  /*
  ** Customize the progress bar color
  */
  loading: { color: '#38003c', failedColor: 'red' },

  /*
  ** Router setup
  */
  router: {
    linkExactActiveClass: 'active',
    linkActiveClass: ''
  },

  /*
  **Nuxt.js modules
  */
  modules: [
    '@nuxtjs/axios',
    '@nuxtjs/moment',
  ],

  /*
  **Axios module config
  */
  axios: {
    baseURL: process.env.BASE_URL || 'http://localhost:3000/api/',
    retry: { retries: 5 },
    debug: false
  },

  /*
  **Moment.js module config
  */
  moment: {
    locales: ['es-us', 'ru']
  },

  /*
  ** Build configuration
  */
  build: {
    vendor: [
      'axios'
    ],
    
    /*
    ** Run ESLint on save
    */
    extend (config, { isDev, isClient }) {
      if (isDev && isClient) {
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })
      }
    }
  },
  serverMiddleware: [
    '~/api/index.js'
  ]
}
