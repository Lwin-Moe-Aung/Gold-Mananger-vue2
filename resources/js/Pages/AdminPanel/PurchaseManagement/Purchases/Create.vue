<template>
    <div>
        <admin-layout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Purchase Create
                </h2>
            </template>
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-default">
                        <form ref="productform" @submit.prevent="createPurchases">
                            <div class="card-header">
                                <h3 class="card-title">Product Create Form</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" placeholder="Name" v-model="form.name" :class="{ 'is-invalid' : form.errors.name }" autofocus="autofocus" autocomplete="off">
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.name}">
                                            {{ form.errors.name }}
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="permissions">Supplier</label>
                                            <multiselect
                                                v-model="supplier"
                                                :options="suppliers"
                                                :multiple="false"
                                                :taggable="true"
                                                placeholder="Supplier name"
                                                label="name"
                                                track-by="id"
                                                @input="changeSupplier"
                                            ></multiselect>
                                            <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.supplier}">
                                                {{ form.errors.supplier }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="permissions">Product Sku</label>
                                            <multiselect
                                                v-model="product"
                                                :options="products"
                                                :multiple="false"
                                                :taggable="true"
                                                placeholder="product sku"
                                                label="product_sku"
                                                track-by="id"
                                                @input="changeProductSku"
                                            ></multiselect>
                                            <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.item_name}">
                                                {{ form.errors.item_name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Daily Price</label>
                                            <input type="text" class="form-control" placeholder="Name"
                                                :value="numberWithCommas(daily_price.kyat)" disabled
                                                >
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Description</label>
                                            <textarea  class="form-control" placeholder="Description"
                                                v-model="form.item_description" :class="{ 'is-invalid' : form.errors.item_description }"
                                                autofocus="autofocus" autocomplete="off"
                                                rows="4" cols="70"
                                            >
                                            </textarea>
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.item_description}">
                                            {{ form.errors.item_description }}
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="image">Choose Image</label>
                                            <input type="file" :class="['form-control',form.errors.image?'border border-danger':'']"  @change="selectImage">
                                            <img class="profile-user-img img-fluid" :src="imageforui" v-if="imageforui">
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.image}">
                                            {{ form.errors.image }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox2" disabled  >
                                            <label for="customCheckbox2" class="custom-control-label">ရွှေချိန်+ကျောက်ချိန်</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input custom-control-input-danger" type="checkbox" id="customCheckbox4" checked="">
                                            <label for="customCheckbox4" class="custom-control-label">ကျောက်ချိန်</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-right">
                                <Link :href="route('admin.products.index')">
                                    <button type="button" class="btn btn-light text-uppercase" style="letter-spacing: 0.1em;">Cancel</button>
                                </Link>
                                <button type="submit" class="btn btn-info text-uppercase" style="letter-spacing: 0.1em;" :disabled="!form.name">Create</button>
                            </div>
                        </form>
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
    import { pickBy, throttle } from 'lodash';
    import { Link } from '@inertiajs/inertia-vue';

    export default {
        props: [
            'products',
            'suppliers'
        ],
        components: {
            AdminLayout,
            Pagination,
            Link
        },
        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    product_id: '',
                    supplier_id: '',
                    gold_plus_gem_weight: '',
                    gold_price: '',
                    gem_weight: '',
                    gem_price: '',
                    fee: '',
                    fee_price: '',
                    fee_for_making: '',
                    image: '',
                    item_description: '',
                }),
                supplier: '',
                product: '',
                imageforui: undefined,
                daily_price: '',
            }
        },
        computed: {

        },
        watch: {

        },

        methods: {
            selectImage(e){
                let file = e.target.files[0];
                this.form.image = e.target.files[0];
                let reader = new FileReader();
                if(file['size'] < 2111775)
                {
                    reader.onloadend = (file) => {
                        //console.log('RESULT', reader.result)
                        this.imageforui = reader.result;

                    }
                    reader.readAsDataURL(file);
                }else{
                    alert('File size can not be bigger than 2 MB')
                }
            },
            createPurchases() {
                this.form.post(this.route('admin.purchases.store'), {
                    preserveScroll: true,
                    onSuccess:() => {
                        Object.assign(this.$data, this.$options.data.call(this));
                        Toast.fire({
                            icon: 'success',
                            title: 'New Product created!'
                        })
                    }
                })
            },
            changeProductSku() {
                this.form.product_id = this.product.id;
                this.daily_price = this.$page.props.daily_setup[this.product.quality];
            },
            changeSupplier() {
                this.form.supplier_id = this.supplier.id;
            },
            numberWithCommas(value) {
                if(typeof value !== "undefined"){
                    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
        }
    }
</script>
