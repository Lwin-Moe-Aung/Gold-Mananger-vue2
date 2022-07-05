<template>
    <div>
        <admin-layout>
            <v-snackbar v-model="snackbar" top collor="warrning">
                <span>Voucher form ဖြည့်ဖို့လိုအပ်သည်။</span>
                <v-btn  color="white" @click="snackbar = false">close</v-btn>
            </v-snackbar>

            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ formTitle }}
                </h2>
            </template>
            <section class="content">
                <div class="container-fluid" data-app>
                    <div class="alert alert-warning" v-if="alertbox">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close"  @click="alertbox = false">&times;</a>
                        <strong>Warning!</strong> Validatoin Error! please check again forms.
                    </div>
                    <form ref="productform" @submit.prevent="checkMode">
                        <div class="card card-primary card-outline" data-select2-id="32">
                            <div class="card-header">
                                <Link :href="route('admin.purchase_returns.index')">
                                    <button class="btn btn-primary float-left mr-3" style="h">
                                        <i class="fas fa-long-arrow-alt-left" aria-hidden="true" ></i>
                                    </button>
                                </Link>
                                <h3 class="card-title">Item Sku and Invoice No ကိုသုံးပီးရှာဖွေနိုင်သည်</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="display: block;" data-select2-id="31">
                                <div class="row">
                                    <div class="col-12 col-sm-4 border-right">
                                        <div class="form-group">
                                            <label for="name">Item Sku</label>
                                            <AutoCompleteSearchComponent
                                                @update:data="selectItemSku"
                                                route_name = "admin.item_sku_search"
                                                v-model = "item"
                                                label="item_sku"
                                                placeholder="Search Item Sku"
                                            />
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4 border-right">
                                        <div class="form-group">
                                            <label for="permissions">Invoice No</label>
                                            <AutoCompleteSearchComponent
                                                @update:data="selectInvoiceNo"
                                                route_name = "admin.invoice_no_search"
                                                v-model = "transaction"
                                                label="invoice_no"
                                                placeholder="Search Invoice No"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ThreeMultiSelectComponent
                            @update:data="changeProductSku"
                            v-model = "form.product_sku"
                        />
                        <div class="card card-primary card-outline" data-select2-id="32">
                            <div class="card-header">
                                <h3 class="card-title">Product/ပေါက်ဈေး/Customer</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="display: block;" data-select2-id="31">
                                <div class="row">
                                    <div class="col-12 col-sm-4 border-right">
                                        <div class="form-group">
                                            <label for="permissions">Product Sku</label>
                                            <div class="row">
                                                <div class="col-sm-10 col-xs-10">
                                                    <AutoCompleteSearchComponent
                                                        @update:data="selectProductSku"
                                                        route_name = "admin.product_sku_search"
                                                        v-model = "product"
                                                        label="product_sku"
                                                        placeholder="Search Procut Sku"
                                                    />
                                                </div>
                                                <div class="col-sm-2 col-xs-2">
                                                    <button type="button" class="btn btn-block bg-gradient-success text-white"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.product_id}">
                                                Product ရွေးဖို့လိုအပ့်ပါသည်
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 border-right">
                                        <DailySetupComponent
                                            @update:data="editDailySetup"
                                            v-model = "form.daily_setup"
                                            :quality = "product.quality"
                                            placeholder="Daily Setup"
                                        />
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.daily_setup}">
                                            ပေါက်ဈေးရွေးပေးပါ။
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 border-right">
                                        <div class="form-group">
                                            <label for="permissions">Customer</label>
                                            <div class="row">
                                                <div class="col-sm-10 col-xs-10">
                                                    <AutoCompleteSearchComponent
                                                        @update:data="selectCustomer"
                                                        route_name = "pos.customer_search"
                                                        v-model = "customer"
                                                        label="search_name"
                                                        placeholder="Search Customer"
                                                    />
                                                </div>
                                                <div class="col-sm-2 col-xs-2">
                                                    <button type="button" class="btn btn-block bg-gradient-success text-white"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.customer_id}">
                                                Customer ရွေးပေးပါ။
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card card-primary card-outline" data-select2-id="32">
                            <div class="card-header">
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <h3 class="card-title">တခြားလိုအပ်သော အချက်အလက်များ</h3>
                            </div>
                            <div class="card-body" style="display: block;" data-select2-id="31">
                                <div class="row">
                                    <div class="col-12 col-sm-6">

                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <!-- <input type="text" class="form-control" placeholder="Name" v-model="form.name" :class="{ 'is-invalid' : form.errors.name }" autofocus="autofocus" autocomplete="off"> -->
                                            <input type="text" v-model="form.name" class="form-control form-control" autofocus="autofocus" autocomplete="off">
                                        </div>

                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.name}">
                                            {{ form.errors.name }}
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
                                        <div class="form-group">
                                            <label for="name">Item Description</label>
                                            <textarea  class="form-control" placeholder=" Item Description"
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
                                            <label for="name">Additional Note</label>
                                            <textarea  class="form-control" placeholder="Transaction Description"
                                                v-model="form.additional_note" :class="{ 'is-invalid' : form.errors.tran_description }"
                                                autofocus="autofocus" autocomplete="off"
                                                rows="4" cols="70"
                                            >
                                            </textarea>
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.tran_description}">
                                            {{ form.errors.additional_note }}
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="row" v-if="form.product_id != ''">
                            <div class="col-md-12">
                                <div class="card card-success card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                        <i class="fas fa-edit"></i>
                                            Voucher form
                                        </h3>
                                    </div>

                                    <div class="alert alert-danger" v-if="snackbar">
                                        <strong>Warning!</strong><a href="#" class="alert-link">Voucher form ဖြည့်ဖို့လိုအပ်သည်။</a>.
                                    </div>

                                    <div class="card-body pad table-responsive" >
                                        <table class="table table-bordered text-center">
                                            <tbody>
                                                <tr>
                                                    <th width="30%"></th>
                                                    <th width="15%"><code>ကျပ်</code></th>
                                                    <th width="15%"><code>ပဲ</code></th>
                                                    <th width="15%"><code>ရွေး</code></th>
                                                    <th width="25%">ကျသင့်ငွေ</th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>ရွှေ+ကျောက်ချိန်</label>
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                            v-model.trim="$v.form.gold_plus_gem_weight.kyat.$model"
                                                            :class="{'is-invalid': validationStatus($v.form.gold_plus_gem_weight.kyat)}"
                                                            class="form-control" placeholder="ကျပ်" style="min-width: 56px;">
                                                        <div v-if="!$v.form.gold_plus_gem_weight.kyat.required" class="invalid-feedback">required</div>
                                                        <div v-if="!$v.form.gold_plus_gem_weight.kyat.minValue" class="invalid-feedback">You must greater than {{ $v.form.gold_plus_gem_weight.kyat.$params.minValue.min }}.</div>
                                                        <div v-if="!$v.form.gold_plus_gem_weight.kyat.maxValue" class="invalid-feedback">You must less than {{ $v.form.gold_plus_gem_weight.kyat.$params.maxValue.max }}</div>
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                            v-model.trim="$v.form.gold_plus_gem_weight.pal.$model"
                                                            :class="{'is-invalid': validationStatus($v.form.gold_plus_gem_weight.pal)}"
                                                            class="form-control" placeholder="ပဲ" style="min-width: 56px;">
                                                        <div v-if="!$v.form.gold_plus_gem_weight.pal.required" class="invalid-feedback">required</div>
                                                        <div v-if="!$v.form.gold_plus_gem_weight.pal.minValue" class="invalid-feedback">You must greater than {{ $v.form.gold_plus_gem_weight.pal.$params.minValue.min }}.</div>
                                                        <div v-if="!$v.form.gold_plus_gem_weight.pal.maxValue" class="invalid-feedback">You must less than {{ $v.form.gold_plus_gem_weight.pal.$params.maxValue.max }}</div>
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                            v-model.trim="$v.form.gold_plus_gem_weight.yway.$model"
                                                            :class="{'is-invalid': validationStatus($v.form.gold_plus_gem_weight.yway)}"
                                                            class="form-control" placeholder="ရွေး" style="min-width: 56px;">
                                                        <div v-if="!$v.form.gold_plus_gem_weight.yway.required" class="invalid-feedback">required</div>
                                                        <div v-if="!$v.form.gold_plus_gem_weight.yway.minValue" class="invalid-feedback">You must greater than {{ $v.form.gold_plus_gem_weight.yway.$params.minValue.min }}.</div>
                                                        <div v-if="!$v.form.gold_plus_gem_weight.yway.maxValue" class="invalid-feedback">You must less than {{ $v.form.gold_plus_gem_weight.yway.$params.maxValue.max }}</div>
                                                    </td>
                                                    <td>
                                                        <input type="number" :value="goldPrice" class="form-control" placeholder="တန်ဖိုး" style="min-width: 120px;" disabled>
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <td>
                                                        <label>ကျောက်ချိန်</label>
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                            v-model.trim="$v.form.gem_weight.kyat.$model"
                                                            :class="{'is-invalid': validationStatus($v.form.gem_weight.kyat)}"
                                                            class="form-control" placeholder="ကျပ်" style="min-width: 56px;" :disabled="product.gem_weight == '0'">
                                                        <div v-if="!$v.form.gem_weight.kyat.required" class="invalid-feedback">required</div>
                                                        <div v-if="!$v.form.gem_weight.kyat.minValue" class="invalid-feedback">You must greater than {{ $v.form.gem_weight.kyat.$params.minValue.min }}.</div>
                                                        <div v-if="!$v.form.gem_weight.kyat.maxValue" class="invalid-feedback">You must less than {{ $v.form.gem_weight.kyat.$params.maxValue.max }}</div>
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                            v-model.trim="$v.form.gem_weight.pal.$model"
                                                            :class="{'is-invalid': validationStatus($v.form.gem_weight.pal)}"
                                                            class="form-control" placeholder="ပဲ" style="min-width: 56px;" :disabled="product.gem_weight == '0'">
                                                        <div v-if="!$v.form.gem_weight.pal.required" class="invalid-feedback">required</div>
                                                        <div v-if="!$v.form.gem_weight.pal.minValue" class="invalid-feedback">You must greater than {{ $v.form.gem_weight.pal.$params.minValue.min }}.</div>
                                                        <div v-if="!$v.form.gem_weight.pal.maxValue" class="invalid-feedback">You must less than {{ $v.form.gem_weight.pal.$params.maxValue.max }}</div>

                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                            v-model.trim="$v.form.gem_weight.yway.$model"
                                                            :class="{'is-invalid': validationStatus($v.form.gem_weight.yway)}"
                                                            class="form-control" placeholder="ရွေး" style="min-width: 56px;" :disabled="product.gem_weight == '0'">
                                                        <div v-if="!$v.form.gem_weight.yway.required" class="invalid-feedback">required</div>
                                                        <div v-if="!$v.form.gem_weight.yway.minValue" class="invalid-feedback">You must greater than {{ $v.form.gem_weight.yway.$params.minValue.min }}.</div>
                                                        <div v-if="!$v.form.gem_weight.yway.maxValue" class="invalid-feedback">You must less than {{ $v.form.gem_weight.yway.$params.maxValue.max }}</div>

                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                            v-model.trim="$v.form.gem_price.$model"
                                                            :class="{'is-invalid': validationStatus($v.form.gem_price)}"
                                                            class="form-control" placeholder="တန်ဖိုး" style="min-width: 56px;" :disabled="product.gem_weight == '0'">
                                                        <div v-if="!$v.form.gem_price.required" class="invalid-feedback">required</div>
                                                        <div v-if="!$v.form.gem_price.minValue" class="invalid-feedback">You must greater than {{ $v.form.gem_price.$params.minValue.min }}.</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>အလျော့တွက်</label>
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                            v-model.trim="$v.form.fee.kyat.$model"
                                                            :class="{'is-invalid': validationStatus($v.form.fee.kyat)}"
                                                            class="form-control" placeholder="ကျပ်" style="min-width: 56px;">
                                                        <div v-if="!$v.form.fee.kyat.required" class="invalid-feedback">required</div>
                                                        <div v-if="!$v.form.fee.kyat.minValue" class="invalid-feedback">You must greater than {{ $v.form.fee.kyat.$params.minValue.min }}.</div>
                                                        <div v-if="!$v.form.fee.kyat.maxValue" class="invalid-feedback">You must less than {{ $v.form.fee.kyat.$params.maxValue.max }}</div>
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                            v-model.trim="$v.form.fee.pal.$model"
                                                            :class="{'is-invalid': validationStatus($v.form.fee.pal)}"
                                                            class="form-control" placeholder="ပဲ" style="min-width: 56px;">
                                                        <div v-if="!$v.form.fee.pal.required" class="invalid-feedback">required</div>
                                                        <div v-if="!$v.form.fee.pal.minValue" class="invalid-feedback">You must greater than {{ $v.form.fee.pal.$params.minValue.min }}.</div>
                                                        <div v-if="!$v.form.fee.pal.maxValue" class="invalid-feedback">You must less than {{ $v.form.fee.pal.$params.maxValue.max }}</div>
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                            v-model.trim="$v.form.fee.yway.$model"
                                                            :class="{'is-invalid': validationStatus($v.form.fee.yway)}"
                                                            class="form-control" placeholder="ရွေး" style="min-width: 56px;">
                                                        <div v-if="!$v.form.fee.yway.required" class="invalid-feedback">required</div>
                                                        <div v-if="!$v.form.fee.yway.minValue" class="invalid-feedback">You must greater than {{ $v.form.fee.yway.$params.minValue.min }}.</div>
                                                        <div v-if="!$v.form.fee.yway.maxValue" class="invalid-feedback">You must less than {{ $v.form.fee.yway.$params.maxValue.max }}</div>
                                                    </td>
                                                    <td>
                                                        <input type="number" :value="feePrice" class="form-control" placeholder="တန်ဖိုး" disabled>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>လက်ခ</label>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <input type="number"
                                                            v-model.trim="$v.form.fee_for_making.$model"
                                                            :class="{'is-invalid': validationStatus($v.form.fee_for_making)}"
                                                            class="form-control" placeholder="တန်ဖိုး" style="min-width: 56px;">
                                                        <div v-if="!$v.form.fee_for_making.required" class="invalid-feedback">required</div>
                                                        <div v-if="!$v.form.fee_for_making.minValue" class="invalid-feedback">You must greater than {{ $v.form.fee_for_making.$params.minValue.min }}.</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>စုစုပေါင်း</label>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <input type="number" :value="totalBefore" class="form-control" placeholder="တန်ဖိုး" disabled>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>လျော့ငွေ</label>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <input type="number"
                                                            v-model.trim="$v.form.item_discount.$model"
                                                            :class="{'is-invalid': validationStatus($v.form.item_discount)}"
                                                            class="form-control" placeholder="တန်ဖိုး" style="min-width: 56px;">
                                                        <div v-if="!$v.form.item_discount.minValue" class="invalid-feedback">You must greater than {{ $v.form.item_discount.$params.minValue.min }}.</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>ကျသင့်ငွေ</label>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <input type="number" :value="finalTotal" class="form-control" placeholder="တန်ဖိုး" disabled>
                                                        <!-- <input type="number"
                                                            v-model.trim="$v.form.final_total.$model"
                                                            :class="{'is-invalid': validationStatus($v.form.final_total)}"
                                                            class="form-control" placeholder="တန်ဖိုး" style="min-width: 56px;" disabled> -->
                                                        <!-- <div v-if="!$v.form.final_total.required" class="invalid-feedback">Voucher Form ဖြည့်ဖို့လိုအပ့်နေပါသည်။</div> -->
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer justify-content-right">
                                        <Link :href="route('admin.purchases.index')">
                                            <button type="button" class="btn btn-light text-uppercase" style="letter-spacing: 0.1em;">Cancel</button>
                                        </Link>
                                        <button type="submit" class="btn btn-primary text-uppercase text-white" style="letter-spacing: 0.1em;" >{{ buttonTxt }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

        </admin-layout>
    </div>
</template>


<script>
    import AdminLayout from '../../../../Layouts/AdminPanelLayout';
    import Pagination from '../../../../Components/AdminPanel/Pagination';
    import { Link } from '@inertiajs/inertia-vue';
    import { required, minValue, maxValue} from 'vuelidate/lib/validators'
    import AutoCompleteSearchComponent from '../../../../Components/AdminPanel/AutoCompleteSearchComponent';
    import ThreeMultiSelectComponent from '../../../../Components/AdminPanel/ThreeMultiSelectComponent';
    import DailySetupComponent from '../../../../Components/AdminPanel/DailySetupComponent';
    import InfoForm from './InfoForm';
    import axios from "axios";


    export default {
        props: [
            // 'products',
            'suppliers',
            // 'transaction',
            'purchase',
            // 'item',
            'product_for_sku',
            'contact',
            'daily_setup_list',
            'errors'
        ],
        components: {
            AdminLayout,
            Pagination,
            Link,
            AutoCompleteSearchComponent,
            ThreeMultiSelectComponent,
            DailySetupComponent,
            InfoForm
        },
        data() {
            return {
                form: this.$inertia.form({
                    item_sku:"",
                    invoice_no:"",
                    item_id: "",
                    name: "",
                    product_id: "",
                    customer_id: "",
                    sell_id: "",
                    daily_setup: { daily_setup_id: "", kyat: "", pal: "", yway: "" },
                    gold_plus_gem_weight: { kyat: "0", pal: "0", yway: "0" },
                    gold_price: 0,
                    gem_weight: { kyat: "0", pal: "0", yway: "0" },
                    gem_price: 0,
                    fee: { kyat: "0", pal: "0", yway: "0" },
                    fee_price: 0,
                    fee_for_making: 0,
                    before_total: 0,
                    discount_amount: 0,
                    final_total: "",
                    image: "",
                    item_description: "",
                    additional_note: "",
                    product_sku:"",
                }),
                supplier: '',
                imageforui: undefined,
                //nn
                item:[],
                transaction:[],
                product:[],
                customer:[],
                snackbar:false,
                alertbox:false,
                // daily_setup: { daily_setup_id: "", kyat: "", pal: "", yway: "" },
            }
        },
        created() {
            console.log(this.form.errors);
        },
        methods: {
            validationStatus: function(validation) {
                return typeof validation != "undefined" ? validation.$error : false;
            },
            selectItemSku(value){
                if(value == null){
                    this.resetData();
                    return;
                }
                axios.get(this.route('admin.search_by_item_sku', value.item_sku))
                    .then((response) => {
                        this.fillData(response.data.data);
                });
            },
            selectInvoiceNo(value) {
                if(value == null){
                    this.resetData();
                    return;
                }
                axios.get(this.route('admin.search_by_invoice_no', value.invoice_no))
                    .then((response) => {
                        this.fillData(response.data.data);
                });
            },
            fillData(data) {
                this.item = data.item;
                this.transaction = data.transaction;
                this.product = data.product;
                this.form.daily_setup = data.daily_setup;
                this.customer = data.customer;
                this.form.item_sku = this.item.item_sku;
                this.form.invoice_no = this.transaction.invoice_no;
                this.form.item_id = this.item.id;
                this.form.sell_id = data.sell.id;
                this.form.name = this.item.name;
                this.form.product_id = this.product.id;
                this.form.customer_id = this.customer.id;
                this.form.gold_plus_gem_weight = this.item.gold_plus_gem_weight;
                this.form.gem_weight = this.item.gem_weight;
                this.form.fee = this.item.fee;
                this.form.fee_for_making = data.sell.fee_for_making;
                this.imageforui = this.item.image;
                this.form.item_description = this.item.item_description;
                this.form.additional_note = this.transaction.additional_note;
                this.form.product_sku = this.product.product_sku;
                // console.log(Object.keys(this.product).length);
            },
            dailyPrice(value){
                return value/16 * this.product.quality;
            },
            resetData(){
                this.item = [];
                this.transaction = [];
                this.product = [];
                this.form.daily_setup = [];
                this.customer = [];
                this.imageforui = "";
                this.form.reset();
            },
            changeProductSku(value) {
                if(value == 'onChangeQ' || value == 'onChangeT') {
                    this.product = [];
                    this.form.daily_setup = { daily_setup_id: "", kyat: "", pal: "", yway: "" };
                    // this.settingDailySetup();
                }else{
                    this.product = value;
                    this.form.product_sku = value.product_sku;
                    this.settingDailySetup();
                }
            },
            selectProductSku(value) {
                if(value == null){
                    this.product = [];
                    this.form.product_sku = "";
                    this.form.product_id = "";
                    this.form.daily_setup = { daily_setup_id: "", kyat: "", pal: "", yway: "" };
                }else{
                    this.product = value;
                    this.form.product_sku = value.product_sku;
                    this.form.product_id = value.id;
                    this.settingDailySetup();
                }
            },
            selectCustomer(value) {
                this.customer = value;
                this.form.customer_id = value.id;
            },
            editDailySetup(value){
                this.form.daily_setup = value;
            },
            settingDailySetup() {
                if(this.product.gem_weight == '0')this.form.reset('gem_weight','gem_price');

                let daily_value = this.$page.props.daily_setup_purchase_return[this.product.quality].kyat;

                let value = {
                    daily_setup_id : this.$page.props.daily_setup_purchase_return[this.product.quality].daily_setup_id,
                    kyat : daily_value,
                    pal : daily_value / 16,
                    yway :  daily_value / 128,
                }
                this.form.daily_setup = value;
            },
            selectImage(e){
                let file = e.target.files[0];
                this.form.image = e.target.files[0];
                let reader = new FileReader();
                if(file['size'] < 2111775)
                {
                    reader.onloadend = (file) => {
                        this.imageforui = reader.result;
                    }
                    reader.readAsDataURL(file);
                }else{
                    alert('File size can not be bigger than 2 MB')
                }
            },
            createPurchaseReturns(){
                this.$v.$touch();
                if (this.$v.$pendding || this.$v.$error) return;
                if(this.form.final_total == ""){
                    this.snackbar = true;
                    return;
                }

                // if(this.form.product_id == "" || this.form.customer_id == "" || this.form.name == ""){
                //     this.alertbox = true;
                //     return;
                // }
                this.form.post(this.route('admin.purchase_returns.store'), {
                    preserveScroll: true,
                    onSuccess:() => {
                        Object.assign(this.$data, this.$options.data.call(this));
                        Toast.fire({
                            icon: 'success',
                            title: 'New Purchase return created!'
                        })
                    },
                })
            },
        },
        computed: {

            formTitle() {
                return this.transaction == null ? 'Create New Purchase' : 'Edit Current Purchase';
            },
            buttonTxt() {
                return this.transaction == null ? 'Create' : 'Update';
            },
            checkMode() {
                let hello = null;
                return hello == null ? this.createPurchaseReturns : this.editPurchaseReturns
            },
            goldPrice() {
                if(Object.keys(this.product).length == 0)return;
                let kyat = parseInt(this.form.gold_plus_gem_weight.kyat) -  parseInt(this.form.gem_weight.kyat);
                let pal = parseInt(this.form.gold_plus_gem_weight.pal) -  parseInt(this.form.gem_weight.pal);
                let yway = this.form.gold_plus_gem_weight.yway -  this.form.gem_weight.yway;
                let kyat_p = kyat * parseInt(this.form.daily_setup.kyat);
                let pal_p = pal * parseInt(this.form.daily_setup.pal);
                let yway_p = yway * this.form.daily_setup.yway;
                let gold_price = kyat_p + pal_p + yway_p;

                if (isNaN(gold_price)) gold_price = "";
                this.form.gold_price = parseInt(gold_price);
                return  parseInt(gold_price);
            },
            feePrice() {
                if(Object.keys(this.product).length == 0)return;

                let kyat_p = parseInt(this.form.fee.kyat) * parseInt(this.form.daily_setup.kyat);
                let pal_p = parseInt(this.form.fee.pal) * parseInt(this.form.daily_setup.pal);
                let yway_p =this.form.fee.yway * this.form.daily_setup.yway;
                let fee_price = kyat_p + pal_p + yway_p;

                if (isNaN(fee_price)) fee_price = "";
                this.form.fee_price = parseInt(fee_price);

                return parseInt(fee_price);
            },
            totalBefore() {
                if(Object.keys(this.product).length == 0)return;
                let before_total =
                    parseInt(this.form.gold_price) +
                    parseInt(this.form.gem_price) +
                    parseInt(this.form.fee_price) +
                    parseInt(this.form.fee_for_making);
                if (isNaN(before_total)) before_total = "";
                this.form.before_total = before_total;

                return before_total;
            },
            finalTotal() {
                if(Object.keys(this.product).length == 0)return;
                let final_total = parseInt(this.form.before_total) - parseInt(this.form.discount_amount);
                if (isNaN(final_total)) final_total = "";
                this.form.final_total = final_total;
                this.form.paid_money = final_total;
                return final_total;
            },
        },
        validations: {
            form: {
                daily_setup: {required},
                gold_plus_gem_weight:{
                    kyat: {required, minValue: minValue(0), maxValue: maxValue(100)},
                    pal: {required, minValue: minValue(0), maxValue: maxValue(15)},
                    yway: {required, minValue: minValue(0), maxValue: maxValue(7.9)},
                },
                gem_weight:{
                    kyat: {required, minValue: minValue(0), maxValue: maxValue(100)},
                    pal: {required, minValue: minValue(0), maxValue: maxValue(15)},
                    yway: {required, minValue: minValue(0), maxValue: maxValue(7.9)},
                },
                gem_price: {required, minValue: minValue(0)},
                fee:{
                    kyat: {required, minValue: minValue(0), maxValue: maxValue(100)},
                    pal: {required, minValue: minValue(0), maxValue: maxValue(15)},
                    yway: {required, minValue: minValue(0), maxValue: maxValue(7.9)},
                },
                fee_for_making:{required, minValue: minValue(0)},
                item_discount:{minValue: minValue(0)}
            },
        },
    }
</script>
<style>
hr {
  margin-top: 1rem;
  margin-bottom: 1rem;
  border: 0;
  border-top: 1px solid rgba(0, 0, 0, 0.1);
}
.fas.fa-plus{
    margin-left: -4px;
}
.btn.btn-block.bg-gradient-success {
    margin-left: -11px;
}
</style>
