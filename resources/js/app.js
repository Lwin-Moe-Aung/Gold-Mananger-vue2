window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: false,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})


import Vue from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'
// import VueToastr from "vue-toastr";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
import Multiselect from 'vue-multiselect'

Vue.mixin({methods:{route:window.route}});
// Vue.use(VueToastr);
Vue.use(Vuetify);
Vue.component('multiselect', Multiselect)
InertiaProgress.init();

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props }) {
        new Vue({
            vuetify: new Vuetify({
                icons: {
                    iconfont: 'fa' || 'md'
                },
                theme: {
                    themes: {
                        dark: {
                            background: '#EEEEEE'
                        }
                    }
                }
            }),
            render: h => h(App, props),
        }).$mount(el)
    },
   
})