<template>
  <div class="container clearfix">
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

    created() {
      this.articles = this.$store.getters.getArticles
    }
  }
</script>
