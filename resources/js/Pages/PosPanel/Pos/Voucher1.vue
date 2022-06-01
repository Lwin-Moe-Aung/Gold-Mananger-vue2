<template>
    <v-col cols="12" sm="9">
        <v-hover v-slot="{ hover }" close-delay="200">
            <v-card
                :elevation="hover ? 16 : 2"
                :class="{ 'on-hover': hover }"
                flat
                class="mx-auto rounded-lg mx-3 no-print"
            >
            <v-form ref="form" lazy-validation>

                <v-list-item three-line>
                    <v-list-item-avatar
                        rounded
                        size="100"
                        color="grey lighten-4"
                        v-if="form.id"
                    >
                        <v-img :src="form.image"></v-img>
                    </v-list-item-avatar>
                    <!-- image upload -->

                     <v-card v-else rounded="lg" class="overflow-hidden mr-3" width="130" height="130" @click.stop="selectImage" >
                        <input id="fileInput" class="d-none" type="file" accept="image/*" @input="updateValue">
                        <v-fade-transition mode="out-in">
                        <v-img v-if="form.image" aspect-ratio="1" :src="form.image">
                            <v-row class="fill-height" align="end" justify="center">
                            <v-slide-y-reverse-transition>
                                <v-sheet v-if="mask" color="error" width="100%" height="100%" class="mask" />
                            </v-slide-y-reverse-transition>
                                <v-btn
                                    class="mb-3"
                                    fab
                                    x-small
                                    color="error"
                                    @click.stop="deleteImage"
                                    @mouseenter="mask=true"
                                    @mouseleave="mask=false"
                                >
                                    <v-icon>mdi-delete</v-icon>
                                </v-btn>
                            </v-row>
                        </v-img>
                        <v-row v-else class="d-flex flex-column align-center justify-center fill-height">
                            <v-icon>
                            mdi-paperclip
                            </v-icon>
                            <span class="mt-3">Select an Image</span>
                        </v-row>
                        </v-fade-transition>
                    </v-card>
                    <!-- end image upload -->
                    <v-list-item-content>
                        <v-list-item-title class="text-h5">
                            <v-row>

                            <!-- combo box -->
                                <v-col
                                    cols="2"
                                    sm="2"
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
                                <v-col
                                    cols="3"
                                    sm="3"
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
                                <v-col
                                    cols="3"
                                    sm="3"
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

                        </v-list-item-title>
                        <v-list-item-subtitle class="mt-1">
                            {{ form.item_description }}
                        </v-list-item-subtitle>
                         <v-row>
                            <v-col
                                cols="5"
                                sm="5"
                                >
                                    <v-text-field
                                        v-model = "dailyValue"
                                        label="ပေါက်စေ◌ျး"
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
                            <v-col
                                cols="3"
                                sm="3"
                                >
                                    <v-text-field
                                        v-model = "form.item_sku"
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

                    </v-list-item-content>
                </v-list-item>
                <v-list-item
                    style="
                        min-height: 5px !important;
                        margin-top: -10px;
                        margin-bottom: 13px;
                    "
                >
                    <v-row style="margin-left: 705px">
                        <v-icon
                            color="info"
                            @click="addToCart()"
                            v-text="'fas fa-shopping-cart'"
                        ></v-icon>
                    </v-row>
                </v-list-item>
                <v-card-actions>
                    <!--new-->
                        <v-container>
                            <v-row>
                                <v-col cols="12" sm="8">
                                    <!--row for voucher-->
                                    <v-row class="voucher-row">
                                        <v-list-item-content>
                                            <strong class="mb-7 ml-5">
                                                ရွှေချိန်

                                            </strong>
                                        </v-list-item-content>
                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model = "form.gold_weight.kyat"
                                                label="ကျပ်"
                                                placeholder="ကျပ်"
                                                outlined
                                                dense
                                                :rules="validationRules"
                                                required
                                                @change="onChange"
                                                type="number"
                                            >
                                            </v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model = "form.gold_weight.pal"
                                                label="ပဲ"
                                                placeholder="ပဲ"
                                                outlined
                                                dense
                                                :rules="validationRules"
                                                required
                                                @change="onChange"
                                                type="number"
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model = "form.gold_weight.yway"
                                                label="ရွေး"
                                                placeholder="ရွေး"
                                                outlined
                                                dense
                                                :rules="validationRules"
                                                required
                                                @change="onChange"
                                                type="number"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="3">
                                            <v-text-field
                                                :value = "goldPrice"
                                                label="ကျသင့်ငွေ"
                                                placeholder="ကျသင့်ငွေ"
                                                outlined
                                                dense
                                                readonly
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>

                                    <v-row class="voucher-row">
                                        <v-list-item-content>
                                            <strong class="mb-7 ml-5">
                                                ကျောက်ချိန်
                                            </strong>
                                        </v-list-item-content>
                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.gem_weight.kyat"
                                                label="ကျပ်"
                                                placeholder="ကျပ်"
                                                outlined
                                                dense
                                                :rules="validationRules"
                                                required
                                                readonly
                                                type="number"
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.gem_weight.pal"
                                                label="ပဲ"
                                                placeholder="ပဲ"
                                                outlined
                                                dense
                                                :rules="validationRules"
                                                required
                                                readonly
                                                type="number"
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.gem_weight.yway"
                                                label="ရွေး"
                                                placeholder="ရွေး"
                                                outlined
                                                dense
                                                :rules="validationRules"
                                                required
                                                readonly
                                                type="number"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="3">
                                            <v-text-field
                                                :value = "gemPrice"
                                                label="ကျသင့်ငွေ"
                                                placeholder="ကျသင့်ငွေ"
                                                outlined
                                                dense
                                                readonly
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>

                                    <v-row class="voucher-row">
                                        <v-list-item-content>
                                            <strong class="mb-7 ml-5">
                                                အလျော့တွက်
                                            </strong>
                                        </v-list-item-content>
                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.fee.kyat"
                                                label="ကျပ်"
                                                placeholder="ကျပ်"
                                                outlined
                                                dense
                                                :rules="validationRules"
                                                required
                                                type="number"
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.fee.pal"
                                                label="ပဲ"
                                                placeholder="ပဲ"
                                                outlined
                                                dense
                                                :rules="validationRules"
                                                required
                                                type="number"
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.fee.yway"
                                                label="ရွေး"
                                                placeholder="ရွေး"
                                                outlined
                                                dense
                                                :rules="validationRules"
                                                required
                                                type="number"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="3">
                                            <v-text-field
                                                :value = "feePrice"
                                                label="ကျသင့်ငွေ"
                                                placeholder="ကျသင့်ငွေ"
                                                outlined
                                                dense
                                                readonly
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="voucher-row">
                                        <v-list-item-content>
                                            <strong class="mb-7 ml-5">
                                                လက်ခ
                                            </strong>
                                        </v-list-item-content>
                                        <v-col cols="12" sm="6" md="2"> </v-col>

                                        <v-col cols="12" sm="6" md="2"> </v-col>
                                        <v-col cols="12" sm="6" md="2"> </v-col>

                                        <v-col cols="12" sm="6" md="3">
                                            <v-text-field
                                                v-model="form.fee_for_making"
                                                label="ကျသင့်ငွေ"
                                                placeholder="ကျသင့်ငွေ"
                                                outlined
                                                dense
                                                :rules="validationRules"
                                                required
                                                type="number"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>

                                    <v-row class="voucher-row">
                                        <v-list-item-content>
                                            <strong class="mb-7 ml-5">
                                                စုစုပေါင်း
                                            </strong>
                                        </v-list-item-content>
                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                :value = "total_kyat"
                                                label="ကျပ်"
                                                placeholder="ကျပ်"
                                                outlined
                                                dense
                                                readonly
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                :value = "total_pal"
                                                label="ပဲ"
                                                placeholder="ပဲ"
                                                outlined
                                                dense
                                                readonly
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                :value = "total_yway"
                                                label="ရွေး"
                                                placeholder="ရွေး"
                                                outlined
                                                dense
                                                readonly
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="3">
                                            <v-text-field
                                                :value = "totalBefore"
                                                label="ကျသင့်ငွေ"
                                                placeholder="ကျသင့်ငွေ"
                                                outlined
                                                dense
                                                readonly
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>
                                <v-col cols="12" sm="1" class="justify-center">
                                    <!-- <v-divider
                                      vertical
                                    ></v-divider> -->
                                </v-col>

                                <v-col cols="12" sm="3">
                                    <v-row class="voucher-row">
                                        <v-list-item-content>
                                            <strong class="mb-7 ml-5">
                                                လျော့ငွေ
                                            </strong>
                                        </v-list-item-content>
                                        <v-col cols="12" sm="6" md="7">
                                            <v-text-field
                                                v-model="form.item_discount"
                                                label="kyats"
                                                placeholder="kyats"
                                                outlined
                                                dense
                                                :rules="validationRules"
                                                required
                                                type="number"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="voucher-row">
                                        <v-list-item-content>
                                            <strong class="mb-7 ml-5">
                                                ကျသင့်ငွေ
                                            </strong>
                                        </v-list-item-content>
                                        <v-col cols="12" sm="12" md="7">
                                            <v-text-field
                                                :value = "finalTotal"
                                                label="kyats"
                                                placeholder="kyats"
                                                outlined
                                                dense
                                                :rules="validationRules"
                                                required
                                                type="number"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="voucher-row">
                                        <v-list-item-content>
                                            <strong class="mb-7 ml-5">
                                                ပေးငွေ
                                            </strong>
                                        </v-list-item-content>
                                        <v-col cols="12" sm="12" md="7">
                                            <v-text-field
                                                v-model="form.paid_money"
                                                label="kyats"
                                                placeholder="kyats"
                                                outlined
                                                dense
                                                :rules="validationRules"
                                                required
                                                type="number"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="voucher-row">
                                        <v-list-item-content>
                                            <strong class="mb-7 ml-5">
                                                ကျန်ငွေ
                                            </strong>
                                        </v-list-item-content>
                                        <v-col cols="12" sm="12" md="7">
                                            <v-text-field
                                                :value = "creditMoney"
                                                label="kyats"
                                                placeholder="kyats"
                                                outlined
                                                dense
                                                readonly
                                                type="number"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="voucher-row">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-btn
                                                color="#ECBD00"
                                                block
                                                dark
                                                class="withoutupercase black--text"
                                                @click="printbill"
                                                >Print Bill</v-btn
                                            >
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>

                            <!--row for voucher-->
                        </v-container>
                        <!--end new-->
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-hover>
        <v-dialog
            v-model="loading"
            hide-overlay
            persistent
            width="300"
                    >
            <v-card
                color="primary"
                dark
            >
                <v-card-text>
                    Please stand by
                    <v-progress-linear
                        indeterminate
                        color="white"
                        class="mb-0"
                    ></v-progress-linear>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-col>
</template>

<script>
    import { validationMixin } from 'vuelidate'
    import { required, maxLength, email } from 'vuelidate/lib/validators'
    import axios from 'axios';
    import Invoice from "./Invoice";
    import { Link } from '@inertiajs/inertia-vue'
    import constant from "../../../constant";
    import {mapGetters, mapActions} from "vuex";

    export default {
        components: {
            Invoice,
            Link,
        },
        mixins: [validationMixin],
        validations: {
            quality: { required, maxLength: maxLength(10) },
        },
        name: "ItemList",

        data() {
            return {
                form: {
                    id: "",
                    name: "",
                    product_sku: "",
                    image: undefined,
                    imageFile: undefined,
                    item_sku: "",
                    gold_weight: { kyat: "", pal: "", yway: "" },
                    gold_price: "",
                    gem_weight: { kyat: "", pal: "", yway: "" },
                    gem_price: "",
                    fee: { kyat: "", pal: "", yway: "" },
                    fee_price: "",
                    fee_for_making: "",
                    item_discount: "",
                    tax: "",
                    item_sku: "",
                    item_description: "",
                    total_kyat: "",
                    total_pal: "",
                    exceed_pal_form_yway: "",
                    total_yway: "",
                    total_before: "",
                    final_total: "",
                    paid_money: "",
                    credit_money: "",
                    note: "",
                },
                quality: '',
                name: '',
                email: '',
                dailyValue: '',
                dailySetup: [],
                loading: false,
                validationRules:[
                    v => !!v || 'Required',
                    v => /^\d+$/.test(v) || 'Must be a number',
                ],

                //image upload
                input: undefined,
                // image: undefined,
                mask: false,
                // combobox
                dataForCombobox:[],
                goldQuality: null,
                goldQualitys: [],
                type: null,
                types: [],
                item_name: null,
                item_names: [],
                // end combobox
                isEditing: false,
                isEditingItemId: false,
            };
        },
        mounted () {
            this.input = document.getElementById('fileInput')
        },

        created() {
            this.getDataForCombobox();
        },

        methods: {
            ...mapActions(["searchItem", "addItem", "editItemFromCart","selectItemReset","searchItemByItemId","removeItem","removeItemFromSearchList","resetCustomer"]),

            getDataForCombobox() {
                axios.get(this.route("pos.get_data_for_combobox"))
                    .then((response) => {
                        this.dataForCombobox = response.data;
                });
            },

            //combo box
            onChangeQ (entry) {
                this.type = null;
                this.types = this.goldQuality.types;
                this.item_name = null;
                this.item_names = [];

            },
            onChangeT (entry) {
                this.item_name = null;
                this.item_names = this.type.item_names;
            },
            onChangeItemName (entry) {
                if(this.goldQuality == null && this.type == null  && this.item_name == null ) return;
                let product_sku = this.goldQuality.quality+this.type.key+this.item_name.key;
                var item_spe = null;
                if(this.form.gold_weight.kyat != "" && this.form.gold_weight.pal  != "" && this.form.gold_weight.yway != ""){
                    let kyat = this.form.gold_weight.kyat.length == 1 ? '0'+this.form.gold_weight.kyat : this.form.gold_weight.kyat;
                    let pal = this.form.gold_weight.pal.length == 1 ? '0'+this.form.gold_weight.pal : this.form.gold_weight.pal;
                    item_spe = kyat + pal+this.form.gold_weight.yway;
                }
                let data = { product_sku: product_sku, item_spe: item_spe}
                this.searchItem(data);
            },
            onChange(entry) {
                if(this.form.gold_weight.kyat != "" && this.form.gold_weight.pal  != ""
                     && this.form.gold_weight.yway != "" && this.goldQuality != null
                      && this.type != null  && this.item_name != null ){

                    let product_sku = this.goldQuality.quality+this.type.key+this.item_name.key;
                    let kyat = this.form.gold_weight.kyat.length == 1 ? '0'+this.form.gold_weight.kyat : this.form.gold_weight.kyat;
                    let pal = this.form.gold_weight.pal.length == 1 ? '0'+this.form.gold_weight.pal : this.form.gold_weight.pal;

                    let item_spe = kyat + pal+this.form.gold_weight.yway;
                    let data = { product_sku: product_sku, item_spe: item_spe}
                    this.searchItem(data);
                }else{
                    alert("valitation");
                }
            },
            //combo box
            addToCart() {
                if(this.form.id == ""){
                    Toast.fire({
                        icon: 'success',
                        title: 'ဖန်တီးထားသောကုန်ပစ္စည်းကို cart ထဲ့ထည့်မရပါ'
                    });
                    return;
                }
                if(this.customer == ""){
                    Toast.fire({
                        icon: 'success',
                        title: 'customer ထည့်သွင့်ရန်လိုအပ့်နေသည်'
                    });
                    return;
                }
                if(this.$refs.form.validate()){
                    let item = {
                        id: this.form.id,
                        name: this.form.name,
                        product_sku: this.form.product_sku,
                        image1: this.form.image,
                        item_sku: this.form.item_sku,
                        gold_weight: this.form.gold_weight,
                        gold_price: this.form.gold_price,
                        gem_weight: this.form.gem_weight,
                        gem_price: this.form.gem_price,
                        fee: this.form.fee,
                        fee_price: this.form.fee_price,
                        fee_for_making: this.form.fee_for_making,
                        item_discount: this.form.item_discount,
                        tax: this.form.tax,
                        item_description: this.form.item_description,
                        total_kyat: this.form.total_kyat,
                        total_pal: this.form.total_pal,
                        exceed_pal_form_yway: this.form.exceed_pal_form_yway,
                        total_yway: this.form.total_yway,
                        total_before: this.form.total_before,
                        final_total: this.form.final_total,
                        paid_money: this.form.paid_money,
                        credit_money: this.form.credit_money,
                        note: this.form.note,
                        quality: this.quality,
                        customer:this.customer

                    };
                    if(this.item_from_cart){
                        //edit item from cart
                        this.editItemFromCart(item);
                        Toast.fire({
                            icon: 'success',
                            title: 'Successfully update'
                        })
                        this.clearFormData();
                        this.selectItemReset();
                        this.resetCustomer();
                    }else{
                        //add item to cart
                        let status = true;
                        this.carts.forEach((x) => {
                            if(x.id == item.id) status = false;
                        });
                        if(status) {
                            this.addItem(item);
                            this.resetCustomer();
                            Toast.fire({
                                icon: 'success',
                                title: 'Success Add to Cart'
                            })
                        }else{
                            Toast.fire({
                                icon: 'success',
                                title: 'Already exist'
                            })
                        }
                        this.clearFormData();
                        this.selectItemReset();

                    }
                }
            },
            editDailySetup() {
                this.isEditing = !this.isEditing
                if(this.isEditing || this.quality == "") return;

                this.dailySetup.kyat = this.dailyValue;
                let data = { dailySetup: this.dailySetup, quality:this.quality}
                axios.post('/pos/edit_daily_setup', data)
                .then(res => {
                    this.dailySetup.kyat = res.data.kyat;
                    this.dailySetup.pal = res.data.pal;
                    this.dailySetup.yway = res.data.yway;
                })
                .catch(function (error) {
                    console.log(error);
                });

            },
            searchByItemId() {
                this.isEditingItemId = !this.isEditingItemId
                if(this.isEditingItemId || this.form.item_sku == "") return;

                this.searchItemByItemId(this.form.item_sku);

            },
            printbill() {
                if(this.customer == ""){
                    Toast.fire({
                        icon: 'success',
                        title: 'customer ထည့်သွင့်ရန်လိုအပ့်နေသည်'
                    });
                    return;
                }
                if(this.$refs.form.validate()){
                    this.loading = true;
                    let data = new FormData();
                    data.append('id',this.form.id);
                    data.append('name',this.form.name);
                    data.append('product_sku',this.form.product_sku);
                    data.append('image',this.form.image);
                    data.append('imageFile',this.form.imageFile);
                    data.append('item_sku',this.form.item_sku);
                    data.append('gold_weight',JSON.stringify(this.form.gold_weight));
                    data.append('gold_price',this.form.gold_price);
                    data.append('gem_weight',JSON.stringify(this.form.gem_weight));
                    data.append('gem_price',this.form.gem_price);
                    data.append('fee',JSON.stringify(this.form.fee));
                    data.append('fee_price',this.form.fee_price);
                    data.append('fee_for_making',this.form.fee_for_making);
                    data.append('item_discount',this.form.item_discount);
                    data.append('total_kyat',this.form.total_kyat);
                    data.append('total_pal',this.form.total_pal);
                    data.append('total_yway',this.form.total_yway);
                    data.append('total_before',this.form.total_before);
                    data.append('final_total',this.form.final_total);
                    data.append('paid_money',this.form.paid_money);
                    data.append('credit_money',this.form.credit_money);
                    data.append('note',this.form.note);
                    data.append('customer_id',this.customer.id);

                    axios.post('/pos/save_order', data)
                        .then(res => {
                            if(res.data.status)
                            {
                                this.clearFormData();
                                this.selectItemReset();
                                this.removeItem(this.form.id);
                                this.removeItemFromSearchList(this.form.id);
                                this.resetCustomer();
                                window.open( constant.URL+"generate_invoice/"+res.data.order_id, "_blank");
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Order Success'
                                })
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });

                }
            },
            selectImage () {
                if (!this.form.imageFile) {
                    this.input.click()
                }
            },
            updateValue (event) {
                this.form.imageFile = event.target.files[0]
                this.form.image = this.form.imageFile ? URL.createObjectURL(this.form.imageFile) : undefined
                this.$emit('input', this.form.imageFile)
            },
            deleteImage () {
                if (this.form.imageFile) {
                    this.form.imageFile = undefined
                    this.form.image = undefined
                    this.mask = false
                    this.input.value = '' // <-- this will fix the issue
                    this.$emit('input', undefined)
                }
            },
            printVoucher() {
                window.print();
            },
            clearFormData() {
                    this.form.id= "",
                    this.form.name= "",
                    this.form.product_sku= "",
                    this.form.image= undefined,
                    this.form.imageFile= undefined,
                    this.form.item_sku= "",
                    this.form.gold_weight= { kyat: "", pal: "", yway: "" },
                    this.form.gold_price= "",
                    this.form.gem_weight= { kyat: "", pal: "", yway: "" },
                    this.form.gem_price= "",
                    this.form.fee= { kyat: "", pal: "", yway: "" },
                    this.form.fee_price= "",
                    this.form.fee_for_making= "",
                    this.form.item_discount= "",
                    this.form.tax= "",
                    this.form.item_description= "",
                    this.form.total_kyat= "",
                    this.form.total_pal= "",
                    this.form.exceed_pal_form_yway= "",
                    this.form.total_yway= "",
                    this.form.total_before= "",
                    this.form.final_total= "",
                    this.form.paid_money= "",
                    this.form.credit_money= "",
                    this.form.note= ""
            }

        },
        watch: {
            loading (val) {
                if (!val) return
                setTimeout(() => (this.loading = false), 2000)
            },
            selectedItem(value) {
                if(value == "") {
                    this.clearFormData();
                    return;
                }
                // if (isNaN(value)) return;
                this.form.id = value.id;
                this.form.name = value.name;
                this.form.product_sku = value.product_sku;
                this.form.image = value.image1;
                this.form.imageFile = undefined;
                this.form.item_sku = value.item_sku;
                this.form.item_description = value.item_description;
                this.form.gold_weight.kyat = String(value.gold_weight.kyat);
                this.form.gold_weight.pal = String(value.gold_weight.pal);
                this.form.gold_weight.yway = String(value.gold_weight.yway);
                this.form.gem_weight.kyat = String(value.gem_weight.kyat);
                this.form.gem_weight.pal = String(value.gem_weight.pal);
                this.form.gem_weight.yway = String(value.gem_weight.yway);
                // this.form.gem_price = String(value.gem_price);
                this.form.fee.kyat = String(value.fee.kyat);
                this.form.fee.pal = String(value.fee.pal);
                this.form.fee.yway = String(value.fee.yway);
                this.form.fee_for_making = value.fee_for_making;
                this.form.item_sku = value.item_sku;
                this.form.tax = value.tax;
                this.quality = value.quality;
                this.form.item_discount = value.item_discount;
                this.form.total_before = value.total_before;
                this.form.final_total = value.final_total;

                this.form.paid_money = value.paid_money;
                this.form.credit_money = value.credit_money;
                this.dailySetup = this.$page.props.daily_setup[this.quality];
                this.dailyValue = this.$page.props.daily_setup[this.quality].kyat;

                //combobox
                this.goldQualitys = this.dataForCombobox.goldQualitys;
                let qty = value.quality;
                let goldQuality = this.goldQualitys.find(function(val) {
                    return val.quality == qty;
                });

                this.types = goldQuality.types;
                let type_key = this.form.product_sku.charAt(2);
                let type = this.types.find(function(val) {
                    return val.key == type_key;
                });

                this.item_names = type.item_names;
                let item_name_key = this.form.product_sku.charAt(3);
                let item_name = this.item_names.find(function(val) {
                    return val.key == item_name_key;
                });
                this.goldQuality = {
                    'name' : goldQuality.name,
                    'quality' : goldQuality.quality,
                };
                this.type = {
                    'key' : type.key,
                    'name' : type.name,
                };
                this.item_name = {
                    'key' : item_name.key,
                    'name' : item_name.name,
                };
                //combobox

            }
        },

        computed: {
            ...mapGetters(['selectedItem', 'item_from_cart', 'carts','customer']),
            goldPrice() {
                if(this.form.product_sku == "")return;
                let price = this.$page.props.daily_setup[this.quality];
                let kyat_p =
                    parseInt(this.form.gold_weight.kyat) * parseInt(price.kyat);
                let pal_p =
                    parseInt(this.form.gold_weight.pal) * parseInt(price.pal);
                let yway_p =
                    parseInt(this.form.gold_weight.yway) * parseInt(price.yway);
                let gold_price = kyat_p + pal_p + yway_p;

                if (isNaN(gold_price)) gold_price = "";
                this.form.gold_price = gold_price;

                return gold_price;
            },
            gemPrice() {
                if(this.form.product_sku == "")return;
                let price = this.$page.props.daily_setup[this.quality];
                let kyat_p =
                    parseInt(this.form.gem_weight.kyat) * parseInt(price.kyat);
                let pal_p =
                    parseInt(this.form.gem_weight.pal) * parseInt(price.pal);
                let yway_p =
                    parseInt(this.form.gem_weight.yway) * parseInt(price.yway);
                let gem_price = kyat_p + pal_p + yway_p;

                if (isNaN(gem_price)) gem_price = "";

                this.form.gem_price = gem_price;

                return gem_price;
            },
            feePrice() {
                if(this.form.product_sku == "")return;
                let price = this.$page.props.daily_setup[this.quality];
                let kyat_p = parseInt(this.form.fee.kyat) * parseInt(price.kyat);
                let pal_p = parseInt(this.form.fee.pal) * parseInt(price.pal);
                let yway_p = parseInt(this.form.fee.yway) * parseInt(price.yway);
                let fee_price = kyat_p + pal_p + yway_p;

                if (isNaN(fee_price)) fee_price = "";
                this.form.fee_price = fee_price;

                return fee_price;
            },
            total_kyat() {
                if(this.form.product_sku == "")return;
                let total_kyat =
                    parseInt(this.form.gold_weight.kyat) +
                    parseInt(this.form.gem_weight.kyat) +
                    parseInt(this.form.fee.kyat);
                if (isNaN(total_kyat)) total_kyat = "";
                this.form.total_kyat = total_kyat;
                return total_kyat;
            },
            total_pal() {
                if(this.form.product_sku == "")return;
                let total_pal =
                    parseInt(this.form.gold_weight.pal) +
                    parseInt(this.form.gem_weight.pal) +
                    parseInt(this.form.fee.pal) +
                    parseInt(this.form.exceed_pal_form_yway);
                if (isNaN(total_pal)) {
                    total_pal = "";
                }
                if (total_pal >= 16) {
                    this.form.total_kyat =
                        this.form.total_kyat + parseInt(total_pal / 16);
                    total_pal = total_pal % 16;
                }
                this.form.total_pal = total_pal;

                return total_pal;
            },
            total_yway() {
                if(this.form.product_sku == "")return;
                let total_yway =
                    parseInt(this.form.gold_weight.yway) +
                    parseInt(this.form.gem_weight.yway) +
                    parseInt(this.form.fee.yway);
                    console.log(total_yway);
                if (isNaN(total_yway)) {
                    total_yway = "";
                }
                if (total_yway >= 8) {
                    this.form.exceed_pal_form_yway = parseInt(
                        total_yway / 8
                    );
                    total_yway = total_yway % 8;
                }else{
                    this.form.exceed_pal_form_yway = 0;
                }
                this.form.total_yway = total_yway;
                return total_yway;
            },
            totalBefore() {
                if(this.form.product_sku == "")return;
                let total_before =
                    parseInt(this.form.gold_price) +
                    parseInt(this.form.gem_price) +
                    parseInt(this.form.fee_price) +
                    parseInt(this.form.fee_for_making);

                if (isNaN(total_before)) total_before = "";
                this.form.total_before = total_before;

                return total_before;
            },
            finalTotal() {
                if(this.form.product_sku == "")return;
                let final_total =
                    parseInt(this.form.total_before) -
                    parseInt(this.form.item_discount);
                if (isNaN(final_total)) final_total = "";
                this.form.final_total = final_total;

                return final_total;
            },
            creditMoney() {
                if(this.form.product_sku == "")return;
                let credit_money =
                    parseInt(this.form.final_total) -
                    parseInt(this.form.paid_money);
                if (isNaN(credit_money)) credit_money = "";
                this.form.credit_money = credit_money;

                return credit_money;
            },
            nameErrors () {
                const errors = []
                if (!this.$v.quality.$dirty) return errors
                !this.$v.quality.maxLength && errors.push('Name must be at most 10 characters long')
                !this.$v.quality.required && errors.push('Name is required.')
                return errors
            },

        },
    };
</script>
<style>
.row + .row {
    margin-top: 0px !important;
}
.mask{
    position: absolute;
    mask-image: radial-gradient(circle at bottom, rgba(0,0,0,0.3) 10%, transparent  50%);
}
@media print {
	.no-print  {
		display: none;
	}

}
</style>
