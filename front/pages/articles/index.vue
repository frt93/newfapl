<template>
  <Articles />
</template>

<script>
import Articles from '~/components/articles/articlesList'

export default {
  components: {
    Articles
  },

  watchQuery: ['page'],

  async asyncData ({ app, store, query }) {
    if (!store.getters.getArticles.length) {
      let { data } = await app.$axios.post('articles', query)
      return store.dispatch('setArticles', data)
    }
  },

  head () {
    return {
      titleChunk: 'Новости'
    }
  }
}
</script>
