<template>
  <div class="container clearfix">
    <main id="maincontent" class="clearfix">
      <contentFilter api-path="/api"
                            model="articles"
                            container="content"
                            reset-btn-value="Сбросить"
                            search-btn-value="Поиск"
                            :competitions="this.filterData.co"
                            :clubs="this.filterData.club"
                            :players="this.filterData.pl"
                            competition-slug="all"
                            competition-name="Все турниры"
                            club-slug="all"
                            club-name="Все клубы"
                            player-slug="all"
                            player-name="Все игроки"
                            unpicked-competition="Выберите турнир"
                            unpicked-club="Выберите клуб"
                            unpicked-player="Выберите игрока"
                            fetch-clubs-err-msg="Не удалось получить список клубов"
                            fetch-players-err-msg="Не удалось получить список игроков"
                            fetch-data-err-msg="Не удалось получить данные"
                            exceeded-requests-msg="Превышено количество попыток"
                            is-filtered="">

      </contentFilter>
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

      <pagination container="maincontent"
              type="default"
              loadBtnValue="Загрузить еще"
              loadingText="Грузим статьи"
              fetchErrMsg="Не удается получить данные"
              model="articles"
              :pages="pages"
              @addArticles="addArticles">
      </pagination>
    </main>
  </div>
</template>

<script>
  import articlePreview from './articlePreview'
  import pagination from '~/components/ui/pagination'
  import contentFilter from '~/components/ui/threeStageFilter'
  
  export default {
    name: 'articlesList',
    components: {
      articlePreview, pagination, contentFilter
    },

    data() {
      return {
        isSocialBlockOpen: false,
        articles: [],
        pages : {
          start:this.articlesData.pages.current,
          last:this.articlesData.pages.last
        }
      }
    },

    methods: {
      addArticles(articles) {
        articles.forEach((article, i) => {
          this.articles.push(article);
        });
      }
    },

    props: {
      articlesData: {
        type:Object,
        required: true
      }
    },

    created() {
      this.articles = this.articlesData.data
      this.filterData = this.articlesData.filtersData
    }
  }
</script>
