export default {
  state: {
    articles: {},
    pinnedArticle: [],
    currentArticle: []
  },
  mutations: {
    setArticles (state, data) {
      if (!state.articles.pages) 
        state.articles = {...state.articles, ...{ pages:{} } };
      if (!state.articles.pages.start) {
        state.articles.pages.start = data.pages.current;
      }
      state.articles.pages.current = data.pages.current;
      state.articles.pages.next = data.pages.current+1;
      state.articles.pages.last = data.pages.last;
    },
    pinnedArticle (state,article) {
      state.pinnedArticle = article
    },
    currentArticle (state, article) {
      state.currentArticle = article
    }
  },
  actions: {
    setArticles (VuexContext, articles) {
      VuexContext.commit('setArticles', articles);
    },
    pinnedArticle (VuexContext, article) {
      VuexContext.commit('pinnedArticle', article)
    },
    currentArticle (VuexContext, article) {
      VuexContext.commit('currentArticle', article)
    }
  },
  getters: {
    getArticles (state) {
      return state.articles
    },

    getPinnedArticle (state) {
      return state.pinnedArticle
    },

    getCurrentArticle (state) {
      return state.currentArticle
    },
  },
}
