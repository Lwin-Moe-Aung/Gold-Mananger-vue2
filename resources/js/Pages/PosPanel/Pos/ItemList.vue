<template>
    <v-item-group mandatory class="mt-n1">
        <v-container>
            <v-sheet
                class="mx-auto"
                elevation="8"
                max-width="1090"
            >
                <v-slide-group
                    v-model="model"

                    active-class="success"
                    show-arrows
                >
                    <v-slide-item
                    v-for="n in 15"
                    :key="n"
                    v-slot="{ active, toggle }"
                    >
                    <v-card
                        :color="active ? '#F6EFEF' : 'white'"
                    :class="active ? 'borderme' : 'borderout'"
                    class="d-flex align-center rounded-lg mx-2 mt-1 mb-1"
                    dark
                    height="130"
                    @click="toggle"
                    flat
                    >
                        <v-row>
                        <v-col cols="12" sm="12">
                        <v-list-item two-line  class="text-center ">
                            <v-list-item-content>
                            <div align="center" justify="center">

                                <v-img  src="images/pos/block.jpg" max-height="900" max-width="90" contain></v-img>

                            </div>
                                <v-list-item-subtitle
                                            :class="active ? 'brown--text' : 'black--text'" class=" caption mt-1">
                                        Gold necklace
                                </v-list-item-subtitle>

                            </v-list-item-content>
                        </v-list-item>
                        </v-col>
                    </v-row>

                    </v-card>
                    </v-slide-item>
                </v-slide-group>
            </v-sheet>
            <!-- <v-row justify="center" class="space mt-2">
                <v-col
                cols="12"
                md="2"
                >
                <v-item v-slot="{ active, toggle }" >
                <v-card
                    :color="active ? '#F6EFEF' : 'white'"
                    :class="active ? 'borderme' : 'borderout'"
                    class="d-flex align-center rounded-lg mx-2"
                    dark
                    height="140"
                    @click="toggle"
                    flat
                    >
                    <v-row>
                        <v-col cols="12" sm="12">
                        <v-list-item three-line  class="text-center ">
                            <v-list-item-content>
                            <div align="center" justify="center">

                                <v-img  src="images/pos/block.jpg" max-height="110" max-width="110" contain></v-img>

                            </div>
                            <v-list-item-subtitle
                            :class="active ? 'brown--text' : 'black--text'" class=" caption mt-4">Gold block</v-list-item-subtitle>

                            </v-list-item-content>
                        </v-list-item>
                        </v-col>
                    </v-row>

                    </v-card>
                </v-item>
                </v-col>
                <v-col
                cols="12"
                md="2"
                >
                <v-item v-slot="{ active, toggle }" >
                <v-card
                    :color="active ? '#F6EFEF' : 'white'"
                    :class="active ? 'borderme' : 'borderout'"
                    class="d-flex align-center rounded-lg mx-2"
                    dark
                    height="140"
                    @click="toggle"
                    flat

                    >
                    <v-row>
                        <v-col cols="12" sm="12">
                        <v-list-item three-line  class="text-center ">
                            <v-list-item-content>
                            <div align="center" justify="center">

                                <v-img  src="images/pos/block.jpg" max-height="90" max-width="90" contain></v-img>

                            </div>
                            <v-list-item-subtitle
                        :class="active ? 'brown--text' : 'black--text'" class=" caption mt-3">Gold necklace</v-list-item-subtitle>

                            </v-list-item-content>
                        </v-list-item>
                        </v-col>
                    </v-row>

                    </v-card>
                </v-item>
                </v-col>
                <v-col
                cols="12"
                md="2"
                >
                <v-item v-slot="{ active, toggle }" >
                <v-card
                    :color="active ? '#F6EFEF' : 'white'"
                    :class="active ? 'borderme' : 'borderout'"
                    class="d-flex align-center rounded-lg mx-2"
                    dark
                    height="140"
                    @click="toggle"
                    flat
                    >
                    <v-row>
                        <v-col cols="12" sm="12">
                        <v-list-item three-line  class="text-center ">
                            <v-list-item-content>
                            <div align="center" justify="center">

                                <v-img  src="images/pos/block.jpg" max-height="80" max-width="80" contain></v-img>

                            </div>
                            <v-list-item-subtitle
                            :class="active ? 'brown--text' : 'black--text'" class=" caption mt-2">Gold ring</v-list-item-subtitle>

                            </v-list-item-content>
                        </v-list-item>
                        </v-col>
                    </v-row>

                    </v-card>
                </v-item>
                </v-col>
                <v-col
                cols="12"
                md="2"
                >
                <v-item v-slot="{ active, toggle }" >
                <v-card
                    :color="active ? '#F6EFEF' : 'white'"
                    :class="active ? 'borderme' : 'borderout'"
                    class="d-flex align-center rounded-lg mx-2"
                    dark
                    height="140"
                    @click="toggle"
                    flat
                    >
                    <v-row>
                        <v-col cols="12" sm="12">
                        <v-list-item three-line  class="text-center ">
                            <v-list-item-content>
                            <div align="center" justify="center">

                                <v-img  src="images/pos/block.jpg" max-height="80" max-width="80" contain></v-img>

                            </div>
                            <v-list-item-subtitle :class="active ? 'brown--text' : 'black--text'"
                            class=" caption mt-2">Diamond</v-list-item-subtitle>

                            </v-list-item-content>
                        </v-list-item>
                        </v-col>
                    </v-row>

                    </v-card>
                </v-item>
                </v-col>
                <v-col
                cols="12"
                md="2"
                >
                <v-item v-slot="{ active, toggle }" >
                <v-card
                    :color="active ? '#F6EFEF' : 'white'"
                    :class="active ? 'borderme' : 'borderout'"
                    class="d-flex align-center rounded-lg mx-2"
                    dark
                    height="140"
                    @click="toggle"
                    flat
                    >
                    <v-row>
                        <v-col cols="12" sm="12">
                        <v-list-item three-line  class="text-center ">
                            <v-list-item-content>
                            <div align="center" justify="center">

                                <v-img  src="images/pos/block.jpg" max-height="110" max-width="110" contain></v-img>

                            </div>
                            <v-list-item-subtitle :class="active ? 'brown--text' : 'black--text'"
                            class=" caption mt-3">Diamond and Gold</v-list-item-subtitle>

                            </v-list-item-content>
                        </v-list-item>
                        </v-col>
                    </v-row>

                    </v-card>
                </v-item>
                </v-col>
                <v-col
                cols="12"
                md="2"
                >
                <v-item v-slot="{ active, toggle }" >
                <v-card
                    :color="active ? '#F6EFEF' : 'white'"
                    :class="active ? 'borderme' : 'borderout'"
                    class="d-flex align-center rounded-lg mx-2"
                    dark
                    height="140"
                    @click="toggle"
                    flat
                    >
                    <v-row>
                        <v-col cols="12" sm="12">
                        <v-list-item three-line  class="text-center ">
                            <v-list-item-content>
                            <div align="center" justify="center">

                                <v-img  src="images/pos/block.jpg" max-height="110" max-width="110" contain></v-img>

                            </div>
                            <v-list-item-subtitle :class="active ? 'brown--text' : 'black--text'"
                            class=" caption mt-4">Gold coin</v-list-item-subtitle>

                            </v-list-item-content>
                        </v-list-item>
                        </v-col>
                    </v-row>

                    </v-card>
                </v-item>
                </v-col>
            </v-row> -->

        </v-container>
    </v-item-group>
</template>


<script>

  export default {
    name: 'ItemList',


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
