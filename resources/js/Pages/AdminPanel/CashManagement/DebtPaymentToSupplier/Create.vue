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
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <Link :href="route('admin.debt-payment-to-suppliers.index')">
                                    <button class="btn btn-primary float-left mr-3" style="h">
                                        <i class="fas fa-long-arrow-alt-left" aria-hidden="true" ></i>
                                    </button>

                                </Link>
                                <h3 class="card-title">Debt Payment From supplier</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="permissions">Supplier</label>
                                            <ContactAutoCompleteSearchComponent
                                                @update:data="selectSupplier"
                                                route_name = "pos.contact_search"
                                                v-model = "supplier"
                                                label="search_name"
                                                placeholder="Search Supplier"
                                                type="supplier"
                                                button="false"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="name">Total Credit: </label>
                                            <input
                                                :value = "total_credits"
                                                type="text"
                                                class="form-control form-control"
                                                autocomplete="off"
                                                disabled
                                            >
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="name">Pay Amount: </label>
                                            <input
                                                type="text"
                                                v-model.trim="$v.total_payment.$model"
                                                class="form-control form-control"
                                                autofocus="autofocus"
                                                autocomplete="off"
                                                @change="onChangeDebtPayment"
                                            >
                                            <div v-if="!$v.total_payment.required" class="invalid-feedback">The debt payment amount field is required.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="callout callout-info" v-if="total_payment != null">
                                    <div class="row">
                                        <div class="col-md-6 text-left">
                                            <h5><i class="fas fa-info"></i> Price:<span class="badge badge-pill bg-warning" v-if="total_debt_payment_amount != null">{{ numberWithCommas(total_debt_payment_amount_for_cal) }}</span> </h5>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <h5><i class="fas fa-info"></i> ဆပ်ရန်ကျန်ရှိငွေ:<span class="badge badge-pill bg-warning" v-if="total_debt_payment_amount != null">{{ numberWithCommas(remaining_credit_money) }}</span> </h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p v-if="total_debt_payment_amount_for_cal != 0">အောက်တွင်ဖော်ပြထားသော voucher များကို ရွေးချယ်၍ ဆပ်နိုင်သည်။</p>
                                        <p v-else>စုစုပေါင်း amount ကုန်ဆုံးသွား၍ ထပ်ရွေးလို့မရတော့ပါ။</p>
                                    </div>
                                </div>
                                <CreditVoucherListsComponent
                                    v-model="supplier_id"
                                    url="supplier/get-credit-data-lists"
                                    />

                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="name">Note:</label>
                                            <textarea
                                                class="form-control"
                                                placeholder="Description"
                                                v-model="additional_note"
                                                autocomplete="off"
                                                rows="4"
                                                cols="70"
                                            >
                                            </textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer justify-content-right">
                                    <Link :href="route('admin.debt-payment-to-suppliers.index')">
                                        <button type="button" class="btn btn-light text-uppercase" style="letter-spacing: 0.1em;">Cancel</button>
                                    </Link>

                                    <button
                                        type="submit"
                                        class="btn btn-primary text-uppercase text-white"
                                        style="letter-spacing: 0.1em;"
                                        :disabled="isDisabled"
                                        >
                                        {{ buttonTxt }}
                                    </button>
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
    import { required, minValue, maxValue} from 'vuelidate/lib/validators';
    import Datepicker from 'vuejs-datepicker';
    import moment from 'moment';
    import ContactAutoCompleteSearchComponent from '../../../../Components/AdminPanel/ContactAutoCompleteSearchComponent';
    import CreditVoucherListsComponent from '../../../../Components/AdminPanel/CreditVoucherListsComponent';
    import axios from 'axios';
    import {mapGetters, mapActions} from "vuex";
    import constant from "../../../../constant";

    export default {
        props: [
            'contact',
        ],
        components: {
            Datepicker,
            AdminLayout,
            Pagination,
            Link,
            ContactAutoCompleteSearchComponent,
            CreditVoucherListsComponent,
        },
        data() {
            return {
                form: this.$inertia.form({
                    id: null,
                }),
                supplier:[],
                supplier_id:null,
                total_payment:null,
                additional_note:"",
                remaining_credit_money:null,
                isDisabled:true,
            }
        },
        mounted() {
            if(this.contact != null){
                this.supplier_id = this.contact.id;
                this.supplier = this.contact;
                this.isDisabled = false;
            }
        },
        created() {
            if(this.transactions != null) {

            }
            else {

            }
        },
        watch: {
            total_debt_payment_amount_for_cal(value){
                this.remaining_credit_money = this.total_credits - (this.total_payment - value);
            }
        },
        computed: {
            ...mapGetters(['total_credits', 'total_debt_payment_amount_for_cal', 'total_debt_payment_amount', 'checked_voucher_lists']),
            formTitle() {
                return this.form.id == null ? 'Create New Debt Payment To Supplier' : 'Edit Current Debt Payment To Supplier';
            },
            buttonTxt() {
                return this.form.id == null ? 'Create' : 'Update';
            },
            checkMode() {
                return this.form.id == null ? this.createDebtPaymentToSupplier : this.editDebtPaymentToSupplier
            },
        },
        validations: {
            total_payment:{required},
        },
        methods: {
            ...mapActions(["setTotalDebtPaymentAmount","resetCartState","repairingCheckedVoucherListsForDatabase"]),
            numberWithCommas(x) {
                let v = parseInt(x);
                return v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            },
            selectSupplier(value) {
                if(value !== null){
                    this.supplier = value;
                    this.supplier_id = value.id;
                    this.total_payment = null;
                    this.isDisabled = false;
                }else{
                    this.supplier = [];
                    this.supplier_id = null;
                    this.total_payment = null;
                    this.isDisabled = true;
                    this.resetCartState();
                }
            },
            validationStatus: function(validation) {
                return typeof validation != "undefined" ? validation.$error : false;
            },
            onChangeDebtPayment(){
                if(this.total_payment > this.total_credits){
                    alert("debt payment is exceed than total credits");
                    this.total_payment = null;
                }
                if(this.total_payment == ""){
                    this.total_payment = null;
                }
                this.setTotalDebtPaymentAmount(this.total_payment);
            },
            async createDebtPaymentToSupplier() {
                this.isDisabled = true;
                this.$v.$touch();
                if (this.$v.$pendding || this.$v.$error) return;
                await this.repairingCheckedVoucherListsForDatabase();
                let data = new FormData();
                data.append('supplier_id',this.supplier_id);
                data.append('total_payment',this.total_payment);
                data.append('remaining_credit_money',this.remaining_credit_money);
                data.append('additional_note',this.additional_note);
                data.append('checked_voucher_lists',JSON.stringify(this.checked_voucher_lists));
                await axios.post(this.route('admin.debt-payment-to-suppliers.store'), data)
                    .then(res => {
                        if(res.data.status){
                            Toast.fire({
                                icon: 'success',
                                title: 'Payment Success'
                            })
                            window.open( constant.ROUTE_URL_ADMIN+"supplier-debt-payment-generate-invoice/"+res.data.transaction_id, "_blank");
                            this.resetCartState();
                            this.supplier = [];
                            this.supplier_id = null;
                            this.total_payment = null;
                            this.additional_note = null;

                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

        },
        beforeDestroy() {
            this.resetCartState();
        }
    }
</script>
