<template>
    <div>
        <admin-layout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Cash Out List
                </h2>
            </template>
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-primary card-outline" data-select2-id="32">
                        <div class="card-header">
                            <h3 class="card-title">Filter</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: block;" data-select2-id="31">
                            <div class="row">
                                <div class="col-12 col-sm-3 border-right">
                                    <div class="form-group">
                                        <label>Date range button:</label>

                                        <div class="input-group">
                                            <button type="button" class="btn btn-default float-right" id="daterange-btn">
                                            <i class="far fa-calendar-alt"></i> Date range picker
                                            <i class="fas fa-caret-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3 border-right">
                                    <div class="form-group">
                                        <label>Cash In Types</label>
                                        <select class="form-control">
                                            <option>All</option>
                                            <option>Purchase</option>
                                            <option>customerစီကရရန်အကြွေး</option>
                                            <option>supplierကိုဆပ့်ငွေ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3 border-right">
                                    <div class="form-group">
                                        <label for="permissions">Customer</label>
                                        <ContactAutoCompleteSearchComponent
                                            @update:data="selectCustomer"
                                            route_name = "pos.contact_search"
                                            v-model = "customer"
                                            label="search_name"
                                            placeholder="Search Customer"
                                            type="customer"
                                            button="false"
                                        />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3 border-right">
                                    <div class="form-group">
                                        <label for="permissions">Supplier</label>
                                        <ContactAutoCompleteSearchComponent
                                            @update:data="selectSupplier"
                                            route_name = "pos.contact_search"
                                            v-model = "supplier"
                                            label="search_name"
                                            placeholder="Search Supplier"
                                            type="supplier"
                                            button="false"
                                        />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <input type="search" v-model="params.search" aria-label="Search" placeholder="Search..." class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
                                    <!-- <div class="card-tools" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">
                                        <Link :href="route('admin.sells.create')">
                                            <button type="button" class="btn btn-info text-white text-uppercase" style="letter-spacing: 0.1em;">
                                                Create
                                            </button>
                                        </Link>
                                    </div> -->
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left uppercase">
                                                    <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('name')">Image
                                                        <svg v-if="params.field === 'name' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                                        </svg>
                                                        <svg v-if="params.field === 'name' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                                        </svg>
                                                    </span>
                                                </th>

                                                <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left uppercase">
                                                    <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('created_at')">Item Sku
                                                        <svg v-if="params.field === 'date' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                                        </svg>
                                                        <svg v-if="params.field === 'date' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                                        </svg>
                                                    </span>
                                                </th>

                                                <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left uppercase">
                                                    <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('created_at')">Product Sku
                                                        <svg v-if="params.field === 'date' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                                        </svg>
                                                        <svg v-if="params.field === 'date' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                                        </svg>
                                                    </span>
                                                </th>
                                                <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left uppercase">
                                                    <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('created_at')">Invoce No
                                                        <svg v-if="params.field === 'date' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                                        </svg>
                                                        <svg v-if="params.field === 'date' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                                        </svg>
                                                    </span>
                                                </th>
                                                <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left uppercase">
                                                    <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('created_at')">Status
                                                        <svg v-if="params.field === 'date' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                                        </svg>
                                                        <svg v-if="params.field === 'date' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                                        </svg>
                                                    </span>
                                                </th>
                                                <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left uppercase">
                                                    <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('created_at')">Total
                                                        <svg v-if="params.field === 'date' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                                        </svg>
                                                        <svg v-if="params.field === 'date' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                                        </svg>
                                                    </span>
                                                </th>
                                                <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left uppercase">
                                                    <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('created_at')">Date
                                                        <svg v-if="params.field === 'date' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                                        </svg>
                                                        <svg v-if="params.field === 'date' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                                        </svg>
                                                    </span>
                                                </th>
                                                <th class="text-capitalize text-right" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(transaction, index) in transactions.data" :key="index">
                                                <td>
                                                    <img class="w-10 h-10 rounded-full" :src="transaction.item.image" alt="" style="width:60px;"/>
                                                    {{ transaction.item.name }}
                                                    <i class="fa fa-undo text-red" aria-hidden="true" v-if="transaction.purchase.purchase_return == '1'"></i>
                                                </td>
                                                <td>{{ transaction.item.item_sku }}</td>
                                                <td>{{ transaction.product.product_sku }}</td>
                                                <td>{{ transaction.invoice_no }}</td>
                                                <td>{{ transaction.status }}</td>
                                                <td>{{ transaction.purchase.final_total }}</td>
                                                <td>{{ dateTime(transaction.created_at) }}</td>
                                                <td class="text-right" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">
                                                    <Link :href="route('admin.purchases.edit', transaction.id)">
                                                        <button class="btn btn-success text-uppercase" style="letter-spacing: 0.1em;">Edit</button>
                                                    </Link>
                                                    <!-- <button class="btn btn-danger text-uppercase ml-1" style="letter-spacing: 0.1em;" @click="deleteTransaction(transaction.id)">Delete</button> -->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer clearfix">
                                    <pagination :links="transactions.links"></pagination>
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
    import { pickBy, throttle } from 'lodash';
    import { Link } from '@inertiajs/inertia-vue';
    import Datepicker from 'vuejs-datepicker';

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
                customer_id:null,
                supplier_id:null,
                date: null,
                customer:null,
                supplier:null,
                params: {
                    search: this.filters.search,
                    field: this.filters.field,
                    direction: this.filters.direction,
                },
            }
        },
        created(){
        },
        computed: {
        },
        watch: {
            params: {
                handler: throttle(function () {
                    let params = pickBy(this.params);
                    this.$inertia.get(this.route('admin.sells.index'), params, { replace: true, preserveState: true });
                }, 150),
                deep: true,
            },
        },
        methods: {
            selectCustomer(value){

            },
            selectSupplier(value){

            },
            selectDate(){

            },
            selectImage(e){
                this.form.image = e.target.files[0];
            },
            sort(field) {
                this.params.field = field;
                this.params.direction = this.params.direction === 'asc' ? 'desc' : 'asc';
            },
            dateTime(value) {
                return moment(value).format('YYYY-MM-DD');
            },
            // deleteTransaction(id) {
            //     Swal.fire({
            //         title: 'Are you sure?',
            //         text: "You won't be able to revert this!",
            //         icon: 'warning',
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#d33',
            //         confirmButtonText: 'Yes, delete it!'
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             this.form.delete(this.route('admin.sells.destroy', id), {
            //                 preserveScroll: true,
            //                 onSuccess: ()=> {
            //                     Swal.fire(
            //                         'Deleted!',
            //                         'Sell has been deleted.',
            //                         'success'
            //                     )
            //                 }
            //             })
            //         }
            //     })
            // }
        }
    }
</script>
