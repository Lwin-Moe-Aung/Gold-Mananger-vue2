<template>
    <div>
        <admin-layout>
            <template #header>
                <a  href="javascript: history.go(-1)">
                    <button class="btn btn-primary float-left mr-3" style="h">
                        <i class="fas fa-long-arrow-alt-left" aria-hidden="true" ></i>
                    </button>
                </a>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Invoice
                </h2>
            </template>
            <InvoiceComponent
                :transaction = transaction
                type = 'purchase'
            />
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
                            <div class="timeline" v-for="(value , key) in debt_payment_to_supplier" :key="key">
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
                                                    {{ value.old_paid_money+value.debt_payment | formatNumber }}
                                                </span>
                                            </p>
                                            <p>
                                                စုစုပေါင်းကျန်ငွေ -
                                                <span class="badge badge-pill bg-warning">
                                                    {{ value.old_credit_money-value.debt_payment | formatNumber }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="timeline-footer">
                                            <Link :href="route('admin.debt-payment-to-suppliers.show',value.transaction_id)">
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
            'debt_payment_to_supplier'
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

