<template>
<div class='div container single-container clearfix'>
  <h1>Редактировать новость</h1>
  <main class="clearfix">
    <form method="POST" @submit.prevent="saveArticle" accept-charset="UTF-8" id="formm">
    <input name="_method" type="hidden" value="PATCH">
    <div id="formGroup">
      <div class="form-group">
        <input type="submit" value="Изменить" class="btn btn-primary">
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
        <input name="title" type="text" :value="article.title" id="title" class="form-control">
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
        <input type="submit" value="Изменить" class="btn btn-primary">
      </div>
      
      <div class="form-group">
        <select name="tag_list[]" id="tags" multiple v-model="article.pickedTags">
          <option v-for="tag in article.allTags" :key="tag.id" :value="tag.name" :selected="tag.id === article.pickedTags">{{tag.name}}</option>
        </select>
      </div>

      <div class="form-group">
        <select name="competition_list[]" id="competitions" multiple>
          <option v-for="competition in article.competitions" :key="competition.id" :value="competition.id" selected>{{competition.name}}</option>
        </select>
      </div>

      <div class="form-group">
        <select name="player_list[]" id="players" multiple>
          <option v-for="player in article.players" :key="player.id" :value="player.id" selected>{{player.name}}</option>
        </select>
      </div>

      <div class="form-group">
        <select name="club_list[]" id="clubs" multiple v-if="article.clubs">
          <option v-for="club in article.clubs" :key="club.id" :value="club.id" selected>{{club.name}}</option>
        </select>
      </div>

      <div class="form-group">
        <select name="staff_list[]" id="staff" multiple v-if="article.staff">
          <option v-for="staff in article.staff" :key="staff.id" :value="staff.id" selected>{{staff.name}}</option>
        </select>
      </div>
      
      <div class="form-group">
        <select name="category_list[]" id="categories" multiple>
          <option v-for="category in article.categories" :key="category.id" :value="category.id" selected>{{category.name}}</option>
        </select>
      </div>
    </div>
    </form>
  </main>
</div> 
</template>

<script>
  export default {
    async asyncData({ app, params, store }) {
      let { data } = await app.$axios.get(`/articles/getarticle/${params.id}`)
      return { article: data }
    },

    methods: {
      saveArticle(params) {
        let form = document.getElementById('formm');
        let data = new FormData(form);
        this.$axios.post(`/articles/update/${this.$route.params.id}`, data)
            .then((res) => {
              console.log(res)
            })
      }
    },

    head() {
      return {
        title: 'Редактирование - ' + this.article.title + ' - Premier League'
      }
    },
  }
</script>