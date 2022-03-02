<template>
    <div>
        <admin-layout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Products
                </h2>
            </template>
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
                                                <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                                    <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('name')">Name
                                                        <svg v-if="params.field === 'name' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                                        </svg>
                                                        <svg v-if="params.field === 'name' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                                        </svg>
                                                    </span>
                                                </th>
                                                <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                                    <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('created_at')">SKU
                                                        <svg v-if="params.field === 'date' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                                        </svg>
                                                        <svg v-if="params.field === 'date' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                                        </svg>
                                                    </span>
                                                </th>

                                                <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                                    <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('created_at')">Description
                                                        <svg v-if="params.field === 'date' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                                        </svg>
                                                        <svg v-if="params.field === 'date' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                                        </svg>
                                                    </span>
                                                </th>

                                                <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                                    <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('created_at')">Tax
                                                        <svg v-if="params.field === 'date' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                                        </svg>
                                                        <svg v-if="params.field === 'date' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                                        </svg>
                                                    </span>
                                                </th>

                                                <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                                    <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('created_at')">Item Count
                                                        <svg v-if="params.field === 'date' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                                        </svg>
                                                        <svg v-if="params.field === 'date' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="width: 15px;">
                                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                                        </svg>
                                                    </span>
                                                </th>
                                                <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
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
                                            <tr v-for="(product, index) in products.data" :key="index">
                                                <td>
                                                    <img class="w-10 h-10 rounded-full" :src="product.image" alt="" style="width:60px;"/>
                                                    {{ product.name }}
                                                </td>
                                                <td>{{ product.product_sku }}</td>
                                                <td>{{ product.description }}</td>
                                                <td>{{ product.tax }}</td>
                                                <td>{{ product.item_count }}</td>
                                                <td>{{ dateTime(product.created_at) }}</td>
                                                <td class="text-right" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">
                                                    <button class="btn btn-success text-uppercase" style="letter-spacing: 0.1em;" @click="editModal(product)">Edit</button>
                                                    <button class="btn btn-danger text-uppercase ml-1" style="letter-spacing: 0.1em;" @click="deleteProductType(product.id)">Delete</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer clearfix">
                                    <pagination :links="products.links"></pagination>
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
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" placeholder="Name" v-model="form.name" :class="{ 'is-invalid' : form.errors.name }" autofocus="autofocus" autocomplete="off">
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.name}">
                                            {{ form.errors.name }}
                                        </div>
                                       
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col sm-3 md-3">
                                                    <label for="permissions">Quality</label>
                                                    <multiselect
                                                        v-model="form.quality"
                                                        :options="gold_qualities"
                                                        :multiple="false"
                                                        :taggable="true"
                                                        placeholder="Quality"
                                                        label="quality"
                                                        track-by="id"
                                                    ></multiselect>
                                                    <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.quality}">
                                                        {{ form.errors.quality }}
                                                    </div>
                                                </div>
                                                 <div class="col sm-3 md-3">
                                                    <label for="permissions">Type</label>
                                                    <multiselect
                                                        v-model="form.type"
                                                        :options="types"
                                                        :multiple="false"
                                                        :taggable="true"
                                                        placeholder="Type"
                                                        label="name"
                                                        track-by="key"
                                                    ></multiselect>
                                                    <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.type}">
                                                        {{ form.errors.type }}
                                                    </div>
                                                </div>
                                                 <div class="col sm-3 md-3">
                                                    <label for="permissions">Name</label>
                                                    <multiselect
                                                        v-model="form.item_name"
                                                        :options="item_names"
                                                        :multiple="false"
                                                        :taggable="true"
                                                        placeholder="Name"
                                                        label="name"
                                                        track-by="id"
                                                    ></multiselect>
                                                    <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.item_name}">
                                                        {{ form.errors.item_name }}
                                                    </div>
                                                </div>
                                                <div class="col sm-3 md-3">
                                                    <label for="w_kyat">Kyats</label>
                                                    <multiselect
                                                        v-model="form.w_kyat"
                                                        :options="weight_kyats"
                                                        :multiple="false"
                                                        :taggable="true"
                                                        placeholder="Kyats"
                                                        label="name"
                                                        track-by="id"
                                                    ></multiselect>
                                                    <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.w_kyat}">
                                                        {{ form.errors.w_kyat }}
                                                    </div>
                                                </div>
                                                <div class="col sm-3 md-3">
                                                    <label for="w_pal">Pals</label>
                                                    <multiselect
                                                        v-model="form.w_pal"
                                                        :options="weight_pals"
                                                        :multiple="false"
                                                        :taggable="true"
                                                        placeholder="Pal"
                                                        label="name"
                                                        track-by="id"
                                                    ></multiselect>
                                                    <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.w_pal}">
                                                        {{ form.errors.w_pal }}
                                                    </div>
                                                </div>
                                                <div class="col sm-3 md-3">
                                                    <label for="w_yway">Yways</label>
                                                    <multiselect
                                                        v-model="form.w_yway"
                                                        :options="weight_yways"
                                                        :multiple="false"
                                                        :taggable="true"
                                                        placeholder="Yway"
                                                        label="name"
                                                        track-by="id"
                                                    ></multiselect>
                                                    <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.w_yway}">
                                                        {{ form.errors.w_yway }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Product Sku : {{form.quality.quality}}{{form.type.key}}{{form.item_name.key}}{{ form.w_kyat.name }}{{ form.w_pal.name }}{{ form.w_yway.name }}</label>
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.product_sku}">
                                            {{ form.errors.product_sku }}
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Description</label>
                                            <input type="text" class="form-control" placeholder="Description" v-model="form.description" :class="{ 'is-invalid' : form.errors.description }" autofocus="autofocus" autocomplete="off">
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.description}">
                                            {{ form.errors.description }}
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Tax</label>
                                            <input type="number" class="form-control" placeholder="Tax" v-model="form.tax" :class="{ 'is-invalid' : form.errors.tax }" autofocus="autofocus" autocomplete="off">
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.tax}">
                                            {{ form.errors.tax }}
                                        </div>
                                        <div class="form-group">
                                            <label for="alert_quantity">Alert Quantity</label>
                                            <input type="number" class="form-control" placeholder="Alert quantity" v-model="form.alert_quantity" :class="{ 'is-invalid' : form.errors.alert_quantity }" autofocus="autofocus" autocomplete="off">
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.alert_quantity}">
                                            {{ form.errors.alert_quantity }}
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Choose Image</label>
                                            <input type="file" :class="['form-control',form.errors.image?'border border-danger':'']"  @change="selectImage">
                                            <!-- <img :src="$page.props.auth_user.image" width="30%" height="166px" alt=""> -->
                                            <!-- <small v-if="form.errors.image" class="text text-danger">{{ form.errors.image }} </small> -->
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.image}">
                                            {{ form.errors.image }}
                                        </div>
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-danger text-uppercase" style="letter-spacing: 0.1em;" @click="closeModal">Cancel</button>
                                        <button type="submit" class="btn btn-info text-uppercase" style="letter-spacing: 0.1em;" :disabled="!form.name || form.processing">{{ buttonTxt }}</button>
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
        props: [
            'products',
            'filters',
            'gold_qualities',
            'types',
            'item_names',
            'weight_kyats', 
            'weight_pals',
            'weight_yways'
            ],
        components: {
            AdminLayout,
            Pagination,
        },
        data() {
            return {
                editedIndex: -1,
                editMode: false,
                form: this.$inertia.form({
                    name: '',
                    quality: '',
                    type: '',
                    item_name: '',
                    w_kyat: '',
                    w_pal: '',
                    w_yway: '',
                    description: '',
                    tax: '',
                    alert_quantity: '',
                    image: ''
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
                return this.editedIndex === -1 ? 'Create New Product Type' : 'Edit Current Product Type';
            },
            buttonTxt() {
                return this.editedIndex === -1 ? 'Create' : 'Edit';
            },
            checkMode() {
                return this.editMode === false ? this.createProduct : this.editProductType
            }
        },
        watch: {
            params: {
                handler: throttle(function () {
                    let params = pickBy(this.params);
                    this.$inertia.get(this.route('admin.product_types.index'), params, { replace: true, preserveState: true });
                }, 150),
                deep: true,
            },
        },
        
        methods: {
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
           
            editModal(product) {
                // console.log(product_type);
                this.editMode = true
                $('#modal-lg').modal('show')
                this.editedIndex = this.products.data.indexOf(product_type)
                this.form.id = product_type.id
                this.form.name = product_type.name
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
            createProduct() {
                this.form.post(this.route('admin.products.store'), {
                    preserveScroll: true,
                    onSuccess:() => {
                        this.closeModal()
                        Toast.fire({
                            icon: 'success',
                            title: 'New Product created!'
                        })
                    }
                })
            },
            editProductType() {
                this.form.patch(this.route('admin.types.update', this.form.id, this.form), {
                    preserveScroll: true,
                    onSuccess:() => {
                        Toast.fire({
                            icon: 'success',
                            title: 'Product Type has been updated!'
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
                        this.form.delete(this.route('admin.types.destroy', id), {
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
