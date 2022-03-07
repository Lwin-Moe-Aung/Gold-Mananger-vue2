<template>
    <v-col cols="12" sm="9">
        <v-hover v-slot="{ hover }" close-delay="200">
            <v-card
                :elevation="hover ? 16 : 2"
                :class="{ 'on-hover': hover }"
                flat
                class="mx-auto rounded-lg mx-3"
            >
                <v-list-item three-line>
                    <v-list-item-avatar
                        rounded
                        size="100"
                        color="grey lighten-4"
                    >
                        <v-img :src="form.image"></v-img>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title class="text-h5">
                            {{ form.name }}</v-list-item-title
                        >
                        <v-list-item-subtitle class="mt-1">
                            {{ form.item_description }}
                        </v-list-item-subtitle>
                        <strong class="mt-3">
                            {{ $page.props.daily_setup[15].kyat }}
                            .kyats
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
                    <v-form>
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
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.gold_weight.yway"
                                                label="ရွေး"
                                                placeholder="ရွေး"
                                                outlined
                                                dense
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
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.gem_weight.pal"
                                                label="ပဲ"
                                                placeholder="ပဲ"
                                                outlined
                                                dense
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.gem_weight.yway"
                                                label="ရွေး"
                                                placeholder="ရွေး"
                                                outlined
                                                dense
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
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.fee.pal"
                                                label="ပဲ"
                                                placeholder="ပဲ"
                                                outlined
                                                dense
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.fee.yway"
                                                label="ရွေး"
                                                placeholder="ရွေး"
                                                outlined
                                                dense
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
                    </v-form>
                    <!--end new-->
                </v-card-actions>
            </v-card>
        </v-hover>
    </v-col>
</template>

<script>
export default {
    name: "ItemList",

    data() {
        return {
            form: this.$inertia.form({
                id: "",
                name: "",
                image: "",
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
            }),
            quality: "",
        };
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
    },

    computed: {
        item() {
            let value = this.$store.state.selectedItem;
            this.form.id = value.id;
            this.form.name = value.name;
            this.form.image = value.image1;
            this.form.item_sku = value.item_sku;
            this.form.item_description = value.item_description;
            this.form.gold_weight.kyat = value.gold_weight.kyat;
            this.form.gold_weight.pal = value.gold_weight.pal;
            this.form.gold_weight.yway = value.gold_weight.yway;
            this.form.gem_weight.kyat = value.gem_weight.kyat;
            this.form.gem_weight.pal = value.gem_weight.pal;
            this.form.gem_weight.yway = value.gem_weight.yway;
            this.form.gem_price = value.gem_price;
            this.form.fee.kyat = value.fee.kyat;
            this.form.fee.pal = value.fee.pal;
            this.form.fee.yway = value.fee.yway;
            this.form.fee_for_making = value.fee_for_making;
            this.form.tax = value.tax;
            this.quality = value.product.quality;
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
    },
};
</script>
<style>
.row + .row {
    margin-top: 0px !important;
}
</style>
