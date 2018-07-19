<template>
  <Article />
</template>

<script>
import Article from '~/components/articles/pinnedArticle'

export default {
  components: {
    Article
  },

  async asyncData ({ app, store }) {
    // We can return a Promise instead of calling the callback
    if (store.getters.getPinnedArticle.length == 0) {
      let { data } = await app.$axios.get('/articles/pinned')
      return store.dispatch('pinnedArticle', data)
    }
  },

  head () {
    return {
      titleChunk: 'Главная'
    }
  }
}
</script>
