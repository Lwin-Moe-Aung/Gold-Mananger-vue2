<template>
      <v-col cols="12" sm="3">
                <v-card    
                      flat class="rounded-lg mx-3"
                    >

                      
                    <v-list-item three-line>
                      <v-list-item-avatar
                        rounded
                        size="100"
                        color="grey lighten-4"
                      >
                      <v-img src="images/pos/block.jpg"></v-img>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-title class="text-h5">
                          Gold block
                        </v-list-item-title>
                        <v-list-item-subtitle class="mt-1">Description is the pattern of narrative development that aims to make vivid a place, object, character....</v-list-item-subtitle>
                      
                      </v-list-item-content>
                    </v-list-item>
                    <v-card-actions>
                      <v-form>
                            <v-container>
                                <v-row class="voucher-row1">
                                  <v-list-item-content>
                                    <strong class="mb-7 ml-5">
                                        လျော့ငွေ
                                      </strong>
                                  
                                  </v-list-item-content>
                                  <v-col
                                        cols="12"
                                        sm="6"
                                        md="7"
                                      >
                                        <v-text-field
                                          label="kyats"
                                          placeholder="kyats"
                                          outlined
                                          dense
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row class="voucher-row1">
                                  <v-list-item-content>
                                    <strong class="mb-7 ml-5">
                                        ကျသင့်ငွေ
                                      </strong>
                                  
                                  </v-list-item-content>
                                  <v-col
                                        cols="12"
                                        sm="12"
                                        md="7"
                                      >
                                        <v-text-field
                                          label="kyats"
                                          placeholder="kyats"
                                          outlined
                                          dense
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row class="voucher-row1">
                                  <v-list-item-content>
                                    <strong class="mb-7 ml-5">
                                        ပေးငွေ
                                      </strong>
                                  
                                  </v-list-item-content>
                                  <v-col
                                        cols="12"
                                        sm="12"
                                        md="7"
                                      >
                                        <v-text-field
                                          label="kyats"
                                          placeholder="kyats"
                                          outlined
                                          dense
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row class="voucher-row1">
                                  <v-list-item-content>
                                    <strong class="mb-7 ml-5">
                                        ကျန်ငွေ
                                      </strong>
                                  
                                  </v-list-item-content>
                                  <v-col
                                        cols="12"
                                        sm="12"
                                        md="7"
                                      >
                                        <v-text-field
                                          label="kyats"
                                          placeholder="kyats"
                                          outlined
                                          dense
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                              
                            </v-container>
                        </v-form>
                    </v-card-actions>
                      <v-card-actions>
                          <v-btn color="#ECBD00" block dark class="withoutupercase mb-2 black--text">Print Bill</v-btn>
                      </v-card-actions>
                    
                </v-card>
              </v-col>
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