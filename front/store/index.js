import Vue from 'vue'
import Vuex from 'vuex'
import Articles from './modules/articles'
import UserData from './modules/userData'
import filters from './modules/filters'

Vue.use(Vuex);

const store = () => new Vuex.Store({
  modules: {
    Articles, UserData, filters
  }
  
})

export default store
