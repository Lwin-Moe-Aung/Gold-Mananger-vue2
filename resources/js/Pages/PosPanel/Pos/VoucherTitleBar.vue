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
                    v-model = "dailySetup.kyat"
                    label="ပေါက်ဈေး"
                    :hint="!isEditing ? 'Click the icon to edit' : 'Click the icon to save'"
                    :readonly="!isEditing"
                >
                    <template v-slot:append-outer>
                        <v-slide-x-reverse-transition
                            mode="out-in"
                        >
                            <v-icon
                                :key="`icon-${isEditing}`"
                                :color="isEditing ? 'success' : 'info'"
                                @click="editDailySetup"
                                v-text="isEditing ? 'fas fa-check' : 'fas fa-edit'"
                            ></v-icon>
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
            dailySetup:[],
        }),
        created() {
            this.getDataForCombobox();
            this.unwatch1 = this.$store.watch(
                (state, getters) => getters.product_sku,
                (newValue, oldValue) => {
                    if(newValue.length > 3){
                        var q = newValue.charAt(0)+newValue.charAt(1);
                        var t = newValue.charAt(2);
                        var i_n = newValue.charAt(3);
                    }else{
                        var q = newValue.charAt(0);
                        var t = newValue.charAt(1);
                        var i_n = newValue.charAt(2);
                    }
                    this.dailySetup = this.$page.props.daily_setup[q];
                    let g_Quality  = this.goldQualitys.find(function(val) {
                        return val.quality == q;
                    });
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

                },
            );
            this.unwatch2 = this.$store.watch(
                (state, getters) => getters.selectedItem,
                (newValue, oldValue) => {
                   this.item_sku = newValue.item_sku
                },
            );
        },
        watch: {

        },
        methods: {
            ...mapActions(["searchItem", "addItem", "editItemFromCart","selectItemReset","searchItemByItemId","removeItem","removeItemFromSearchList","resetCustomer"]),
            getDataForCombobox() {
                axios.get(this.route("pos.get_data_for_combobox"))
                    .then((response) => {
                        this.goldQualitys = response.data.goldQualitys;
                });
            },
            onChangeQ (entry) {
                this.type = null;
                this.types = this.goldQuality.types;
                this.item_name = null;
                this.item_names = [];
                this.dailySetup = this.$page.props.daily_setup[this.goldQuality.quality];
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
            editDailySetup() {
                this.isEditing = !this.isEditing
                if(this.isEditing || this.goldQuality == null) return;

                let data = { dailySetup: this.dailySetup, quality:this.goldQuality.quality}
                axios.post('/pos/edit_daily_setup', data)
                .then(res => {
                    this.dailySetup.kyat = res.data.daily_price_kyat;
                    this.dailySetup.pal = res.data.daily_price_pal;
                    this.dailySetup.yway = res.data.daily_price_yway;
                })
                .catch(function (error) {
                    console.log(error);
                });

            },
            searchByItemId() {
                this.isEditingItemId = !this.isEditingItemId
                if(this.isEditingItemId || this.item_sku == "") return;

                this.searchItemByItemId(this.item_sku);

            },
        },
        computed: {
            ...mapGetters(['product_sku','toast_message','toast_icon','selectedItem']),
        },
        beforeDestroy() {
            this.unwatch1();
        },
    }
</script>
<style>
