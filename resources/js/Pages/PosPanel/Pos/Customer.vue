<template>
    <v-col cols="12" sm="3">
        <v-hover v-slot="{ hover }" close-delay="200">
            <v-card
                :elevation="hover ? 16 : 2"
                :class="{ 'on-hover': hover }"
                flat
                class="mx-auto rounded-lg mx-3 no-print"
            >
                 <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="float-right">
                            <v-icon
                                color="info"
                                @click="addCustomer()"
                                v-text="'fas fa-plus'"
                            >
                            </v-icon>
                        </div>
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="images/pos/customer.jpg" alt="User profile picture">
                        </div>
                        <!-- Multiselect -->
                        <div class="text-center" >
                            <multiselect
                                v-model="selectedCustomer"
                                id="customer_id" placeholder="Search customer"
                                :options="customersList" name="name" label="search_name" track-by="id"
                                @search-change="onSearchCustomersChange"
                                @input="onSelectedCustomer"
                                :show-labels="false"
                                style="padding-left: 0px !important;"
                            />
                        </div>

                        <!-- Multiselect -->

                        <v-container v-if="customer != null">

                            <p class="text-muted text-center" style="font-size: 13px !important;" >{{customer.address}}</p>
                            <p class="text-muted text-center" style="font-size: 13px !important;">{{customer.mobile1}},{{customer.mobile2}}</p>


                            <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>ဝယ်ယူမှုများ</b> <a class="float-right">{{customer.total_amount}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>ကျန်ငွေ</b> <a class="float-right">500,000</a>
                            </li>
                            <li class="list-group-item">
                                <b>နောက်ဆုံးပေးငွေ</b> <a class="float-right">15,000</a>
                            </li>
                            </ul>

                            <a href="#" class="btn btn-primary btn-block" style="color: white !important;"><b>View Detail</b></a>

                        </v-container>

                    </div>
                <!-- /.card-body -->

                </div>

            </v-card>
        </v-hover>
        <!-- dialog box -->
        <v-dialog
            v-model="dialog"
            persistent
            max-width="600px"
            >
            <!-- <template v-slot:activator="{ on, attrs }">
                <v-btn
                color="primary"
                dark
                v-bind="attrs"
                v-on="on"
                >
                Open Dialog
                </v-btn>
            </template> -->
            <v-card>
                <v-card-title>
                <span class="text-h5">User Profile</span>
                </v-card-title>
                <v-card-text>
                <v-container>
                    <v-row>
                    <v-col
                        cols="12"
                        sm="6"
                        md="4"
                    >
                        <v-text-field
                        label="Legal first name*"
                        required
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="12"
                        sm="6"
                        md="4"
                    >
                        <v-text-field
                        label="Legal middle name"
                        hint="example of helper text only on focus"
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="12"
                        sm="6"
                        md="4"
                    >
                        <v-text-field
                        label="Legal last name*"
                        hint="example of persistent helper text"
                        persistent-hint
                        required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field
                        label="Email*"
                        required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field
                        label="Password*"
                        type="password"
                        required
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="12"
                        sm="6"
                    >
                        <v-select
                        :items="['0-17', '18-29', '30-54', '54+']"
                        label="Age*"
                        required
                        ></v-select>
                    </v-col>
                    <v-col
                        cols="12"
                        sm="6"
                    >
                        <v-autocomplete
                        :items="['Skiing', 'Ice hockey', 'Soccer', 'Basketball', 'Hockey', 'Reading', 'Writing', 'Coding', 'Basejump']"
                        label="Interests"
                        multiple
                        ></v-autocomplete>
                    </v-col>
                    </v-row>
                </v-container>
                <small>*indicates required field</small>
                </v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="blue darken-1"
                    text
                    @click="dialog = false"
                >
                    Close
                </v-btn>
                <v-btn
                    color="blue darken-1"
                    text
                    @click="dialog = false"
                >
                    Save
                </v-btn>
                </v-card-actions>
            </v-card>
            </v-dialog>

        <!-- end dialog box -->
    </v-col>

</template>

<script>
    import axios from "axios";
    import {mapGetters, mapActions} from "vuex";
    import Multiselect from 'vue-multiselect';
    import {throttle} from "lodash";

    export default {

        components: {
            Multiselect
        },
        data() {
            return {
                dialog: false,
                query: '',
                results: [],

                //multiselect
                customersList:[],
                selectedCustomer: undefined,

            };
        },
        created() {
            this.unwatch1 = this.$store.watch(
                (state, getters) => getters.customer,
                (newValue, oldValue) => {
                    this.customersList = [];
                    if(newValue == ""){
                        this.selectedCustomer = "";
                    }else{
                        this.selectedCustomer = newValue;
                        this.selectedCustomer.search_name = newValue.name;
                    }
                },
            );
        },
        methods: {
            ...mapActions(["setCustomer"]),
            onSearchCustomersChange: throttle(function (search_value) {
                axios.get(this.route("pos.customer_search"),{params: {search_value: search_value}})
                    .then(response => {
                        this.customersList = response.data.data;
                });
            }, 300),

            onSelectedCustomer(customer) {
                this.selectedCustomer.search_name = customer.name;
                this.setCustomer(customer);
            },
            addCustomer() {
                this.dialog = true;
            }
        },
        computed: {
        ...mapGetters(['customer']),

        },
        beforeDestroy() {
            this.unwatch1();
        },
    };
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
    .multiselect__content {
        padding-left: 0px !important;
    }
</style>
