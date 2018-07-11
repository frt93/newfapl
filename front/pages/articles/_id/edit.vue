<template>
<div class='div container single-container clearfix'>
  <h1>Редактировать новость</h1>
  <main class="clearfix">
    <form method="POST" @submit.prevent="saveArticle($event.target)" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="PATCH">
    <div id="formGroup">
      <div class="form-group">
        <input type="submit" value="Сохранить" class="btn btn-primary">
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
        <textarea name="excerpt" cols="50" rows="10" class="form-control" v-model="article.excerpt"></textarea>
      </div>

      <div class="form-group">
        <label for="body">Содержание</label> 
        <textarea name="body" cols="50" rows="10" class="form-control" v-model="article.body"></textarea>
      </div>

      <div class="form-group">
        <label for="published_at">Дата публикации</label> 
        <input name="published_at" type="datetime" :value="article.published_at" class="form-control">
      </div>

      <div class="form-group">
        <label for="author">Автор</label> 
        <input name="author" type="text" :value="article.author" class="form-control">
      </div>
      
      <div class="form-group">
        <select name="tag_list[]" multiple 
                v-model="article.tags"
                >
          <option v-for="tag in article.tagsList" :key="tag.id" 
                  :value="tag.name" 
                  >
                  {{tag.name}}
          </option>
        </select>
      </div>

      <div class="form-group">
        <select name="competition_list[]" multiple
                v-model="article.competitions"
                >
          <option v-for="competition in article.competitionsList" :key="competition.id" 
                  :value="competition.id"
                  >
                  {{competition.name}}
            </option>
        </select>
      </div>

      <div class="form-group">
        <select name="player_list[]" multiple
                v-model="article.players"
                >
          <option v-for="player in article.playersList" :key="player.id" 
                  :value="player.id"
                  >
                  {{player.name}}
          </option>
        </select>
      </div>

      <div class="form-group">
        <select name="club_list[]" multiple
                v-model="article.clubs"
                >
          <option v-for="club in article.clubsList" :key="club.id" 
                  :value="club.id"
                  >
                  {{club.name}}
          </option>
        </select>
      </div>

      <div class="form-group">
        <select name="staff_list[]" multiple
                v-model="article.staff"
                >
          <option v-for="staff in article.staffList" :key="staff.id" 
                  :value="staff.id"
                  >
                  {{staff.name}}
          </option>
        </select>
      </div>
      
      <div class="form-group">
        <select name="category_list[]" multiple 
                v-model="article.categories"
                >
          <option v-for="category in article.categoriesList" :key="category.id" 
                  :value="category.id"
                  >
                  {{category.name}}
          </option>
        </select>
      </div>

      <div class="form-group">
        <input type="submit" value="Сохранить" class="btn btn-primary">
      </div>
    </div>
    </form>
  </main>
</div> 
</template>

<script>
  export default {
    async asyncData({ app, params, store }) {
      let { data } = await app.$axios.get(`/articles/${params.id}/edit`)
      return { article: data }
    },

    methods: {
      saveArticle(form, params) {
        const article = new FormData(form);
        this.$axios.post(`/articles/update/${this.$route.params.id}`, article)
            .then((res) => {

            })
            .catch((err) => {
              console.log(err)
            })
      }
    },

    head() {
      return {
        titleChunk: `Редактирование - ${this.article.title}`
      }
    }
  }
</script>