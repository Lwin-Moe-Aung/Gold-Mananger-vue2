<template>
    <v-card>
        <v-toolbar
            color="indigo"
            dark
        >
            <v-toolbar-title>Cash In</v-toolbar-title>
            <v-spacer></v-spacer>
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
                    <v-list-item-title> Total Sale Amount </v-list-item-title>
                </v-list-item-content>

                <v-spacer></v-spacer>
                <v-list-item-content>
                    {{ value.total_sell_amount | formatNumber }}
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
                    <v-list-item-title> Total Debt From Customer </v-list-item-title>
                </v-list-item-content>

                <v-spacer></v-spacer>
                <v-list-item-content>
                    {{ value.total_debt_from_customer | formatNumber }}
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
    export default {
        name: "TotalCashInAmountComponent",
        props: ["value"],

    }
</script>

