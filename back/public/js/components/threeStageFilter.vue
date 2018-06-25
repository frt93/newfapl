<template>
    <section class="contentFilter clearfix">
        <div class="dropdown" 
             :class="{active:co.length}" 
             @click.self="isOpened($event)">
                {{ pickedCoName }}
             
            <ul>
                <li v-for="competition in competitionsList"
                    :key="competition.slug"
                    @click="pickCompetition($event, competition.slug, competition.name)"
                    :class="{picked: pickedCoSlug == competition.slug}">{{ competition.name }}</li>
            </ul>
        </div>

        <div class="dropdown" 
             :class="{disabled: !co.length || loadingClubs, loading: loadingClubs, active: club.length}" 
             @click.self="isOpened($event) && co.length">

                {{ pickedClubName }}
            <ul v-if="co.length">
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
             :class="{disabled: (!co.length || !club.length || loadingPlayers), loading: loadingPlayers, active: pl.length}" 
             @click.self="isOpened($event) && (co.length && club.length)">


                {{ pickedPlName }}
            <ul v-if="club.length">
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
             :class="{disabled: ( errorsCount > 0 && errorsCount < 15 ) && !co.length}"
             @click="resetFilter" 
             v-if="co.length || !reseted">
                {{ this.resetBtnValue }}
            <div class="icn reset"></div>
        </div>

        <div class="btn filter" 
             tabindex="1"
             :class="{disabled: fetching}"
             v-if="picked && co.length"
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
    /**
     * We bind this component with the pagination component
     */
    import infinitePagination from '../components/infinitePaginate';

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
                competitionsList: [],
                clubsList: [],
                playersList: [],

                /**
                 * Variables of the loading state of clubs / players lists
                 */
                loadingClubs: false,
                loadingPlayers: false,

                /**
                 * Variables that hold the slug and the name of the selected competition / club / player 
                 */
                pickedCoSlug: this.competitionSlug,
                pickedCoName: this.competitionName,

                pickedClubSlug: this.clubSlug,
                pickedClubName: this.clubName,
                
                pickedPlSlug: this.playerSlug,
                pickedPlName: this.playerName,
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

            'competitionSlug',
            'competitionName',

            'clubSlug',
            'clubName',

            'playerSlug',
            'playerName',

            'unpickedCompetition',
            'unpickedClub',
            'unpickedPlayer',

            'apiPath',
            'model',
            'container',
            'resetBtnValue',
            'searchBtnValue',

            'fetchClubsErrMsg',
            'fetchPlayersErrMsg',
            'fetchDataErrMsg',
            'exceededRequestsMsg',

            /**
             * Flag that controls the visibility state of the reset button after rendering the page by the server. 
             * In the case of the presence of filtration parameters in the URL, the variable return true 
             * or false in the absence of these
             */
            'isFiltered'
        ],
        /**
         * Computed values of request's parametres
         */
        computed: {
            co() {
                return ( this.pickedCoSlug !='all' ? '?co='+this.pickedCoSlug : '' )
            },

            club() {
                return ( this.pickedClubSlug !='all' ? '&club='+this.pickedClubSlug : '' )
            },

            pl() {
                return ( this.pickedPlSlug !='all' ? '&pl='+this.pickedPlSlug : '' )
            },
            requestUrl() {
                return ( this.apiPath + '/' + this.model + this.co + this.club + this.pl)
            }
        },
        methods: {

            /**
            * Parse received from server JSON string to associative array of competitions / clubs / players.
            * 
            * If url of rendered page already have get parameters, set `reseted` flag to false value and
            * $emit the filtering event, passing current url to the pagination component
            * 
            * @param  {String}
            * @return {Object, Boolean}
             */
            getSchedule() {
                this.competitionsList = JSON.parse(this.competitions);
                this.clubsList = JSON.parse(this.clubs);
                this.playersList = JSON.parse(this.players);

                if (this.isFiltered) {
                    this.reseted = false;
                    this.$root.$emit( 'filtered', this.requestUrl, this.reseted );
                }
            },

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
            fetchClubsList(slug) {
                this.loadingClubs = true;
                axios.get( this.apiPath + '?getclubslist=' + slug )
                .then( response => {              
                    this.loadingClubs = this.fetchClubsError = false;
                    this.clubsList = response.data
                })
                .catch( error => {
                    console.log(error);
                    this.fetchClubsError = true;
                    this.loadingPlayers = this.fetchPlayersError =  false;

                    setTimeout( () => { this.clubsListRecursion(slug) }, 3000 )
                })
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
            fetchPlayersList(slug) {
                this.loadingPlayers = true;
                axios.get(this.apiPath + '?getplayerslist=' + slug)
                .then(response => {              
                    this.loadingPlayers = this.fetchPlayersError = false;
                    this.playersList = response.data
                })
                .catch( error => {
                    console.log(error);
                    this.fetchPlayersError = true;
                    setTimeout( () => { this.playersListRecursion(slug) }, 3000 )
                })
            },

            playersListRecursion(slug) {
                if (this.pickedClubSlug != slug) {
                    return false;
                } else {
                    return this.fetchPlayersList(slug)
                }
            },

            resetClubsBlock() {
                this.pickedClubSlug =  'all';
                this.pickedClubName = this.unpickedClub;
            },

            resetPlayersBlock() {
                this.pickedPlSlug = 'all';
                this.pickedPlName = this.unpickedPlayer;
            },

            resetFilter() {
                this.pickedCoName = this.unpickedCompetition;
                this.pickedCoSlug = 'all';
                this.resetClubsBlock();
                this.resetPlayersBlock();
                this.loadingClubs = this.loadingPlayers = this.fetchClubsError = this.fetchPlayersError = false;
                this.errorsCount = 0;
                if ( !this.reseted) {
                    this.fetchData(true)
                }
            },

            /**
            * Sending request to server to receive the filtered data. 
            * Depending on the success of the request, we change the values of component's state flags
            * and send the data to the pagination component
            * @return {Array}
            */
            fetchData(ifReseting) {
                this.fetching = true;
                if( this.errorsCount > 15 ) {
                    this.errorsCount = 0
                };
                axios.get( this.requestUrl )
                .then( response => {
                    this.reseted = ifReseting;
                    var container = document.getElementById( this.container );
                    container.innerHTML = '';
                    container.insertAdjacentHTML( 'beforeEnd', response.data.content );
                    
                    this.fetching = this.picked = false;
                    this.errorsCount = 0;

                    window.history.replaceState(null, null, '/' + this.model + this.co + this.club + this.pl);
                    var lastpage = response.data.lastpage;
                    /**
                    * $emit the filtering event and pass the new request url to the pagination component
                    */
                    this.$root.$emit( 'filtered', this.requestUrl, this.reseted, lastpage );
                })
                .catch( error => {
                    console.log( error );
                    this.picked =  true;
                    let url = this.requestUrl;
                    this.errorsCount++;
                    setTimeout( () => { this.fetchDataRecursion(ifReseting, url) }, 2000 )
                })
            },

            fetchDataRecursion(ifReseting, url) {
                if(url != this.requestUrl ) {
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
                
                
            },
        },

        /**
         * We track changes in query parameters relative to those 
         * for which content is currently filtered.
         * Depending on their equality or difference, we regulate the `picked` - state flag
         * 
        */
        watch: {
            requestUrl: function(newVal, oldVal) {
                this.picked = ( this.co !='' && newVal != ( this.apiPath + '/' + this.model + window.location.search ) ) ? true : false;
            },
            fetching: function() {
                document.getElementById( this.container ).classList.toggle('loading')
            }
        },

        created() {
            this.getSchedule();
        }
    }
</script>