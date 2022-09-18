<template>
    <v-expansion-panels focusable >
        <v-expansion-panel>
            <v-expansion-panel-header>
                    Invoice no
                    <v-spacer></v-spacer>
                    Amount
                    <v-spacer></v-spacer>
                    Product Sku
                    <v-spacer></v-spacer>
                    Date
                    <v-spacer></v-spacer>
            </v-expansion-panel-header>
        </v-expansion-panel>
        <v-expansion-panel
            v-for="(item,i) in value"
            :key="i"
        >
            <v-expansion-panel-header>
                {{ item.invoice_no }}
                <v-spacer></v-spacer>
                <span class="badge bg-warning">{{ item.final_total | formatNumber}}</span>
                <v-spacer></v-spacer>
                {{ item.product_sku }}
                <v-spacer></v-spacer>
                {{ formatDateTime(item.created_at) }}
                <v-spacer></v-spacer>
            </v-expansion-panel-header>
            <v-expansion-panel-content>
                <InvoiceComponent
                    :transaction = item
                    type = "sell"
                />
            </v-expansion-panel-content>
        </v-expansion-panel>
    </v-expansion-panels>
</template>
<script>
    import moment from 'moment';
    import InvoiceComponent from '../../../../Components/AdminPanel/InvoiceComponent';

    export default {
        name: "SellTransactions",
        props: ["value"],
        components: {
            InvoiceComponent
        },
        created() {

        },
        data() {
            return {

            }
        },
        watch: {

        },
        methods: {
            formatDateTime(value) {
                return moment(String(value)).format('YYYY-MM-DD hh:mm')
            }
        }
    }
  </script>
