<template>
    <Articles />
</template>

<script>
import Articles from '~/components/articles/articlesList'

export default {
  components: {
    Articles
  },

  async asyncData({ app, params, store, query }) {
    // We can return a Promise instead of calling the callback
    let page = ( query.page ) ? '?page='+query.page : '';

    let { data } = await app.$axios.get('/articles/getlast' + page)
    return store.dispatch('setArticles', data)
  }
}
</script>
