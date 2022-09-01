<template>
    <v-col cols="12" sm="12" md="12">
        <v-hover v-slot="{ hover }" close-delay="200">
            <v-card
                :elevation="hover ? 16 : 2"
                :class="{ 'on-hover': hover }"
                flat
                class="mx-auto rounded-lg mx-3 no-print"
            >
                <v-form ref="form" lazy-validation>
                    <v-list-item three-line>
                        <v-flex xs2 md2 sm2 lg2 >
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
                        </v-flex>
                        <v-flex xs7 md7 sm7 lg7 >
                            <VoucherTitleBar/>
                        </v-flex>
                        <v-flex xs3 md3 sm3 lg3 class="mb-16">
                            <v-icon
                                color="info"
                                @click="addToCart()"
                                v-text="'fas fa-shopping-cart'"
                            ></v-icon>
                        </v-flex>
                    </v-list-item>
                    <v-card-actions>
                        <v-container fluid>
                            <v-row>
                                <v-col cols="12" lg="9" sm="9" md="9" xs="12" >
                                    <v-card flat class="mr-2">
                                        <v-layout row wrap class="pl-4 textfield one">
                                            <v-flex xs3 md3 sm3 class="mt-5 text-left">
                                                <div>ရွှေ+ကျောက်ချိန်</div>
                                            </v-flex>
                                            <v-flex xs2 sm2 md2>
                                                <v-flex xs6 sm6 md6>
                                                    <v-text-field
                                                        v-model = "form.gold_plus_gem_weight.kyat"
                                                        label="ကျပ်"
                                                        placeholder="ကျပ်"
                                                        :rules="validationRules"
                                                        required
                                                        @change="onChange"
                                                        type="number"
                                                        min="0"
                                                        max="16"
                                                        oninput="if(Number(this.value) > Number(this.max)) this.value = this.max;"
                                                    >
                                                    </v-text-field>
                                                </v-flex>
                                            </v-flex>
                                            <v-flex xs2 sm2 md2>
                                                <v-flex xs6 sm6 md6>
                                                     <v-text-field
                                                        v-model = "form.gold_plus_gem_weight.pal"
                                                        label="ပဲ"
                                                        placeholder="ပဲ"
                                                        :rules="validationRules"
                                                        required
                                                        @change="onChange"
                                                        type="number"
                                                        min="0"
                                                        max="15"
                                                        oninput="if(Number(this.value) > Number(this.max)) this.value = this.max;"
                                                    ></v-text-field>
                                                </v-flex>
                                            </v-flex>
                                            <v-flex xs2 sm2 md2>
                                                <v-flex xs6 sm6 md6>
                                                   <v-text-field
                                                        v-model = "form.gold_plus_gem_weight.yway"
                                                        label="ရွေး"
                                                        placeholder="ရွေး"
                                                        :rules="yway_validationRules"
                                                        required
                                                        @change="onChange"
                                                        type="number"
                                                        min="0"
                                                        max="7.9"
                                                        step=".1"
                                                        oninput="if(Number(this.value) > Number(this.max)) this.value = this.max;"
                                                    ></v-text-field>
                                                </v-flex>

                                            </v-flex>
                                            <v-flex xs3 sm3 md3>
                                                <div class="right">
                                                <v-chip small class="one white--text my-6 caption">{{ goldPrice }}</v-chip>
                                                </div>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider></v-divider>
                                        <v-layout row wrap class="pl-4 textfield one">
                                            <v-flex xs3 md3 sm3 class="mt-5 text-left">
                                                <div>
                                                    <div class="mb-2">
                                                        ကျောက်ချိန်
                                                    </div>

                                                    <div class="red--text font-weight-medium " v-if="!gem_weight_status && gem_weight_status !== ''">
                                                        Disable
                                                    </div>
                                                </div>
                                            </v-flex>
                                            <v-flex xs2 sm2 md2>
                                                <v-flex xs6 sm6 md6>
                                                    <v-text-field
                                                        v-model = "form.gem_weight.kyat"
                                                        label="ကျပ်"
                                                        placeholder="ကျပ်"
                                                        :rules="validationRules"
                                                        required
                                                        @change="onChange"
                                                        type="number"
                                                        min="0"
                                                        max="16"
                                                        oninput="if(Number(this.value) > Number(this.max)) this.value = this.max;"
                                                        :disabled="!gem_weight_status"
                                                    >
                                                    </v-text-field>
                                                </v-flex>
                                            </v-flex>
                                            <v-flex xs2 sm2 md2>
                                                <v-flex xs6 sm6 md6>
                                                     <v-text-field
                                                        v-model = "form.gem_weight.pal"
                                                        label="ပဲ"
                                                        placeholder="ပဲ"
                                                        :rules="validationRules"
                                                        required
                                                        @change="onChange"
                                                        type="number"
                                                        min="0"
                                                        max="15"
                                                        oninput="if(Number(this.value) > Number(this.max)) this.value = this.max;"
                                                        :disabled="!gem_weight_status"
                                                    ></v-text-field>
                                                </v-flex>
                                            </v-flex>
                                            <v-flex xs2 sm2 md2>
                                                <v-flex xs6 sm6 md6>
                                                   <v-text-field
                                                        v-model = "form.gem_weight.yway"
                                                        label="ရွေး"
                                                        placeholder="ရွေး"
                                                        :rules="yway_validationRules"
                                                        required
                                                        @change="onChange"
                                                        type="number"
                                                        min="0"
                                                        max="7.9"
                                                        step=".1"
                                                        oninput="if(Number(this.value) > Number(this.max)) this.value = this.max;"
                                                        :disabled="!gem_weight_status"
                                                    ></v-text-field>
                                                </v-flex>

                                            </v-flex>
                                            <v-flex xs3 sm3 md3>
                                                <div class="right">
                                                    <v-flex xs7 sm7 md7>
                                                        <v-text-field
                                                            v-model="form.gem_price"
                                                            label="ကျသင့်ငွေ"
                                                            placeholder="ကျသင့်ငွေ"
                                                            :rules="validationRules"
                                                            required
                                                            type="number"
                                                            :disabled="!gem_weight_status"
                                                        ></v-text-field>
                                                    </v-flex>
                                                </div>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider></v-divider>
                                        <v-layout row wrap class="pl-4 textfield one">
                                            <v-flex xs3 md3 sm3 class="mt-5 text-left">
                                                <div>အလျော့တွက်</div>
                                            </v-flex>
                                            <v-flex xs2 sm2 md2>
                                                <v-flex xs6 sm6 md6>
                                                    <v-text-field
                                                        v-model = "form.fee.kyat"
                                                        label="ကျပ်"
                                                        placeholder="ကျပ်"
                                                        :rules="validationRules"
                                                        required
                                                        @change="onChange"
                                                        type="number"
                                                        min="0"
                                                        max="16"
                                                        oninput="if(Number(this.value) > Number(this.max)) this.value = this.max;"
                                                    >
                                                    </v-text-field>
                                                </v-flex>
                                            </v-flex>
                                            <v-flex xs2 sm2 md2>
                                                <v-flex xs6 sm6 md6>
                                                     <v-text-field
                                                        v-model = "form.fee.pal"
                                                        label="ပဲ"
                                                        placeholder="ပဲ"
                                                        :rules="validationRules"
                                                        required
                                                        @change="onChange"
                                                        type="number"
                                                        min="0"
                                                        max="15"
                                                        oninput="if(Number(this.value) > Number(this.max)) this.value = this.max;"
                                                    ></v-text-field>
                                                </v-flex>
                                            </v-flex>
                                            <v-flex xs2 sm2 md2>
                                                <v-flex xs6 sm6 md6>
                                                   <v-text-field
                                                        v-model = "form.fee.yway"
                                                        label="ရွေး"
                                                        placeholder="ရွေး"
                                                        :rules="yway_validationRules"
                                                        required
                                                        @change="onChange"
                                                        type="number"
                                                        min="0"
                                                        max="7.9"
                                                        step=".1"
                                                        oninput="if(Number(this.value) > Number(this.max)) this.value = this.max;"
                                                    ></v-text-field>
                                                </v-flex>

                                            </v-flex>
                                            <v-flex xs3 sm3 md3>
                                                <div class="right">
                                                    <v-chip small class="one white--text my-6 caption">{{ feePrice }}</v-chip>
                                                </div>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider></v-divider>
                                        <v-layout row wrap class="pl-4 textfield one">
                                            <v-flex xs3 md3 sm3 class="mt-5 text-left">
                                                <div>လက်ခ</div>
                                            </v-flex>
                                            <v-flex xs2 sm2 md2>
                                            </v-flex>
                                            <v-flex xs2 sm2 md2>
                                            </v-flex>
                                            <v-flex xs2 sm2 md2>
                                            </v-flex>
                                            <v-flex xs3 sm3 md3>
                                                <div class="right">
                                                    <v-flex xs7 sm7 md7>
                                                        <v-text-field
                                                            v-model="form.fee_for_making"
                                                            label="ကျသင့်ငွေ"
                                                            placeholder="ကျသင့်ငွေ"
                                                            :rules="validationRules"
                                                            required
                                                            type="number"
                                                        ></v-text-field>
                                                    </v-flex>
                                                </div>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider></v-divider>
                                        <v-layout row wrap class="pl-4 textfield one">
                                            <v-flex xs3 md3 sm3 class="mt-5 text-left">
                                                <div>စုစုပေါင်း</div>
                                            </v-flex>
                                            <v-flex xs2 sm2 md2>
                                            </v-flex>
                                            <v-flex xs2 sm2 md2>
                                            </v-flex>
                                            <v-flex xs2 sm2 md2>
                                            </v-flex>
                                            <v-flex xs3 sm3 md3>
                                                <div class="right">
                                                    <v-chip small class="one white--text my-6 caption">{{ totalBefore }}</v-chip>
                                                </div>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider></v-divider>
                                    </v-card>
                                </v-col>


                                <v-col
                                    cols="12"
                                    lg="3"
                                    sm="3"
                                    md="3"
                                    xs="12"
                                >
                                   <v-card flat>
                                        <v-layout row wrap class="pa-3 textfield one">
                                            <v-flex xs6 sm6 md6>
                                                <div>လျော့ငွေ</div>
                                            </v-flex>

                                            <v-flex xs6 sm6 md6>
                                                <div class="right">
                                                    <v-text-field
                                                        v-model="form.discount_amount"
                                                        label="kyats"
                                                        placeholder="kyats"
                                                        dense
                                                        :rules="validationRules"
                                                        required
                                                        type="number"
                                                    ></v-text-field>
                                                </div>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider></v-divider>
                                        <v-layout row wrap class="pa-3 textfield one">
                                            <v-flex xs6 sm6 md6>
                                                <div>ကျသင့်ငွေ</div>
                                            </v-flex>

                                            <v-flex xs6 sm6 md6>
                                                <div class="right">
                                                   <v-text-field
                                                        :value = "finalTotal"
                                                        label="kyats"
                                                        dense
                                                        placeholder="kyats"
                                                        :rules="validationRules"
                                                        required
                                                        type="number"
                                                    ></v-text-field>
                                                </div>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider></v-divider>
                                        <v-layout row wrap class="pa-3 textfield one">
                                            <v-flex xs6 sm6 md6>
                                                <div>ပေးငွေ</div>
                                            </v-flex>

                                            <v-flex xs6 sm6 md6>
                                                <div class="right">
                                                   <v-text-field
                                                        v-model="form.paid_money"
                                                        label="kyats"
                                                        placeholder="kyats"
                                                        dense
                                                        :rules="validationRules"
                                                        required
                                                        type="number"
                                                    ></v-text-field>
                                                </div>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider></v-divider>
                                        <v-layout row wrap class="pa-3 textfield one">
                                            <v-flex xs6 sm6 md6>
                                                <div>ကျန်ငွေ</div>
                                            </v-flex>

                                            <v-flex xs6 sm6 md6>
                                                <div class="right">
                                                   <v-text-field
                                                        :value = "creditMoney"
                                                        label="kyats"
                                                        placeholder="kyats"
                                                        dense
                                                        readonly
                                                        type="number"
                                                    ></v-text-field>
                                                </div>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider></v-divider>
                                        <v-layout row wrap class="pa-3 textfield one">
                                            <v-flex xs12 sm12 md12 lg12 class="justify-center">
                                                <v-btn
                                                    color="#ECBD00"
                                                    block
                                                    dark
                                                    class="withoutupercase black--text"
                                                    @click="printbill"
                                                    >Print Bill</v-btn
                                                >
                                            </v-flex>
                                        </v-layout>
                                         <v-divider></v-divider>
                                    </v-card>
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
    import VoucherTitleBar from "./VoucherTitleBar";


    export default {
        components: {
            Invoice,
            Link,
            VoucherTitleBar
        },
        mixins: [validationMixin],
        validations: {
            quality: { required, maxLength: maxLength(10) },
        },
        name: "Voucher1",

        data() {
            return {
                form: {
                    id: null,
                    name: null,
                    product_sku: null,
                    image: undefined,
                    imageFile: undefined,
                    item_sku: null,
                    gold_plus_gem_weight: { kyat: null, pal: null, yway: null },
                    gold_price: null,
                    gem_weight: { kyat: null, pal: null, yway: null },
                    gem_price: null,
                    fee: { kyat: null, pal: null, yway: null },
                    fee_price: null,
                    fee_for_making: null,
                    discount_amount: null,
                    tax: null,
                    item_sku: null,
                    item_description: null,
                    before_total: null,
                    final_total: null,
                    paid_money: null,
                    credit_money: null,
                    note: null,
                    daily_Setup: { daily_setup_id: null, quality_16_pal: null, kyat: null, pal: null, yway: null },
                },
                gem_weight_status:'',
                quality: '',
                name: '',
                email: '',
                loading: false,
                validationRules:[
                    v => !!v || 'Required',
                    v => Number.isInteger(Number(v)) || "Must be integer!"
                ],
                yway_validationRules:[
                    v => !!v || 'Required',
                    v => /^\d{0,1}(?:\.\d{1})?$/.test(v) || 'limitation error',
                ],

                //image upload
                input: undefined,
                mask: false,
            };
        },
        mounted () {
            this.input = document.getElementById('fileInput')
        },

        created() {
            this.unwatch1 = this.$store.watch(
                (state, getters) => getters.reset_voucher_form,
                (newValue, oldValue) => {
                    if(newValue)this.clearFormData();
                },
            );
            this.fillFormData(this.selectedItem);
        },

        methods: {
            ...mapActions(["searchItem", "addItem", "editItemFromCart",
                "selectItemReset","searchItemByItemId","removeItem",
                "removeItemFromSearchList","resetCustomer", "resetVoucherForm"]),

            onChange(entry) {
                if(this.form.gold_plus_gem_weight.kyat != "" && this.form.gold_plus_gem_weight.pal  != ""
                     && this.form.gold_plus_gem_weight.yway != "" && this.goldQuality != null
                      && this.type != null  && this.item_name != null ){

                    let product_sku = this.goldQuality.quality+this.type.key+this.item_name.key;
                    let kyat = this.form.gold_plus_gem_weight.kyat.length == 1 ? '0'+this.form.gold_plus_gem_weight.kyat : this.form.gold_plus_gem_weight.kyat;
                    let pal = this.form.gold_plus_gem_weight.pal.length == 1 ? '0'+this.form.gold_plus_gem_weight.pal : this.form.gold_plus_gem_weight.pal;

                    let item_spe = kyat + pal+this.form.gold_plus_gem_weight.yway;
                    let data = { product_sku: product_sku, item_spe: item_spe}
                    this.searchItem(data);
                }
            },
            toastMessage(icon, title) {
                Toast.fire({
                    icon: icon,
                    title: title
                });
            },
            //combo box
            addToCart() {
                if(this.$refs.form.validate()){
                    if(this.form.id == ""){
                        this.toastMessage('error', 'ဖန်တီးထားသောကုန်ပစ္စည်းကို cart ထဲ့ထည့်မရပါ')
                        return;
                    }
                    if(this.customer == ""){
                        this.toastMessage('warning', 'customer ထည့်သွင့်ရန်လိုအပ့်နေသည်')
                        return;
                    }
                    let item = {
                        id: this.form.id,
                        name: this.form.name,
                        product_sku: this.form.product_sku,
                        image: this.form.image,
                        item_sku: this.form.item_sku,
                        gold_plus_gem_weight: this.form.gold_plus_gem_weight,
                        gold_price: this.form.gold_price,
                        gem_weight: this.form.gem_weight,
                        gem_price: this.form.gem_price,
                        fee: this.form.fee,
                        fee_price: this.form.fee_price,
                        fee_for_making: this.form.fee_for_making,
                        discount_amount: this.form.discount_amount,
                        tax: this.form.tax,
                        item_description: this.form.item_description,
                        before_total: this.form.before_total,
                        final_total: this.form.final_total,
                        paid_money: this.form.paid_money,
                        credit_money: this.form.credit_money,
                        note: this.form.note,
                        quality: this.quality,
                        customer:this.customer,
                        daily_Setup:this.form.daily_Setup,
                    };
                    if(this.item_from_cart){
                        //edit item from cart
                        this.editItemFromCart(item);
                        this.toastMessage('success', 'Successfully update')
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
                            this.toastMessage('success', 'Success Add to Cart')
                        }else{
                            this.toastMessage('warning', 'Already exist')
                        }
                        this.clearFormData();
                        this.selectItemReset();
                    }
                }
            },

            printbill() {
                if(this.$refs.form.validate()){
                    if(this.customer == ""){
                        this.toastMessage('warning', 'customer ထည့်သွင့်ရန်လိုအပ့်နေသည်')
                        return;
                    }
                    this.loading = true;
                    let data = new FormData();
                    data.append('id',this.form.id);
                    data.append('name',this.form.name);
                    data.append('product_sku',this.form.product_sku);
                    data.append('image',this.form.image);
                    data.append('imageFile',this.form.imageFile);
                    data.append('item_sku',this.form.item_sku);
                    data.append('gold_plus_gem_weight',JSON.stringify(this.form.gold_plus_gem_weight));
                    data.append('gold_price',this.form.gold_price);
                    data.append('gem_weight',JSON.stringify(this.form.gem_weight));
                    data.append('gem_price',this.form.gem_price);
                    data.append('fee',JSON.stringify(this.form.fee));
                    data.append('fee_price',this.form.fee_price);
                    data.append('fee_for_making',this.form.fee_for_making);
                    data.append('discount_amount',this.form.discount_amount);
                    data.append('before_total',this.form.before_total);
                    data.append('final_total',this.form.final_total);
                    data.append('paid_money',this.form.paid_money);
                    data.append('credit_money',this.form.credit_money);
                    data.append('note',this.form.note);
                    data.append('customer_id',this.customer.id);
                    data.append('daily_Setup',JSON.stringify(this.form.daily_Setup));

                    axios.post('/pos/sell', data)
                        .then(res => {
                            if(res.data.status)
                            {
                                this.removeItem(this.form.id);
                                this.removeItemFromSearchList(this.form.id);
                                window.open( constant.ROUTE_URL_POS+"generate_invoice/"+res.data.transaction_id, "_blank");
                                this.toastMessage('success', 'Order Success');
                                this.clearFormData();
                                this.selectItemReset();
                                this.resetCustomer();
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
                this.form.id= "";
                this.form.name= "";
                this.form.product_sku= "";
                this.form.image= undefined;
                this.form.imageFile= undefined;
                this.form.item_sku= "";
                this.form.gold_plus_gem_weight= { kyat: "", pal: "", yway: "" };
                this.form.gold_price= "";
                this.form.gem_weight= { kyat: "", pal: "", yway: "" };
                this.form.gem_price= "";
                this.form.fee= { kyat: "", pal: "", yway: "" };
                this.form.fee_price= "";
                this.form.fee_for_making= "";
                this.form.discount_amount= "";
                this.form.tax= "";
                this.form.item_description= "";
                this.form.before_total= "";
                this.form.final_total= "";
                this.form.paid_money= "";
                this.form.credit_money= "";
                this.form.note= "";
                this.resetVoucherForm();
            },
            fillFormData(value){
                if(value == "") {
                    this.clearFormData();
                    return;
                }
                this.form.id = value.id;
                this.form.name = value.name;
                this.form.product_sku = value.product_sku;
                this.form.image = value.image;
                this.form.imageFile = undefined;
                this.form.item_sku = value.item_sku;
                this.form.item_description = value.item_description;
                this.form.gold_plus_gem_weight.kyat = String(value.gold_plus_gem_weight.kyat);
                this.form.gold_plus_gem_weight.pal = String(value.gold_plus_gem_weight.pal);
                this.form.gold_plus_gem_weight.yway = String(value.gold_plus_gem_weight.yway);
                this.form.gem_weight.kyat = String(value.gem_weight.kyat);
                this.form.gem_weight.pal = String(value.gem_weight.pal);
                this.form.gem_weight.yway = String(value.gem_weight.yway);
                this.form.gem_price = value.gem_weight_status ? parseInt(value.gem_price):'0';
                this.form.fee.kyat = String(value.fee.kyat);
                this.form.fee.pal = String(value.fee.pal);
                this.form.fee.yway = String(value.fee.yway);
                this.form.fee_for_making = value.fee_for_making;
                this.form.item_sku = value.item_sku;
                this.form.tax = value.tax;
                this.quality = value.quality;
                this.form.discount_amount = value.discount_amount;
                this.form.before_total = value.before_total;
                this.form.final_total = value.final_total;
                this.gem_weight_status = value.gem_weight_status;

                this.form.paid_money = value.paid_money;
                this.form.credit_money = value.credit_money;
                if (typeof value.daily_Setup !== 'undefined'){
                    this.form.daily_Setup = {};
                    Object.assign( this.form.daily_Setup, value.daily_Setup);
                }
            }
        },
        watch: {
            loading (val) {
                if (!val) return
                setTimeout(() => (this.loading = false), 2000)
            },
            selectedItem(value) {
                this.fillFormData(value);
            },
            daily_setup(value) {
                this.form.daily_Setup = {};
                Object.assign( this.form.daily_Setup, value);
            }
        },
        computed: {
            ...mapGetters(['selectedItem', 'item_from_cart', 'carts','customer', 'reset_voucher_form','daily_setup']),
            goldPrice() {
                if(this.form.product_sku == "")return;
                let price = this.form.daily_Setup;
                let kyat = parseInt(this.form.gold_plus_gem_weight.kyat) -  parseInt(this.form.gem_weight.kyat);
                let pal = parseInt(this.form.gold_plus_gem_weight.pal) -  parseInt(this.form.gem_weight.pal);
                let yway = this.form.gold_plus_gem_weight.yway - this.form.gem_weight.yway;

                let kyat_p = kyat * parseInt(price.kyat);
                let pal_p = pal * parseInt(price.pal);
                let yway_p = yway * price.yway;
                let gold_price = kyat_p + pal_p + parseInt(yway_p);

                if (isNaN(gold_price)) gold_price = "";
                this.form.gold_price = gold_price;

                return gold_price;
            },
            feePrice() {
                if(this.form.product_sku == "")return;
                let price = this.form.daily_Setup;
                let kyat_p = parseInt(this.form.fee.kyat) * parseInt(price.kyat);
                let pal_p = parseInt(this.form.fee.pal) * parseInt(price.pal);
                let yway_p = this.form.fee.yway * price.yway;
                let fee_price = kyat_p + pal_p + parseInt(yway_p);

                if (isNaN(fee_price)) fee_price = "";
                this.form.fee_price = fee_price;

                return fee_price;
            },
            totalBefore() {
                if(this.form.product_sku == "")return;
                let before_total =
                    parseInt(this.form.gold_price) +
                    parseInt(this.form.gem_price) +
                    parseInt(this.form.fee_price) +
                    parseInt(this.form.fee_for_making);

                if (isNaN(before_total)) before_total = "";
                this.form.before_total = before_total;

                return before_total;
            },
            finalTotal() {
                if(this.form.product_sku == "")return;
                let final_total =
                    parseInt(this.form.before_total) -
                    parseInt(this.form.discount_amount);
                if (isNaN(final_total)) final_total = "";
                this.form.final_total = final_total;
                this.form.paid_money = final_total;
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
        },
    };
</script>
<style>
/* .row + .row {
    margin-top: 0px !important;
} */
.mask{
    position: absolute;
    mask-image: radial-gradient(circle at bottom, rgba(0,0,0,0.3) 10%, transparent  50%);
}
@media print {
	.no-print  {
		display: none;
	}

}
.colored-toast.swal2-icon-success {
  background-color: #a5dc86 !important;
}

.colored-toast.swal2-icon-error {
  background-color: #f27474 !important;
}

.colored-toast.swal2-icon-warning {
  background-color: #f8bb86 !important;
}

.colored-toast.swal2-icon-info {
  background-color: #3fc3ee !important;
}

.colored-toast.swal2-icon-question {
  background-color: #87adbd !important;
}

.colored-toast .swal2-title {
  color: white;
}

.colored-toast .swal2-close {
  color: white;
}

.colored-toast .swal2-html-container {
  color: white;
}
.textfield.one{
  border-left: 4px solid #0069D9;
}
.textfield.two{
  border-left: 4px solid #ffaa2c;
}
.textfield.three{
  border-left: 4px solid #f83e70;
}
.v-chip.one{
    background: #ECBD00 !important;
    width: 90px;
}
.v-chip.two{
  background: #ECBD00 !important;
}
.v-chip.three{
  background: #ECBD00 !important;
}

</style>
