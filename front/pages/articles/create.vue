<template>
<div class='div container single-container clearfix'>
  <h1>Создать новость</h1>
  <main class="clearfix">
    <form method="POST" @submit.prevent="saveArticle($event.target)" accept-charset="UTF-8" id="formm">
    <div id="formGroup">
      <div class="form-group">
        <input type="submit" value="Создать" class="btn btn-primary">
      </div>

      <div class="form-group">
        <input type="checkbox" 
               v-model="article.pinned" 
               :true-value="1" 
               :false-value="0"
        >
        <input name="pinned" type="hidden" :value="article.pinned">
        <label for="checkbox">Pinned?</label>
      </div>
      
      <div class="form-group">
        <label for="title">Заголовок</label> 
        <input name="title" type="text" v-model="article.title" class="form-control">
      </div>

      <div class="form-group">
        <label for="body">Превью</label> 
        <textarea name="excerpt" cols="50" rows="10" id="excerpt" class="form-control" v-model="article.excerpt"></textarea>
      </div>

      <div class="form-group">
        <label for="body">Содержание</label> 
        <textarea name="body" cols="50" rows="10" id="body" class="form-control" v-model="article.body"></textarea>
      </div>

      <div class="form-group">
        <label for="published_at">Дата публикации</label> 
        <input name="published_at" type="datetime" :value="article.date" id="published_at" class="form-control">
      </div>

      <div class="form-group">
        <label for="author">Автор</label> 
        <input name="author" type="text" :value="article.author" id="author" class="form-control">
      </div>
      
      <div class="form-group">
        <select name="tag_list[]" multiple>
          <option v-for="tag in relationalData.tagsList" :key="tag.id" 
                  :value="tag.id" 
                  >
                  {{tag.name}}
          </option>
        </select>
      </div>

      <div class="form-group">
        <select name="competition_list[]" multiple>
          <option v-for="competition in relationalData.competitionsList" :key="competition.id" 
                  :value="competition.id" 
                  >
                  {{competition.name}}
            </option>
        </select>
      </div>

      <div class="form-group">
        <select name="player_list[]" multiple>
          <option v-for="player in relationalData.playersList" :key="player.id" 
                  :value="player.id" 
                  >
                  {{player.name}}
          </option>
        </select>
      </div>

      <div class="form-group">
        <select name="club_list[]" multiple>
          <option v-for="club in relationalData.clubsList" :key="club.id" 
                  :value="club.id" 
                  >
                  {{club.name}}
          </option>
        </select>
      </div>

      <div class="form-group">
        <select name="staff_list[]" multiple>
          <option v-for="staff in relationalData.staffList" :key="staff.id" 
                  :value="staff.id" 
                  >
                  {{staff.name}}
          </option>
        </select>
      </div>
      
      <div class="form-group">
        <select name="category_list[]" multiple>
          <option v-for="category in relationalData.categoriesList" :key="category.id" 
                  :value="category.id" 
                  >
                  {{category.name}}
          </option>
        </select>
      </div>

      <div class="form-group">
        <input type="submit" value="Создать" class="btn btn-primary">
      </div>
    </div>
    </form>
  </main>
</div> 
</template>

<script>
  export default {
    data() {
      return {
        article: {
          title: '',
          excerpt: '',
          body: '',
          pinned: 0,
          date: '',
          author: this.$store.getters.userData.username,


        }
      }
    },

    async asyncData({ app }) {
      let { data } = await app.$axios.get('/articles/create')
      return { relationalData: data }
    },

    methods: {
      saveArticle(form, params) {
        const article = new FormData(form);
        this.$axios.post('/articles/store', article)
            .then((res) => {
              this.$router.push('/articles/' + res.data.id)
            })
            .catch((err) => {
              console.log(err)
            })
      },

      realtime() {
        this.article.date = this.$moment().format('Y-M-D H:mm:ss')

      },
    },

    mounted() {
      this.interval = setInterval(this.realtime, 1000)
    },

    beforeDestroy() {
      clearInterval(this.interval)
    },

    head() {
      return {
        titleChunk: 'Создать новость'
      }
  }
  }
</script>