<template>
     <v-expansion-panels focusable >
        <v-expansion-panel>
            <v-expansion-panel-header>
                    Invoice no
                    <v-spacer></v-spacer>
                    စုစုပေါင်းဆပ့်ငွေ
                    <v-spacer></v-spacer>
                    ဆပ့်ရန်ကျန်ငွေ
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
                <span class="badge bg-warning">{{ item.debt_paid_money | formatNumber}}</span>
                <v-spacer></v-spacer>
                <span class="badge bg-warning">{{ item.remaining_credit_money | formatNumber}}</span>
                <v-spacer></v-spacer>
                {{ formatDateTime(item.created_at) }}
                <v-spacer></v-spacer>
            </v-expansion-panel-header>
            <v-expansion-panel-content>
                <DebtPaymentDetailComponent
                    :transaction = item
                    type="debt_payment_from_customer"
                />
            </v-expansion-panel-content>
        </v-expansion-panel>
    </v-expansion-panels>
</template>
<script>
    import DebtPaymentDetailComponent from '../../../../Components/AdminPanel/DebtPaymentDetailComponent';
    import moment from 'moment';

    export default {
        name: "DebtPaymentFromCustomer",
        props: ["value"],
        components: {
            DebtPaymentDetailComponent
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
