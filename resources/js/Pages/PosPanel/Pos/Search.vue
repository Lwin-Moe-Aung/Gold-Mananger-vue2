<template>
     <v-toolbar color="rgba(0,0,0,0)" flat>
              <v-row>
                  <v-col cols="12" sm="12">
                      <v-card    
                          flat class="rounded-lg mx-2" 
                        >
                        <v-row color="orange accent-1">

                        
                              <v-toolbar color="orange accent-1">
                                <v-col
                                    cols="12"
                                    sm="2"
                                  >
                                  <v-toolbar-title class="text-h6 mr-6 hidden-sm-and-down">
                                    Product SKU
                                  </v-toolbar-title>
                                </v-col>
                                <v-col
                                    cols="12"
                                    sm="3"
                                  >
                                    <v-autocomplete
                                    v-model="model"
                                    :items="items"
                                    :loading="isLoading"
                                    :search-input.sync="search"
                                    chips
                                    clearable
                                    hide-details
                                    hide-selected
                                    item-text="name"
                                    item-value="symbol"
                                    label="Search for a product type..."
                                    solo
                                                          >
                                      <template v-slot:no-data>
                                        <v-list-item>
                                          <v-list-item-title>
                                            Search for your favorite
                                            <strong>Products</strong>
                                          </v-list-item-title>
                                        </v-list-item>
                                      </template>
                                      <template v-slot:selection="{ attr, on, item, selected }">
                                        <v-chip
                                          v-bind="attr"
                                          :input-value="selected"
                                          color="blue-grey"
                                          class="white--text"
                                          v-on="on"
                                        >
                                          <v-icon left>
                                            mdi-bitcoin
                                          </v-icon>
                                          <span v-text="item.name"></span>
                                        </v-chip>
                                      </template>
                                        <template v-slot:item="{ item }">
                                          <v-list-item-avatar
                                            color="indigo"
                                            class="text-h5 font-weight-light white--text"
                                          >
                                            {{ item.name.charAt(0) }}
                                          </v-list-item-avatar>
                                          <v-list-item-content>
                                            <v-list-item-title v-text="item.name"></v-list-item-title>
                                            <v-list-item-subtitle v-text="item.symbol"></v-list-item-subtitle>
                                          </v-list-item-content>
                                          <v-list-item-action>
                                            <v-icon>mdi-bitcoin</v-icon>
                                          </v-list-item-action>
                                        </template>
                                  </v-autocomplete>
                                </v-col>
                                <v-col
                                    cols="12"
                                    sm="2"
                                    class="mt-7"
                                  >
                                      <v-select
                                            :items="select_item"
                                            label="ကျပ်သား"
                                            solo
                                          ></v-select>
                                </v-col>
                                <v-col
                                    cols="12"
                                    sm="2"
                                    class="mt-7"
                                  >
                                    <v-select
                                            :items="select_item"
                                            label="ပဲ"
                                            solo
                                          ></v-select>
                                </v-col>
                                  
                                  <v-col
                                    cols="12"
                                    sm="2"
                                    class="mt-7"
                                  >
                                    <v-select
                                            :items="select_item"
                                            label="ရွေး"
                                            solo
                                          ></v-select>
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