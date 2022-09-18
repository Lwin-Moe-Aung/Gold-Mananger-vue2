<template>
    <div>
        <admin-layout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Debt Payment To Supplier Detail
                </h2>
            </template>
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <Link :href="route('admin.debt-payment-to-suppliers.index')">
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
                    <DebtPaymentDetailComponent
                        :transaction="transaction"
                        type="debt_payment_to_supplier"
                    />
                </div>

                <div class="row no-print">
                    <div class="col-12">
                        <a href="#"
                            class="btn btn-default"
                            @click="print"
                            >
                            <i class="fas fa-print"></i> Print
                        </a>
                    </div>
                </div>
            </section>
        </admin-layout>
    </div>
</template>
<script>
    import AdminLayout from '../../../../Layouts/AdminPanelLayout';
    import { Link } from '@inertiajs/inertia-vue';
    import DebtPaymentDetailComponent from '../../../../Components/AdminPanel/DebtPaymentDetailComponent';
    import constant from "../../../../constant";

    export default {
        props: [
            'transaction',
        ],
        components: {
            AdminLayout,
            Link,
            DebtPaymentDetailComponent
        },
        data() {
            return {
                customer:[],
            }
        },
        created() {

        },
        watch: {

        },
        computed: {

        },
        validations: {
        },
        methods: {
            print(){
               window.open( constant.ROUTE_URL_ADMIN+"supplier-debt-payment-generate-invoice/"+this.transaction.id, "_blank");
            }
        },

    }
</script>
