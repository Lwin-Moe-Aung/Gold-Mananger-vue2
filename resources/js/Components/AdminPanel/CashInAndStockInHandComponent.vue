<template>
    <v-app>
        <v-container fluid >
            <v-container v-if="cash_in_data == null">
                <v-alert
                    prominent
                    type="error"
                    >
                    <v-row align="center">
                        <v-col class="grow">
                            You need to Open Day first!
                        </v-col>
                        <v-col class="shrink">
                            <Link :href="route('admin.opening-days.create')">
                                <v-btn>
                                   Go To Open a Day
                                </v-btn>
                            </Link>
                        </v-col>
                    </v-row>
                </v-alert>
            </v-container>
            <v-container v-else>
                <v-row dense>
                    <v-col
                        cols="12"
                    >
                        <v-card>
                            <v-card-actions>
                                <h3>{{ title }}</h3>
                                <v-spacer></v-spacer>
                                <v-spacer></v-spacer>
                                <v-dialog
                                    ref="dialog"
                                    v-model="modal"
                                    :return-value.sync="date"
                                    persistent
                                    width="290px"
                                    v-if=" status != 2"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            v-model="date"
                                            label="Picker in dialog"
                                            prepend-icon="mdi-calendar"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        v-model="date"
                                        scrollable
                                    >
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="modal = false"
                                        >
                                            Cancel
                                        </v-btn>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="$refs.dialog.save(date);getData();"
                                        >
                                            OK
                                        </v-btn>
                                    </v-date-picker>
                                </v-dialog>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                    <v-col
                        cols="12"
                        sm="12"
                        md="6"
                    >
                        <TotalCashInAmountComponent
                            @update:data="checkBoxActionCashIn"
                            v-model="cash_in_data"
                            v-if="cash_in_data !=null "
                            :checkBoxShowStatus="checkBoxShowStatus"
                        />
                    </v-col>
                    <v-col
                        cols="12"
                        sm="12"
                        md="6"
                    >
                        <TotalCashOutAmountComponent
                            @update:data="checkBoxActionCashOut"
                            v-model="cash_out_data"
                            v-if="cash_out_data !=null "
                            :checkBoxShowStatus="checkBoxShowStatus"
                        />
                    </v-col>
                </v-row>
                <v-row>
                    <v-col
                        cols="12"
                        sm="12"
                        md="6"
                    >
                        <v-card>
                            <v-card-actions>
                                <v-list-item>
                                    <v-list-item-icon>
                                        <v-icon
                                            color="success"
                                        >
                                            mdi-star
                                        </v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title> Cash In Hand    : </v-list-item-title>
                                    </v-list-item-content>

                                    <v-spacer></v-spacer>
                                    <v-list-item-content v-if="cash_in_data != null">
                                            {{ cashInHand | formatNumber}}
                                    </v-list-item-content>

                                    <v-spacer></v-spacer>
                                    <v-checkbox
                                        v-model="checkbox_status_for_cash_in_hand"
                                        label="Verify"
                                        color="success"
                                        hide-details
                                        v-if="status == '2'"
                                    ></v-checkbox>
                                </v-list-item>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col
                        cols="12"
                        sm="12"
                        md="6"
                        v-if="stock_in_hand != null"
                    >
                        <v-card>
                            <v-list>
                                <v-list-item>
                                    <v-list-item-icon>
                                        <v-icon
                                            color="success"
                                        >
                                            mdi-star
                                        </v-icon>
                                    </v-list-item-icon>

                                    <v-list-item-content>
                                        <v-list-item-title> Stock In Hand </v-list-item-title>
                                    </v-list-item-content>

                                    <v-spacer></v-spacer>
                                    <v-checkbox
                                        v-model="checkbox_status_for_stock_in_hand"
                                        label="Verify"
                                        color="success"
                                        hide-details
                                        v-if="status == '2'"
                                    ></v-checkbox>
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
                                        <v-list-item-title> Quantity </v-list-item-title>
                                    </v-list-item-content>

                                    <v-spacer></v-spacer>
                                    <v-list-item-content>
                                        {{ stock_in_hand.item_count }}
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
                                        <v-list-item-title> Total Gold & Gem Weight </v-list-item-title>
                                    </v-list-item-content>

                                    <v-spacer></v-spacer>
                                    <v-list-item-content>
                                        <span class="badge bg-warning">
                                            {{ stock_in_hand.total_gold_plus_gem_weight.kyat }} ကျပ်
                                        </span>
                                    </v-list-item-content>
                                    <v-list-item-content>
                                        <span class="badge bg-warning">
                                            {{ stock_in_hand.total_gold_plus_gem_weight.pal }} ပဲ
                                        </span>
                                    </v-list-item-content>
                                    <v-list-item-content>
                                        <span class="badge bg-warning">
                                            {{ stock_in_hand.total_gold_plus_gem_weight.yway }} ရွေး
                                        </span>
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
                                        <v-list-item-title> Total Gem Weight </v-list-item-title>
                                    </v-list-item-content>

                                    <v-spacer></v-spacer>
                                    <v-list-item-content>
                                        <span class="badge bg-warning">
                                            {{ stock_in_hand.total_gem_weight.kyat }} ကျပ်
                                        </span>
                                    </v-list-item-content>
                                    <v-list-item-content>
                                        <span class="badge bg-warning">
                                            {{ stock_in_hand.total_gem_weight.pal }} ပဲ
                                        </span>
                                    </v-list-item-content>
                                    <v-list-item-content>
                                        <span class="badge bg-warning">
                                            {{ stock_in_hand.total_gem_weight.yway }} ရွေး
                                        </span>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </v-card>
                    </v-col>
                </v-row>
                <v-row
                    class="float-right"
                    v-if="closeDay"
                >
                    <v-btn
                        depressed
                        color="primary"
                        @click="submit"
                    >
                        Close Day
                    </v-btn>

                </v-row>
            </v-container>
        </v-container>
    </v-app>
</template>

<script>
    import TotalCashInAmountComponent from './TotalCashInAmountComponent';
    import TotalCashOutAmountComponent from './TotalCashOutAmountComponent';
    import { Link } from '@inertiajs/inertia-vue'
    import axios from "axios";

    export default {
        name: "CashInAndStockInHandComponent",
        props: ["status"],
        components: {
            TotalCashInAmountComponent,
            TotalCashOutAmountComponent,
            Link
        },
        data: () => ({
            date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
            modal: false,
            cash_out_data:null,
            cash_in_data:null,
            stock_in_hand:null,
            checkbox_status_for_cash_in:false,
            checkbox_status_for_cash_out:false,
            checkbox_status_for_cash_in_hand:false,
            checkbox_status_for_stock_in_hand:false,

        }),
        mounted() {
            this.getData();
        },
        computed:{
            closeDay(){
                if(this.checkbox_status_for_cash_in && this.checkbox_status_for_cash_out && this.checkbox_status_for_cash_in_hand && this.checkbox_status_for_stock_in_hand)
                return true;
                else
                return false;
            },
            title() {
                if(this.status == "1") return "View Cash In Hand!";
                else return "Let Close Day!"
            },
            checkBoxShowStatus() {
                return this.status == '2'? true: false;
            },
            cashInHand() {
                return this.cash_in_data.total_cash_in_amount -  this.cash_out_data.total_cash_out_amount
            }

        },
        methods: {
            getData() {
                let getDataUrl = "";
                // if (this.status == 1) {
                //     getDataUrl = this.route('admin.cash-in-hands.getCashInHandByDate') + "&date=" + this.date;
                // } else {
                //     getDataUrl = this.route('admin.cash-in-hands.getCashInHandForCloseDay');
                // }

                if (this.status === 1) {
                    getDataUrl = `/admin/get-cash-in-hand-by-date?date=${this.selectedDate}`;
                } else {
                    getDataUrl = '/admin/get-cash-in-hand';
                }

                axios.get(getDataUrl).then(response => {
                    this.cash_in_data = response.data.cash_in_data;
                    this.cash_out_data = response.data.cash_out_data;
                    this.stock_in_hand = response.data.stock_in_hand;
                });
            },
            checkBoxActionCashIn(value) {
               this.checkbox_status_for_cash_in = value;
            },
            checkBoxActionCashOut(value) {
                this.checkbox_status_for_cash_out = value;
            },
            submit() {
                axios.post(
                    this.route('admin.closing-days.store'),
                        {
                            id:this.cash_in_data.open_close_day_id,
                            cashInHand:this.cashInHand
                        }
                    )
                    .then((response) => {
                        if(response.data.status)alert("success");
                    });
            }

        }
    }
</script>

