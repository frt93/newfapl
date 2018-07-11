<template>
<div>{{this.$route.query}}
  <div v-for="r in this.$route.query" :key="r">{{r}}</div>
    <Articles /></div>
</template>

<script>
import Articles from '~/components/articles/articlesList'

export default {
  components: {
    Articles
  },

  watchQuery: ['page', 'club'],

  async asyncData({ app, params, store, query }) {
    let { data } = await app.$axios.get(`/articles?`)
    return store.dispatch('setArticles', data)
  },

  head() {
    return {
      titleChunk: 'Новости'
    }
  }
}
</script>
