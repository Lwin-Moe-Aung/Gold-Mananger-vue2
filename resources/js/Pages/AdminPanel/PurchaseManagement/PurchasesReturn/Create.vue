<template>
    <div>
        <admin-layout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ formTitle }}
                </h2>
            </template>
            <section class="content">
                <div class="container-fluid" data-app>
                    <form ref="productform" @submit.prevent="checkMode">
                        <div class="card card-primary card-outline" data-select2-id="32">
                            <div class="card-header">
                                <Link :href="route('admin.purchases.index')">
                                    <button class="btn btn-primary float-left mr-3" style="h">
                                        <i class="fas fa-long-arrow-alt-left" aria-hidden="true" ></i>
                                    </button>
                                </Link>
                                <h3 class="card-title">Search Form Item Sku and Invoice No</h3>
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
                                            <div v-if="!$v.form.name.required" class="invalid-feedback">The name field is required.</div>
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.name}">
                                            {{ form.errors.name }}
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
                                            <div v-if="!$v.supplier.required" class="invalid-feedback">The Supplier field is required.</div>
                                            <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.supplier}">
                                                {{ form.errors.supplier }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ThreeMultiSelectComponent
                            @update:data="changeProductSku"
                            v-model = "product.product_sku"
                        />
                        <div class="card card-primary card-outline" data-select2-id="32">
                            <div class="card-header">
                                <h3 class="card-title">Select Form and Show Daily Setup</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
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
                                            <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.supplier}">
                                                {{ form.errors.supplier }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 border-right">
                                        <DailySetupComponent
                                            @update:data="editDailySetup"
                                            :quality = "product != null ? `${product.quality}`:null"
                                            placeholder="Daily Setup"
                                        />
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
                                            <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.supplier}">
                                                {{ form.errors.supplier }}
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
                                <h3 class="card-title">Information</h3>
                            </div>
                            <div class="card-body" style="display: block;" data-select2-id="31">
                                <div class="row">
                                    <div class="col-12 col-sm-6">

                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <!-- <input type="text" class="form-control" placeholder="Name" v-model="form.name" :class="{ 'is-invalid' : form.errors.name }" autofocus="autofocus" autocomplete="off"> -->
                                            <input type="text" v-model.trim="$v.form.name.$model" :class="{'is-invalid': validationStatus($v.form.name)}" class="form-control form-control" autofocus="autofocus" autocomplete="off">
                                            <div v-if="!$v.form.name.required" class="invalid-feedback">The name field is required.</div>
                                        </div>

                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.name}">
                                            {{ form.errors.name }}
                                        </div>

                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="permissions">Supplier</label>
                                            <div class="row">
                                                <div class="col-sm-11 col-xs-11">
                                                    <multiselect
                                                        v-model.trim="$v.supplier.$model"
                                                        :options="suppliers"
                                                        :multiple="false"
                                                        :taggable="true"
                                                        placeholder="Supplier name"
                                                        label="name"
                                                        track-by="id"
                                                        @input="changeSupplier"
                                                        :class="{'is-invalid': validationStatus($v.supplier)}"
                                                    ></multiselect>
                                                    <div v-if="!$v.supplier.required" class="invalid-feedback">The Supplier field is required.</div>
                                                </div>
                                                <div class="col-sm-1 col-xs-1">
                                                    <button type="button" class="btn btn-success btn-flat text-white float-right"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
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
                                            <div class="row">
                                                <div class="col-sm-11 col-xs-11">

                                                </div>
                                                <div class="col-sm-1 col-xs-1">
                                                    <button type="button" class="btn btn-success btn-flat text-white float-right"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.item_name}">
                                                {{ form.errors.item_name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">

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
                                            <label for="name">Transaction Description</label>
                                            <textarea  class="form-control" placeholder="Transaction Description"
                                                v-model="form.tran_description" :class="{ 'is-invalid' : form.errors.tran_description }"
                                                autofocus="autofocus" autocomplete="off"
                                                rows="4" cols="70"
                                            >
                                            </textarea>
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.tran_description}">
                                            {{ form.errors.tran_description }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
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
                                    <div class="col-12 col-sm-6">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-success card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                        <i class="fas fa-edit"></i>
                                            Voucher form
                                        </h3>
                                    </div>
                                    <div class="card-body pad table-responsive">
                                        <!-- <table class="table table-bordered text-center">
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
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table> -->
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
    import moment from 'moment';
    import Pagination from '../../../../Components/AdminPanel/Pagination';
    import { Link } from '@inertiajs/inertia-vue';
    import { required, minValue, maxValue} from 'vuelidate/lib/validators'
    import AutoCompleteSearchComponent from '../../../../Components/AdminPanel/AutoCompleteSearchComponent';
    import ThreeMultiSelectComponent from '../../../../Components/AdminPanel/ThreeMultiSelectComponent';
    import DailySetupComponent from '../../../../Components/AdminPanel/DailySetupComponent';

    export default {
        props: [
            // 'products',
            'suppliers',
            // 'transaction',
            'purchase',
            // 'item',
            'product_for_sku',
            'contact',
            'daily_setup_list'
        ],
        components: {
            AdminLayout,
            Pagination,
            Link,
            AutoCompleteSearchComponent,
            ThreeMultiSelectComponent,
            DailySetupComponent
        },
        data() {
            return {
                form: this.$inertia.form({
                    item_sku:"",
                    invoice_no:"",
                    id: "",
                    name: "",
                    product_id: "",
                    supplier_id: "",
                    daily_setup_id: "",
                    gold_plus_gem_weight: { kyat: "0", pal: "0", yway: "0" },
                    gold_price: "0",
                    gem_weight: { kyat: "0", pal: "0", yway: "0" },
                    gem_price: "0",
                    fee: { kyat: "0", pal: "0", yway: "0" },
                    fee_price: "0",
                    fee_for_making: "0",
                    before_total: "0",
                    item_discount: "0",
                    final_total: "0",
                    image: "",
                    item_description: "",
                    tran_description: "",
                    product_sku:"",
                }),
                supplier: '',
                product: '',
                imageforui: undefined,
                radio_old_daily_price: false,
                //nn
                item:[],
                transaction:[],
                product:[],
                customer:[],
                daily_setup:"",
            }
        },
        created() {

        },

        methods: {
            selectItemSku(value){
                this.item = value;
            },
            selectInvoiceNo(value) {
                this.transaction = value;
            },
            changeProductSku(value) {
                this.form.product_sku = value;
            },
            selectProductSku(value) {
                this.product = value;
                this.daily_setup = this.$page.props.daily_setup[this.product.quality];
            },
            selectCustomer(value) {
                this.customer = value;
            },
            editDailySetup(value){
                this.daily_setup = value;
            },
            validationStatus: function(validation) {
                return typeof validation != "undefined" ? validation.$error : false;
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
            createPurchases() {
                this.$v.$touch();
                if (this.$v.$pendding || this.$v.$error) return;
                this.form.daily_setup_id = this.daily_price.daily_setup_id;
                this.form.post(this.route('admin.purchases.store'), {
                    preserveScroll: true,
                    onSuccess:() => {
                        Object.assign(this.$data, this.$options.data.call(this));
                        Toast.fire({
                            icon: 'success',
                            title: 'New Item created!'
                        })
                    }
                })
            },
            editPurchases() {
                this.$v.$touch();
                if (this.$v.$pendding || this.$v.$error) return;
                this.form.daily_setup_id = this.daily_price.daily_setup_id;
                this.form.post(this.route('admin.purchases.purchase_update', this.form), {
                    preserveScroll: true,
                    onSuccess:() => {
                        Toast.fire({
                            icon: 'success',
                            title: 'Purchase has been updated!'
                        })
                    }
                })
            },

            changeSupplier() {
            },
            numberWithCommas(value) {
                if(typeof value !== "undefined"){
                    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            resetVoucherForm () {
                this.form.gold_plus_gem_weight = { kyat: "0", pal: "0", yway: "0" };
                this.form.gold_price= "0";
                this.form.gem_weight = { kyat: "0", pal: "0", yway: "0" };
                this.form.gem_price = "0";
                this.form.fee = { kyat: "0", pal: "0", yway: "0" };
                this.form.fee_price = "0";
                this.form.fee_for_making = "0";
                this.form.before_total = "0";
                this.form.item_discount = "0";
                this.form.final_total = "0";
            }
        },
        computed: {
            formTitle() {
                return this.transaction == null ? 'Create New Purchase' : 'Edit Current Purchase';
            },
            buttonTxt() {
                return this.transaction == null ? 'Create' : 'Update';
            },
            checkMode() {
                return this.transaction == null ? this.createPurchases : this.editPurchases
            },
            goldPrice() {
                if(this.product == "")return;
                let price = this.daily_price;
                let kyat = parseInt(this.form.gold_plus_gem_weight.kyat) -  parseInt(this.form.gem_weight.kyat);
                let pal = parseInt(this.form.gold_plus_gem_weight.pal) -  parseInt(this.form.gem_weight.pal);
                let yway = parseInt(this.form.gold_plus_gem_weight.yway) -  parseInt(this.form.gem_weight.yway);

                let kyat_p = kyat * parseInt(price.kyat);
                let pal_p = pal * parseInt(price.pal);
                let yway_p = yway * parseInt(price.yway);
                let gold_price = kyat_p + pal_p + yway_p;

                if (isNaN(gold_price)) gold_price = "";
                this.form.gold_price = gold_price;
                return gold_price;
            },
            feePrice() {
                if(this.product == "")return;
                let price = this.daily_price;
                let kyat_p = parseInt(this.form.fee.kyat) * parseInt(price.kyat);
                let pal_p = parseInt(this.form.fee.pal) * parseInt(price.pal);
                let yway_p = parseInt(this.form.fee.yway) * parseInt(price.yway);
                let fee_price = kyat_p + pal_p + yway_p;

                if (isNaN(fee_price)) fee_price = "";
                this.form.fee_price = fee_price;

                return fee_price;
            },
            totalBefore() {
                if(this.product == "")return;
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
                if(this.product == "")return;
                let final_total =
                    parseInt(this.form.before_total) -
                    parseInt(this.form.item_discount);
                if (isNaN(final_total)) final_total = "";
                this.form.final_total = final_total;
                this.form.paid_money = final_total;
                return final_total;
            },
        },
        validations: {
            form: {
                name: {required},
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
            supplier: {required},
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
