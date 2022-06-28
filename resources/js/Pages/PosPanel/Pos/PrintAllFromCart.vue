<template>
    <v-container>

        <v-icon @click="back">fas fa-long-arrow-alt-left</v-icon>
        <v-card>
            <v-toolbar
                dark
                color="primary"
                >
                <v-spacer>List From Cart</v-spacer>
            </v-toolbar>
            <v-list
                three-line
                subheader
                v-for="(item, index) in carts"
                :key="item.id"
                :index="index"
                >
                <v-subheader></v-subheader>
                <div class="col-12 table-responsive col-invoice-page">
                    <table class="table table-bordered text-center bg-white">
                        <tbody>
                            <tr>
                                <td rowspan="4" style="vertical-align : middle;text-align:center;">{{ index+1 }}#</td>
                                <td colspan="3">{{item.quality}}ပဲရည်&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ numberWithCommas(item.daily_Setup.kyat) }} ကျပ်</td>
                                <td colspan="3">ရွှေချိန်</td>
                                <td colspan="3">ကျောက်ချိန်</td>
                                <td colspan="3">အလျော့</td>
                                <td rowspan="3" style="vertical-align : middle;text-align:center;">လက်ခ</td>
                                <td colspan="3">စုစုပေါင်း</td>
                                <td rowspan="3" style="vertical-align : middle;text-align:center;">Discount</td>
                                <td rowspan="3" style="vertical-align : middle;text-align:center;">Final Total</td>
                                <td rowspan="4" style="vertical-align : middle;text-align:center;">
                                        <v-btn
                                        color="#ECBD00"
                                        block
                                        dark
                                        class="widthoutupercase black--text"
                                        @click="printBill(item)"
                                        >Print</v-btn
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td> Customer</td>
                                <td> Product Sku</td>
                                <td> Item Name</td>


                                <td style="width: 40px">ကျပ်</td>
                                <td style="width: 40px">ပဲ</td>
                                <td style="width: 40px">ရွေး</td>

                                <td style="width: 40px">ကျပ်</td>
                                <td style="width: 40px">ပဲ</td>
                                <td style="width: 40px">ရွေး</td>

                                <td style="width: 40px">ကျပ်</td>
                                <td style="width: 40px">ပဲ</td>
                                <td style="width: 40px">ရွေး</td>


                                <td style="width: 40px">ကျပ်</td>
                                <td style="width: 40px">ပဲ</td>
                                <td style="width: 40px">ရွေး</td>
                            </tr>
                            <tr>
                                <td> {{item.customer.name}}</td>
                                <td> {{item.product_sku}}</td>
                                <td>
                                    <v-list-item-avatar rounded color="grey lighten-4">
                                        <v-img :src="item.image"></v-img>
                                    </v-list-item-avatar>
                                    {{ item.name }}
                                </td>

                                <td>{{ item.gold_plus_gem_weight.kyat }}</td>
                                <td>{{ item.gold_plus_gem_weight.pal }}</td>
                                <td>{{ item.gold_plus_gem_weight.yway }}</td>

                                <td>{{ item.gem_weight.kyat }}</td>
                                <td>{{ item.gem_weight.pal }}</td>
                                <td>{{ item.gem_weight.yway }}</td>

                                <td>{{ item.fee.kyat }}</td>
                                <td>{{ item.fee.pal }}</td>
                                <td>{{ item.fee.yway }}</td>


                                <td>{{ item.total_kyat }}</td>
                                <td>{{ item.total_pal }}</td>
                                <td>{{ item.total_yway }}</td>
                            </tr>
                            <tr>
                                <td colspan="3">ကျသင့်ငွေတန်ဖိုး</td>
                                <td colspan="3">{{ numberWithCommas(item.gold_price) }}</td>

                                <td colspan="3">{{ numberWithCommas(item.gem_price) }}</td>

                                <td colspan="3">{{ numberWithCommas(item.fee_price) }}</td>
                                <td> {{ numberWithCommas(item.fee_for_making) }}</td>
                                <td colspan="3">{{ numberWithCommas(item.before_total) }}</td>
                                <td> {{ numberWithCommas(item.discount_amount) }}</td>
                                <td> {{ numberWithCommas(item.final_total) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </v-list>

            <div>
                <v-container class="grey lighten-5">
                    <v-row

                    >
                        <v-col
                        key="start"
                        align-self="start"
                        >
                        </v-col>

                        <v-col
                        key="end"
                        align-self="end"
                        >
                            <!-- /.col -->
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center bg-white">
                                        <tbody>
                                            <tr>
                                                <td style="width:50%">လျော့ငွေ:</td>
                                                <td class="text-right">{{numberWithCommas(discount)}}</td>
                                            </tr>
                                            <tr>
                                                <td>ကျသင့်ငွေ</td>
                                                <td class="text-right">{{numberWithCommas(final_total)}}</td>
                                            </tr>
                                            <tr>
                                                <td>ပေးငွေ:</td>
                                                <td class="text-right">{{numberWithCommas(paid_money)}}</td>
                                            </tr>
                                            <tr>
                                                <td>ကျန်ငွေ:</td>
                                                <td class="text-right">{{numberWithCommas(credit_money)}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <!-- /.col -->
                        </v-col>
                    </v-row>
                </v-container>
            </div>

        </v-card>
    </v-container>

</template>

<script>
    import axios from 'axios';
    import constant from "../../../constant";
    import {
            mapGetters,
            mapActions,
            mapState
        } from "vuex";

    export default {
        data() {
            return {
                drawer1: true,
                total: "",
                dialog: true,
            };
        },
        computed: {
            ...mapGetters(['carts']),

            subTotal() {
                let total = 0;
                this.carts.forEach((item) => {
                    total = total + parseInt(item.final_total);
                    // alert(parseInt(item.total_after));
                });
                return total;
            },
            discount() {
                let discount = 0;
                this.carts.forEach((item) => {
                    discount = discount + parseInt(item.item_discount);
                });
                return discount;
            },
            final_total() {
                let final_total = 0;
                this.carts.forEach((item) => {
                    final_total = final_total + parseInt(item.final_total);
                });
                return final_total;
            },
            paid_money() {
                let paid_money = 0;
                this.carts.forEach((item) => {
                    paid_money = paid_money + parseInt(item.paid_money);
                });
                return paid_money;
            },
            credit_money() {
                let credit_money = 0;
                this.carts.forEach((item) => {
                    credit_money = credit_money + parseInt(item.credit_money);
                });
                return credit_money;
            }
        },
        methods: {
            ...mapActions(["editItem", "removeItem","removeItemFromSearchList"]),
            back() {
                window.history.back();
            },
            numberWithCommas(value) {
                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },

            printBill(item) {
                let data = new FormData();
                data.append('id',item.id);
                data.append('name',item.name);
                data.append('product_sku',item.product_sku);
                data.append('image',item.image);
                data.append('imageFile',item.imageFile);
                data.append('item_sku',item.item_sku);
                data.append('gold_plus_gem_weight',JSON.stringify(item.gold_plus_gem_weight));
                data.append('gold_price',item.gold_price);
                data.append('gem_weight',JSON.stringify(item.gem_weight));
                data.append('gem_price',item.gem_price);
                data.append('fee',JSON.stringify(item.fee));
                data.append('fee_price',item.fee_price);
                data.append('fee_for_making',item.fee_for_making);
                data.append('discount_amount',item.discount_amount);
                data.append('before_total',item.before_total);
                data.append('final_total',item.final_total);
                data.append('paid_money',item.paid_money);
                data.append('credit_money',item.credit_money);
                data.append('note',item.note);
                data.append('customer_id',item.customer.id);
                data.append('daily_Setup',JSON.stringify(item.daily_Setup));

                axios.post('/pos/sell', data)
                    .then(res => {
                        if(res.data.status)
                        {
                            this.removeItem(item.id);
                            this.removeItemFromSearchList(item.id);
                            window.open( constant.URL+"generate_invoice/"+res.data.transaction_id, "_blank");
                            // this.$inertia.get(`/pos/generate_invoice`,{ order_id: res.data.order_id });
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
        }
    };
</script>


<style>
.v-card.borderme {
    /* border:2px solid #704232 !important; */
    border: 2px solid #ecbd00 !important;
}
.col-12 {
    padding: 5px !important;
}
.v-btn.widthoutupercase {
    text-transform: none !important;
}
table.table-bordered{
    border:1px solid blue;
    margin-top:20px;
  }
table.table-bordered > thead > tr > th{
    border:1px solid blue;
}
table.table-bordered > tbody > tr > td{
    border:1px solid blue;
}
</style>
