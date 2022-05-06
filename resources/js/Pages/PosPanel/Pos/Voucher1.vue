<template>
    <v-col cols="12" sm="9">
        <v-hover v-slot="{ hover }" close-delay="200">
            <v-card
                :elevation="hover ? 16 : 2"
                :class="{ 'on-hover': hover }"
                flat
                class="mx-auto rounded-lg mx-3"
            >
            <v-form ref="form" lazy-validation>

                <v-list-item three-line>
                    <v-list-item-avatar
                        rounded
                        size="100"
                        color="grey lighten-4"
                        v-if="form.image"
                    >
                        <v-img :src="form.image"></v-img>
                    </v-list-item-avatar>
                    <!-- image upload -->

                     <v-card v-else rounded="lg" class="overflow-hidden mr-3" width="130" height="130" @click.stop="selectImage" >
                        <input id="fileInput" class="d-none" type="file" accept="image/*" @input="updateValue">
                        <v-fade-transition mode="out-in">
                        <v-img v-if="image" aspect-ratio="1" :src="image">
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
                            <v-col
                                cols="12"
                                sm="6"
                            >
                                <v-text-field
                                    label="Product Name"
                                    v-model="form.name"
                                    :rules="nameRules"
                                    required
                                ></v-text-field>
                            </v-col>

                        </v-list-item-title>
                        <v-list-item-subtitle class="mt-1">
                            {{ form.item_description }}
                        </v-list-item-subtitle>

                        <strong class="mt-3">
                            <v-tooltip top>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn

                                    dark
                                    v-bind="attrs"
                                    v-on="on"
                                    @click="openModel"
                                    >
                                    {{ dailySetup.kyat | formatNumber }}
                                    .kyats
                                </v-btn>
                            </template>
                            <span>{{quality}} .ပဲရည်</span>
                            </v-tooltip>

                        </strong>

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
                        <i
                            class="fas fa-solid fa-cart-plus"
                            style="padding-right: 12px; color: gold"
                            @click="addToCart()"
                        ></i>
                        <i class="fas fa-save" style="color: gold"></i>
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
                                                v-model="form.gold_weight.kyat"
                                                label="ကျပ်"
                                                placeholder="ကျပ်"
                                                outlined
                                                dense
                                                :rules="goldWeightKyatRules"
                                                required
                                            >
                                            </v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.gold_weight.pal"
                                                label="ပဲ"
                                                placeholder="ပဲ"
                                                outlined
                                                dense
                                                :rules="goldWeightPalRules"
                                                required
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.gold_weight.yway"
                                                label="ရွေး"
                                                placeholder="ရွေး"
                                                outlined
                                                dense
                                                :rules="goldWeightYwayRules"
                                                required
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="3">
                                            <v-text-field
                                                v-model="form.gold_price"
                                                label="ကျသင့်ငွေ"
                                                placeholder="ကျသင့်ငွေ"
                                                outlined
                                                dense
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
                                                :rules="gemWeightKyatRules"
                                                required
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.gem_weight.pal"
                                                label="ပဲ"
                                                placeholder="ပဲ"
                                                outlined
                                                dense
                                                :rules="gemWeightPalRules"
                                                required
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.gem_weight.yway"
                                                label="ရွေး"
                                                placeholder="ရွေး"
                                                outlined
                                                dense
                                                :rules="gemWeightYwayRules"
                                                required
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="3">
                                            <v-text-field
                                                v-model="form.gem_price"
                                                label="ကျသင့်ငွေ"
                                                placeholder="ကျသင့်ငွေ"
                                                outlined
                                                dense
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
                                                :rules="feeWeightKyatRules"
                                                required
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.fee.pal"
                                                label="ပဲ"
                                                placeholder="ပဲ"
                                                outlined
                                                dense
                                                :rules="feeWeightPalRules"
                                                required
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.fee.yway"
                                                label="ရွေး"
                                                placeholder="ရွေး"
                                                outlined
                                                dense
                                                :rules="feeWeightYwayRules"
                                                required
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="3">
                                            <v-text-field
                                                v-model="form.fee_price"
                                                label="ကျသင့်ငွေ"
                                                placeholder="ကျသင့်ငွေ"
                                                outlined
                                                dense
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
                                                :rules="feeForMakingRules"
                                                required
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
                                                v-model="form.total_kyat"
                                                label="ကျပ်"
                                                placeholder="ကျပ်"
                                                outlined
                                                dense
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.total_pal"
                                                label="ပဲ"
                                                placeholder="ပဲ"
                                                outlined
                                                dense
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.total_yway"
                                                label="ရွေး"
                                                placeholder="ရွေး"
                                                outlined
                                                dense
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="3">
                                            <v-text-field
                                                v-model="form.total_before"
                                                label="ကျသင့်ငွေ"
                                                placeholder="ကျသင့်ငွေ"
                                                outlined
                                                dense
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
                                                :rules="itemDiscountRules"
                                                required
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
                                                v-model="form.total_after"
                                                label="kyats"
                                                placeholder="kyats"
                                                outlined
                                                dense
                                                :rules="totalAfterRules"
                                                required
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
                                                :rules="paidMoneyRules"
                                                required
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
                                                v-model="form.credit_money"
                                                label="kyats"
                                                placeholder="kyats"
                                                outlined
                                                dense

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
                                        <!-- <v-card-actions>
                                      </v-card-actions> -->
                                    </v-row>
                                </v-col>
                            </v-row>

                            <!--row for voucher-->
                        </v-container>

                    <!--end new-->
                </v-card-actions>
                </v-form>
                    <v-row
                            justify="center"
                            >
                            <v-dialog
                                v-model="dialog2"
                                max-width="500px"
                            >
                                <v-card>
                                    <v-card-title>
                                        {{ quality }} ပဲရည်
                                    </v-card-title>
                                    <v-card-text>
                                        <form @submit.prevent="editDailySetup">

                                            <v-text-field
                                                v-model="dailyValue"
                                                :error-messages="nameErrors"
                                                :counter="10"
                                                label="Quality"
                                                required
                                                @input="$v.quality.$touch()"
                                                @blur="$v.quality.$touch()"
                                            ></v-text-field>

                                            <v-btn
                                                color="success"
                                                text
                                                type="submit"
                                            >
                                            Add
                                            </v-btn>
                                            <v-btn
                                                color="primary"
                                                text
                                                @click="dialog2 = false"
                                            >
                                                Close
                                            </v-btn>
                                        </form>
                                    </v-card-text>

                                </v-card>
                            </v-dialog>
                        </v-row>
            </v-card>
        </v-hover>
    </v-col>
</template>

<script>
    import { validationMixin } from 'vuelidate'
    import { required, maxLength, email } from 'vuelidate/lib/validators'
    import axios from 'axios';

    export default {
        mixins: [validationMixin],
        validations: {
            quality: { required, maxLength: maxLength(10) },
        },
        name: "ItemList",

        data() {
            return {
                form: this.$inertia.form({
                    id: "",
                    name: "",
                    image: "",
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
                    item_description: "",
                    total_kyat: "",
                    total_pal: "",
                    exceed_pal_form_yway: "",
                    total_yway: "",
                    total_before: "",
                    total_after: "",
                    paid_money: "",
                    credit_money: "",
                    note: "",
                }),
                quality: '',
                dialog2: false,
                name: '',
                email: '',
                dailyValue: '',
                dailySetup: [],
                nameRules: [
                    v => !!v || 'Required',
                ],
                goldWeightKyatRules: [
                    v => !!v || 'Required',
                    v => /^\d+$/.test(v) || 'Must be a number',
                ],
                goldWeightPalRules: [
                    v => !!v || 'Required',
                    v => /^\d+$/.test(v) || 'Must be a number',
                ],
                goldWeightYwayRules: [
                    v => !!v || 'Required',
                    v => /^\d+$/.test(v) || 'Must be a number',
                ],
                gemWeightKyatRules: [
                    v => !!v || 'Required',
                    v => /^\d+$/.test(v) || 'Must be a number',
                ],
                gemWeightPalRules: [
                    v => !!v || 'Required',
                    v => /^\d+$/.test(v) || 'Must be a number',
                ],
                gemWeightYwayRules: [
                    v => !!v || 'Required',
                    v => /^\d+$/.test(v) || 'Must be a number',
                ],
                feeWeightKyatRules: [
                    v => !!v || 'Required',
                    v => /^\d+$/.test(v) || 'Must be a number',
                ],
                feeWeightPalRules: [
                    v => !!v || 'Required',
                    v => /^\d+$/.test(v) || 'Must be a number',
                ],
                feeWeightYwayRules: [
                    v => !!v || 'Required',
                    v => /^\d+$/.test(v) || 'Must be a number',
                ],
                feeForMakingRules: [
                    v => !!v || 'Required',
                    v => /^\d+$/.test(v) || 'Must be a number',
                ],
                itemDiscountRules: [
                    v => !!v || 'Required',
                    v => /^\d+$/.test(v) || 'Must be a number',
                ],
                totalAfterRules: [
                    v => !!v || 'Required',
                    v => /^\d+$/.test(v) || 'Must be a number',
                ],
                paidMoneyRules: [
                    v => !!v || 'Required',
                    v => /^\d+$/.test(v) || 'Must be a number',
                ],
                //image upload
                input: undefined,
                image: undefined,
                mask: false
            };
        },
        mounted () {
            this.input = document.getElementById('fileInput')
        },
        methods: {
            addToCart() {
                let item = [];
                item.id = this.form.id;
                item.name = this.form.name;
                item.image = this.form.image;
                item.total_after = this.form.total_after;
                this.$store.dispatch("addItem", item);
            },
            openModel() {
                this.dialog2 = true;
            },
            editDailySetup() {
                this.dialog2 = false;
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
            printbill() {
                if(this.$refs.form.validate()){
                    this.form.post(this.route('pos.save_order'), {
                        preserveScroll: true,
                        onSuccess:() => {
                            this.closeModal()
                            Toast.fire({
                                icon: 'success',
                                title: 'New Product created!'
                            })
                        }
                    })
                }
            },
            selectImage () {
                if (!this.form.imageFile) {
                    this.input.click()
                }
            },
            updateValue (event) {
                this.form.imageFile = event.target.files[0]
                this.image = this.form.imageFile ? URL.createObjectURL(this.form.imageFile) : undefined
                this.$emit('input', this.form.imageFile)
            },
            deleteImage () {
                if (this.form.imageFile) {
                    this.form.imageFile = undefined
                    this.image = undefined
                    this.mask = false
                    this.input.value = '' // <-- this will fix the issue
                    this.$emit('input', undefined)
                }
            }
        },

        computed: {

            item() {
                let value = this.$store.state.selectedItem;
                console.log(value);
                this.form.id = value.id;
                this.form.name = value.name;
                this.form.image = value.image1;
                this.form.item_sku = value.item_sku;
                this.form.item_description = value.item_description;
                this.form.gold_weight.kyat = String(value.gold_weight.kyat);
                this.form.gold_weight.pal = String(value.gold_weight.pal);
                this.form.gold_weight.yway = String(value.gold_weight.yway);
                this.form.gem_weight.kyat = String(value.gem_weight.kyat);
                this.form.gem_weight.pal = String(value.gem_weight.pal);
                this.form.gem_weight.yway = String(value.gem_weight.yway);
                this.form.gem_price = String(value.gem_price);
                this.form.fee.kyat = String(value.fee.kyat);
                this.form.fee.pal = String(value.fee.pal);
                this.form.fee.yway = String(value.fee.yway);
                this.form.fee_for_making = value.fee_for_making;
                this.form.tax = value.tax;
                this.quality = value.quality;

                this.dailySetup = this.$page.props.daily_setup[this.quality];
                this.dailyValue = this.$page.props.daily_setup[this.quality].kyat;
                return value;
            },
            goldPrice() {
                let price = this.$page.props.daily_setup[this.quality];
                let kyat_p =
                    parseInt(this.form.gold_weight.kyat) * parseInt(price.kyat);
                let pal_p =
                    parseInt(this.form.gold_weight.pal) * parseInt(price.pal);
                let yway_p =
                    parseInt(this.form.gold_weight.yway) * parseInt(price.yway);
                this.form.gold_price = kyat_p + pal_p + yway_p;
                if (isNaN(this.form.gold_price)) this.form.gold_price = "";
                return this.form.gold_price;
            },
            gemPrice() {
                let price = this.$page.props.daily_setup[this.quality];
                let kyat_p =
                    parseInt(this.form.gem_weight.kyat) * parseInt(price.kyat);
                let pal_p =
                    parseInt(this.form.gem_weight.pal) * parseInt(price.pal);
                let yway_p =
                    parseInt(this.form.gem_weight.yway) * parseInt(price.yway);
                this.form.gem_price = kyat_p + pal_p + yway_p;
                if (isNaN(this.form.gem_price)) this.form.gem_price = "";
                return this.form.gem_price;
            },
            feePrice() {
                let price = this.$page.props.daily_setup[this.quality];
                let kyat_p = parseInt(this.form.fee.kyat) * parseInt(price.kyat);
                let pal_p = parseInt(this.form.fee.pal) * parseInt(price.pal);
                let yway_p = parseInt(this.form.fee.yway) * parseInt(price.yway);
                this.form.fee_price = kyat_p + pal_p + yway_p;
                if (isNaN(this.form.fee_price)) this.form.fee_price = "";

                return this.form.fee_price;
            },
            totalKyat() {
                this.form.total_kyat =
                    parseInt(this.form.gold_weight.kyat) +
                    parseInt(this.form.gem_weight.kyat) +
                    parseInt(this.form.fee.kyat);
                if (isNaN(this.form.total_kyat)) this.form.total_kyat = "";

                return this.form.total_kyat;
            },
            totalPal() {
                this.form.total_pal =
                    parseInt(this.form.gold_weight.pal) +
                    parseInt(this.form.gem_weight.pal) +
                    parseInt(this.form.fee.pal) +
                    parseInt(this.form.exceed_pal_form_yway);
                if (isNaN(this.form.total_pal)) {
                    this.form.total_pal = "";
                }
                if (this.form.total_pal >= 16) {
                    this.form.total_kyat =
                        this.form.total_kyat + parseInt(this.form.total_pal / 16);
                    this.form.total_pal = this.form.total_pal % 16;
                }
                return this.form.total_pal;
            },
            totalYway() {
                this.form.total_yway =
                    parseInt(this.form.gold_weight.yway) +
                    parseInt(this.form.gem_weight.yway) +
                    parseInt(this.form.fee.yway);
                if (isNaN(this.form.total_yway)) {
                    this.form.total_yway = "";
                }
                if (this.form.total_yway >= 8) {
                    this.form.exceed_pal_form_yway = parseInt(
                        this.form.total_yway / 8
                    );
                    this.form.total_yway = this.form.total_yway % 8;
                }else{
                    this.form.exceed_pal_form_yway = 0;
                }
                return this.form.total_yway;
            },
            totalBefore() {
                this.form.total_before =
                    parseInt(this.form.gold_price) +
                    parseInt(this.form.gem_price) +
                    parseInt(this.form.fee_price) +
                    parseInt(this.form.fee_for_making);

                if (isNaN(this.form.total_before)) this.form.total_before = "";

                return this.form.total_before;
            },
            totalAfter() {
                this.form.total_after =
                    parseInt(this.form.total_before) -
                    parseInt(this.form.item_discount);
                if (isNaN(this.form.total_after)) this.form.total_after = "";
                return this.form.total_after;
            },
            creditMoney() {
                this.form.credit_money =
                    parseInt(this.form.total_after) -
                    parseInt(this.form.paid_money);
                if (isNaN(this.form.credit_money)) this.form.credit_money = "";
                return this.form.credit_money;
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
</style>
