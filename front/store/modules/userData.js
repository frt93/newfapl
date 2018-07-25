export default {
  state: {
    isModalOpen: false,
    userData: [],
    isUserLogged: true,
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
    },
    userLogged (VuexContext, user) {
        VuexContext.commit('userLogged', user)
    }
  },

  getters: {
    userData (state) {
      return state.userData
    },

    getLaravelCsrfToken (state) {
      return state.laravelCsrfToken
    }
  }
}