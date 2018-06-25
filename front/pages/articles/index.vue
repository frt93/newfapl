<template>
    <Articles />
</template>

<script>
import Articles from '~/components/articles/articlesList'

export default {
  components: {
    Articles
  },

  // fetch ({ store }) {
  //   return axios.get('http://fapl.loc/api/articles/getlast')
  //   .then((res) => {
  //     this.articles = res.data
  //     store.dispatch('setArticles', res.data)
  //   })
  // },

  async asyncData({ app, params, store }) {
    // We can return a Promise instead of calling the callback
    let { data } = await app.$axios.get('/articles/getlast')
    return store.dispatch('setArticles', data)
  }
}
</script>
