<template>

        <!-- Main content -->
        <section class="invoice" style="background-color: #FEF2CB !important;">
            <div class="container">
                <div class="container-fluid">
                    <!-- title row -->
                    <div class="row row-invoice-page">
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
                            <small class="float-right">Date: {{ dateTime(transaction.created_at)}}</small>

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info row-invoice-page">
                        <div class="col-sm-4 invoice-col">
                        Customer Info
                        <address>
                            <strong>{{transaction.contact.name}}</strong><br>
                            {{transaction.contact.address}}<br>
                            Phone: {{transaction.contact.mobile1}},{{transaction.contact.mobile2}}<br>
                            Email: {{transaction.contact.email}}
                        </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">

                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                        <b>Invoice #{{transaction.invoice_no}}</b><br>
                        <br>
                        <b>Unit Id #{{item.item_sku}}</b><br>
                        <br>
                        <b>Payment Due:</b> {{ date(transaction.transaction_date)}}<br>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <!-- /glod quality Table-->
                    <div class="row row-invoice-page">
                        <!-- /.col -->
                        <div class="col-6 col-invoice-page">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center bg-white">
                                    <tr>
                                        <th style="width:50%">ရွှေရည်</th>
                                        <td class="text-right">{{product.quality}}</td>
                                    </tr>
                                    <tr>
                                        <th>ပစ္စည်းအမည်</th>
                                        <td class="text-right">{{item.name}}</td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                         <!-- accepted payments column -->
                        <div class="col-6 col-invoice-page">

                        </div>
                    </div>
                    <!-- /glod quality -->

                    <!-- Table row -->
                    <div class="row row-invoice-page">
                        <div class="col-12 table-responsive col-invoice-page">
                            <table class="table table-bordered text-center bg-white">
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
                                        <td>{{item.gold_weight.kyat}}</td>
                                        <td>{{item.gold_weight.pal}}</td>
                                        <td>{{item.gold_weight.yway}}</td>
                                        <td class="text-right">{{numberWithCommas(item.gold_price)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">ကျောက်ချိန်</td>
                                        <td>{{item.gem_weight.kyat}}</td>
                                        <td>{{item.gem_weight.pal}}</td>
                                        <td>{{item.gem_weight.yway}}</td>
                                        <td class="text-right">{{numberWithCommas(item.gem_price)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">အလျော့တွက်</td>
                                        <td>{{item.fee.kyat}}</td>
                                        <td>{{item.fee.pal}}</td>
                                        <td>{{item.fee.yway}}</td>
                                        <td class="text-right">{{numberWithCommas(item.fee_price)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">လက်ခ</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">{{numberWithCommas(item.fee_for_making)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">စုစုပေါင်း</td>
                                        <td>{{order.total_weight.kyat}}</td>
                                        <td>{{order.total_weight.pal}}</td>
                                        <td>{{order.total_weight.yway}}</td>
                                        <td class="text-right">{{numberWithCommas(order.total_before)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row row-invoice-page">
                        <!-- accepted payments column -->
                        <div class="col-6 col-invoice-page">

                        </div>
                        <!-- /.col -->
                        <div class="col-6 col-invoice-page">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center bg-white">
                                    <tr>
                                        <th style="width:50%">လျော့ငွေ:</th>
                                        <td class="text-right">{{numberWithCommas(order.discount_amount)}}</td>
                                    </tr>
                                    <tr>
                                        <th>ကျသင့်ငွေ</th>
                                        <td class="text-right">{{numberWithCommas(order.final_total)}}</td>
                                    </tr>
                                    <tr>
                                        <th>ပေးငွေ:</th>
                                        <td class="text-right">{{numberWithCommas(order.paid_money)}}</td>
                                    </tr>
                                    <tr>
                                        <th>ကျန်ငွေ:</th>
                                        <td class="text-right">{{numberWithCommas(order.credit_money)}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row no-print">
                        <div class="col-12">
                            <a href="#" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                        </div>
                    </div>
                </div>
             </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->

</template>
<script>
    import moment from 'moment';

    export default {
        name: 'Invoice',
        props: [
            'order',
            'transaction',
            'item',
            'product'
            ],
        created() {
            this.printbill();
            // console.log("hello invoice page");
            // window.addEventListener("load", window.print());
        },
        methods: {
            printbill() {
                window.print();
            },
            date(value) {
                return moment(value).format('DD/MM/YYYY');
            },
            numberWithCommas(value) {
                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            dateTime(value) {
                return moment(value).format('DD/MM/YYYY hh:mm:s A');
            }
        }

    }
</script>
<style>
    @media print {
        .no-print  {
            display: none;
        }

    }
    .row-invoice-page {
        margin-top: 0px !important;
    }
    .col-invoice-page {
        padding: 0px !important;
    }

</style>
