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
    </div>
    </form>
  </main>
</div> 
</template>

<script>
  export default {
    async asyncData({ app, params }) {
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
    }
  }
</script>