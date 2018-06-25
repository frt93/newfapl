import Vue from 'vue';
import axios from 'axios';
import Echo from "laravel-echo";
import store from './store/store.js';


window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '2b2863226f30cf5770cc',
    cluster: 'ap2',
    encrypted: true
});


window.axios = axios


var navbarVue = new Vue({
  el:"#navbar",
  store,
  data: {
    isMoreButtonOpen : false,
    mainLogoHeight : ''
  },
  methods: {
    onScroll: function(event) {
      let targets = document.querySelectorAll('#navbar, body'),
          logo = document.getElementById('mainLogo'),
          scrollTop = window.pageYOffset || document.documentElement.scrollTop,
          navBarHeight = 60,
          mainLogoHeight = 120;
      if(scrollTop >= navBarHeight) {
        for (var i = 0; i < targets.length; i++) {
          targets[i].classList.add('fixed')
        }
        this.mainLogoHeight = navBarHeight
      } else {
        for (var i = 0; i < targets.length; i++) {
          targets[i].classList.remove('fixed')
        }
        this.mainLogoHeight = (mainLogoHeight - scrollTop)
      }
    }
  },
  computed: {
    isUserLogged() {
      return this.$store.state.isUserLogged
    },
    userData() {
      return this.$store.state.userData
    }
  },
  created () {
    window.addEventListener('scroll', this.onScroll)
  }
})

var socialButtonsBlockVue = new Vue ({
  el: "#socialList",
  data: {
    isSocialBlockOpen: false,
  }
})

var pagination = new Vue ({
    el: '#maincontent',
    data: {
        infiniteLoading: true
    },
    components: {
        infinitePagination: require('./components/infinitePaginate'),
        threeStageContentFilter: require('./components/threeStageFilter')
    }
    
});

var loginModal = new Vue ({
  el: '.loginform',
  store,
  components: {
    modal: require('./components/modal'),
    auth: require('./components/auth')
  },
  computed: {
    showAuthModal() {
      return this.$store.state.isModalOpen
    }
  },
  methods: {
    openAuthModal() {
      store.commit('showAuthModal', true)
    }
  }

  
})

// var broadcast = new Vue({
//   el: '#broadcast',
  

//   // created() {
//   //   window.Echo.private('TestChannel')
//   //   .listen('OrderShipped', (e) => {
//   //       console.log(e);
//   //   });
//   // }
// })