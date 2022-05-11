<template>
    <div>
        <admin-layout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Invoice
                </h2>
            </template>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Content Wrapper. Contains page content -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="callout callout-info">
                                            <h5><i class="fas fa-info"></i> Note:</h5>
                                            This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
                                            </div>


                                            <!-- Main content -->
                                            <div class="invoice p-3 mb-3">
                                            <!-- title row -->
                                            <div class="row">
                                                <div class="col-12">
                                                <h4>
                                                    <i class="fas fa-globe"></i> {{ transaction.business.name }} / {{ transaction.business_location.name }}
                                                    <small class="float-right">Date: {{ dateTime(transaction.transaction_date)}}</small>
                                                </h4>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- info row -->
                                            <div class="row invoice-info">
                                                <div class="col-sm-4 invoice-col">
                                                Customer Info
                                                <address>
                                                    <strong>{{transaction.contact.name}}</strong><br>
                                                    {{transaction.contact.address}}<br>
                                                    Phone: {{transaction.contact.mobile1}},{{transaction.contact.mobile2}}<br>
                                                    Email: {{transaction.contact.email}}
                                                </address>
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-4 invoice-col">

                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-4 invoice-col">
                                                <b>Invoice #{{transaction.invoice_no}}</b><br>
                                                <br>
                                                <b>Payment Due:</b> {{ dateTime(transaction.transaction_date)}}<br>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->

                                            <!-- Table row -->
                                            <div class="row">
                                                <div class="col-12 table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>အမျိုးအစား</th>
                                                                <th>ကျပ်</th>
                                                                <th>ပဲ </th>
                                                                <th>ရွေး</th>
                                                                <th>တန်ဖိုး</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>ရွှေချိန်</td>
                                                                <td>{{item.gold_weight.kyat}}</td>
                                                                <td>{{item.gold_weight.pal}}</td>
                                                                <td>{{item.gold_weight.yway}}</td>
                                                                <td>{{item.gold_price}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>ကျောက်ချိန်</td>
                                                                <td>{{item.gem_weight.kyat}}</td>
                                                                <td>{{item.gem_weight.pal}}</td>
                                                                <td>{{item.gem_weight.yway}}</td>
                                                                <td>{{item.gem_price}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>အလျော့တွက်</td>
                                                                <td>{{item.fee.kyat}}</td>
                                                                <td>{{item.fee.pal}}</td>
                                                                <td>{{item.fee.yway}}</td>
                                                                <td>{{item.fee_price}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>လက်ခ</td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td>{{item.fee_for_making}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>စုစုပေါင်း</td>
                                                                <td>{{order.total_weight.kyat}}</td>
                                                                <td>{{order.total_weight.pal}}</td>
                                                                <td>{{order.total_weight.yway}}</td>
                                                                <td>{{order.total_before}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->

                                            <div class="row">
                                                <!-- accepted payments column -->
                                                <div class="col-6">
                                                    <p class="lead">Item: {{item.name}}</p>
                                                    <img class="w-10 h-10 rounded-full" :src="item.image1" alt=""  style="width:100px;"/>
                                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                                        Product sku :{{ product.product_sku }}
                                                    </p>
                                                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                                        Item sku :{{ item.item_sku }}
                                                    </p>
                                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                                        {{ item.item_description }}
                                                    </p>
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-6">
                                                    <p class="lead">Amount Due {{ dateTime(transaction.transaction_date)}}</p>

                                                    <div class="table-responsive">
                                                        <table class="table">
                                                        <tr>
                                                            <th style="width:50%">လျော့ငွေ:</th>
                                                            <td>{{order.discount_amount}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>ကျသင့်ငွေ</th>
                                                            <td>{{order.final_total}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>ပေးငွေ:</th>
                                                            <td>{{order.paid_money}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>ကျန်ငွေ:</th>
                                                            <td>{{order.credit_money}}</td>
                                                        </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->

                                            <!-- this row will not appear when printing -->
                                            <div class="row no-print">
                                                <div class="col-12">
                                                <a href="#" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                                                <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                                                    Payment
                                                </button>
                                                <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                                    <i class="fas fa-download"></i> Generate PDF
                                                </button>
                                                </div>
                                            </div>
                                            </div>
                                            <!-- /.invoice -->
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                    <!-- /.content -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                         <div class="col-6" v-if="product.draft == 1">
                            <form @submit.prevent="productFormSubmit">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="">Product</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" placeholder="Name" :value="product.product_sku" autofocus="autofocus" autocomplete="off" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" placeholder="Name" v-model="product_form.name" autofocus="autofocus" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Description</label>
                                            <input type="text" class="form-control" placeholder="Description" v-model="product_form.description" autofocus="autofocus" autocomplete="off">
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" v-model="product_form.approve_changes">
                                            <label class="form-check-label" for="exampleCheck1">Approve changes</label>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-6" v-if="item.draft == 1">
                            <form @submit.prevent="itemFormSubmit">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="">Item</h4>
                                    </div>
                                    <div class="card-body">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" placeholder="Name" v-model="item_form.name" autofocus="autofocus" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Description</label>
                                                <input type="text" class="form-control" placeholder="Description" v-model="item_form.description" autofocus="autofocus" autocomplete="off">
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" v-model="item_form.approve_changes">
                                                <label class="form-check-label" for="exampleCheck1">Approve changes</label>
                                            </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                         <div class="col-6" v-if="type.draft == 1">
                            <form @submit.prevent="typeFormSubmit">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="">Type</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Key</label>
                                            <input type="text" class="form-control" placeholder="Name" :value="type.key" autofocus="autofocus" autocomplete="off" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" placeholder="Name" v-model="type_form.name" autofocus="autofocus" autocomplete="off">
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" v-model="type_form.approve_changes">
                                            <label class="form-check-label" for="exampleCheck1">Approve changes</label>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-6" v-if="itemname.draft == 1">
                            <form @submit.prevent="itemNameFormSubmit">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="">ItemName</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Key</label>
                                            <input type="text" class="form-control" placeholder="Name" :value="itemname.key" autofocus="autofocus" autocomplete="off" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" placeholder="Description" v-model="itemname_form.name" autofocus="autofocus" autocomplete="off">
                                        </div>
                                            <div class="form-check">
                                            <input type="checkbox" class="form-check-input" v-model="itemname_form.approve_changes">
                                            <label class="form-check-label" for="exampleCheck1">Approve changes</label>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
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
    import { Link } from '@inertiajs/inertia-vue';
    import { pickBy, throttle } from 'lodash';
    import axios from 'axios';

    export default {
        props: [
            'order',
            'transaction',
            'item',
            'product',
            'type',
            'itemname'
            ],
        components: {
            AdminLayout,
            Pagination,
            Link
        },
        created() {
            if(this.product.draft == 1) this.productForm();
            if(this.item.draft == 1) this.itemForm();
            if(this.itemname.draft == 1) this.itemnameForm();
            if(this.type.draft == 1) this.typeForm();
        },
        data() {
            return {
                product_form : {
                    'id': '',
                    'name': '',
                    'image': '',
                    'imagefile': undefined,
                    'description': '',
                    'approve_changes': false
                },
                item_form : {
                    'id': '',
                    'name': '',
                    'image': '',
                    'imagefile': undefined,
                    'description': '',
                    'approve_changes': false

                },
                itemname_form : {
                    'id': '',
                    'name': '',
                    'key': '',
                    'approve_changes': false

                },
                type_form : {
                    'id': '',
                    'name': '',
                    'key': '',
                    'approve_changes': false

                }
            }
        },

        methods: {
            dateTime(value) {
                return moment(value).format('DD/MM/YYYY');
            },
            productForm() {
                this.product_form.id = this.product.id;
                this.product_form.name = this.product.name;
                this.product_form.description = this.product.description;
            },
            itemForm() {
                this.item_form.id = this.item.id;
                this.item_form.name = this.item.name;
                this.item_form.description = this.item.description;
            },
            itemnameForm() {
                this.itemname_form.id = this.itemname.id;
                this.itemname_form.name = this.itemname.name;
            },
            typeForm() {
                this.type_form.id = this.type.id;
                this.type_form.name = this.type.name;
            },
            productFormSubmit() {
                let data = { product_form: this.product_form }
                axios.post('/admin/orders/product_form_save', data)
                    .then(res => {
                        this.product.draft = 0;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            itemFormSubmit() {
                let data = { item_form: this.item_form }
                axios.post('/admin/orders/item_form_save', data)
                    .then(res => {
                        this.item.draft = 0;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            typeFormSubmit() {
                let data = { type_form: this.type_form }
                axios.post('/admin/orders/type_form_save', data)
                    .then(res => {
                        this.type.draft = 0;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            itemNameFormSubmit() {
                let data = { itemname_form: this.itemname_form }
                axios.post('/admin/orders/itemname_form_save', data)
                    .then(res => {
                        this.itemname.draft = 0;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        }
    }
</script>
