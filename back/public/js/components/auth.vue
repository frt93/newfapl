<template>
  <div class="form">
      <form id="auth" class="form-horizontal" method="POST">
        <signin :providers="providers" :routes="routes" :label="labels"></signin>
      </form>
    
  </div>
</template>

<script type="text/babel">
    export default {
        data() {
            return {
               route: 'signInRoute',
               labels: [],
               routes: [],
               providers: []
            }
        },
        components: {
            signin: require('../components/signin'),
        },
        props: {
            token: String,
            routesList: String,
            providersList: String,
            labelsList: String
        },
        created() {
            this.labels = JSON.parse(this.labelsList);
            this.routes = JSON.parse(this.routesList);
            this.providers = JSON.parse(this.providersList);
        }
    }
</script>