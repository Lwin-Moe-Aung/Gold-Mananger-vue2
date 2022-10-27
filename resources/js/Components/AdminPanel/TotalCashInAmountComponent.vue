<template>
    <v-card>
        <v-toolbar
            color="indigo"
            dark
        >
            <v-toolbar-title>Cash In</v-toolbar-title>
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
                    <v-list-item-title> Opening Balance </v-list-item-title>
                </v-list-item-content>

                <v-list-item-action>
                    {{ value.opening_balance | formatNumber }}
                </v-list-item-action>
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
                    <v-list-item-title> Total Sale Amount
                        <v-icon class="mr-1">
                            mdi-heart
                        </v-icon>
                        <span class="subheading">{{  value.sells.count }}</span>
                        <v-btn
                            icon
                            @click="show_total_sell_lists = !show_total_sell_lists"
                            v-if="value.sells.count !=0 "
                        >
                            <v-icon>{{ show_total_sell_lists ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                        </v-btn>
                    </v-list-item-title>

                </v-list-item-content>
                <v-list-item-action>
                    {{ value.sells.total_sell_amount | formatNumber }}
                </v-list-item-action>
            </v-list-item>
            <v-list-item v-if="show_total_sell_lists">
                <v-expand-transition >
                    <v-list-item-content v-show="show_total_sell_lists">
                        <ShowTransactionListsComponent
                            v-model="value.sells.sells"
                            status = "sells"
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
                    <v-list-item-title> Total Debt From Customer
                        <v-icon class="mr-1">
                            mdi-heart
                        </v-icon>
                        <span class="subheading">{{  value.debt_from_customers.count }}</span>
                        <v-btn
                            icon
                            @click="show_debt_from_customer_lists = !show_debt_from_customer_lists"
                            v-if="value.sells.count !=0 "
                        >
                            <v-icon>{{ show_debt_from_customer_lists ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                        </v-btn>
                    </v-list-item-title>
                </v-list-item-content>

                <v-list-item-action>
                    {{ value.debt_from_customers.total_debt_from_customers | formatNumber }}
                </v-list-item-action>

            </v-list-item>

            <v-list-item v-if="show_debt_from_customer_lists">
                <v-expand-transition >
                    <v-list-item-content v-show="show_debt_from_customer_lists">
                        <ShowDebtTransactionListsComponent
                            v-model="value.debt_from_customers.debt_from_customers"
                            status="debt_from_customer"
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
                    {{ value.total_cash_in_amount | formatNumber }}
                </v-list-item-action>
            </v-list-item>
        </v-list>
    </v-card>
</template>
<script>
    import ShowTransactionListsComponent from './ShowTransactionListsComponent';
    import ShowDebtTransactionListsComponent from './ShowDebtTransactionListsComponent';

    export default {
        name: "TotalCashInAmountComponent",
        props: ["value", "checkBoxShowStatus"],
        components: {
            ShowTransactionListsComponent,
            ShowDebtTransactionListsComponent
        },
        data: () => ({
            checkStatus: false,
            show_total_sell_lists: false,
            show_debt_from_customer_lists: false,

        }),
        methods: {
            checkAction(){
                this.$emit('update:data', this.checkStatus);
            }
        }

    }
</script>

