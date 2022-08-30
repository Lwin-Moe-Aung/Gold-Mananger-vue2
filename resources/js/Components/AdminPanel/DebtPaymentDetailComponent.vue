<template>
    <div class="card">
        <div class="card-header">
            <Link :href="urlLink">
                <button class="btn btn-primary float-left mr-3" style="h">
                    <i class="fas fa-long-arrow-alt-left" aria-hidden="true" ></i>
                </button>
            </Link>
            <h3 class="card-title">Detail</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body" style="display: block;">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">{{ nameTxt }}</span>
                                <span class="info-box-number text-center text-muted mb-0">{{ transaction.contact.name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">ဆပ်ငွေ</span>
                                <span class="info-box-number text-center text-muted mb-0 badge badge-pill bg-warning">
                                    {{ numberWithCommas(transaction.debt_paid_money) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">လက်ကျန် အကြွေး</span>
                                <span class="info-box-number text-center text-muted mb-0 badge badge-pill bg-warning">
                                    {{ numberWithCommas(transaction.remaining_credit_money) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h4>{{ titleTxt }}</h4>
                        <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="/images/customers/default-user.png">
                                <span class="username">
                                    <a href="#">{{ transaction.contact.name }}</a>
                                </span>
                                <span class="description">{{ transaction.contact.email }}</span>
                            </div>
                            <!-- /.user-block -->
                            <p>ph-{{ transaction.contact.mobile1 }}, {{ transaction.contact.mobile2 }}</p>
                            <p>Address - {{ transaction.contact.address }}</p>
                            <p>
                                <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> profile</a>
                            </p>
                        </div>
                        <h4>Transaction Information</h4>
                        <div class="post clearfix">
                            <p>Invoice_no - {{ transaction.invoice_no }}</p>
                            <p>Date - {{ formatDateTime(transaction.created_at) }}</p>
                            <p>ဆပ်ငွေ - <span class="badge-pill bg-warning">{{ numberWithCommas(transaction.debt_paid_money) }}</span></p>
                            <p>လက်ကျန်အကြွေး - <span class="badge-pill bg-warning">{{ numberWithCommas(transaction.remaining_credit_money) }}</span></p>
                            <p>Note - {{ transaction.additional_notes }}</p>
                            <p>
                                <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Detail</a>
                            </p>
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                    <h3 class="text-primary"><i class="fas fa-paint-brush"></i> Voucher List</h3>
                    <div  class="card bg-light d-flex flex-fill" v-for="(value, key) in voucherLists" :key="key">
                        <div class="card-header text-muted border-bottom-0" v-if="value.debt_payment != 0">
                            Original Invoice Number-
                            <Link v-if="type == 'debt_payment_from_customer'"
                                :href="route('admin.sells.show',value.parent_id)"
                                class="btn btn-sm btn-primary badge-pill badge-dark">
                                {{ value.transaction.invoice_no }}
                            </Link>
                            <Link v-else
                                :href="route('admin.purchases.show',value.parent_id)"
                                class="btn btn-sm btn-primary badge-pill badge-dark">
                                {{ value.transaction.invoice_no }}
                            </Link>
                        </div>
                        <div class="card-body pt-0" v-if="value.debt_payment != 0">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b>{{ value.item.name }}</b></h2>
                                    <p class="text-muted text-sm">
                                        <b>Date: </b> {{ formatDateTime(value.created_at) }}
                                    </p>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small">
                                            <b>စုစုပေါင်း : </b>
                                            <span class="badge badge-pill bg-warning">{{ numberWithCommas(value.transaction.before_total) }}</span>
                                        </li>
                                        <li class="small">
                                            <b>လျော့ငွေ : </b>
                                            <span class="badge badge-pill bg-warning">{{ numberWithCommas(value.transaction.discount_amount) }}</span>
                                        </li>
                                        <li class="small">
                                            <b>ကျသင့်ငွေ : </b>
                                            <span class="badge badge-pill bg-warning">{{ numberWithCommas(value.transaction.final_total) }}</span>
                                        </li>
                                        <li class="small">
                                            <b>ပေးငွေ : </b>
                                            <span class="badge badge-pill bg-warning">{{ numberWithCommas(value.old_paid_money) }}</span>
                                        </li>
                                        <li class="small">
                                            <b>ကျန်ငွေ : </b>
                                            <span class="badge badge-pill bg-warning">{{ numberWithCommas(value.old_credit_money) }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-5 text-center">
                                    <h2>
                                        <span class="badge badge-pill badge-dark"></span>
                                    </h2>
                                    <img :src="value.item.image" alt="user-avatar" class="img-circle img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer" v-if="value.debt_payment != 0">
                            <div class="text-right">
                                <p class="text-muted text-sm">
                                    <b>အကြွေးဆပ်ငွေ : </b> <span class="badge bg-warning">{{ numberWithCommas(value.debt_payment) }}</span>
                                </p>
                                <p class="text-muted text-sm">
                                    <b>ဆပ်ပီးကျန်ငွေ : </b> <span class="badge bg-warning">{{ numberWithCommas(value.old_credit_money-value.debt_payment) }}</span>
                                </p>
                                <Link v-if="type == 'debt_payment_from_customer'"
                                    :href="route('admin.sells.show',value.parent_id)"
                                    class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View Voucher
                                </Link>
                                <Link v-else
                                    :href="route('admin.purchases.show',value.parent_id)"
                                    class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View Voucher
                                </Link>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue';
    import moment from 'moment';

    export default {
        name: 'DebtPaymentDetailComponent',
        props: ["transaction","type","back_url"],
        components: {
            Link,
        },
        created() {
            if(this.type == 'debt_payment_from_customer'){
                this.voucherLists = this.transaction.debt_payment_from_customer;
            }else{
                this.voucherLists = this.transaction.debt_payment_to_supplier;
            }
        },
        data() {
            return {
                voucherLists: [],
            }
        },
        watch: {

        },
        methods: {
            numberWithCommas(x) {
                let v = parseInt(x);
                return v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            },
            formatDateTime(value) {
                return moment(String(value)).format('YYYY-MM-DD hh:mm')
            }
        },
        computed: {
            nameTxt() {
                return this.type == "debt_payment_from_customer" ? 'Customer Name' : 'Supplier Name';
            },
            titleTxt() {
                return this.type == "debt_payment_from_customer" ? 'Customer Information' : 'Supplier Information';
            },
            urlLink() {
                return this.type == "debt_payment_from_customer" ? route('admin.debt-payment-from-customers.index') : route('admin.debt-payment-to-suppliers.index');
            }
        }
    }
</script>
