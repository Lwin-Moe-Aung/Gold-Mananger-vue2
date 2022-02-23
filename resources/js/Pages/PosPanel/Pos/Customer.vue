<template>
     <v-col cols="12" sm="3">
                      <v-card    
                          flat class="rounded-lg mx-3"
                        >
                            <v-list-item three-line>
                                  <v-list-item-avatar
                                      rounded
                                      size="50"
                                      class="mr-2"
                                      color="grey lighten-4"
                                    >
                                    <v-img src="images/pos/customer.jpg"></v-img>
                                  </v-list-item-avatar>
                          
                                  <v-list-item-content>
                                    <v-list-item-title class="text-h5">
                                      Daw Hla Hla
                                    </v-list-item-title>
                                    <v-list-item-subtitle class="mt-1">No2, Hledan, Kamaryouk, Yangon, Myanmar</v-list-item-subtitle>
                                    <v-list-item-subtitle class="mt-1">0982382728</v-list-item-subtitle>

                                    <strong class="mt-3">
                                      Debit : 50,000
                                    </strong>
                                    
                                    
                                  </v-list-item-content>
                            </v-list-item>
                          <v-card-text class="mr-6">
                              <div class="font-weight-bold ml-8 mb-2">
                              02-02-2022
                              </div>

                              <v-timeline
                                align-top
                                dense
                              >
                                <v-timeline-item
                                  v-for="message in messages"
                                  :key="message.time"
                                  :color="message.color"
                                  small
                                >
                                  <div>
                                    <div class="font-weight-normal">
                                      <strong>{{ message.from }}</strong> @{{ message.time }}
                                    </div>
                                    <div>{{ message.message }}</div>
                                  </div>
                                </v-timeline-item>
                              </v-timeline>
                            </v-card-text>
                  
              
                        <v-card-actions class="text-right">
                          <v-btn
                            text
                              color="deep-purple accent-4"
                              
                            >
                              View Profile Detail
                            </v-btn>
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