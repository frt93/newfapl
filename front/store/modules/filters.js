export default {
  state: {
    clubsByCompetition: [],
    playersByClub: []
  },
  
  mutations: {
    addFiltersData (state, {data, type, slug}) {
      if (type == "clubs") {
        let clubs = state.clubsByCompetition;
        if ( !clubs.find(obj => obj.co == slug) ) 
          clubs.push({co:slug, data:data} )
       }

       if (type == "players") {
        let players = state.playersByClub;
        if ( !players.find(obj => obj.club == slug) ) 
          players.push({club:slug, data:data} )
       }
    },
  },

  actions: {
    addFiltersData (VuexContext, {data, type, slug}) {
      VuexContext.commit('addFiltersData', {data, type, slug})
    }
  },

  getters: {
    getClubsByCompetition: (state) => (competitionSlug) => {
      const clubs = state.clubsByCompetition.find(obj => obj.co == competitionSlug);
      if( clubs ) {
        return clubs.data
      } else {
        return false
      }
    },

    getPlayersByClub: (state) => (clubSlug) => {
      const players = state.playersByClub.find(obj => obj.club == clubSlug);
      if( players ) {
        return players.data
      } else {
        return false
      }
    }
  }
}