<template>
    <div>
        <admin-layout>
            <div class="d-flex justify-content-between p-3">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Debt To Get From Customer
                </h2>
            </div>
            <section class="content" data-app>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="d-flex p-2">
                                <div class="p-2">
                                    <div class="d-flex align-items-center ml-1">
                                        <label for="paginate" class="text-nowrap mb-0"
                                            >Per Page</label
                                        >
                                        <select
                                            v-model="paginate"
                                            class="form-control form-control-sm"
                                        >
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="ml-2 p-1">
                                    <v-combobox
                                        v-model="customer"
                                        :items="customers"
                                        @change="onChangeCustomer"
                                        item-text="name"
                                        item-value="id"
                                        return-object
                                        label="Select Customer"
                                        clearable
                                        dense
                                        hide-selected
                                        solo
                                    ></v-combobox>
                                </div>


                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>
                                                <a href="#">Name</a>
                                            </th>
                                            <th>
                                               <a href="#">Mobile</a>
                                            </th>
                                            <th>
                                                <a href="#">Address</a>
                                            </th>
                                            <th>
                                                <a href="#">စုစုပေါင်းအကြွေး</a>
                                            </th>
                                            <th>Action</th>
                                        </tr>

                                        <tr
                                            v-for="(creditCustomerList, index) in creditCustomerLists.data"
                                            :key="index"
                                        >
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ creditCustomerList.name }}</td>
                                            <td>{{ creditCustomerList.mobile }}</td>
                                            <td>{{ creditCustomerList.address }}</td>
                                            <td><span class="badge bg-warning">{{ numberWithCommas(creditCustomerList.total_credit_money) }}</span></td>
                                            <td>
                                                <Link :href="route('admin.createDebtPaymentFromCustomerWithContactId', { contact_id: creditCustomerList.contact_id })">
                                                    <button class="btn btn-warrning btn-sm">
                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                    </button>
                                                </Link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-sm-6 offset-5 float-right">
                                    <pagination
                                        :data="creditCustomerLists"
                                        @pagination-change-page="getData"
                                    ></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </admin-layout>
    </div>
</template>


<script>
    import AdminLayout from '../../../../Layouts/AdminPanelLayout';
    import moment from 'moment';
    import { Link } from '@inertiajs/inertia-vue';
    import 'vue2-datepicker/index.css';
    import Datepicker from 'vue2-datepicker';
    import axios from "axios";
    // import Datepicker from 'vuejs-datepicker';


    export default {
        props: [
            'transactions',
            'filters',
            ],
        components: {
            AdminLayout,
            Link,
            Datepicker
        },
        data() {
            return {
                creditCustomerLists: {},
                paginate: 10,
                search: '',
                customer:null,
                customer_id:'',
                customers: [],
                sort_direction: "desc",
                sort_field: "created_at",
            };
        },

        watch: {
            paginate: function(value) {
                this.getData();
            },
            search: function(value) {
                this.getData();
            },
        },

        methods: {
            numberWithCommas(x) {
                let v = parseInt(x);
                return v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            },
            onChangeCustomer() {
                if(this.customer != null)this.customer_id = this.customer.id;
                else this.customer_id = '';
                this.getData();
            },
            getData(page = 1) {
                const type = "sell";
                let getDataUrlWithoutPagination =
                    "/admin/get-customers-data-who-have-credits?" +
                    "selectedContact=" +
                    this.customer_id +
                    "&type=" +
                    type;

                const getDataUrl = getDataUrlWithoutPagination.concat(
                    "&paginate=" + this.paginate + "&page=" + page
                );
                axios.get(getDataUrl).then(response => {
                    this.creditCustomerLists = response.data;
                });
            }
        },

        mounted() {
            let type = "sell";
            axios.get(this.route("admin.getRemainCreditCustomerLists"), { params: {type: type}})
                .then((response) => {
                    console.log(response.data);
                    this.customers = response.data.data;
            });
            this.getData();
        }
    };
</script>
