<template>
    <div>
        <admin-layout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Debt Payment From Customer Detail
                </h2>
            </template>
            <section class="content">

                <DebtPaymentDetailComponent
                    :transaction="transaction"
                    type="debt_payment_from_customer"
                />
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
               window.open( constant.ROUTE_URL_ADMIN+"customer-debt-payment-generate-invoice/"+this.transaction.id, "_blank");
            }
        },

    }
</script>
