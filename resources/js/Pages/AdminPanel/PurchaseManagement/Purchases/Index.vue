<template>
    <div>
        <admin-layout>
            <div class="d-flex justify-content-between p-3">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Purchase Lists
                </h2>
                <Link :href="route('admin.purchases.create')">
                    <button type="button" class="btn btn-info text-white text-uppercase" style="letter-spacing: 0.1em;">
                        Create
                    </button>
                </Link>
            </div>
            <section class="content" data-app>
                <v-snackbar
                    v-model="snackbar"
                    color="success"
                    timeout="6000"
                    top="top"
                    >
                    Purchase Delete Successfully
                    <template v-slot:action="{ attrs }">
                        <v-btn
                            dark
                            text
                            v-bind="attrs"
                            @click="snackbar = false"
                            >
                            Close
                        </v-btn>
                    </template>
                </v-snackbar>
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
                                                <a href="#" @click.prevent="change_sort('item_name')"
                                                    >Image</a
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'desc' &&
                                                            sort_field == 'item_name'
                                                    "
                                                    >&uarr;</span
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'asc' &&
                                                            sort_field == 'item_name'
                                                    "
                                                    >&darr;</span
                                                >
                                            </th>
                                            <th>
                                                <a href="#" @click.prevent="change_sort('contact_name')"
                                                    >Customer Name</a
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'desc' &&
                                                            sort_field == 'contact_name'
                                                    "
                                                    >&uarr;</span
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'asc' &&
                                                            sort_field == 'contact_name'
                                                    "
                                                    >&darr;</span
                                                >
                                            </th>
                                            <th>
                                                <a href="#" @click.prevent="change_sort('item_sku')"
                                                    >Item Sku</a
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'desc' &&
                                                            sort_field == 'item_sku'
                                                    "
                                                    >&uarr;</span
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'asc' &&
                                                            sort_field == 'item_sku'
                                                    "
                                                    >&darr;</span
                                                >
                                            </th>
                                            <th>
                                                <a href="#" @click.prevent="change_sort('product_sku')"
                                                    >Product Sku</a
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'desc' &&
                                                            sort_field == 'product_sku'
                                                    "
                                                    >&uarr;</span
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'asc' &&
                                                            sort_field == 'product_sku'
                                                    "
                                                    >&darr;</span
                                                >
                                            </th>
                                            <th>
                                                <a
                                                    href="#"
                                                    @click.prevent="change_sort('invoice_no')"
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
                                                <a
                                                    href="#"
                                                    @click.prevent="change_sort('final_total')"
                                                    >Amount</a
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'desc' &&
                                                            sort_field == 'final_total'
                                                    "
                                                    >&uarr;</span
                                                >
                                                <span
                                                    v-if="
                                                        sort_direction == 'asc' &&
                                                            sort_field == 'final_total'
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
                                            v-for="(data, index) in dataLists.data"
                                            :key="index"
                                        >
                                            <td>{{ index + 1 }}</td>
                                            <td>
                                                <img class="w-10 h-10 rounded-full" :src="data.image" alt="" style="width:60px;"/>
                                                {{ data.item_name }}
                                            </td>
                                            <td style="font-size: 14px; width:250px;">{{ data.contact_name }}</td>
                                            <td>{{ data.item_sku }}</td>
                                            <td>{{ data.product_sku }}</td>
                                            <td>{{ data.invoice_no }}</td>
                                            <td><span class="badge badge-pill bg-warning">{{ numberWithCommas(data.final_total) }}</span></td>
                                            <td>{{ data.created_at }}</td>
                                            <td>
                                                <button
                                                    onclick="confirm('Are you sure you wanna delete this Record?') || event.stopImmediatePropagation()"
                                                    class="btn btn-sm"
                                                    @click="deleteRecord(data.transaction_id)"
                                                >
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                                <Link :href="route('admin.purchases.edit', data.transaction_id)">
                                                    <button class="btn btn-warrning btn-sm">
                                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                                    </button>
                                                </Link>
                                                <Link :href="route('admin.purchases.show',data.transaction_id)">
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
                                        :data="dataLists"
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

    export default {
        components: {
            AdminLayout,
            Link,
            Datepicker
        },
        data() {
            return {
                dataLists: {},
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
                snackbar: false,
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
            deleteRecord(id) {
                axios
                    .delete(this.route("admin.purchases.deleteRecord",id))
                    .then(response => {
                        if (response.data.status) {
                            this.snackbar = true;
                            this.getData();
                        }
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
            getData(page = 1) {
                let getDataUrlWithoutPagination =
                    "/admin/get-purchase-data-lists?" +
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
                    this.endDate;

                const getDataUrl = getDataUrlWithoutPagination.concat(
                    "&paginate=" + this.paginate + "&page=" + page
                );
                axios.get(getDataUrl).then(response => {
                    this.dataLists = response.data;
                });
            }
        },

        mounted() {
            const type = 'supplier';
            axios.get(this.route("admin.purchases.getSupplierLists"), { params: {type: type}})
                .then((response) => {
                    console.log(response.data);
                    this.suppliers = response.data.data;
            });
            this.getData();
        }
    };
</script>
