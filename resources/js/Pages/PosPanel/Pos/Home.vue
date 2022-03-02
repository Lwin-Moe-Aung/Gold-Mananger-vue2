<template>
    
        <pos-panel-layout>
             <!--<Search/>  -->
              <v-toolbar color="rgba(0,0,0,0)" flat>
                <v-row>
                    <v-col cols="12" sm="12">
                        <v-card    
                            flat class="rounded-lg mx-2" 
                          >
                            <v-row>
                                  <v-toolbar color="#ECBD00">
                                      <v-col
                                          cols="12"
                                          sm="5"
                                        >
                                          <v-autocomplete
                                                v-model="model"
                                                :items="products"
                                                :loading="isLoading"
                                                :search-input.sync="search"
                                                chips
                                                clearable
                                                hide-details
                                                hide-selected
                                                item-text="product_sku"
                                                item-value="id"
                                                label="Search for a coin..."
                                                solo
                                              >
                                              <template v-slot:no-data>
                                                <v-list-item>
                                                  <v-list-item-title>
                                                    Search for 
                                                    <strong>Product Sku</strong>
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
                                                  <span v-text="item.product_sku"></span>
                                                </v-chip>
                                              </template>
                                              <template v-slot:item="{ item }">
                                                <v-list-item-avatar
                                                  color="indigo"
                                                  class="text-h5 font-weight-light white--text"
                                                >
                                                  <v-img  :src="item.image" max-height="90" max-width="90" contain></v-img>
                                                  <!-- {{ item.name.charAt(0) }} -->
                                                </v-list-item-avatar>
                                                <v-list-item-content>
                                                  <v-list-item-title v-text="item.product_sku"></v-list-item-title>
                                                  <v-list-item-subtitle v-text="item.name"></v-list-item-subtitle>
                                                </v-list-item-content>
                                                <v-list-item-action>
                                                  <v-icon>mdi-bitcoin</v-icon>
                                                </v-list-item-action>
                                              </template>
                                            </v-autocomplete>
                                       </v-col>
                                  </v-toolbar>
                                  
                            </v-row>
                        </v-card>
                    </v-col>
                </v-row>
              </v-toolbar>
                
              <v-item-group mandatory class="mt-n1">
                  <v-container>
                    <v-sheet
                      class="mx-auto"
                      elevation="8"
                      max-width="1090"
                    >
                        <v-slide-group
                          
                          active-class="success"
                          show-arrows
                        >
                          <v-slide-item
                            v-for="item in items"
                            :key="item.id"
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
                             <v-row  @click="selectItem(item)">
                              <v-col cols="12" sm="12">
                                <v-list-item two-line  class="text-center ">
                                  <v-list-item-content>
                                    <div align="center" justify="center">
                                    
                                        <v-img  :src="item.image1" max-height="90" max-width="90" contain></v-img>
                                    
                                    </div>
                                    <v-list-item-subtitle
                                    :class="active ? 'brown--text' : 'black--text'" class=" caption mt-1">{{item.name}}</v-list-item-subtitle>
                                    
                                  </v-list-item-content>
                                </v-list-item>
                              </v-col>
                            </v-row>
                             
                            </v-card>
                          </v-slide-item>
                        </v-slide-group>
                    </v-sheet>
                   
        
                </v-container>
            </v-item-group>
            <v-toolbar color="#EEEEEE" flat class="toolbar-middle">
              <v-toolbar-title class="mb-7">Customer Profile</v-toolbar-title><v-spacer></v-spacer><span class="mb-7" color="grey">Open Voucher</span>
            </v-toolbar>
            <v-row>
                <Customer/>
                <Voucher1/>
                <Voucher2/>

            </v-row>
            <!-- <div class="bg red">hello</div> -->
            
        </pos-panel-layout>
    
</template>

<script>
    import PosPanelLayout from '../../../Layouts/PosPanelLayout';
    import Customer from './Customer';
    import ItemList from './ItemList';
    import Search from './Search';
    import Voucher1 from './Voucher1';
    import Voucher2 from './Voucher2';
    // import { pickBy, throttle } from 'lodash';
    import axios from 'axios'

    export default {
        components: {
            PosPanelLayout,
            Customer,
            ItemList,
            Search,
            Voucher1,
            Voucher2
        },
        data() {
          return {
              loading: false,
              product: [],
              form: this.$inertia.form({
                    id:'',
                    name: '',
                    image: '',
                    item_sku: '',
                    gold_weight: '',
                    gold_price: '',
                    fee_for_making: '',
                    item_discount: '',
                    tax: '',
                    item_description: '',

                }),
              isLoading: false,
              products: [],
              items: [],
              model: null,
              search: null,
            
          }
        },
        watch: {
          model (val) {
            if(val == null){
              this.items = [];
              return
            }
            axios.get(this.route('pos.search',val))
              .then(response => {
                // console.log(response);
                this.items = response.data;
              })
            
          },
          search (val) {
            // products have already been loaded
            if (this.products.length > 0) return
            this.isLoading = true
            // Lazily load input products
            fetch(this.route('pos.product.lists'))
            // fetch('https://api.coingecko.com/api/v3/coins/list')
              .then(res => res.clone().json())
              .then(res => {
                this.products = res
              })
              .catch(err => {
                console.log(err)
              })
              .finally(() => (this.isLoading = false))
            },
        },
        methods: {
          selectItem(item) {
            this.form.id = item.id;
            this.form.name = item.name;
            this.form.image = item.image1;
            this.form.item_sku = item.item_sku;
            this.form.gold_weight = item.gold_weight;
            this.form.gold_price = item.gold_price;
            this.form.fee_for_making = item.fee_for_making;
            this.form.item_discount = item.item_discount;
            this.form.tax = item.tax;
            this.form.item_description = item.item_description;

          }
          
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