import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export default new Vuex.Store({
    state: {
      isModalOpen: false,
      userData: [],
      isUserLogged: ''
    },
    mutations: {
        showAuthModal (state, payload) {
            state.isModalOpen = payload
        },
        userLogged (state, payload) {
            state.isUserLogged = true;
            state.userData = payload
        }
    }
})