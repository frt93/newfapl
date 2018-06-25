import Vue from 'vue';
import selectPlugin from './components/selectPlugin';

var select = new Vue({
    el: "#formGroup",
    components: {
      selectPlugin
    }
})