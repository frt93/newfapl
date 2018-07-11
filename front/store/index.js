import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const UserData = () => new Vuex.Store({

  state: {
    isModalOpen: false,
    userData: [],
    isUserLogged: true,
    articles: [],
    articlesMeta: [],
    pinnedArticle: [],
    currentArticle: [],
    laravelCsrfToken: null
  },
  
  mutations: {
    showAuthModal (state, payload) {
      state.isModalOpen = payload
    },
    userLogged (state, payload) {
      state.isUserLogged = true;
      state.userData = payload
    },
    setArticles(state, response) {
      state.articles = response.data;
    },
    pinnedArticle(state,article) {
      state.pinnedArticle = article
    },
    currentArticle(state, article) {
      state.currentArticle = article
    },
    setLaravelCsrfToken (state, token) {
      state.laravelCsrfToken = token
    }
  },

  actions: {
    nuxtServerInit (VuexContext, context) {
      return Promise.resolve(context.$axios.get('http://back.loc/gettoken')
        .then(res => {
          VuexContext.commit('setLaravelCsrfToken', res.data)
        }))
    },
    userLogged(VuexContext, user) {
        VuexContext.commit('userLogged', user)
    },
    setArticles(VuexContext, response) {
      VuexContext.commit('setArticles', response)
    },
    pinnedArticle(VuexContext, article) {
      VuexContext.commit('pinnedArticle', article)
    },
    currentArticle(VuexContext, article) {
      VuexContext.commit('currentArticle', article)
    }
  },

  getters: {
    userData(state) {
      return state.userData
    },

    getArticles(state) {
      return state.articles
    },

    getPinnedArticle(state) {
      return state.pinnedArticle
    },

    getCurrentArticle(state) {
      return state.currentArticle
    },

    getLaravelCsrfToken(state) {
      return state.laravelCsrfToken
    }
  }
})

export default UserData
