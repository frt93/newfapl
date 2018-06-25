<template>
    <div v-if="this.type == 'default'">
        <div class="btn loadmore" 
             v-if="(errorsCount > 15) || (!infiniteLoading && !loading && this.currentPage < this.lastPage)" 
             @click="fetchData">
            {{ this.loadBtnValue }}
        </div>

        <div class="loader" v-if="loading && this.currentPage < this.lastPage">
            <span v-if="errorsCount < 1">{{ this.loadingText }}</span>
            <span v-if="errorsCount > 0">{{ this.fetchErrMsg }}</span>
            <div class="loader-line">
                <div class="line"></div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    /**
     * We bind this component with the contentFilter component
     */
    import threeStageContentFilter from '../components/threeStageFilter';
    
    export default {
        name: 'infinitePagination',
        data() {
            return {
                loading: false,
                infiniteLoading: true,
                fetchPath: this.apiPath + '/' + this.model,

                /**
                 * A flag that indicates the presence or absence of filtering parameters in the URL on which the page is rendered. 
                 * The default value is "true". In case of $emit the user event "filtered" by the filtering component, we get "false"
                 */
                isReseted: true,

                startPage: this.start,
                currentPage: this.start,
                lastPage: this.last,
                errorsCount: 0
            }
        },
        props: [
            
            /**
             * The values of "props" are equivalent to the values passed by the server 
             * in the same named attributes of the component
             */

            /** 
             * The url of current page to which the request is sent.
            */
            'apiPath',
            /** 
             * The page number with which the pagination begins
            */
            'start',

            /** 
             * Recieve the last page's nubmer of paginate
            */
            'last',

            /**
             * DOM container to which data is inserted
             */
            'container',

            /**
             * Type of pagination used
            */
            'type',

            /**
             * Laravel Model, the content of which is paginated (Articles, Photos, etc.)
            */
            'model',

            /**
             * The text on the content-load button and the preloader text
             */
            'loadBtnValue',
            'loadingText',

            /**
             * The text of the error message that occurs when the data request was not successfully processed
             */
            'fetchErrMsg'
        ],

        computed: {
            nextPage() {
                return (+this.currentPage + 1)
            },

            /**
             * A function that computes passing a parameter with a page number to the query URL as single or additional.
             * Returns the response, depending on the value returned by the data parameter "isReseted"
             */
            page() {
                return ( ( this.isReseted ) ? '?page='+this.nextPage : '&page='+this.nextPage )
            } 
        },
        methods: {

            /** 
             * Sending a request for data
             * 
             * @return {response}
            */
            fetchData() {
                this.loading = true;
                if( this.errorsCount > 15 ) {
                    this.errorsCount = 0
                };
                axios.get( this.fetchPath + this.page )
                .then(response => {              
                        document.getElementById(this.container)
                                .insertAdjacentHTML('beforeEnd', response.data.content);
                        this.currentPage++;
                        this.nextPage;
                        this.errorsCount = 0;                    
                        this.loading = false;
                        this.infiniteLoading = ( (this.currentPage - this.startPage ) > 1 ) ? false : true
                })
                .catch( error => {
                    console.log(error);
                    this.errorsCount++;
                    if( this.errorsCount <=15 ){
                    setTimeout( () => { this.fetchData() }, 2000 )
                    } else {
                        this.loading = false;
                    }
                })
            },

            /** 
             * Run the fetch function when scrolling to a specific value
            */
            load() {
                let scrollTop = window.pageYOffset || document.documentElement.scrollTop,
                    wrapperHeight = document.getElementById(this.container).offsetHeight,
                    diffHeight = wrapperHeight - 1000;
                if(diffHeight <= scrollTop && !this.loading 
                                           && this.errorsCount < 1 
                                           && this.infiniteLoading 
                                           && (this.lastPage > this.currentPage) ) {
                    return this.fetchData()
                }
            }
        },
        created() {
            /**
             * In case the component works in conjunction with the filtering component,
             * We catch the $emitted filter event by changing the URL to which the request is sent
             */
            this.$root.$on('filtered', (url, isReseted, lastpage) => {
                this.infiniteLoading = true;
                this.isReseted = isReseted;
                this.fetchPath = url;
                this.startPage = this.currentPage = 1;
                ( lastpage ) ? this.lastPage = lastpage : '';
            })
        },

        mounted() {
            window.addEventListener('scroll', this.load);
        }
    }
</script>