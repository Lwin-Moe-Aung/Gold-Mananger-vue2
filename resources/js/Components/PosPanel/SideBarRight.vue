<template>
    <v-navigation-drawer app color="white" right width="290">
        <v-list subheader two-line class="mt-1">
            <v-list-item>
                <v-list-item-avatar rounded>
                    <v-img src="images/pos/cashier.jpg"></v-img>
                </v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-subtitle>I'm a Cashier</v-list-item-subtitle>
                    <v-list-item-title>Lwin Moe Aung</v-list-item-title>
                </v-list-item-content>
                <v-list-item-action>
                    <v-badge bordered overlap color="red" dot>
                        <v-icon>far fa-bell</v-icon>
                    </v-badge>
                </v-list-item-action>
            </v-list-item>
        </v-list>
        <strong class="ml-3">Bills</strong>
        <v-list
            subheader
            two-line
            class="mt-1"
            v-for="(item, index) in carts"
            :key="item.id"
            :index="index"
        >
            <v-list-item>
                <v-list-item-avatar rounded color="grey lighten-4">
                    <v-img :src="item.image1"></v-img>
                </v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title class="subtitle-2">{{
                        item.name
                    }}</v-list-item-title>
                    <v-list-item-subtitle
                        >X1
                        <v-btn plain color="#704232" small
                            @click="editItemFromCart(item)"
                            >Edit

                        </v-btn>

                        <v-btn plain color="#704232" small
                            @click="removeItemFromCart(item.id)"
                            >Delete
                            <!-- <v-icon right>mdi-pencil</v-icon> -->
                        </v-btn>



                    </v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action class="caption">{{item.final_total}}</v-list-item-action>
            </v-list-item>
        </v-list>

        <v-toolbar color="rgba(0,0,0,0)" flat>
            <strong>Subtotal</strong><v-spacer></v-spacer
            ><strong>{{ subTotal }}</strong>
        </v-toolbar>
        <v-toolbar color="rgba(0,0,0,0)" flat class="mt-n6">
            <span>Tax(10%)</span><v-spacer></v-spacer><span></span>
        </v-toolbar>
        <v-divider class="mx-4"></v-divider>
        <v-toolbar color="rgba(0,0,0,0)" flat>
            <strong>Total</strong><v-spacer></v-spacer
            ><strong>{{ subTotal }}</strong>
        </v-toolbar>
        <strong class="ml-5">Payment Method</strong>
        <v-item-group mandatory class="mt-n1">
            <v-container>
                <v-row justify="center">
                    <v-col cols="12" md="4">
                        <v-item v-slot="{ active, toggle }">
                            <v-card
                                color="#F6EFEF"
                                :class="active ? 'borderme' : ''"
                                class="d-flex align-center rounded-lg"
                                dark
                                height="70"
                                @click="toggle"
                                flat
                            >
                                <v-row>
                                    <v-col cols="12" md="12">
                                        <v-list-item
                                            three-line
                                            class="text-center mt-1"
                                        >
                                            <v-list-item-content>
                                                <div>
                                                    <v-icon
                                                        :color="
                                                            active
                                                                ? '#ECBD00'
                                                                : 'black'
                                                        "
                                                        >fas
                                                        fa-money-bill-wave</v-icon
                                                    >
                                                </div>
                                                <v-list-item-subtitle
                                                    :class="
                                                        active
                                                            ? 'brown--text'
                                                            : 'black--text'
                                                    "
                                                    class="mt-n2 caption"
                                                    >Cach</v-list-item-subtitle
                                                >
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-col>
                                </v-row>
                            </v-card>
                        </v-item>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-item v-slot="{ active, toggle }">
                            <v-card
                                color="#F6EFEF"
                                :class="active ? 'borderme' : ''"
                                class="d-flex align-center rounded-lg"
                                dark
                                height="70"
                                @click="toggle"
                                flat
                            >
                                <v-row>
                                    <v-col cols="12" md="12">
                                        <v-list-item
                                            three-line
                                            class="text-center mt-1"
                                        >
                                            <v-list-item-content>
                                                <div>
                                                    <v-icon
                                                        :color="
                                                            active
                                                                ? '#ECBD00'
                                                                : 'black'
                                                        "
                                                        >fas
                                                        fa-credit-card</v-icon
                                                    >
                                                </div>
                                                <v-list-item-subtitle
                                                    :class="
                                                        active
                                                            ? 'brown--text'
                                                            : 'black--text'
                                                    "
                                                    class="mt-n2 caption"
                                                    >debit
                                                    Card</v-list-item-subtitle
                                                >
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-col>
                                </v-row>
                            </v-card>
                        </v-item>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-item v-slot="{ active, toggle }">
                            <v-card
                                color="#F6EFEF"
                                :class="active ? 'borderme' : ''"
                                class="d-flex align-center rounded-lg"
                                dark
                                height="70"
                                @click="toggle"
                                flat
                            >
                                <v-row>
                                    <v-col cols="12" md="12">
                                        <v-list-item
                                            three-line
                                            class="text-center mt-1"
                                        >
                                            <v-list-item-content>
                                                <div>
                                                    <v-icon
                                                        :color="
                                                            active
                                                                ? '#ECBD00'
                                                                : 'black'
                                                        "
                                                        >fas fa-qrcode</v-icon
                                                    >
                                                </div>
                                                <v-list-item-subtitle
                                                    :class="
                                                        active
                                                            ? 'brown--text'
                                                            : 'black--text'
                                                    "
                                                    class="mt-n2 caption"
                                                    >E-Wallet</v-list-item-subtitle
                                                >
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-col>
                                </v-row>
                            </v-card>
                        </v-item>
                    </v-col>
                </v-row>
            </v-container>
        </v-item-group>
        <div class="mx-3 mt-2">
            <v-btn
                color="#ECBD00"
                block
                dark
                class="widthoutupercase black--text"
                @click="printAllBill"
                >Print Bills</v-btn
            >
        </div>
    </v-navigation-drawer>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            total: "",
        };
    },
    computed: {
        carts() {
            return this.$store.state.carts;
        },
        subTotal() {
            let total = 0;
            this.$store.state.carts.forEach((item) => {
                total = total + parseInt(item.final_total);
                // alert(parseInt(item.total_after));
            });
            return total;
        },
    },
    methods: {
        editItemFromCart(item) {
            this.$store.dispatch("editItem", item);
        },
        removeItemFromCart(item_id) {
            this.$store.dispatch("removeItem", item_id);
        },
        printAllBill() {
            this.$store.state.carts.forEach((item) => {
                let data = new FormData();
                data.append('id',item.id);
                data.append('name',item.name);
                data.append('product_sku',item.product_sku);
                data.append('image',item.image);
                data.append('imageFile',item.imageFile);
                data.append('item_sku',item.item_sku);
                data.append('gold_weight',JSON.stringify(item.gold_weight));
                data.append('gold_price',item.gold_price);
                data.append('gem_weight',JSON.stringify(item.gem_weight));
                data.append('gem_price',item.gem_price);
                data.append('fee',JSON.stringify(item.fee));
                data.append('fee_price',item.fee_price);
                data.append('fee_for_making',item.fee_for_making);
                data.append('item_discount',item.item_discount);
                data.append('total_kyat',item.total_kyat);
                data.append('total_pal',item.total_pal);
                data.append('total_yway',item.total_yway);
                data.append('total_before',item.total_before);
                data.append('final_total',item.final_total);
                data.append('paid_money',item.paid_money);
                data.append('credit_money',item.credit_money);
                data.append('note',item.note);

                axios.post('/pos/save_order', data)
                    .then(res => {
                        if(res.data.status)
                        {
                            window.open( "http://localhost:8000/pos/generate_invoice/"+res.data.order_id, "_blank");
                            // this.$inertia.get(`/pos/generate_invoice`,{ order_id: res.data.order_id });
                            Toast.fire({
                                icon: 'success',
                                title: 'Order Success'
                            })
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            });
        }
    }
};
</script>

<style>
.v-card.borderme {
    /* border:2px solid #704232 !important; */
    border: 2px solid #ecbd00 !important;
}
.col-12 {
    padding: 5px !important;
}
.v-btn.widthoutupercase {
    text-transform: none !important;
}
</style>
