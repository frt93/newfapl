<template>
<div>
  <header class="entry-head">
    <div class="container entry-head-content clearfix">
      <div class="articlehead">
        
        <h5>
          <div 
              v-for="category in article.categories" 
              :key="category.id">
              {{ category }}
          </div>
        </h5>
        <h1>{{ article.title }}</h1>
        <h5>
          {{ article.author }}
          <span>{{ this.$moment(article.published_at).fromNow() }}</span>
        </h5>
        <h5><nuxt-link :to="editLink">Изменить</nuxt-link></h5>
      </div>

    </div>
  </header>
  <div class="container single-container clearfix">
    <Social />
    <main class="single-entry clearfix">
      <article class="single-entry clearfix">
        <span class="entry-full-img">
          <img src="/i/eden200.jpg" style="height:650px; width:964px">
        </span>
        <span class="entry-content">
          {{ article.body }}
        </span>
      </article>
      <hr>
      <h5>Теги:</h5>
      <ul>
        <li 
            style="float:left; margin-right:15px"
            v-for="tag in article.tags" 
            :key="tag">
            {{ tag }}
        </li>
      </ul>
      <hr>
      <h5>Игроки:</h5>
      <ul>
        <li 
          style="float:left; margin-right:15px"
          v-for="player in article.players" 
          :key="player.id">
          {{ player }}
        </li>
      </ul>
      <hr>
      <h5>Клубы:</h5>
      <ul>
        <li 
          style="float:left; margin-right:15px"
          v-for="club in article.clubs" 
          :key="club.id">
          {{ club }}
        </li>
      </ul>
      <hr>
      <h5>Персонал:</h5>
      <ul>
        <li 
          style="float:left; margin-right:15px"
          v-for="staff in article.staff" 
          :key="staff.id">
          {{ staff }}
        </li>
      </ul>
      <div class="navigation clearfix">
        <span class="previous-entry" v-if="article.previous">
          <nuxt-link :to="prevLink">Предыдущая</nuxt-link>
        </span>
        <span class="next-entry" v-if="article.next">
          <nuxt-link :to="nextLink">Следующая</nuxt-link>
        </span>
      </div>
      <section class="mainWidget latest">
        <header class="clearfix">
          <h3 class="clearfix">Latest News</h3>
        </header>
        <nuxt-link class="btn moreBtn" to="/articles">More News
          <span class="icn arrow-right"></span>
        </nuxt-link>
      </section>
    </main>
  </div>
</div>
</template>

<script>
import Social from '@/components/articles/social'

export default {
  validate ({ params }) {
    // Must be a number
    return /^\d+$/.test(params.id)
  },

  components: {
    Social
  },

  async asyncData ({ app, params }) {
    let { data } = await app.$axios.get(`/articles/${params.id}`)
    return { article: data }
  },

  computed: {
    editLink () {
      return `/articles/${this.$route.params.id}/edit`
    },
    prevLink () {
      return `/articles/${this.article.previous}`
    },
    nextLink () {
      return `/articles/${this.article.next}`
    }
  },

  head () {
    return {
      titleChunk: this.article.title
    }
  }
}
</script>
