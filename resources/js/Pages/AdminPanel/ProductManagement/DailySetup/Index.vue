<template>
    <div>
        <admin-layout>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                               <div class="card-header">
                                    <input type="search" v-model="params.search" aria-label="Search" placeholder="Search..." class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
                                    <div class="card-tools" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">
                                        <button type="button" class="btn btn-info text-uppercase" style="letter-spacing: 0.1em;" @click="openModal">
                                            Create
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-black uppercase">
                                                    <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('id')">index
                                                        <svg v-if="params.field === 'id' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                                        </svg>
                                                        <svg v-if="params.field === 'id' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                                        </svg>
                                                    </span>
                                                </th>
                                                <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-black uppercase">
                                                    <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('daily_price')">Daily Price
                                                        <svg v-if="params.field === 'daily_price' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                                        </svg>
                                                        <svg v-if="params.field === 'daily_price' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                                        </svg>
                                                    </span>
                                                </th>
                                                <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-black uppercase">
                                                    <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('created_at')">Date
                                                        <svg v-if="params.field === 'created_at' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                                        </svg>
                                                        <svg v-if="params.field === 'created_at' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                                        </svg>
                                                    </span>
                                                </th>
                                                <th class="text-capitalize text-right" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(daily_setup, index) in daily_setups.data" :key="index">
                                                <td>
                                                    <img class="w-10 h-10 rounded-full" :src="daily_setup.image" alt="" style="width:60px;"/>
                                                    {{ index+1 }}
                                                </td>
                                                <td>{{ daily_setup.daily_price }}</td>
                                                <td>{{ dateTime(daily_setup.created_at) }}</td>
                                                <td class="text-right" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">
                                                    <button class="btn btn-success text-uppercase" style="letter-spacing: 0.1em;" @click="editModal(daily_setup)">Edit</button>
                                                    <button class="btn btn-danger text-uppercase ml-1" style="letter-spacing: 0.1em;" @click="deleteProductType(daily_setup.id)">Delete</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer clearfix">
                                    <pagination :links="daily_setups.links"></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
              <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ formTitle }}</h4>
                            <button type="button" class="close" @click="closeModal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body overflow-hidden">
                            <div class="card card-primary">
                                <form @submit.prevent="checkMode">
                                    <div class="card-body">


                                        <div class="form-group">
                                            <label for="name" class="h4">Daily Price</label>
                                            <input type="text" class="form-control" placeholder="Daily Price" v-model="form.daily_price" :class="{ 'is-invalid' : form.errors.name }" autofocus="autofocus" autocomplete="off">
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.daily_price}">
                                            {{ form.errors.daily_price }}
                                        </div>
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-danger text-uppercase" style="letter-spacing: 0.1em;" @click="closeModal">Cancel</button>
                                        <button type="submit" class="btn btn-info text-uppercase" style="letter-spacing: 0.1em;" :disabled="!form.daily_price || form.processing">{{ buttonTxt }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </admin-layout>
    </div>
</template>

<script>
    import AdminLayout from '../../../../Layouts/AdminPanelLayout';
    import moment from 'moment';
    import Pagination from '../../../../Components/AdminPanel/Pagination';
    import { pickBy, throttle } from 'lodash';

    export default {
        props: ['daily_setups','filters'],
        components: {
            AdminLayout,
            Pagination,
        },
       data() {
            return {
                editedIndex: -1,
                editMode: false,
                form: this.$inertia.form({
                    daily_price: '',
                }),
                params: {
                    search: this.filters.search,
                    field: this.filters.field,
                    direction: this.filters.direction,
                },

            }
        },
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Create New Daily Price' : 'Edit Current Daily Price';
            },
            buttonTxt() {
                return this.editedIndex === -1 ? 'Create' : 'Edit';
            },
            checkMode() {
                return this.editMode === false ? this.createDailySetup : this.editDailySetup
            }
        },
        watch: {
            params: {
                handler: throttle(function () {
                    let params = pickBy(this.params);
                    this.$inertia.get(this.route('admin.daily_setups.index'), params, { replace: true, preserveState: true });
                }, 150),
                deep: true,
            },
        },

        methods: {
            sort(field) {
                this.params.field = field;
                this.params.direction = this.params.direction === 'asc' ? 'desc' : 'asc';
            },
            dateTime(value) {
                return moment(value).format('YYYY-MM-DD');
            },

            editModal(daily_setup) {
                this.editMode = true
                $('#modal-lg').modal('show')
                this.editedIndex = this.daily_setups.data.indexOf(daily_setup)
                this.form.id = daily_setup.id
                this.form.daily_price = daily_setup.daily_price
            },
            openModal() {
                this.editedIndex = -1
                $('#modal-lg').modal('show')
            },
            closeModal() {
                this.form.clearErrors()
                this.editMode = false
                this.form.reset()
                $('#modal-lg').modal('hide')
            },
            createDailySetup() {
                this.form.post(this.route('admin.daily_setups.store'), {
                    preserveScroll: true,
                    onSuccess:() => {
                        this.closeModal()
                        Toast.fire({
                            icon: 'success',
                            title: 'New Daily Price created!'
                        })
                    }
                })
            },
            editDailySetup() {
                this.form.patch(this.route('admin.daily_setups.update', this.form.id, this.form), {
                    preserveScroll: true,
                    onSuccess:() => {
                        Toast.fire({
                            icon: 'success',
                            title: 'Daily Setup has been updated!'
                        })
                        this.closeModal()
                    }
                })
            },
            deleteProductType(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.form.delete(this.route('admin.daily_setups.destroy', id), {
                            preserveScroll: true,
                            onSuccess: ()=> {
                                Swal.fire(
                                    'Deleted!',
                                    'Daily Setup has been deleted.',
                                    'success'
                                )
                            }
                        })
                    }
                })
            }
        }
    }
</script>

