<template>
  <div class="container clearfix">
    <span @click="addParams">Добавить параметры</span>
    <main id="maincontent" class="clearfix">
      <articlePreview 
        v-for="article in articles" 
        :key="article.id"
        :id="article.id"
        :title="article.title"
        :excerpt="article.excerpt"
        :isPublished="article.published"
        :date="article.published_at"
        :categories="article.categories">
      </articlePreview>
    </main>
  </div>
</template>

<script>
  import articlePreview from '~/components/articles/articlePreview'
  
  export default {
    name: 'articlesList',
    components: {
      articlePreview
    },

    data() {
      return {
        isSocialBlockOpen: false,
        articles: []
      }
    },

    methods: {
      addParams() {
        this.$router.push({query: { page: '3' }})
      }
    },

    created() {
      this.articles = this.$store.getters.getArticles
    }
  }
</script>
