<template>
    <div>
        <admin-layout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Products Edit
                </h2>
            </template>
            <section class="content">
                <div class="container-fluid" data-app>
                    <div class="card card-default">
                        <form ref="productform" @submit.prevent="editProduct" enctype="multipart/form-data">
                            <div class="card-header">
                                <h3 class="card-title">Product Edit Form</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="permissions">Quality</label>
                                            <div class="row">
                                                <div class="col-sm-10 col-xs-10 col-md-10">
                                                    <multiselect
                                                        v-model="form.quality"
                                                        :options="gold_qualities"
                                                        :multiple="false"
                                                        :taggable="true"
                                                        placeholder="Quality"
                                                        label="quality"
                                                        track-by="id"
                                                    ></multiselect>
                                                </div>
                                                <div class="col-sm-2 col-xs-2 col-md-2  ">
                                                    <button type="button" class="btn btn-success text-white ml-n3" @click="addQualityDialog = true"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.quality}">
                                                {{ form.errors.quality }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="type">Type</label>
                                            <div class="row">
                                                <div class="col-sm-10 col-xs-10 col-md-10">
                                                   <multiselect
                                                        v-model="form.type"
                                                        :options="types"
                                                        :multiple="false"
                                                        :taggable="true"
                                                        placeholder="Type"
                                                        label="name"
                                                        track-by="key"
                                                    ></multiselect>
                                                </div>
                                                <div class="col-sm-2 col-xs-2 col-md-2  ">
                                                    <button type="button" class="btn btn-success text-white ml-n3" @click="addTypeDialog = true"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.type}">
                                                {{ form.errors.type }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="type">Name</label>
                                            <div class="row">
                                                <div class="col-sm-10 col-xs-10 col-md-10">
                                                    <multiselect
                                                        v-model="form.item_name"
                                                        :options="item_names"
                                                        :multiple="false"
                                                        :taggable="true"
                                                        placeholder="Name"
                                                        label="name"
                                                        track-by="id"
                                                    ></multiselect>
                                                </div>
                                                <div class="col-sm-2 col-xs-2 col-md-2  ">
                                                    <button type="button" class="btn btn-success text-white ml-n3" @click="addItemNameDialog = true"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.item_name}">
                                                {{ form.errors.item_name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                            <label for="alert_quantity">Alert Quantity</label>
                                            <input type="number" class="form-control" placeholder="Alert quantity" v-model="form.alert_quantity" :class="{ 'is-invalid' : form.errors.alert_quantity }" autofocus="autofocus" autocomplete="off">
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.alert_quantity}">
                                            {{ form.errors.alert_quantity }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Description</label>
                                            <textarea  class="form-control" placeholder="Description"
                                                v-model="form.description" :class="{ 'is-invalid' : form.errors.description }"
                                                autofocus="autofocus" autocomplete="off"
                                                rows="4" cols="70"
                                            >
                                            </textarea>
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.description}">
                                            {{ form.errors.description }}
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="image">Choose Image</label>

                                            <input type="file" :class="['form-control',form.errors.image?'border border-danger':'']"  @change="changeImage">
                                            <img class="profile-user-img img-fluid" :src="imageforui" v-if="imageforui">
                                            <img class="profile-user-img img-fluid" :src="$props.product.image" v-else>
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.image}">
                                            {{ form.errors.image }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox2" disabled  v-model="form.gold_and_gem_weight">
                                            <label for="customCheckbox2" class="custom-control-label">ရွှေချိန်+ကျောက်ချိန်</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input custom-control-input-danger" type="checkbox" id="customCheckbox4" checked="" v-model="form.gem_weight">
                                            <label for="customCheckbox4" class="custom-control-label">ကျောက်ချိန်</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-right">
                                <Link :href="route('admin.products.index')">
                                    <button type="button" class="btn btn-light text-uppercase" style="letter-spacing: 0.1em;">Cancel</button>
                                </Link>
                                <button type="submit" class="btn btn-info text-white text-uppercase" style="letter-spacing: 0.1em;" :disabled="!form.name">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <AddQualityDialogComponent
                @update:data="eventQualityDialog"
                v-model = "addQualityDialog"
            />
            <AddDialogComponent
                @update:data="eventTypeDialog"
                v-model = "addTypeDialog"
                route_name = "admin.product_types.storeDialog"
                title = "Add Type"
            />
            <AddDialogComponent
                @update:data="eventItemNameDialog"
                v-model = "addItemNameDialog"
                route_name = "admin.item_names.storeDialog"
                title="Add Name"
            />

        </admin-layout>
    </div>
</template>


<script>
    import AdminLayout from '../../../../Layouts/AdminPanelLayout';
    import moment from 'moment';
    import Pagination from '../../../../Components/AdminPanel/Pagination';
    import { Link } from '@inertiajs/inertia-vue';
    import constant from "../../../../constant";
    import AddQualityDialogComponent from '../../../../Components/AdminPanel/AddQualityDialogComponent';
    import AddDialogComponent from '../../../../Components/AdminPanel/AddDialogComponent';

    export default {
        props: [
            'product',
            'gold_qualities',
            'types',
            'item_names',
            ],
        components: {
            AdminLayout,
            Pagination,
            Link,
            AddQualityDialogComponent,
            AddDialogComponent
        },
        data() {
            return {
                form: this.$inertia.form({
                    id: '',
                    name: '',
                    quality: '',
                    type: '',
                    item_name: '',
                    description: '',
                    alert_quantity: '',
                    image: '',
                    gold_and_gem_weight: true,
                    gem_weight: false,
                    _token: constant.CSRF
                }),
                imageforui: undefined,
                addQualityDialog: false,
                addTypeDialog: false,
                addItemNameDialog: false,
            }
        },
        computed: {

        },
        watch: {

        },
        mounted () {
            this.form.id = this.$props.product.id;
            this.form.name = this.$props.product.name;
            // this.form.quality = this.$props.product.quality;
            // this.form.type = this.$props.product.type_id;
            // this.form.item_name = this.$props.product.item_names_id;
            this.form.description = this.$props.product.description;
            this.form.alert_quantity = this.$props.product.alert_quantity;
            // this.form.imageforui = this.$props.product.image;
            this.form.gem_weight = this.$props.product.gem_weight == 1 ? true: false;
            this.form.quality = this.$props.gold_qualities.find(o => o.quality === this.$props.product.quality);
            this.form.type = this.$props.types.find(o => o.id === this.$props.product.type_id);
            this.form.item_name = this.$props.item_names.find(o => o.id === this.$props.product.item_names_id);
        },
        methods: {
            changeImage(e){
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
             //For getting Instant Uploaded Photo
            editProduct() {
                this.form.post(this.route('admin.products.product_update', this.form), {
                    preserveScroll: true,
                    onSuccess:() => {
                        // window.history.back();
                        window.location.href = constant.DOMAIN+"admin/products";
                        // window.open( constant.DOMAIN+"generate_invoice/"+res.data.order_id, "_blank");
                        Toast.fire({
                            icon: 'success',
                            title: 'Product has been updated!'
                        })
                    }
                })
            },
            eventQualityDialog(value) {
                if(value != null){
                    this.form.quality = value;
                    this.gold_qualities.push(value);
                }
                this.addQualityDialog = false;
            },
            eventTypeDialog(value) {
                this.addTypeDialog = false;
                if(value != null){
                    this.form.type = value;
                    this.types.push(value);
                }
            },
            eventItemNameDialog(value) {
                this.addItemNameDialog = false;
                if(value != null){
                    this.form.item_name = value;
                    this.item_names.push(value);
                }
            }
        }
    }
</script>
