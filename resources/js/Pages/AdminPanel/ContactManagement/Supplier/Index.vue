<template>
    <div>
        <admin-layout>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Supplier</h3>
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
                                                <th class="text-capitalize">Name</th>
                                                <th class="text-capitalize">E-mail</th>
                                                <th class="text-capitalize">Business Name</th>
                                                <th class="text-capitalize">Address</th>
                                                <th class="text-capitalize">Moblies</th>
                                                <th class="text-capitalize">Joined</th>
                                                <th class="text-capitalize text-right" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(supplier, index) in suppliers.data" :key="index">
                                                <td class="text-capitalize">{{ supplier.name }}</td>
                                                <td>{{ supplier.email }}</td>
                                                <td>{{ supplier.supplier_business_name }}</td>
                                                <td>{{ supplier.address }}</td>
                                                <td>{{ supplier.mobile1 }}, {{ supplier.mobile2 }}</td>
                                                <td>{{ dateTime(supplier.created_at) }}</td>
                                                <td class="text-right" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">
                                                    <button class="btn btn-success text-uppercase" style="letter-spacing: 0.1em;" @click="editModal(supplier)">Edit</button>
                                                    <button class="btn btn-danger text-uppercase ml-1" style="letter-spacing: 0.1em;" @click="deleteSupplier(supplier.id)">Delete</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer clearfix">
                                    <pagination :links="suppliers.links"></pagination>
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
                            <div class="d-flex flex-column h4">
                                <span>Preview: <span class="text-capitalize">{{ form.name }}</span>
                                </span>
                                <span class="mt-2">Preview E-mail: <span class="text-capitalize">{{ form.email }}</span>
                                </span>
                            </div>
                            <div class="card card-primary">
                                <form @submit.prevent="checkMode">
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="name" class="h4">Name</label>
                                            <input type="text" class="form-control" placeholder="Name" v-model="form.name" :class="{ 'is-invalid' : form.errors.name }" autofocus="autofocus" autocomplete="off">
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.name}">
                                            {{ form.errors.name }}
                                        </div>

                                        <div class="form-group">
                                            <label for="email" class="h4">E-mail</label>
                                            <input type="email" class="form-control" placeholder="E-mail Address" v-model="form.email" :class="{ 'is-invalid' : form.errors.email }" autocomplete="off">
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.email}">
                                            {{ form.errors.email }}
                                        </div>
                                         <div class="form-group">
                                            <label for="supplier_business_name" class="h4">Supplier Business Name</label>
                                            <input type="text" class="form-control" placeholder="Supplier Business Name" v-model="form.supplier_business_name" :class="{ 'is-invalid' : form.errors.supplier_business_name }" autocomplete="off">
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.supplier_business_name}">
                                            {{ form.errors.supplier_business_name }}
                                        </div>
                                        <div class="form-group">
                                            <label for="address" class="h4">Address</label>
                                            <input type="text" class="form-control" placeholder="Address" v-model="form.address" :class="{ 'is-invalid' : form.errors.address }" autocomplete="off">
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.address}">
                                            {{ form.errors.address }}
                                        </div>

                                        <div class="form-group">
                                            <label for="mobile1" class="h4">Mobile</label>
                                            <input type="number" class="form-control" placeholder="Mobile1" v-model="form.mobile1" :class="{ 'is-invalid' : form.errors.mobile1 }" autocomplete="off">
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.mobile1}">
                                            {{ form.errors.mobile1 }}
                                        </div>

                                        <div class="form-group">
                                            <label for="mobile2" class="h4">Other Mobile Number</label>
                                            <input type="number" class="form-control" placeholder="Other Mobile Number" v-model="form.mobile2" :class="{ 'is-invalid' : form.errors.mobile2 }" autocomplete="off">
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.mobile2}">
                                            {{ form.errors.mobile2 }}
                                        </div>

                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-danger text-uppercase" style="letter-spacing: 0.1em;" @click="closeModal">Cancel</button>
                                        <button type="submit" class="btn btn-info text-uppercase" style="letter-spacing: 0.1em;" :disabled="!form.name || !form.email || form.processing">{{ buttonTxt }}</button>
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
    import Pagination from '../../../../Components/AdminPanel/Pagination'
    import constant from '../../../../constant';
    export default {
        props: ['suppliers'],
        components: {
            AdminLayout,
            Pagination,
        },
        data() {
            return {
                editedIndex: -1,
                editMode: false,
                form: this.$inertia.form({
                    id: '',
                    name: '',
                    email: '',
                    supplier_business_name: '',
                    address: '',
                    mobile1: '',
                    mobile2: '',
                    _token: constant.CSRF
                }),
            }
        },
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Create New Supplier' : 'Edit Current Supplier';
            },
            buttonTxt() {
                return this.editedIndex === -1 ? 'Create' : 'Edit';
            },
            checkMode() {
                return this.editMode === false ? this.createSupplier : this.editSupplier
            }
        },
        methods: {
            dateTime(value) {
                return moment(value).format('YYYY-MM-DD');
            },

            editModal(supplier) {
                this.editMode = true
                $('#modal-lg').modal('show')
                this.editedIndex = this.suppliers.data.indexOf(supplier)
                this.form.id = supplier.id
                this.form.name = supplier.name
                this.form.email = supplier.email
                this.form.address = supplier.address
                this.form.supplier_business_name = supplier.supplier_business_name
                this.form.mobile1 = supplier.mobile1
                this.form.mobile2 = supplier.mobile2
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
            createSupplier() {
                this.form.post(this.route('admin.suppliers.store'), {
                    preserveScroll: true,
                    onSuccess:() => {
                        this.closeModal()
                        Toast.fire({
                            icon: 'success',
                            title: 'New Supplier created!'
                        })
                    }
                })
            },
            editSupplier() {
                this.form.patch(this.route('admin.suppliers.update', this.form.id, this.form), {
                    preserveScroll: true,
                    onSuccess:() => {
                        Toast.fire({
                            icon: 'success',
                            title: 'Supplier has been updated!'
                        })
                        this.closeModal()
                    }
                })
            },
            deleteSupplier(id) {
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
                        this.form.delete(this.route('admin.suppliers.destroy', id), {
                            preserveScroll: true,
                            onSuccess: ()=> {
                                Swal.fire(
                                    'Deleted!',
                                    'Supplier has been deleted.',
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

