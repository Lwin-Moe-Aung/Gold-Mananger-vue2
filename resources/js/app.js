window.Toast = Swal.mixin({
    toast: true,
    position: 'top-right',
    iconColor: 'white',
    customClass: {
    popup: 'colored-toast'
    },
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
})


import Vue from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'
// import VueToastr from "vue-toastr";
// import Vuetify from "vuetify";
// import "vuetify/dist/vuetify.min.css";
// import '@fortawesome/fontawesome-free/css/all.css'
// import 'material-design-icons-iconfont/dist/material-design-icons.css'
import vuetify from './plugins/vuetify'
import Multiselect from 'vue-multiselect'
import "vue-multiselect/dist/vue-multiselect.min.css";
import { store } from './store/store';
import Vuelidate from 'vuelidate';

Vue.config.productionTip = false
Vue.mixin({methods:{route:window.route}});
Vue.use(Vuelidate);
// Vue.use(VueToastr);
// Vue.use(Vuetify);
Vue.component('multiselect', Multiselect)
InertiaProgress.init();

var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0"); // displaying other groupings/separators is possible, look at the docs
});

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props }) {
        new Vue({
            vuetify,
            store: store,
            render: h => h(App, props),
        }).$mount(el)
    },

})
