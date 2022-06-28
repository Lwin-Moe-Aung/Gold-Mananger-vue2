<template>
    <v-container class="pa-5" >

        <v-row>
        <!-- combo box -->
            <v-col
                cols="12"
                lg="3"
                md="3"
                sm="3"
                xs="3"
            >
                <v-combobox
                    v-model="goldQuality"
                    :items="goldQualitys"
                    @change="onChangeQ"
                    item-text="name"
                    item-value="quality"
                    return-object
                    label="ပဲရည်"
                ></v-combobox>
            </v-col>
             <!-- <v-spacer class="d-lg-none d-xl-flex black--text"></v-spacer> -->

            <v-col
                cols="12"
                lg="4"
                md="4"
                sm="4"
                xs="4"
            >
                <v-combobox
                    v-model="type"
                    :items="types"
                    @change="onChangeT"
                    item-text="name"
                    item-value="key"
                    return-object
                    label="ရွှေ/ကျောက်"
                ></v-combobox>
            </v-col>
             <!-- <v-spacer class="d-lg-none d-xl-flex black--text"></v-spacer> -->

            <v-col
                cols="12"
                lg="4"
                md="4"
                sm="4"
                xs="4"
            >
                <v-combobox
                    v-model="item_name"
                    :items="item_names"
                    @change="onChangeItemName"
                    item-text="name"
                    item-value="key"
                    return-object
                    label="အမျိုးအမည်"
                ></v-combobox>
            </v-col>
        <!-- combo box -->
        </v-row>


        <v-row>
            <v-col
                cols="12"
                lg="6"
                sm="6"
                md="6"
                xs="6"
                >
                <v-text-field
                    v-model = "daily_Setup.kyat"
                    label="ပေါက်ဈေး"
                    placeholder="ကျပ်"
                    :rules="validationRules"
                    @change="editDailySetup"
                    type="number"
                >
                    <template v-slot:append-outer>
                        <v-slide-x-reverse-transition
                            mode="out-in"
                        >
                            <v-icon
                                :key="`icon-${isEditing}`"
                                @click="restoreDailySetup"
                                aria-hidden="true"
                            >
                            refresh</v-icon>
                        </v-slide-x-reverse-transition>
                    </template>
                </v-text-field>
            </v-col>
             <v-spacer class="d-lg-none d-xl-flex black--text"></v-spacer>
            <v-col
                cols="12"
                lg=""
                sm="4"
                md="4"
                xs="4"
                >
                <v-text-field
                    v-model = "item_sku"
                    label="Unit Id"
                    :hint="!isEditingItemId ? 'Click the icon to edit' : 'Click the icon to save'"
                    :readonly="!isEditingItemId"
                >
                    <template v-slot:append-outer>
                        <v-slide-x-reverse-transition
                            mode="out-in"
                        >
                            <v-icon
                                :key="`icon-${isEditingItemId}`"
                                :color="isEditingItemId ? 'success' : 'info'"
                                @click="searchByItemId"
                                v-text="isEditingItemId ? 'fas fa-check' : 'fas fa-edit'"
                            ></v-icon>
                        </v-slide-x-reverse-transition>
                    </template>
                </v-text-field>
            </v-col>
        </v-row>

    </v-container>
</template>

<script>
    import axios from 'axios';
    import {mapGetters, mapActions} from "vuex";

    export default {
        name: 'VoucherTitleBar',
        data: () => ({
            // combobox
            // dataForCombobox:[],
            goldQuality: null,
            goldQualitys: [],
            type: null,
            types: [],
            item_name: null,
            item_names: [],
            // end combobox
            isEditing: false,
            isEditingItemId: false,
            item_sku:'',
            daily_Setup: { daily_setup_id: "", quality_16_pal: "", kyat: "", pal: "", yway: "" },
            validationRules:[
                v => !!v || 'Required',
                // v => /^\d+$/.test(v) || 'limitation error',
            ],
            selectedItem_dailySetup: {},
        }),
        async created() {
            await this.getDataForCombobox();
            await this.fillData();
            // this.unwatch1 = this.$store.watch(
            //     (state, getters) => getters.product_sku,
            //     (newValue, oldValue) => {
            //         if(newValue.length > 3){
            //             var q = newValue.charAt(0)+newValue.charAt(1);
            //             var t = newValue.charAt(2);
            //             var i_n = newValue.charAt(3);
            //         }else{
            //             var q = newValue.charAt(0);
            //             var t = newValue.charAt(1);
            //             var i_n = newValue.charAt(2);
            //         }
            //         this.setDailySetup(this.$page.props.daily_setup[q]);
            //         let g_Quality  = this.goldQualitys.find(function(val) {
            //             return val.quality == q;
            //         });
            //         this.goldQuality = g_Quality;
            //         this.types = this.goldQuality.types;
            //         let type_e = this.types.find(function(val) {
            //             return val.key == t;
            //         });
            //         this.type = type_e;
            //         this.item_names = this.type.item_names
            //         let item_n = this.item_names.find(function(val) {
            //             return val.key == i_n;
            //         });
            //         this.item_name = item_n;

            //     },
            // );
            // this.unwatch2 = this.$store.watch(
            //     (state, getters) => getters.selectedItem,
            //     (newValue, oldValue) => {
            //        this.item_sku = newValue.item_sku
            //     },
            // );
        },
        watch: {
            daily_setup(value){
                this.daily_Setup.daily_setup_id = value.daily_setup_id;
                this.daily_Setup.kyat = value.kyat;
                this.daily_Setup.pal = value.pal;
                this.daily_Setup.yway = value.yway;
            },
            selectedItem(value) {
                this.item_sku = value.item_sku;
                if(typeof value.daily_Setup !== 'undefined') Object.assign(this.daily_Setup, value.daily_Setup);
                if(this.item_from_cart && value !== "") this.setDailySetup(value.product_sku);
            },
            product_sku(newValue) {
                this.setDailySetup(newValue);
            }

        },
        methods: {
            ...mapActions(["searchItem", "addItem", "editItemFromCart","selectItemReset","searchItemByItemId","removeItem","removeItemFromSearchList","resetCustomer", "dailySetup"]),
            fillData() {
                if(this.selectedItem == "" )return;
                Object.assign(this.daily_Setup, this.selectedItem.daily_Setup);
                this.setDailySetup(this.selectedItem.product_sku);
                this.item_sku = this.selectedItem.item_sku;
            },
            setDailySetup(newValue) {
                console.log(newValue)
                if(newValue.length > 3){
                    var q = newValue.charAt(0)+newValue.charAt(1);
                    var t = newValue.charAt(2);
                    var i_n = newValue.charAt(3);
                }else{
                    var q = newValue.charAt(0);
                    var t = newValue.charAt(1);
                    var i_n = newValue.charAt(2);
                }
                let g_Quality  = this.goldQualitys.find(function(val) {
                    return val.quality == q;
                });
                console.log("ggq");
                console.log(this.goldQualitys);
                console.log(q);
                console.log(g_Quality);
                this.goldQuality = g_Quality;
                this.types = this.goldQuality.types;
                let type_e = this.types.find(function(val) {
                    return val.key == t;
                });
                this.type = type_e;
                this.item_names = this.type.item_names
                let item_n = this.item_names.find(function(val) {
                    return val.key == i_n;
                });
                this.item_name = item_n;
                if(!this.item_from_cart)  this.dailySetup(this.$page.props.daily_setup[this.goldQuality.quality]);
                else this.dailySetup(this.daily_Setup);
            },
            async getDataForCombobox(){
                await axios.get(this.route("pos.get_data_for_combobox"))
                    .then((response) => {
                        this.goldQualitys = response.data.goldQualitys;
                });
            },
            onChangeQ (entry) {
                this.type = null;
                this.types = this.goldQuality.types;
                this.item_name = null;
                this.item_names = [];
                this.dailySetup(this.$page.props.daily_setup[this.goldQuality.quality]);
            },
            onChangeT (entry) {
                this.item_name = null;
                this.item_names = this.type.item_names;
            },
            onChangeItemName (entry) {
                if(this.goldQuality == null && this.type == null  && this.item_name == null ) return;
                let product_sku = this.goldQuality.quality+this.type.key+this.item_name.key;

                let data = { product_sku: product_sku}
                this.searchItem(data);
                // this.clearFormData();
            },
            // editDailySetupOld() {
            //     this.isEditing = !this.isEditing
            //     if(this.isEditing || this.goldQuality == null) return;

            //     let data = { daily_Setup: this.daily_Setup, quality:this.goldQuality.quality}
            //     axios.post('/pos/edit_daily_setup', data)
            //     .then(res => {
            //         this.daily_Setup.kyat = res.data.daily_price_kyat;
            //         this.daily_Setup.pal = res.data.daily_price_pal;
            //         this.daily_Setup.yway = res.data.daily_price_yway;
            //     })
            //     .catch(function (error) {
            //         console.log(error);
            //     });

            // },
            editDailySetup() {
                if(this.goldQuality == null)return;
                if(this.daily_Setup.kyat <= 1000 ){
                    alert('daily price must be greater than "1000"');
                    return;
                };
                let q = parseInt(this.goldQuality.quality);
                let kyat = parseInt(this.daily_Setup.kyat);
                let pal = kyat / q;
                let yway = pal / 8;
                this.daily_Setup.daily_setup_id = "";
                this.daily_Setup.quality_16_pal = pal * (q+(16-q));
                this.daily_Setup.kyat = kyat;
                this.daily_Setup.pal = pal;
                this.daily_Setup.yway = yway;

                this.dailySetup(this.daily_Setup);
            },
            restoreDailySetup() {
                this.isEditing = !this.isEditing;
                if(this.goldQuality == null) return;
                this.dailySetup(this.$page.props.daily_setup[this.goldQuality.quality]);
            },
            searchByItemId() {
                this.isEditingItemId = !this.isEditingItemId
                if(this.isEditingItemId || this.item_sku == "") return;

                this.searchItemByItemId(this.item_sku);

            },
        },
        computed: {
            ...mapGetters(['product_sku','toast_message','toast_icon','selectedItem','daily_setup','item_from_cart']),
        },
    }
</script>
<style>
