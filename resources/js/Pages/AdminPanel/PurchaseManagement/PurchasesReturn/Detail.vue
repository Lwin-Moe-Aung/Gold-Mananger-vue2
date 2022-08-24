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
                type = 'purchase_return'
            />
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

