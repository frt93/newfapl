<template>
  <Articles :articlesData="articles"></Articles>
</template>

<script>
import Articles from '~/components/articles/articlesList'

export default {
  components: {
    Articles
  },

  async asyncData ({ app, store, query }) {
      let { data } = await app.$axios.post('articles', {query, ...{'ancillarydata': true}})
      return {articles: data}
  },

  head () {
    return {
      titleChunk: 'Новости'
    }
  }
}
</script>
