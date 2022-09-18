<template>
    <div>
        <v-row
            justify="center"
        >
            <v-dialog
                v-model="dialog"
                fullscreen
                hide-overlay
                transition="dialog-bottom-transition"
                scrollable
            >
                <v-card tile>
                    <v-toolbar
                        flat
                        dark
                        color="primary"
                    >
                        <v-btn
                            icon
                            dark
                            @click="close()"
                        >
                            <v-icon>fas fa-close</v-icon>
                        </v-btn>
                        <template v-slot:extension>
                            <v-tabs align-with-title color="red">
                                <v-tab @click="setShowDataStatus('CustomerInformation')">Customer Information</v-tab>
                                <v-tab @click="setShowDataStatus('SellTransactions')">Customer Transactions</v-tab>
                                <v-tab @click="setShowDataStatus('DebtPaymentFromCustomer')">Customer Debt Payment History</v-tab>
                            </v-tabs>
                        </template>
                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                            <v-btn
                                dark
                                text
                                @click="close()"
                            >
                                Close
                            </v-btn>
                        </v-toolbar-items>
                    </v-toolbar>
                    <v-card-text>
                        <v-card class="overflow-hidden">
                            <v-sheet
                                id="scrolling-techniques-4"
                                class="overflow-y-auto"
                                max-height="600"
                            >
                                <v-container style="height: 1000px;">
                                    <CustomerInformation
                                        v-model="customerInfo"
                                        v-if="this.showDataStatus == 'CustomerInformation'"
                                    />
                                    <SellTransactions
                                        v-model="sellTransactions"
                                        v-if="this.showDataStatus == 'SellTransactions'"
                                    />
                                    <DebtPaymentFromCustomer
                                        v-model="debtPaymentHistories"
                                        v-if="this.showDataStatus == 'DebtPaymentFromCustomer'"
                                    />
                                </v-container>
                            </v-sheet>
                        </v-card>
                    </v-card-text>
                    <div style="flex: 1 1 auto;"></div>
                </v-card>
            </v-dialog>
        </v-row>
    </div>
</template>
<script>
    import CustomerInformation from "./CustomerInformation";
    import SellTransactions from "./SellTransactions";
    import DebtPaymentFromCustomer from "./DebtPaymentFromCustomer";
    import axios from 'axios';

    export default {
        name: "ShowDetailDialog",
        props: ["value","customerDetailId"],
        components: {
            CustomerInformation,
            SellTransactions,
            DebtPaymentFromCustomer
        },
        created() {

        },
        data() {
            return {
               dialog:false,
               customerId:null,
               showDataStatus:'CustomerInformation',
               customerInfo:null,
               sellTransactions:null,
               debtPaymentHistories:null
            }
        },
        watch: {
            value (val) {
                this.dialog = val;
                if(this.customerId == this.customerDetailId) return;

                this.customerId = this.customerDetailId;
                this.getData();
            },
        },
        methods: {
            setShowDataStatus(value) {
                this.showDataStatus = value;
            },
            close(){
                this.$emit('update:data', false);
            },
            getData()
            {
                axios.get(this.route("pos.customer-lists.detail"), { params: {customer_id: this.customerId}})
                    .then((response) => {
                        this.customerInfo = response.data.customerInfo;
                        this.sellTransactions = response.data.sellTransactions;
                        this.debtPaymentHistories = response.data.debtPaymentHistories;
                    });
            }
        }
    }
  </script>
