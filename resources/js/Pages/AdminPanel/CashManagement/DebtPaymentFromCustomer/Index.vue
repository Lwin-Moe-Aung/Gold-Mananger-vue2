<template>
    <div>
        <admin-layout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    DebtPaymentFromCustomer
                </h2>
            </template>
            <section class="content">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-content-center mb-2">
                        <div class="d-flex">
                            <div>
                                <div class="d-flex align-items-center ml-4">
                                    <label for="paginate" class="text-nowrap mr-2 mb-0"
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
                            <div>
                                <div class="d-flex align-items-center ml-4">
                                    <label for="paginate" class="text-nowrap mr-2 mb-0"
                                        >FilterBy Customer</label
                                    >
                                    <select
                                        v-model="selectedCustomer"
                                        class="form-control form-control-sm"
                                    >
                                        <option value="">All Customer</option>
                                        <option
                                            v-for="item in classes"
                                            :key="item.id"
                                            :value="item.id"
                                        >
                                            {{ item.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <input
                                v-model.lazy="search"
                                type="search"
                                class="form-control"
                                placeholder="Search by name,total_debt_payment,phone,or remaining_credit..."
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
                                        <a href="#" @click.prevent="change_sort('total_debt_payment')"
                                            >စုစုပေါင်းဆပ့်ငွေ</a
                                        >
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                    sort_field == 'total_debt_payment'
                                            "
                                            >&uarr;</span
                                        >
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                    sort_field == 'total_debt_payment'
                                            "
                                            >&darr;</span
                                        >
                                    </th>
                                    <th>
                                        <a href="#" @click.prevent="change_sort('remaining_credit')"
                                            >ဆပ့်ရန်ကျန်ငွေ</a
                                        >
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                    sort_field == 'remaining_credit'
                                            "
                                            >&uarr;</span
                                        >
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                    sort_field == 'remaining_credit'
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
                                    v-for="(student, index) in debtPaymentLists.data"
                                    :key="index"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ student.name }}</td>
                                    <td>{{ student.total_debt_payment }}</td>
                                    <td>{{ student.remaining_credit }}</td>
                                    <td>{{ student.created_at }}</td>
                                    <td>
                                        <button
                                            onclick="confirm('Are you sure you wanna delete this Record?') || event.stopImmediatePropagation()"
                                            class="btn btn-danger btn-sm"
                                            @click="deleteSingleRecord(student.id)"
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
            </section>
        </admin-layout>
    </div>
</template>


<script>
    import AdminLayout from '../../../../Layouts/AdminPanelLayout';
    import moment from 'moment';
    import Pagination from '../../../../Components/AdminPanel/Pagination';
    import ContactAutoCompleteSearchComponent from '../../../../Components/AdminPanel/ContactAutoCompleteSearchComponent';
    import { pickBy, throttle } from 'lodash';
    import { Link } from '@inertiajs/inertia-vue';
    import Datepicker from 'vuejs-datepicker';
    import axios from "axios";

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
                search: "",
                classes: {},
                selectedCustomer: "",
                selectedSection: "",
                sections: {},
                checked: [],
                selectPage: false,
                selectAll: false,
                sort_direction: "desc",
                sort_field: "created_at",
                url: "",
                getStudentsUrl: "",
                getStudentsUrlWithoutPaginate: ""
            };
        },

        watch: {
            paginate: function(value) {
                this.getData();
            },
            search: function(value) {
                this.getData();
            },
            selectedCustomer: function(value) {
                this.selectedSection = "";
                axios
                    .get("/api/sections?class_id=" + this.selectedCustomer)
                    .then(response => {
                        this.sections = response.data.data;
                    });
                this.getData();
            },
            selectedSection: function(value) {
                this.getData();
            },
            selectPage: function(value) {
                this.checked = [];
                if (value) {
                    this.students.data.forEach(student => {
                        this.checked.push(student.id);
                    });
                } else {
                    this.checked = [];
                    this.selectAll = false;
                }
            },
            checked: function(value) {
                this.url = "/api/students/export/" + this.checked;
            }
        },

        methods: {
            selectAllRecords() {
                axios.get(this.getStudentsUrlWithoutPaginate).then(response => {
                    // console.log(response.data);
                    this.checked = [];
                    response.data.data.forEach(student => {
                        this.checked.push(student.id);
                    });
                    this.selectAll = true;
                });
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
                this.getStudentsUrlWithoutPaginate =
                    "/admin/get-debt-payment-lists?" +
                    "q=" +
                    this.search +
                    "&sort_direction=" +
                    this.sort_direction +
                    "&sort_field=" +
                    this.sort_field +
                    "&selectedCustomer=" +
                    this.selectedCustomer;

                this.getStudentsUrl = this.getStudentsUrlWithoutPaginate.concat(
                    "&paginate=" + this.paginate + "&page=" + page
                );
                axios.get(this.getStudentsUrl).then(response => {
                    this.debtPaymentLists = response.data.data;
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
