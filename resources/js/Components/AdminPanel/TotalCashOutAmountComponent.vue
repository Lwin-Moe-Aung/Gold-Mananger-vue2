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
                    <v-list-item-title> Total Purchase
                        <v-icon class="mr-1">
                            mdi-heart
                        </v-icon>
                        <span class="subheading">{{  value.purchases.count }}</span>
                        <v-btn
                            icon
                            @click="show_total_purchase_lists = !show_total_purchase_lists"
                            v-if="value.purchases.count != 0"
                        >
                            <v-icon>{{ show_total_purchase_lists ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                        </v-btn>
                    </v-list-item-title>
                </v-list-item-content>

                <v-list-item-action>
                    {{ value.purchases.total_purchase_amount | formatNumber }}
                </v-list-item-action>

            </v-list-item>
            <v-list-item v-if="show_total_purchase_lists">
                <v-expand-transition >
                    <v-list-item-content v-show="show_total_purchase_lists">
                        <ShowTransactionListsComponent
                            v-model="value.purchases.purchases"
                            route = "purchases"
                            v-if="value"
                        />
                    </v-list-item-content>
                </v-expand-transition>
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
                    <v-list-item-title> Total Expense
                        <v-icon class="mr-1">
                            mdi-heart
                        </v-icon>
                        <span class="subheading">{{  value.expenses.count }}</span>
                        <v-btn
                            icon
                            @click="show_expense_lists = !show_expense_lists"
                            v-if="value.expenses.count != 0"
                        >
                            <v-icon>{{ show_expense_lists ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                        </v-btn>
                    </v-list-item-title>
                </v-list-item-content>

                <v-spacer></v-spacer>
                <v-list-item-action>
                    {{ value.total_expense_amount | formatNumber }}
                </v-list-item-action>
            </v-list-item>
            <v-list-item v-if="show_expense_lists">
                <v-expand-transition >
                    <v-list-item-content v-show="show_expense_lists">
                        <ShowExpenseListsComponent
                            v-model="value.expenses.expenses"
                            v-if="value"
                        />
                    </v-list-item-content>
                </v-expand-transition>
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
                    <v-list-item-title> Total Debt To Supplier
                        <v-icon class="mr-1">
                            mdi-heart
                        </v-icon>
                        <span class="subheading">{{  value.debt_payment_to_suppliers.count }}</span>
                        <v-btn
                            icon
                            @click="show_debt_to_supplier_lists = !show_debt_to_supplier_lists"
                            v-if="value.debt_payment_to_suppliers.count != 0"
                        >
                            <v-icon>{{ show_debt_to_supplier_lists ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                        </v-btn>
                    </v-list-item-title>
                </v-list-item-content>

                <v-list-item-action>
                    {{ value.total_debt_payment_to_supplier | formatNumber }}
                </v-list-item-action>
            </v-list-item>
            <v-list-item v-if="show_debt_to_supplier_lists">
                <v-expand-transition >
                    <v-list-item-content v-show="show_debt_to_supplier_lists">
                        <ShowDebtTransactionListsComponent
                            v-model="value.debt_payment_to_suppliers.debt_payment_to_suppliers"
                            status="debt_to_supplier"
                            v-if="value"
                        />
                    </v-list-item-content>
                </v-expand-transition>
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

                <v-list-item-action>
                    {{ value.total_cash_out_amount | formatNumber }}
                </v-list-item-action>
            </v-list-item>
        </v-list>
    </v-card>
</template>
<script>
    import ShowTransactionListsComponent from './ShowTransactionListsComponent';
    import ShowExpenseListsComponent from './ShowExpenseListsComponent';
    import ShowDebtTransactionListsComponent from './ShowDebtTransactionListsComponent';
    export default {
        name: "TotalCashOutAmountComponent",
        props: ["value", "checkBoxShowStatus"],
        components: {
            ShowTransactionListsComponent,
            ShowExpenseListsComponent,
            ShowDebtTransactionListsComponent
        },
        data: () => ({
            checkStatus: false,
            show_total_purchase_lists: false,
            show_expense_lists: false,
            show_debt_to_supplier_lists: false
        }),
        methods: {
            checkAction(){
                this.$emit('update:data', this.checkStatus);
            }
        }

    }
</script>
