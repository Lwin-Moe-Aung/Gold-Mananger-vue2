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
                        <strong class="mt-3"> 1,700,000 .kyats </strong>
                    </v-list-item-content>

                    <i class="fas fa-save" style="margin-top: -97px"></i>
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
                                        <v-col cols="12" sm="6" md="2">
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
                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
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
                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
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

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                v-model="form.fee_for_making"
                                                label="kyats"
                                                placeholder="kyat"
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
                                                label="kyats"
                                                placeholder="kyat"
                                                outlined
                                                dense
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                label="kyats"
                                                placeholder="kyat"
                                                outlined
                                                dense
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                label="kyats"
                                                placeholder="kyat"
                                                outlined
                                                dense
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field
                                                label="kyats"
                                                placeholder="kyat"
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

                fee_for_making: "",
                item_discount: "",
                tax: "",
                item_description: "",
            }),
            quality: "",
        };
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
            return this.gold_price;
        },
    },
};
</script>
<style>
.row + .row {
    margin-top: 0px !important;
}
</style>
