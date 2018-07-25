<template>
    <section class="contentFilter clearfix">
        <div class="dropdown" 
             :class="{active:co}" 
             @click.self="isOpened($event)">
                {{ pickedCoName }}
             
            <ul>
                <li v-for="competition in competitions"
                    :key="competition.slug"
                    @click="pickCompetition($event, competition.slug, competition.name)"
                    :class="{picked: pickedCoSlug == competition.slug}">{{ competition.name }}</li>
            </ul>
        </div>

        <div class="dropdown" 
             :class="{disabled: !co || loadingClubs, loading: loadingClubs, active: club}" 
             @click.self="isOpened($event)">

                {{ pickedClubName }}
            <ul v-if="co">
                <li v-for="club in clubsList" 
                    :key="club.slug"
                    @click="pickClub($event, club.slug, club.name)"
                    :class="{picked: pickedClubSlug == club.slug}">{{ club.name }}</li>
            </ul>

            <div class="loader" v-if="loadingClubs">
                <div class="loader-line">
                    <div class="line"></div>
                </div>
            </div>
        </div>

        <div class="dropdown" 
             :class="{disabled: (!co || !club || loadingPlayers), loading: loadingPlayers, active: pl}" 
             @click.self="isOpened($event)">


                {{ pickedPlName }}
            <ul v-if="club">
                <li v-for="player in playersList"
                    :key="player.slug"
                    @click="pickPlayer($event, player.slug, player.name)"
                    :class="{picked: pickedPlSlug == player.slug}">{{ player.name }}</li>
            </ul>

            <div class="loader" v-if="loadingPlayers">
                <div class="loader-line">
                    <div class="line"></div>
                </div>
            </div>
        </div>

        <div class="btn reset" 
             tabindex="0"
             :class="{disabled: ( errorsCount > 0 && errorsCount < 15 ) && !co}"
             @click="resetFilter" 
             v-if="co || !reseted">
                {{ this.resetBtnValue }}
            <div class="icn reset"></div>
        </div>

        <div class="btn filter" 
             tabindex="1"
             :class="{disabled: fetching}"
             v-if="picked && co"
             @click="fetchData(false)">{{ this.searchBtnValue }}
        </div>

        <span class="error" v-if="fetchClubsError || fetchPlayersError || errorsCount > 0">
            <p v-if="fetchClubsError">{{ fetchClubsErrMsg }}</p>
            <p v-if="fetchPlayersError">{{ fetchPlayersErrMsg }}</p>
            <p v-if="errorsCount > 0 && errorsCount <= 15">{{ fetchDataErrMsg }}</p>
            <p v-if="errorsCount > 15">{{ exceededRequestsMsg }}</p>
        </span>
    </section>
</template>

<script type="text/babel">

    export default {
        name: 'threeStageFilter',
        data() {
            return {
                /**
                 * Components's state flags
                 */
                fetching: false,
                picked: false,
                reseted: true,

                fetchClubsError: false,
                fetchPlayersError: false,
                errorsCount: 0,

                /**
                 * Variables that store arrays with a list of names and 
                 * the corresponding slugs of competition, clubs and players
                 */
                clubsList: this.clubs,
                playersList: this.players,

                /**
                 * Variables of the loading state of clubs / players lists
                 */
                loadingClubs: false,
                loadingPlayers: false,

                /**
                 * Variables that hold the slug and the name of the selected competition / club / player 
                 */
                pickedCoSlug: this.selected.co.slug,
                pickedCoName: this.selected.co.name,

                pickedClubSlug: this.selected.club.slug,
                pickedClubName: this.selected.club.name,
                
                pickedPlSlug: this.selected.pl.slug,
                pickedPlName: this.selected.pl.name,

                fetchClubsErrMsg:"Не удалось получить список клубов",
                fetchPlayersErrMsg:"Не удалось получить список игроков",
                fetchDataErrMsg:"Не удалось получить данные",
                exceededRequestsMsg:"Превышено количество попыток запроса. Попробуйте снова",

                resetBtnValue:"Сбросить",
                searchBtnValue:"Поиск"
            }
        },

        /**
         * The values of "props" are equivalent to the values passed by the server 
         * in the same named attributes of the component
        */
        props: [
            'competitions',
            'clubs',
            'players',
            'selected',
            'defaults',
            'model',
            'container'
        ],
        /**
         * Computed values of request's parametres
         */
        computed: {
            co() {
                return ( this.pickedCoSlug != 'all' ? {co: this.pickedCoSlug} : '' )
            },

            club() {
                return ( this.pickedClubSlug != 'all' ? {club:this.pickedClubSlug} : '')
            },

            pl() {
                return ( this.pickedPlSlug != 'all' ? {pl: this.pickedPlSlug} : '' )
            },
            query() {
              return {...this.co, ...this.club, ...this.pl}
			}
        },
        methods: {

            /**
            * Function of interaction with the competitions block.
            */
            pickCompetition(self, slug, name) {
                if(this.pickedCoSlug != slug ) {
                    this.pickedCoSlug = slug;
                    this.pickedCoName = name;
                    if ( slug != 'all' ) {
                        this.resetClubsBlock();
                        this.resetPlayersBlock();
                        this.fetchClubsList(slug);
                    } else {
                        this.resetFilter()
                    }
                } else {
                   self.stopPropagation()
                }
            },

            /**
            * Function of interaction with the clubs block.
            */
            pickClub(self, slug, name){
                if(this.pickedClubSlug != slug ) {
                    this.pickedClubSlug = slug;
                    this.pickedClubName = name;
                    this.resetPlayersBlock();
                    if ( slug != 'all' ) {
                        this.fetchPlayersList(slug);
                    }
                } else {
                    self.stopPropagation()
                }
            },

            /**
            * Function of interaction with the players block.
            */
            pickPlayer(self, slug, name){
                if(this.pickedPlSlug != slug ) {
                    this.pickedPlSlug = slug;
                    this.pickedPlName = name;
                } else {
                    self.stopPropagation()
                }
            },

            /**
            * Fetch an array of clubs, participating in the picked competition
            * @param  {String}
            * @return {Array}
            */
            async fetchClubsList(slug) {
                let clubsInStore = this.$store.getters.getClubsByCompetition(slug)
                if (clubsInStore) {
                    this.clubsList = clubsInStore;
                } else {
                    this.loadingClubs = true;
                    await this.$axios.post( '/filters', {'getclubslist': slug} )
                    .then( response => {              
                        this.loadingClubs = this.fetchClubsError = false;
                        this.clubsList = response.data;
                        this.$store.dispatch( 'addFiltersData', {data: response.data, type:"clubs", slug} )
                    })
                    .catch( error => {
                        console.log(error);
                        this.fetchClubsError = true;
                        this.loadingPlayers = this.fetchPlayersError =  false;

                        setTimeout( () => { this.clubsListRecursion(slug) }, 3000 )
                    })
                }
            },

            clubsListRecursion(slug) {
                if (this.pickedCoSlug != slug) {
                    return false
                } else {
                    return this.fetchClubsList(slug)
                }
            },

            /**
            * Fetch an array of players, participating for the picked club in the picked competition
            * @param  {String}
            * @return {Array}
            */
            async fetchPlayersList(slug) {
                let playersInStore = this.$store.getters.getPlayersByClub(slug);
                if (playersInStore) {
                    this.playersList = playersInStore;
                } else {
                    this.loadingPlayers = true;
                    await this.$axios.post( '/filters', {'getplayerslist': slug} )
                    .then(response => {              
                        this.loadingPlayers = this.fetchPlayersError = false;
                        this.playersList = response.data;
                        this.$store.dispatch( 'addFiltersData', {data: response.data, type:"players", slug} )
                    })
                    .catch( error => {
                        console.log(error);
                        this.fetchPlayersError = true;
                        setTimeout( () => { this.playersListRecursion(slug) }, 3000 )
                    })
                }
            },

            playersListRecursion(slug) {
                if (this.pickedClubSlug != slug ) {
                    if (slug = 'all') {
                      this.loadingPlayers = this.fetchPlayersError = false
                    }
                    return false;
                } else {
                    return this.fetchPlayersList(slug)
                }
            },

            resetClubsBlock() {
                this.pickedClubSlug =  'all';
                this.pickedClubName = this.defaults.club;
            },

            resetPlayersBlock() {
                this.pickedPlSlug = 'all';
                this.pickedPlName = this.defaults.pl;
            },

            resetFilter() {
                this.pickedCoName = this.defaults.co;
                this.pickedCoSlug = 'all';
                this.resetClubsBlock();
                this.resetPlayersBlock();
                this.loadingClubs = this.loadingPlayers = this.fetchClubsError = this.fetchPlayersError = false;
                this.errorsCount = 0;
                if ( !this.reseted ) {
                    this.fetchData(true)
                }
            },

            /**
            * Sending request to server to receive the filtered data. 
            * Depending on the success of the request, we change the values of component's state flags
            * and send the data to the pagination component
            * @return {Array}
            */
            async fetchData(ifReseting) {
                this.fetching = true;
                if( this.errorsCount > 15 ) {
                    this.errorsCount = 0
                };
                await this.$axios.post(this.model, {...this.query, ...{'ancillary': 'pages'} })
                .then( response => {
                    this.reseted = ifReseting;
                    this.$emit('filterArticles', response.data);
                    
                    this.fetching = this.picked = false;
                    this.errorsCount = 0;

                    this.$router.replace( {query: this.query} )
                })
                .catch( error => {
                    console.log( error );
                    this.picked =  true;
                    let query = this.query;
                    this.errorsCount++;
                    setTimeout( () => { this.fetchDataRecursion(ifReseting, query) }, 2000 )
                })
            },

            fetchDataRecursion(ifReseting, query) {
                if(query != this.query ) {
                    this.fetching = false;
                    this.errorsCount = 0;
                    return false
                } else if(this.errorsCount > 15) {
                    this.fetching = false;
                    return false
                } else {
                    return this.fetchData(ifReseting);
                }
            },

            /**
             * The function of managing the "open"  class or filtering blocks.
             * Accepts the $event parameter when clicked on the unlocked(!) filtering 
             * block and launches the click eventListener that tracks click outside
             * this block or its child nodes. If such a click took place - the block closes, the listener is deleted.
            */
            isOpened(e) {
              if (process.browser) {
                var self = e.target;
                var handleClickOutside = (e) => {
                    if( self != e.target  ) {
                        self.classList.remove('open');
                        document.removeEventListener('click', handleClickOutside)
                    }
                }

                if( !self.classList.contains('disabled') ) {
                    self.classList.toggle('open');
                    document.addEventListener('click', handleClickOutside)
                }
                
              } 
            },
        },

        /**
         * We track changes in query parameters relative to those 
         * for which content is currently filtered.
         * Depending on their equality or difference, we regulate the `picked` - state flag
         * 
        */
        watch: {
            query: function(newVal, oldVal) {
              let route = this.$route.query
              this.picked = ( this.co && 
                                      ( newVal.co != route.co ||
                                        newVal.club != route.club ||
                                        newVal.pl != route.pl ) ) 
                            ? true : false;
            },
            fetching: function() {
              document.getElementById( this.container ).classList.toggle('loading')
            }
        },

        created() {
          if(this.$route.query.co || this.$route.query.club || this.$route.query.pl) {
            this.reseted = false
          }
        }
    }
</script>