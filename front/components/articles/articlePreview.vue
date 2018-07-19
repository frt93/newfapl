<template>
  <section class="entry clearfix">
    <div class="maincontent">
      <nuxt-link :to="postLink" class="entry-title-link">
        <figure class="clearfix">
          <span class="entry-pre-img">
            <img :src="thumbnail" alt="">
          </span>
          <figcaption>
            <span class="post-cat">
              {{ categories }}
            </span>
            <span class="date">
              {{ this.$moment(date).fromNow() }}
              <p> id: {{ id }}</p>
            </span>
            <h2>{{ title }}</h2>
            <p>{{ excerpt }}</p>
          </figcaption>
        </figure>
      </nuxt-link>
      <nuxt-link :to="editLink">Изменить</nuxt-link>
      <div @click="setPublishStatus(id)">{{ isPublishedLabel }}</div>
    </div>
  </section>
</template>

<script>
  import axios from 'axios';  

  export default {
    name: 'articlePreview',

    data() {
      return {
        publishStatus: this.isPublished
      }
    },

    props: {
      id: {
        type: Number, 
        required: true
      },
      title: {
        type: String,
        required: true
      },
      thumbnail: {
        type: String,
        default: '/i/eden200.jpg'
      },
      excerpt: {
        type: String,
        required: true
      },
      isPublished: {
        type: Number,
        required: true
      },
      date: {
        type: String,
        required: true
      },
      categories: {
        type: Array,
        required: false
      }
    },

    computed: {
      postLink() {
        return  '/articles/' + this.id
      },
      editLink() {
        return  '/articles/' + this.id + '/edit'
      },
      isPublishedLabel: {
        get() {
          return this.publishStatus ? 'Деактивировать' : 'Активировать'
        },

        set(newValue) {
          this.publishStatus = newValue
        }
      },
      publishStatusLink() {
        return  this.publishStatus 
                ? '/articles/' + this.id + '/unpublish' 
                : '/articles/' + this.id + '/publish' 
      }
    },

    methods: {
      setPublishStatus() {
          return this.$axios.get(this.publishStatusLink)
          .then((res) => {
            this.publishStatus = res.data.value
          })
      }
    }
  }
</script>
