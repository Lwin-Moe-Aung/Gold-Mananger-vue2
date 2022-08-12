<template>
    <div>
        <admin-layout>
            <div class="d-flex justify-content-between p-3">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    DebtPaymentFromCustomer
                </h2>
                <Link :href="route('admin.debt-payment-from-customers.create')">
                    <button type="button" class="btn btn-info text-white text-uppercase" style="letter-spacing: 0.1em;">
                        Create
                    </button>
                </Link>
            </div>
            <section class="content">
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
                                <div class="ml-2 p-2">
                                    <select
                                        v-model="selectedCustomer"
                                        class="form-control form-control-sm"
                                    >
                                        <option value="">All Customer</option>
                                    </select>
                                </div>
                                <div class="ml-2 p-2">
                                    <Datepicker
                                        v-model="range"
                                        lang="en"
                                        range type="date"
                                        format="YYYY-MM-DD"
                                        width="350"
                                        placeholder ="Select date"
                                    ></Datepicker >
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
                                            <td>{{ debtPaymentList.debt_paid_money }}</td>
                                            <td>{{ debtPaymentList.remaining_credit_money }}</td>
                                            <td>{{ debtPaymentList.created_at }}</td>
                                            <td>
                                                <button
                                                    onclick="confirm('Are you sure you wanna delete this Record?') || event.stopImmediatePropagation()"
                                                    class="btn btn-danger btn-sm"
                                                    @click="deleteSingleRecord(debtPaymentList.id)"
                                                >
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-sm-6 offset-5">
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
    import Pagination from '../../../../Components/AdminPanel/Pagination';
    import ContactAutoCompleteSearchComponent from '../../../../Components/AdminPanel/ContactAutoCompleteSearchComponent';
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
            Pagination,
            Link,
            ContactAutoCompleteSearchComponent,
            Datepicker
        },
        data() {
            return {
                debtPaymentLists: {},
                paginate: 10,
                search: '',
                selectedCustomer: '',
                sort_direction: "desc",
                sort_field: "created_at",
                url: '',
                getDataUrl: '',
                getDataUrlWithoutPadination: '',
                range:'',
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

            change_sort(field) {
                if (this.sort_field == field) {
                    this.sort_direction =
                        this.sort_direction == "asc" ? "desc" : "asc";
                } else {
                    this.sort_field = field;
                }
                this.getData();
            },
            deleteSingleRecord(student_id) {
                axios.delete("/api/student/delete/" + student_id).then(response => {
                    this.checked = this.checked.filter(id => id != student_id);
                    this.$toast.success("Student Deleted Successfully");
                    this.getData();
                });
            },
            deleteRecords() {
                axios
                    .delete("/api/students/massDestroy/" + this.checked)
                    .then(response => {
                        if (response.status == 204) {
                            this.$toast.success(
                                "Selected Students were Deleted Successfully"
                            );
                            this.checked = [];
                            this.getData();
                        }
                    });
            },
            isChecked(student_id) {
                return this.checked.includes(student_id);
            },
            getData(page = 1) {
                this.getDataUrlWithoutPadination =
                    "/admin/get-debt-payment-lists?" +
                    "q=" +
                    this.search +
                    "&sort_direction=" +
                    this.sort_direction +
                    "&sort_field=" +
                    this.sort_field +
                    "&selectedCustomer=" +
                    this.selectedCustomer;

                this.getDataUrl = this.getDataUrlWithoutPadination.concat(
                    "&paginate=" + this.paginate + "&page=" + page
                );
                axios.get(this.getDataUrl).then(response => {
                    this.debtPaymentLists = response.data;
                });
            }
        },

        mounted() {
            // axios.get("/api/classes").then(response => {
            //     this.classes = response.data.data;
            // });
            this.getData();
        }
    };
</script>
