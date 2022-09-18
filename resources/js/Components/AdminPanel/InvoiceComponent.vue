<template>
        <section class="invoice" style="background-color: #FEF2CB !important;">
            <div class="container">
                <div class="container-fluid">
                    <div class="row row-invoice-page" v-if="transaction.business != undefined">
                        <div class="col-4">

                        </div>
                        <div class="col-4 text-center">
                        <h5>
                            <i class="fas fa-gold"></i> {{ transaction.business.name }} / {{ transaction.business_location.name }}
                        </h5>
                        <p> {{transaction.business_location.address}}</p>
                        <p> {{transaction.business_location.mobile}}</p>
                        <p> {{transaction.business_location.email}}</p>

                        </div>
                        <div class="col-4">
                            <small class="float-right">Date: {{ formatDateTime(transaction.created_at)}}</small>

                        </div>
                    </div>
                    <div class="row invoice-info row-invoice-page" v-if="transaction.contact != undefined">
                        <div class="col-sm-4 invoice-col">
                        {{ contactInfoTxt }}
                        <address>
                            <strong>{{transaction.contact.name}}</strong><br>
                            {{transaction.contact.address}}<br>
                            Phone: {{transaction.contact.mobile1}},{{transaction.contact.mobile2}}<br>
                            Email: {{transaction.contact.email}}
                        </address>
                        </div>
                        <div class="col-sm-4 invoice-col">

                        </div>
                        <div class="col-sm-4 invoice-col">
                        <b>Invoice #{{transaction.invoice_no}}</b><br>
                        <br>
                        <b>Unit Id #{{data.item.item_sku}}</b><br>
                        <br>
                        <b>Payment Due:</b> {{ formatDateTime(transaction.transaction_date)}}<br>
                        </div>
                    </div>

                    <div class="row row-invoice-page">
                        <div class="col-6 col-invoice-page">
                            <div class="table-responsive">
                                <table class="table table-bselled text-center bg-white">
                                    <tr>
                                        <th style="width:50%">ရွှေရည်</th>
                                        <td class="text-right">{{data.item.product.quality}}</td>
                                    </tr>
                                    <tr>
                                        <th>ပစ္စည်းအမည်</th>
                                        <td class="text-right">{{data.item.name}}</td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <div class="col-6 col-invoice-page">
                        </div>
                    </div>

                    <div class="row row-invoice-page">
                        <div class="col-12 table-responsive col-invoice-page">
                            <table class="table table-bselled text-center bg-white">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th style="width: 100px">ကျပ်</th>
                                        <th style="width: 100px">ပဲ</th>
                                        <th style="width: 100px">ရွေး</th>
                                        <th style="width: 160px">ကျသင့်ငွေ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-left">ရွှေချိန်</td>
                                        <td>{{data.item.gold_plus_gem_weight.kyat}}</td>
                                        <td>{{data.item.gold_plus_gem_weight.pal}}</td>
                                        <td>{{data.item.gold_plus_gem_weight.yway}}</td>
                                        <td class="text-right">{{data.gold_price | formatNumber}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">ကျောက်ချိန်</td>
                                        <td>{{data.item.gem_weight.kyat}}</td>
                                        <td>{{data.item.gem_weight.pal}}</td>
                                        <td>{{data.item.gem_weight.yway}}</td>
                                        <td class="text-right">{{data.gem_price| formatNumber}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">အလျော့တွက်</td>
                                        <td>{{data.item.fee.kyat}}</td>
                                        <td>{{data.item.fee.pal}}</td>
                                        <td>{{data.item.fee.yway}}</td>
                                        <td class="text-right">{{data.fee_price| formatNumber}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">လက်ခ</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">{{data.fee_for_making| formatNumber}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">စုစုပေါင်း</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">{{data.before_total| formatNumber}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="row row-invoice-page">
                        <div class="col-6 col-invoice-page">

                        </div>
                        <div class="col-6 col-invoice-page">
                            <div class="table-responsive">
                                <table class="table table-bselled text-center bg-white">
                                    <tr>
                                        <th style="width:50%">လျော့ငွေ:</th>
                                        <td class="text-right">{{data.discount_amount| formatNumber}}</td>
                                    </tr>
                                    <tr>
                                        <th>ကျသင့်ငွေ</th>
                                        <td class="text-right">{{data.final_total| formatNumber}}</td>
                                    </tr>
                                    <tr>
                                        <th>ပေးငွေ:</th>
                                        <td class="text-right">{{data.paid_money| formatNumber}}</td>
                                    </tr>
                                    <tr>
                                        <th>ကျန်ငွေ:</th>
                                        <td class="text-right">{{data.credit_money| formatNumber}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row no-print" v-if="transaction.business != undefined">
                        <div class="col-12">
                            <a rel="noopener" @click="print()" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue';
    import moment from 'moment';
    import constant from "../../constant";

    export default {
        name: 'InvoiceComponent',
        props: ["transaction","type"],
        components: {
            Link,
        },
        created() {
            if(this.type == 'purchase' ){
                this.data = this.transaction.purchase;
                this.invoice_link = 'purchase-invoice'
            }else if(this.type == 'purchase_return'){
                this.data = this.transaction.purchase;
                this.invoice_link = 'purchase-return-invoice';
            }else if(this.type == 'sell'){
                this.data = this.transaction.sell;
                this.invoice_link = 'sell-invoice';
            }
        },
        data() {
            return {
                data:[],
                invoice_link:null,
            }
        },
        watch: {

        },
        methods: {
            print(){
                window.open( constant.ROUTE_URL_ADMIN+this.invoice_link+"/"+this.transaction.id, "_blank");
            },
            formatDateTime(value) {
                return moment(String(value)).format('YYYY-MM-DD hh:mm')
            }
        },
        computed: {
            contactInfoTxt() {
                let title = '';
                if(this.type == 'purchase') title = 'Supplier Info';
                else if(this.type == 'sell'|| this.type == 'purchase_return') title = 'Customer Info';
                return title;
            },
        }
    }
</script>
