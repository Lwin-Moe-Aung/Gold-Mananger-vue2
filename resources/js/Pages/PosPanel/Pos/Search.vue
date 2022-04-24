<template>
    <v-toolbar color="rgba(0,0,0,0)" flat>
              <v-row>
                  <v-col cols="12" sm="12">
                      <v-card
                          flat class="rounded-lg mx-2"
                        >
                        <v-row>


                              <v-toolbar color="#E1E2E1">

                                <v-col
                                    cols="12"
                                    sm="5"
                                    class="mt-7 text-white"

                                  >
                                     <v-text-field

                                      v-model="message3"
                                      label="Search Item By Product SKu"
                                      clearable
                                    ></v-text-field>
                                </v-col>


                          </v-toolbar>
                          </v-row>
                      </v-card>
                  </v-col>
              </v-row>
    </v-toolbar>
</template>

<script>

  export default {
    name: 'Search',


     data: () => ({
        isLoading: false,
        items: [],
        model: null,
        search: null,
        tab: null,
        select_item: ['1', '2', '3', '4','5', '6', '7', '8'],
        messages: [
            {
            from: 'လက်ကျန်',
            message: `50,000`,
            time: '10:42am',
            color: 'deep-purple lighten-1',
            },
            {
            from: 'ဆပ်ငွေ',
            message: '30,000',
            time: '10:37am',
            color: 'green',
            },
        ],
    }),

    watch: {
        model (val) {
            if (val != null) this.tab = 0
            else this.tab = null
        },
        search () {
            // Items have already been loaded
            if (this.items.length > 0) return

            this.isLoading = true

            // Lazily load input items
            fetch('https://api.coingecko.com/api/v3/coins/list')
            .then(res => res.clone().json())
            .then(res => {
                this.items = res
            })
            .catch(err => {
                console.log(err)
            })
            .finally(() => (this.isLoading = false))
        },
    },
  }
</script>
<style>
.v-card.borderme {
    border: 2px solid #704232 !important;
}
.v-card.borderout{
  border: 1px solid #BCAAA4 !important;
}
.voucher-row{
  margin-bottom: -22px;
}
.voucher-row1{
  margin-bottom: -37px;
}
.toolbar-middle{
  height: 40px !important;
}
/* .v-toolbar__content{
  height: 31px !important;
} */
.v-timeline{
  padding-top: 0 !important;
}

</style>
