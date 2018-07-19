import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const UserData = () => new Vuex.Store({

  state: {
    isModalOpen: false,
    userData: [],
    isUserLogged: true,
    articles: [],
    articlesMeta: {pages: {}},
    pinnedArticle: [],
    currentArticle: [],
    laravelCsrfToken: null,
    filtersData: {competitions: {}, clubs: {}, players: {}}
  },
  
  mutations: {
    showAuthModal (state, payload) {
      state.isModalOpen = payload
    },
    userLogged (state, payload) {
      state.isUserLogged = true;
      state.userData = payload
    },
    setArticles (state, response) {
      response.forEach((article, i) => {
        state.articles.push(article);
      });
      
    },
    setArticlesMeta (state, data) {
      state.articlesMeta.pages.last = data.last_page;
      state.articlesMeta.pages.current = data.current_page;
      if ( !state.articlesMeta.pages.start ) {
        state.articlesMeta.pages.start = data.current_page;
      }
      state.filtersData.competitions = data.co;
      state.filtersData.clubs = data.club;
      state.filtersData.players = data.pl;
    },
    pinnedArticle (state,article) {
      state.pinnedArticle = article
    },
    currentArticle (state, article) {
      state.currentArticle = article
    },
    setLaravelCsrfToken (state, token) {
      state.laravelCsrfToken = token
    }
  },

  actions: {
    nuxtServerInit (VuexContext, context, query) {
      // return Promise.resolve(context.$axios.get('http://back.loc/gettoken')
      //   .then(res => {
      //     VuexContext.commit('setLaravelCsrfToken', res.data)
      //   }))
      if (context.route.name == 'articles') {
        return Promise.resolve(context.$axios.post('articles', context.route.query)
          .then(res => {
            VuexContext.dispatch('setArticles', res.data)
        }))
      }
    },
    userLogged (VuexContext, user) {
        VuexContext.commit('userLogged', user)
    },
    setArticles (VuexContext, articles) {
      VuexContext.commit('setArticles', articles.data);
      VuexContext.commit('setArticlesMeta', articles)
    },
    pinnedArticle (VuexContext, article) {
      VuexContext.commit('pinnedArticle', article)
    },
    currentArticle (VuexContext, article) {
      VuexContext.commit('currentArticle', article)
    }
  },

  getters: {
    userData (state) {
      return state.userData
    },

    getArticles (state) {
      return state.articles
    },

    getArticlesMeta (state) {
      return state.articlesMeta
    },

    getPinnedArticle (state) {
      return state.pinnedArticle
    },

    getCurrentArticle (state) {
      return state.currentArticle
    },

    getLaravelCsrfToken (state) {
      return state.laravelCsrfToken
    },

    getFiltersData (state) {
      return state.filtersData
    }
  }
})

export default UserData
