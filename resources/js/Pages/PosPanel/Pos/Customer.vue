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
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="images/pos/customer.jpg" alt="User profile picture">
                        </div>

                       <!-- autocomplete -->
                        <!-- <div>
                            <input
                                placeholder="Search"
                                v-model="query"
                                v-on:keyup="autoComplete"
                                class="form-control">

                                <div class="panel-footer"
                                    v-if="results.length"
                                    style="position:relative !important; z-index: 1000; border: 1px solid #ccc; background: #fff;"

                                >

                                    <ul class="list-group" v-for="result in results" style="padding-left: 0px !important;">
                                        <li class="list-group-item" style="font-size: 13px !important;"
                                            @click="setCustomer(result)"
                                        >
                                        {{ result.search_name }}
                                        </li>
                                    </ul>
                                </div>
                        </div> -->
                       <!-- end autocomplete -->
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
                    this.customersList = [],
                    this.selectedCustomer.search_name = newValue.name
                },
            );
        },
        methods: {
            ...mapActions(["setCustomer"]),
            // autoComplete(){
            //     this.results = [];
            //     if(this.query.length > 2){
            //         axios.get(this.route("pos.customer_search"),{params: {search_value: this.query}}).then(response => {
            //             this.results = response.data.data;
            //         });
            //     }
            // },
            onSearchCustomersChange: throttle(function (search_value) {
                axios.get(this.route("pos.customer_search"),{params: {search_value: search_value}})
                    .then(response => {
                        this.customersList = response.data.data;
                });
            }, 300),

            onSelectedCustomer(customer) {
                this.selectedCustomer.search_name = customer.name;
                this.setCustomer(customer);
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
