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
                    <p> {{transaction.business_location.name.address}}</p>
                    <p> {{transaction.business_location.name.mobile}}</p>
                    <p> {{transaction.business_location.name.email}}</p>

                    </div>
                    <div class="col-4">
                        <small class="float-right">Date: {{ dateTime(transaction.created_at)}}</small>

                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info row-invoice-page">
                    <div class="col-sm-4 invoice-col">
                        <strong v-if="type == 'debt_payment_from_customer'">Customer Info</strong>
                        <strong v-else>Supplier Info</strong>
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
                    <b>Payment Due:</b> {{ date(transaction.transaction_date)}}<br>
                    </div>
                    <!-- /.col -->
                </div>


                <!-- /glod quality -->

                    <!-- Table row -->
                <div class="row row-invoice-page">
                    <div class="col-12 table-responsive col-invoice-page">
                        <table class="table table-bselled text-center bg-white">
                            <thead>
                                <tr>
                                    <th style="width: 100px">နံပါတ်စဉ်</th>
                                    <th>Invoice No</th>
                                    <th>ကျန်ငွေ</th>
                                    <th>ဆပ်ငွေ</th>
                                    <th>ဆပ်ပီးကျန်ငွေ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, index) in data" :key="index">
                                    <td>{{ index+1 }}</td>
                                    <td>{{ value.transaction.invoice_no }}</td>
                                    <td>{{ numberWithCommas(value.old_credit_money) }}</td>
                                    <td>{{ numberWithCommas(value.debt_payment) }}</td>
                                    <td>{{ numberWithCommas(value.old_credit_money - value.debt_payment)}}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="font-weight:bold;">စုစုပေါင်း</td>
                                    <td style="font-weight:bold;">
                                        {{ numberWithCommas(oldRemainTotalCredit) }}
                                    </td>
                                    <td style="font-weight:bold;">
                                        {{ numberWithCommas(totalDebtPayment) }}
                                    </td>
                                    <td style="font-weight:bold;">
                                        {{ numberWithCommas(oldRemainTotalCredit - totalDebtPayment) }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
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
        name: 'DebtPaymentInvoiceComponent',
        props: [
            'transaction','type'
        ],
        data() {
            return {
                oldRemainTotalCredit:0,
                totalDebtPayment:0,
                data:[],
            }
        },
        methods: {
            printbill() {
                window.print();
            },
            date(value) {
                return moment(value).format('DD/MM/YYYY');
            },
            numberWithCommas(value) {
                const v = parseInt(value);
                return v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            dateTime(value) {
                return moment(value).format('DD/MM/YYYY hh:mm:s A');
            },
            pushData(){
                if(this.type == 'debt_payment_from_customer')this.data = this.transaction.debt_payment_from_customer;
                else this.data = this.transaction.debt_payment_to_supplier;

                this.data.forEach((element) => {
                    this.oldRemainTotalCredit = this.oldRemainTotalCredit+ parseInt(element.old_credit_money);
                    this.totalDebtPayment = this.totalDebtPayment+ parseInt(element.debt_payment);
                });
            }
        },
        mounted() {
            this.pushData();
            this.printbill();
        },

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
