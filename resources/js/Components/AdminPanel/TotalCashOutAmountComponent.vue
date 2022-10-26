<template>
    <v-card>
        <v-toolbar
            color="indigo"
            dark
        >
            <v-toolbar-title>Cash Out</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-checkbox
                v-model="checkStatus"
                @change="checkAction"
                label="Verify"
                color="success"
                hide-details
                v-if="checkBoxShowStatus"
            ></v-checkbox>
        </v-toolbar>
        <v-list>
            <v-list-item>
                <v-list-item-icon>
                    <v-icon
                        color="pink"
                    >
                        mdi-star
                    </v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title> Total Purchase </v-list-item-title>
                </v-list-item-content>

                <v-spacer></v-spacer>
                <v-list-item-content>
                    {{ value.total_purchase_amount | formatNumber }}
                </v-list-item-content>
            </v-list-item>
            <v-list-item>
                <v-list-item-icon>
                    <v-icon
                        color="pink"
                    >
                        mdi-star
                    </v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title> Total Expense </v-list-item-title>
                </v-list-item-content>

                <v-spacer></v-spacer>
                <v-list-item-content>
                    {{ value.total_expense_amount | formatNumber }}
                </v-list-item-content>
            </v-list-item>
            <v-list-item>
                <v-list-item-icon>
                    <v-icon
                        color="pink"
                    >
                        mdi-star
                    </v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title> Total Debt To Supplier </v-list-item-title>
                </v-list-item-content>

                <v-spacer></v-spacer>
                <v-list-item-content>
                    {{ value.total_debt_payment_to_supplier | formatNumber }}
                </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
            <v-list-item>
                <v-list-item-icon>
                    <v-icon
                        color="orange"
                    >
                        mdi-star
                    </v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title> Total Amount: </v-list-item-title>
                </v-list-item-content>

                <v-spacer></v-spacer>
                <v-list-item-content>
                    {{ value.total_cash_out_amount | formatNumber }}
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-card>
</template>
<script>
    export default {
        name: "TotalCashOutAmountComponent",
        props: ["value", "checkBoxShowStatus"],
        data: () => ({
            checkStatus: false,
        }),
        methods: {
            checkAction(){
                this.$emit('update:data', this.checkStatus);
            }
        }

    }
</script>
