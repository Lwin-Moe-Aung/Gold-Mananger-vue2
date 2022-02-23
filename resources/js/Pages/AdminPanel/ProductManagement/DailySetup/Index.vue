<template>
    <div>
        <admin-layout>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Daily Setups</h3>
                                    <div class="card-tools" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">
                                        Date: {{ date }}
                                        <input type="date" v-model="params.date"  @change="dateChange()" >
                                         &nbsp;&nbsp;
                                        <button class="btn btn-success text-uppercase" style="letter-spacing: 0.1em;" @click="editModal(daily_setup)">
                                            Edit
                                        </button>
                                        &nbsp;&nbsp;
                                        <button type="button" class="btn btn-info text-uppercase" style="letter-spacing: 0.1em;" @click="openModal">
                                            Create
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="text-capitalize">index</th>
                                                <th class="text-capitalize">Name</th>
                                                <th class="text-capitalize">Daily Price</th>
                                                <th class="text-capitalize">Date</th>
                                                <!-- <th class="text-capitalize text-right" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">Actions</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(daily_setup, index) in daily_setups.data" :key="index">
                                                <td class="text-capitalize">{{ index +1}}</td>
                                                <td class="text-capitalize">{{ daily_setup.product_type.name}} </td>
                                                <th class="text-capitalize">{{ daily_setup.daily_price}} </th>
                                                <td>{{ dateTime(daily_setup.created_at) }}</td>
                                                <!-- <td class="text-right" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">
                                                    <button class="btn btn-success text-uppercase" style="letter-spacing: 0.1em;" @click="editModal(daily_setup)">Edit</button>
                                                    <button class="btn btn-danger text-uppercase ml-1" style="letter-spacing: 0.1em;" @click="deleteDailySetup(daily_setup.id)">Delete</button>
                                                </td> -->
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
                                    <div v-for="(daily_setup, index) in form.daily_setups" :key="index">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-3 col-form-label h4 text-right">{{ daily_setup.name }}</label>
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control" placeholder="Name" v-model="form.daily_setups[index].daily_price" autofocus="autofocus" autocomplete="off">
                                            </div>
                                            <label for="name" class="col-sm-2 col-form-label h4">ကျပ်</label>
                                        </div>
                                      
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-danger text-uppercase" style="letter-spacing: 0.1em;" @click="closeModal">Cancel</button>
                                        <button type="submit" class="btn btn-info text-uppercase" style="letter-spacing: 0.1em;">{{ buttonTxt }}</button>
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
    import axios from 'axios';

    export default {
        props: ['daily_setups','product_types'],
        components: {
            AdminLayout,
            Pagination,
        },
        data() {
            return {
                editedIndex: -1,
                editMode: false,
                form: this.$inertia.form({
                    daily_setups:[]
                }),
                params: {
                    date:'',
                },
            }
        },
        created() {
            const current = new Date();
            this.date = `${current.getDate()}/${current.getMonth()+1}/${current.getFullYear()}`;
        },
       
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Create New Daily Setup' : 'Edit Current Daily Setup';
            },
            buttonTxt() {
                return this.editedIndex === -1 ? 'Create' : 'Edit';
            },
            checkMode() {
                return this.editMode === false ? this.createDailySetup : this.editDailySetup
            }
           
        },
        methods: {
            dateChange(){
                console.log(this.date)
                this.getDataByDate()
            },
            dateTime(value) {
                return moment(value).format('YYYY-MM-DD');
            },
            getDataByDate() {
                this.form.get(this.route('admin.daily_setups.index',this.params), {
                    preserveScroll: true,
                    onSuccess:() => {
                        this.closeModal()
                        Toast.fire({
                            icon: 'success',
                            title: 'New Daily Setup created!'
                        })
                    }
                })
            },
            editModal(daily_setup) {
                this.editMode = true
                 for(let i = 0; i <= this.daily_setups.length -1; i++){
                    this.form.daily_setups.push({
                        id:this.daily_setups[i].id,
                        type_of_daily_setup:this.daily_setups[i].type_of_daily_setup,
                        daily_price:this.daily_setups[i].daily_price,
                        business_id:this.daily_setups[i].business_id,
                        name:this.daily_setups[i].product_type.name,
                    })
                }
                $('#modal-lg').modal('show')
            },
            openModal() {
                this.editedIndex = -1
                for(let i = 0; i <= this.product_types.length -1; i++){
                    this.form.daily_setups.push({
                        type_of_daily_setup:this.product_types[i].id,
                        daily_price:0,
                        business_id:this.product_types[i].business_id,
                        name:this.product_types[i].name,
                    })
                }
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
                            title: 'New Daily Setup created!'
                        })
                    }
                })
            },
            editDailySetup() {
                this.form.post(this.route('admin.daily_setups.edit_daily_setup', this.form), {
                    preserveScroll: true,
                    onSuccess:() => {
                        this.closeModal()
                        Toast.fire({
                            icon: 'success',
                            title: 'New Daily Setup created!'
                        })
                    }
                })
            },
            deleteDailySetup(id) {
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
                                    'Product Type has been deleted.',
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
            
