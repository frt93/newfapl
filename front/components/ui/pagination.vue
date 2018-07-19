<template>
  <div v-if="this.type == 'default'">
    <div class="btn loadmore" 
         v-if="(errorsCount > 15) || (!isLazyLoad && !isLoading && this.currentPage < this.lastPage)" 
         @click="fetchData">
      {{ this.loadBtnValue }}
    </div>

    <div class="loader" v-if="isLoading && this.currentPage < this.lastPage">
      <span v-if="errorsCount < 1">{{ this.loadingText }}</span>
      <span v-if="errorsCount > 0">{{ this.fetchErrMsg }}</span>
      <div class="loader-line">
        <div class="line"></div>
      </div>
    </div>

    <div class="contentNotFound clearfix" v-if="( this.currentPage || this.startPage ) == this.lastPage">
      Больше нет новостей, удовлетворяющих запросу
    </div>
    <div class="contentNotFound clearfix" v-if="this.startPage > this.lastPage">
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
      checkk: '',

      isReseted: true,
      errorsCount: 0
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
    },
    startPage: {
      type: Number,
      required: true
    },
    currentPage: {
      type: Number,
      required: true
    },
    lastPage: {
      type: Number,
      required: true
    },
  },

  computed: {
    nextPage() {
      return +this.currentPage + 1
    },
    isLazyLoad() {
      return ( (this.currentPage - this.startPage ) > 1 ) ? false : true
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
      let query = this.$route.query;
      await this.$axios.post(this.model, {query, ...{'page': this.nextPage}})
        .then( (res) => {
          this.$store.dispatch(`set${this.model}`, res.data);
          this.$router.push({ query: { page: this.nextPage }})
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
                                 && (this.lastPage > this.currentPage) ) {
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
        //         this.startPage = this.currentPage = 1;
        //         ( lastpage ) ? this.lastPage = lastpage : '';
        //     })
        // },

  created() {
    if (process.browser) {
      window.addEventListener('scroll', this.load);
    }

    this.checkk = (this.$route.query.page) ? this.$route.query.page : 1
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