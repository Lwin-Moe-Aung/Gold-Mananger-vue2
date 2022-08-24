<template>
    <div>
        <admin-layout>
            <template #header>
                <Link :href="route('admin.sells.index')">
                    <button class="btn btn-primary float-left mr-3" style="h">
                        <i class="fas fa-long-arrow-alt-left" aria-hidden="true" ></i>
                    </button>
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Invoice
                </h2>
            </template>
            <InvoiceComponent
                :transaction = transaction
                type = 'sell'
            />
            <!-- <section class="invoice" style="background-color: #FEF2CB !important;">
                <div class="container">
                    <div class="container-fluid">
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
                        </div>
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
                            <div class="col-sm-4 invoice-col">

                            </div>
                            <div class="col-sm-4 invoice-col">
                            <b>Invoice #{{transaction.invoice_no}}</b><br>
                            <br>
                            <b>Unit Id #{{transaction.sell.item.item_sku}}</b><br>
                            <br>
                            <b>Payment Due:</b> {{ date(transaction.transaction_date)}}<br>
                            </div>
                        </div>

                        <div class="row row-invoice-page">
                            <div class="col-6 col-invoice-page">
                                <div class="table-responsive">
                                    <table class="table table-bselled text-center bg-white">
                                        <tr>
                                            <th style="width:50%">ရွှေရည်</th>
                                            <td class="text-right">{{transaction.sell.item.product.quality}}</td>
                                        </tr>
                                        <tr>
                                            <th>ပစ္စည်းအမည်</th>
                                            <td class="text-right">{{transaction.sell.item.name}}</td>
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
                                            <td>{{transaction.sell.item.gold_plus_gem_weight.kyat}}</td>
                                            <td>{{transaction.sell.item.gold_plus_gem_weight.pal}}</td>
                                            <td>{{transaction.sell.item.gold_plus_gem_weight.yway}}</td>
                                            <td class="text-right">{{numberWithCommas(transaction.sell.gold_price)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">ကျောက်ချိန်</td>
                                            <td>{{transaction.sell.item.gem_weight.kyat}}</td>
                                            <td>{{transaction.sell.item.gem_weight.pal}}</td>
                                            <td>{{transaction.sell.item.gem_weight.yway}}</td>
                                            <td class="text-right">{{numberWithCommas(transaction.sell.gem_price)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">အလျော့တွက်</td>
                                            <td>{{transaction.sell.item.fee.kyat}}</td>
                                            <td>{{transaction.sell.item.fee.pal}}</td>
                                            <td>{{transaction.sell.item.fee.yway}}</td>
                                            <td class="text-right">{{numberWithCommas(transaction.sell.fee_price)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">လက်ခ</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right">{{numberWithCommas(transaction.sell.fee_for_making)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">စုစုပေါင်း</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right">{{numberWithCommas(transaction.sell.before_total)}}</td>
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
                                            <td class="text-right">{{numberWithCommas(transaction.sell.discount_amount)}}</td>
                                        </tr>
                                        <tr>
                                            <th>ကျသင့်ငွေ</th>
                                            <td class="text-right">{{numberWithCommas(transaction.sell.final_total)}}</td>
                                        </tr>
                                        <tr>
                                            <th>ပေးငွေ:</th>
                                            <td class="text-right">{{numberWithCommas(transaction.sell.paid_money)}}</td>
                                        </tr>
                                        <tr>
                                            <th>ကျန်ငွေ:</th>
                                            <td class="text-right">{{numberWithCommas(transaction.sell.credit_money)}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row no-print">
                            <div class="col-12">
                                <a href="#" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                            </div>
                        </div>
                    </div>
                </div>

            </section> -->
            <div class="container card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Paid History</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div  class="card-body" style="display: block;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="timeline" v-for="(value , key) in debt_payment_from_customer" :key="key">
                                <div class="time-label">
                                    <span class="bg-success">{{ date(value.created_at) }}</span>
                                </div>
                                <div>
                                    <i class="fas fa-envelope bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{ time(value.created_at) }}</span>
                                        <h3 class="timeline-header">
                                            ဆပ်ငွေ -
                                            <span class="badge badge-pill bg-warning">{{ value.debt_payment | formatNumber }}</span>
                                        </h3>

                                        <div class="timeline-body">
                                            <p>
                                                စုစုပေါင်းပေးငွေ -
                                                <span class="badge badge-pill bg-warning">
                                                    {{ parseInt(value.old_paid_money) + parseInt(value.debt_payment) | formatNumber}}
                                                </span>
                                            </p>
                                            <p>
                                                စုစုပေါင်းကျန်ငွေ -
                                                <span class="badge badge-pill bg-warning">
                                                    {{ (value.old_credit_money-value.debt_payment) | formatNumber }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="timeline-footer">
                                            <Link :href="route('admin.debt-payment-from-customers.show',value.transaction_id)">
                                                <a class="btn btn-default btn-sm">Read Detail</a>
                                            </Link>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-clock bg-gray"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </admin-layout>
    </div>
</template>


<script>
    import AdminLayout from '../../../../Layouts/AdminPanelLayout';
    import moment from 'moment';
    import InvoiceComponent from '../../../../Components/AdminPanel/InvoiceComponent';
    import { Link } from '@inertiajs/inertia-vue';

    export default {
        env: {
                browser: true,
                node: true,
            },
        props: [
            'transaction',
            'debt_payment_from_customer'
        ],
        components: {
            AdminLayout,
            InvoiceComponent,
            Link
        },
        created() {
            // this.printbill();
        },
        methods: {
            printbill() {
                window.print();
            },
            date(value) {
                return moment(value).format('DD/MM/YYYY');
            },

            dateTime(value) {
                return moment(value).format('DD/MM/YYYY hh:mm:s A');
            },
            time(value) {
                return moment(value).format('hh:mm A');
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

