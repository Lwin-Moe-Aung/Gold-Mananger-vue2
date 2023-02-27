<template>
    <div>
        <admin-layout>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Customer</h3>
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
                                                <th class="text-capitalize">Address</th>
                                                <th class="text-capitalize">Moblies</th>
                                                <th class="text-capitalize">Joined</th>
                                                <th class="text-capitalize text-right" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(customer, index) in customers.data" :key="index">
                                                <td class="text-capitalize">{{ customer.name }}</td>
                                                <td>{{ customer.email }}</td>
                                                 <td>{{ customer.address }}</td>
                                                <td>{{ customer.mobile1 }}, {{ customer.mobile2 }}</td>
                                                <td>{{ dateTime(customer.created_at) }}</td>
                                                <td class="text-right" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">
                                                    <button class="btn btn-success text-uppercase" style="letter-spacing: 0.1em;" @click="editModal(customer)">Edit</button>
                                                    <button class="btn btn-danger text-uppercase ml-1" style="letter-spacing: 0.1em;" @click="deleteCustomer(customer.id)">Delete</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer clearfix">
                                    <pagination :links="customers.links"></pagination>
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
    import Pagination from '../../../../Components/AdminPanel/Pagination';

    export default {
        props: ['customers'],
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
                    address: '',
                    mobile1: '',
                    mobile2: '',
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }),
            }
        },
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Create New Customer' : 'Edit Current Customer';
            },
            buttonTxt() {
                return this.editedIndex === -1 ? 'Create' : 'Edit';
            },
            checkMode() {
                return this.editMode === false ? this.createCustomer : this.editCustomer
            }
        },
        methods: {
            dateTime(value) {
                return moment(value).format('YYYY-MM-DD');
            },
            addTag(newRole) {
                let tag = {
                    name: newRole,
                }
                this.roleOptions.push(tag)
                this.form.roles.push(tag)
            },
            editModal(customer) {
                this.editMode = true
                $('#modal-lg').modal('show')
                this.editedIndex = this.customers.data.indexOf(customer)
                this.form.id = customer.id
                this.form.name = customer.name
                this.form.email = customer.email
                this.form.address = customer.address
                this.form.mobile1 = customer.mobile1
                this.form.mobile2 = customer.mobile2
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
            createCustomer() {
                this.form.post(this.route('admin.customers.store'), {
                    preserveScroll: true,
                    onSuccess:() => {
                        this.closeModal()
                        Toast.fire({
                            icon: 'success',
                            title: 'New Customer created!'
                        })
                    }
                })
            },
            editCustomer() {
                this.form.patch(this.route('admin.customers.update', this.form.id, this.form), {
                    preserveScroll: true,
                    onSuccess:() => {
                        Toast.fire({
                            icon: 'success',
                            title: 'Customer has been updated!'
                        })
                        this.closeModal()
                    }
                })
            },
            deleteCustomer(id) {
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
                        this.form.delete(this.route('admin.customers.destroy', id), {
                            preserveScroll: true,
                            onSuccess: ()=> {
                                Swal.fire(
                                    'Deleted!',
                                    'Customer has been deleted.',
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

