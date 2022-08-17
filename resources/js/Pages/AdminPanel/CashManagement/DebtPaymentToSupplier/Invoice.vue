<template>
    <div>
        <DebtPaymentInvoiceComponent
            :transaction="transaction"
            type="debt_payment_to_supplier"
        />
    </div>
</template>
<script>
    import DebtPaymentInvoiceComponent from '../../../../Components/AdminPanel/DebtPaymentInvoiceComponent';

    export default {
        props: [
            'transaction',
        ],
        components: {
            DebtPaymentInvoiceComponent
        },
        data() {
            return {

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
