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

                                <div class="ml-auto p-2">
                                    <input
                                        v-model.lazy="search"
                                        type="search"
                                        class="form-control"
                                        placeholder="Search by ..."
                                    />
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>
                                                <a href="#"
                                                    >Name</a
                                                >
                                            </th>
                                            <th>
                                                <a href="#" @click.prevent="change_sort('mobile')"
                                                    >Mobile</a
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'desc' &&
                                                            sort_field == 'mobile'
                                                    "
                                                    >&uarr;</span
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'asc' &&
                                                            sort_field == 'mobile'
                                                    "
                                                    >&darr;</span
                                                >
                                            </th>
                                            <th>
                                                <a href="#" @click.prevent="change_sort('address')"
                                                    >Address</a
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'desc' &&
                                                            sort_field == 'address'
                                                    "
                                                    >&uarr;</span
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'asc' &&
                                                            sort_field == 'address'
                                                    "
                                                    >&darr;</span
                                                >
                                            </th>
                                            <th>
                                                <a href="#" @click.prevent="change_sort('debt_paid_money')"
                                                    >စုစုပေါင်းအကြွေး</a
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'desc' &&
                                                            sort_field == 'debt_paid_money'
                                                    "
                                                    >&uarr;</span
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'asc' &&
                                                            sort_field == 'debt_paid_money'
                                                    "
                                                    >&darr;</span
                                                >
                                            </th>
                                            <th>Action</th>
                                        </tr>

                                        <tr
                                            v-for="(debtPaymentList, index) in debtPaymentLists.data"
                                            :key="index"
                                        >
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ debtPaymentList.name }}</td>
                                            <td>{{ debtPaymentList.mobile }}</td>
                                            <td>{{ debtPaymentList.address }}</td>
                                            <td>{{ debtPaymentList.remaining_credit_money }}</td>
                                            <td>{{ debtPaymentList.created_at }}</td>
                                            <td>
                                                <button
                                                    onclick="confirm('Are you sure you wanna delete this Record?') || event.stopImmediatePropagation()"
                                                    class="btn btn-sm"
                                                    @click="deleteRecord(debtPaymentList.id)"
                                                >
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="btn btn-warrning btn-sm"
                                                    @click="editRecord(debtPaymentList.id)"
                                                >
                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                </button>

                                                <Link :href="route('admin.debt-payment-from-customers.show',debtPaymentList.id)">
                                                    <button class="btn btn-warrning btn-sm">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
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
                                        :data="debtPaymentLists"
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
                debtPaymentLists: {},
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
            onChangeCustomer() {
                if(this.customer != null)this.customer_id = this.customer.id;
                else this.customer_id = '';
                this.getData();
            },
            change_sort(field) {
                if (this.sort_field == field) {
                    this.sort_direction =
                        this.sort_direction == "asc" ? "desc" : "asc";
                } else {
                    this.sort_field = field;
                }
                this.getData();
            },
            getData(page = 1) {
                const type = "debt_payment_from_customer";
                let getDataUrlWithoutPagination =
                    "/admin/get-debt-payment-lists?" +
                    "q=" +
                    this.search +
                    "&sort_direction=" +
                    this.sort_direction +
                    "&sort_field=" +
                    this.sort_field +
                    "&selectedContact=" +
                    this.customer_id +
                    "&startDate=" +
                    this.startDate +
                    "&endDate=" +
                    this.endDate +
                    "&type=" +
                    type;

                const getDataUrl = getDataUrlWithoutPagination.concat(
                    "&paginate=" + this.paginate + "&page=" + page
                );
                axios.get(getDataUrl).then(response => {
                    this.debtPaymentLists = response.data;
                });
            }
        },

        mounted() {
            let type = "debt_payment_from_customer";
            axios.get(this.route("admin.getCustomerLists"), { params: {type: type}})
                .then((response) => {
                    console.log(response.data);
                    this.customers = response.data.data;
            });
            this.getData();
        }
    };
</script>
