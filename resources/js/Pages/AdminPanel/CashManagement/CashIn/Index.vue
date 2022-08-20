<template>
    <div>
        <admin-layout>
            <div class="d-flex justify-content-between p-3">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Cash In Data Lists
                </h2>
                <Link :href="route('admin.debt-payment-from-customers.create')">
                    <button type="button" class="btn btn-info text-white text-uppercase" style="letter-spacing: 0.1em;">
                        Create
                    </button>
                </Link>
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
                                    <div class="form-group">
                                        <select class="form-control" v-model="selectedType">
                                            <option value='all'>All</option>
                                            <option value='sell'>Sell</option>
                                            <option value='debt_payment_from_customer'>customer ဆပ်ငွေ</option>
                                            <option value='purchase'>supplierကိုပေးရန်အကြွေး</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="ml-2 p-1" v-if="selectedType == 'sell' || selectedType == 'debt_payment_from_customer'">
                                    <multiselect
                                        v-model="customer"
                                        :options="customers"
                                        @search-change="onSearchDataChange"
                                        @input="onSelectedData"
                                        label="search_name"
                                        track-by="id"
                                        id="id"
                                        placeholder="Search Customer"
                                    >
                                    </multiselect>
                                </div>
                                <div class="ml-2 p-1" v-if="selectedType == 'purchase'">
                                    <multiselect
                                        v-model="supplier"
                                        :options="suppliers"
                                        @search-change="onSearchDataChange"
                                        @input="onSelectedData"
                                        label="search_name"
                                        track-by="id"
                                        id="id"
                                        placeholder="Search Supplier"
                                    >
                                    </multiselect>
                                </div>
                                <div class="ml-2 p-2">
                                    <Datepicker
                                        v-model="dateRange"
                                        lang="en"
                                        range type="date"
                                        @input="inputDatepicker"
                                        format="YYYY-MM-DD"
                                        width="350"
                                        placeholder ="Select date"
                                        confirm
                                    ></Datepicker>
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
                                                <a href="#" @click.prevent="change_sort('name')"
                                                    >Name</a
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'desc' &&
                                                            sort_field == 'name'
                                                    "
                                                    >&uarr;</span
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'asc' &&
                                                            sort_field == 'name'
                                                    "
                                                    >&darr;</span
                                                >
                                            </th>
                                            <th>
                                                <a href="#" @click.prevent="change_sort('mobile1')"
                                                    >Mobile</a
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'desc' &&
                                                            sort_field == 'mobile1'
                                                    "
                                                    >&uarr;</span
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'asc' &&
                                                            sort_field == 'mobile1'
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
                                                <a href="#" @click.prevent="change_sort('invoice_no')"
                                                    >Invoice No</a
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'desc' &&
                                                            sort_field == 'invoice_no'
                                                    "
                                                    >&uarr;</span
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'asc' &&
                                                            sort_field == 'invoice_no'
                                                    "
                                                    >&darr;</span
                                                >
                                            </th>
                                            <th>
                                                <a href="#" @click.prevent="change_sort('type')"
                                                    >Type</a
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'desc' &&
                                                            sort_field == 'type'
                                                    "
                                                    >&uarr;</span
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'asc' &&
                                                            sort_field == 'type'
                                                    "
                                                    >&darr;</span
                                                >
                                            </th>
                                            <th>
                                                <a href="#" @click.prevent="change_sort('amount')"
                                                    >Amount</a
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'desc' &&
                                                            sort_field == 'amount'
                                                    "
                                                    >&uarr;</span
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'asc' &&
                                                            sort_field == 'amount'
                                                    "
                                                    >&darr;</span
                                                >
                                            </th>
                                            <th>
                                                <a
                                                    href="#"
                                                    @click.prevent="change_sort('created_at')"
                                                    >Date</a
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'desc' &&
                                                            sort_field == 'created_at'
                                                    "
                                                    >&uarr;</span
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'asc' &&
                                                            sort_field == 'created_at'
                                                    "
                                                    >&darr;</span
                                                >
                                            </th>
                                            <th>Action</th>
                                        </tr>

                                        <tr
                                            v-for="(cashInDataList, index) in cashInDataLists.data"
                                            :key="index"
                                        >
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ cashInDataList.name }}</td>
                                            <td>{{ cashInDataList.mobile }}</td>
                                            <td>{{ cashInDataList.address }}</td>
                                            <td>{{ cashInDataList.invoice_no}}</td>
                                            <td>{{ cashInDataList.type }}</td>

                                            <td><span class="badge badge-pill bg-warning">{{ numberWithCommas(cashInDataList.amount) }}</span></td>
                                            <td>{{ cashInDataList.created_at }}</td>
                                            <td>
                                                <!-- <Link :href="route('admin.debt-payment-from-customers.show',cashInDataList.id)">
                                                    <button class="btn btn-warrning btn-sm">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                </Link> -->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-sm-6 offset-5 float-right">
                                    <pagination
                                        :data="cashInDataLists"
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
    import ContactAutoCompleteSearchComponent from '../../../../Components/AdminPanel/ContactAutoCompleteSearchComponent';
    import {throttle} from "lodash";

    export default {
        props: [
            'transactions',
            'filters',
            ],
        components: {
            AdminLayout,
            Link,
            Datepicker,
            ContactAutoCompleteSearchComponent
        },
        data() {
            return {
                selectedType:'all',
                cashInDataLists: {},
                paginate: 10,
                search: '',

                contact_id:'',
                customer:null,
                customers:[],
                suppliers:[],
                supplier:null,

                sort_direction: "desc",
                sort_field: "created_at",
                dateRange:'',
                startDate:'',
                endDate:'',
                route_name:'pos.contact_search',
                type:null,
            };
        },

        watch: {
            paginate: function(value) {
                this.getData();
            },
            search: function(value) {
                this.getData();
            },
            selectedType(val) {
                if(val == 'sell' || val == 'debt_payment_from_customer') this.type = 'customer';
                else if(val == 'purchase') this.type = 'supplier';
                this.contact_id = ''
                this.customer = null
                this.supplier = null
                this.getData();
            }
        },

        methods: {
            numberWithCommas(x) {
                let v = parseInt(x);
                return v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            },
            onSelectedData(value) {
                if(value != null)this.contact_id = value.id;
                else this.contact_id = '';

                this.getData();
            },
            onSearchDataChange: throttle(function (term) {
                axios.get(this.route(this.route_name), { params: { term: term ,type: this.type}})
                            .then((response) => {
                                if(this.type == 'customer') this.customers = response.data.data;
                                else this.suppliers = response.data.data;
                        });
            }, 300),

            inputDatepicker() {
                if(this.dateRange[0] != null){
                    this.startDate = moment(this.dateRange[0]).format('YYYY-MM-DD');
                    this.endDate = moment(this.dateRange[1]).format('YYYY-MM-DD');
                }else{
                    this.startDate = '';
                    this.endDate = '';
                }
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
                let getDataUrlWithoutPagination =
                    "/admin/get-cash-in-data-lists?" +
                    "q=" +
                    this.search +
                    "&sort_direction=" +
                    this.sort_direction +
                    "&sort_field=" +
                    this.sort_field +
                    "&selectedType=" +
                    this.selectedType +
                    "&contact_id=" +
                    this.contact_id +
                    "&startDate=" +
                    this.startDate +
                    "&endDate=" +
                    this.endDate;

                const getDataUrl = getDataUrlWithoutPagination.concat(
                    "&paginate=" + this.paginate + "&page=" + page
                );
                axios.get(getDataUrl).then(response => {
                    this.cashInDataLists = response.data;
                });
            }
        },

        mounted() {
            axios.get(this.route(this.route_name), { params: {type: 'customer'}})
                .then((response) => {
                    this.customers = response.data.data;
            });
            axios.get(this.route(this.route_name), { params: {type: 'supplier'}})
                .then((response) => {
                    this.suppliers = response.data.data;
            });
            this.getData();
        }
    };
</script>
