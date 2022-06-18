<template>

    <v-card id="create" >
        <Link :href="route('pos.cart')">
            <v-speed-dial
                v-model="fab"
                :top="true"
                :bottom="false"
                :right="true"
                :left="false"
                :open-on-hover="false"
                transition="slide-y-reverse-transition"
                >
                <template v-slot:activator>
                    <v-btn
                        color="gold darken-2"
                        dark
                        fab
                    >
                        <v-icon
                            color="white"
                            v-text="'fas fa-shopping-cart'"
                        >

                        </v-icon>
                        <b class="mb-5 red--text">{{carts.length}}</b>
                    </v-btn>
                </template>
            </v-speed-dial>
        </Link>

  </v-card>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
import {mapGetters} from "vuex";
export default {
    components: {
        Link,
    },
    data: () => ({
        fab:null,

    }),
    computed: {
        ...mapGetters(['carts']),
    },
    watch: {

    },
}
</script>
<style>
  /* This is for documentation purposes and will not be needed in your application */
  #create .v-speed-dial {
    position: absolute;
  }

  #create .v-btn--floating {
    position: relative;
  }
</style>
