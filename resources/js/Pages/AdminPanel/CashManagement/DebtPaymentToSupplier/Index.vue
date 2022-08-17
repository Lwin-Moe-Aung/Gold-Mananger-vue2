<template>
    <div>
        <admin-layout>
            <div class="d-flex justify-content-between p-3">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    DebtPaymentToSupplier
                </h2>
                <Link :href="route('admin.debt-payment-to-suppliers.create')">
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
                                    <v-combobox
                                        v-model="supplier"
                                        :items="suppliers"
                                        @change="onChangeSupplier"
                                        item-text="name"
                                        item-value="id"
                                        return-object
                                        label="Select Supplier"
                                        clearable
                                        dense
                                        hide-selected
                                        solo
                                    ></v-combobox>
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
                                                <a href="#"
                                                    >Name</a
                                                >
                                            </th>
                                            <th>
                                                <a href="#" @click.prevent="change_sort('mobile')"
                                                    >Mobile</a
                                                >
                                            </th>
                                            <th>
                                                <a href="#" @click.prevent="change_sort('debt_paid_money')"
                                                    >စုစုပေါင်းဆပ့်ငွေ</a
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
                                            <th>
                                                <a href="#" @click.prevent="change_sort('remaining_credit_money')"
                                                    >ဆပ့်ရန်ကျန်ငွေ</a
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'desc' &&
                                                            sort_field == 'remaining_credit_money'
                                                    "
                                                    >&uarr;</span
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'asc' &&
                                                            sort_field == 'remaining_credit_money'
                                                    "
                                                    >&darr;</span
                                                >
                                            </th>
                                            <th>
                                                <a
                                                    href="#"
                                                    @click.prevent="change_sort('created_at')"
                                                    >Created At</a
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
                                            v-for="(debtPaymentList, index) in debtPaymentLists.data"
                                            :key="index"
                                        >
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ debtPaymentList.name }}</td>
                                            <td>{{ debtPaymentList.mobile }}</td>
                                            <td><span class="badge badge-pill bg-warning">{{ numberWithCommas(debtPaymentList.debt_paid_money) }}</span></td>
                                            <!-- <td>{{ debtPaymentList.debt_paid_money }}</td> -->
                                            <td><span class="badge badge-pill bg-warning">{{ numberWithCommas(debtPaymentList.remaining_credit_money) }}</span></td>
                                            <!-- <td>{{ debtPaymentList.remaining_credit_money }}</td> -->
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

                                                <Link :href="route('admin.debt-payment-to-suppliers.show',debtPaymentList.id)">
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
                supplier:null,
                supplier_id:'',
                suppliers: [],
                sort_direction: "desc",
                sort_field: "created_at",
                dateRange:'',
                startDate:'',
                endDate:'',
            };
        },
        watch: {
            paginate: function(value) {
                this.getData();
            },
            search: function(value) {
                this.getData();
            },
            model (val) {
                if (val.length > 5) {
                this.$nextTick(() => this.model.pop())
                }
            },
        },
        methods: {
            numberWithCommas(x) {
                let v = parseInt(x);
                return v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            },
            onChangeSupplier() {
                if(this.supplier != null)this.supplier_id = this.supplier.id;
                else this.supplier_id = '';
                this.getData();
            },
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
                const type = "debt_payment_to_supplier";
                let getDataUrlWithoutPagination =
                    "/admin/get-debt-payment-lists?" +
                    "q=" +
                    this.search +
                    "&sort_direction=" +
                    this.sort_direction +
                    "&sort_field=" +
                    this.sort_field +
                    "&selectedContact=" +
                    this.supplier_id +
                    "&startDate=" +
                    this.startDate +
                    "&endDate=" +
                    this.endDate +
                    "&type=" +
                    type;

                let getDataUrl = getDataUrlWithoutPagination.concat(
                    "&paginate=" + this.paginate + "&page=" + page
                );
                axios.get(getDataUrl).then(response => {
                    this.debtPaymentLists = response.data;
                });
            }
        },

        mounted() {
            let type = "debt_payment_to_supplier";
            axios.get(this.route("admin.getCustomerLists"), { params: {type: type}})
                .then((response) => {
                    this.suppliers = response.data.data;
            });
            this.getData();
        }
    };
</script>
