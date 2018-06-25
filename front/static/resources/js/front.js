
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