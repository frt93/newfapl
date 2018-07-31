<template>
  <div class="container clearfix">
    <main id="maincontent" class="clearfix">
      <stagedFilter
        model="articles"
        container="maincontent"
        :competitions="filterData.co"
        :clubs="filterData.club"
        :players="filterData.pl"
        :selected="filterData.picked"
        :defaults="filterData.defaults"
        @filterArticles="filterArticles"
      >
      </stagedFilter>
      <articlePreview 
        v-for="article in articles" 
        :key="article.id"
        :id="article.id"
        :title="article.title"
        :excerpt="article.excerpt"
        :isPublished="article.published"
        :date="article.published_at"
        :categories="article.categories"
        >
      </articlePreview>

      <pagination 
        container="maincontent"
        type="default"
        loadBtnValue="Загрузить еще"
        loadingText="Грузим статьи"
        fetchErrMsg="Не удается получить данные"
        model="articles"
        @addArticles="addArticles"
      >
      </pagination>
    </main>
  </div>
</template>

<script>
  import articlePreview from './articlePreview'
  import pagination from '~/components/ui/pagination'
  import stagedFilter from '~/components/ui/filters/staged'
  
  export default {
    name: 'articlesList',
    components: {
      articlePreview, pagination, stagedFilter
    },

    data() {
      return {
        isSocialBlockOpen: false,
        articles: this.articlesData.data,
        filterData: this.articlesData.filtersData
      }
    },

    methods: {
      addArticles (articles) {
        this.$store.dispatch('setArticles', articles)
        articles.data.forEach((article, i) => {
          this.articles.push(article);
        });
      },
      filterArticles (articles) {
        this.articles = articles.data;
        this.$store.dispatch('setArticles', articles)
      }
    },

    props: {
      articlesData: {
        type:Object,
        required: true
      }
    },

    created() {
      this.$store.dispatch('setArticles', this.articlesData)
    }
  }
</script>
