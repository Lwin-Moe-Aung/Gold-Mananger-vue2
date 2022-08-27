<template>
   <InvoiceComponent
        :transaction = transaction
        type = 'purchase'
    />
</template>


<script>
    import InvoiceComponent from '../../../../Components/AdminPanel/InvoiceComponent';

    export default {
        props: [
            'transaction',
        ],
        components: {
            InvoiceComponent,
        },
        created() {
            this.printbill();
        },
        methods: {
            printbill() {
                window.print();
            },
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

