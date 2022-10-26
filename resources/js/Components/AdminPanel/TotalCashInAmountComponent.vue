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

                <v-spacer></v-spacer>
                <v-list-item-content>
                    {{ value.opening_balance | formatNumber }}
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
                    <v-list-item-title> Total Sale Amount
                        <v-icon class="mr-1">
                            mdi-heart
                        </v-icon>
                        <span class="subheading">{{  value.sells.count }}</span>
                        <v-btn
                            icon
                            @click="show = !show"
                            v-if="value.sells.count !=0 "
                        >
                            <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                        </v-btn>
                    </v-list-item-title>

                </v-list-item-content>

                <v-spacer></v-spacer>
                <v-list-item-content>
                    {{ value.sells.total_sell_amount | formatNumber }}
                </v-list-item-content>
            </v-list-item>
            <v-list-item v-if="show != false">
                <v-expand-transition>
                    <div v-show="show">
                        <v-divider></v-divider>
                        <ShowSellTransactionListsComponent v-model="value.sells.sells"/>
                        <v-divider></v-divider>
                    </div>
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
                    </v-list-item-title>
                </v-list-item-content>

                <v-spacer></v-spacer>
                <v-list-item-content>
                    {{ value.debt_from_customers.total_debt_from_customers | formatNumber }}
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
                    {{ value.total_cash_in_amount | formatNumber }}
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-card>
</template>
<script>
    import ShowSellTransactionListsComponent from './ShowSellTransactionListsComponent';

    export default {
        name: "TotalCashInAmountComponent",
        props: ["value", "checkBoxShowStatus"],
        components: {
            ShowSellTransactionListsComponent,
        },
        data: () => ({
            checkStatus: false,
            show: false,
        }),
        methods: {
            checkAction(){
                this.$emit('update:data', this.checkStatus);
            }
        }

    }
</script>

