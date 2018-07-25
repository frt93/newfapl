<template>
  <div v-if="this.type == 'default'">
    <div class="btn loadmore" 
         v-if="(errorsCount > 15) || (!isLazyLoad && !isLoading && this.pages.current < this.pages.last)" 
         @click="fetchData">
      {{ this.loadBtnValue }}
    </div>

    <div class="loader" v-if="isLoading && this.pages.current < this.pages.last">
      <span v-if="errorsCount < 1">{{ this.loadingText }}</span>
      <span v-if="errorsCount > 0">{{ this.fetchErrMsg }}</span>
      <div class="loader-line">
        <div class="line"></div>
      </div>
    </div>

    <div class="contentNotFound clearfix" v-if="( this.pages.current || this.pages.start ) == this.pages.last">
      Больше нет новостей, удовлетворяющих запросу
    </div>
    <div class="contentNotFound clearfix" v-if="this.pages.start > this.pages.last">
      Нет новостей, удовлетворяющих запросу
    </div>
    
  </div>
</template>

<script type="text/babel">
    
export default {
  name: 'pagination',
  data() {
    return {
      isLoading: false,
      recursiveFetch: '',

      isReseted: true,
      errorsCount: 0,

      pages: this.$store.getters.getArticles.pages
    }
  },
  props: {
    container: {
      type: String,
      required: true
    },
    type: {
      type: String,
      required: true
    },
    model: {
      type: String,
      required: true
    },
    loadBtnValue: {
      type: String,
      required: true
    },
    loadingText: {
      type: String,
      required: true
    },
    fetchErrMsg: {
      type: String,
      required: true
    }
  },

  computed: {
    isLazyLoad() {
      return ( (this.pages.current - this.pages.start ) > 1 ) ? false : true
    }
  },
  methods: {
    /** 
    * Sending a request for data
    * 
    * @return {response}
    */
    async fetchData() {
      this.isLoading = true;
      if( this.errorsCount > 15 ) {
        this.errorsCount = 0
      };
      let queries = {...this.$route.query, ...{'page': this.pages.next}};
      await this.$axios.post(this.model, queries)
        .then( (res) => {
          this.pages.current++;
          this.$emit('addArticles', {...res.data, ...{'pages':this.pages}} );
          this.$router.replace({ 
            query: {...this.$route.query, ...{'page': this.pages.current}} 
          })
          this.errorsCount = 0;                 
          this.isLoading = false;
        })
        .catch( (err) => {
          console.log(err);
          this.errorsCount++;
          if( this.errorsCount <= 15 ){
            this.recursiveFetch = setTimeout( () => { this.fetchData() }, 2000 )
          } else {
            this.isLoading = false;
          }
        })
    },

    /** 
    * Run the fetch function when scrolling to a specific value
    */
    load() {
      let scrollTop = document.documentElement.scrollTop,
          wrapperHeight = document.getElementById(this.container).offsetHeight,
          diffHeight = wrapperHeight - 1000;
      if(diffHeight <= scrollTop && !this.isLoading 
                                 && this.errorsCount < 1 
                                 && this.isLazyLoad 
                                 && (this.pages.last > this.pages.current) ) {
        return this.fetchData()
      }
    }
  },
        // created() {
        //     /**
        //      * In case the component works in conjunction with the filtering component,
        //      * We catch the $emitted filter event by changing the URL to which the request is sent
        //      */
        //     this.$root.$on('filtered', (url, isReseted, lastpage) => {
        //         this.isLazyLoad = true;
        //         this.isReseted = isReseted;
        //         this.fetchPath = url;
        //         this.pages.start = this.pages.current = 1;
        //         ( lastpage ) ? this.pages.start.last = lastpage : '';
        //     })
        // },

  created() {
    if (process.browser) {
      window.addEventListener('scroll', this.load);
    }
  },
  beforeDestroy() {
    if (process.browser) {
      window.removeEventListener('scroll', this.load);
      if( this.errorsCount > 0 ) {
        clearTimeout( this.recursiveFetch )
      }
    }
  }
}
</script>