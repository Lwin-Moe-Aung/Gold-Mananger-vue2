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
            </section>
        </admin-layout>
    </div>
</template>
<script>
    import AdminLayout from '../../../../Layouts/AdminPanelLayout';
    import { Link } from '@inertiajs/inertia-vue';
    import DebtPaymentDetailComponent from '../../../../Components/AdminPanel/DebtPaymentDetailComponent';

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


        },

    }
</script>
