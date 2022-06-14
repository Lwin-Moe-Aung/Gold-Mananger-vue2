<template>
    <v-card id="create">
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
                    color="blue darken-2"
                    dark
                    fab
                >
                    <v-icon>
                        mdi-cart-outline
                    </v-icon>
                </v-btn>
            </template>
        </v-speed-dial>
  </v-card>
</template>

<script>
  export default {
    data: () => ({
        fab:null,


    }),

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
