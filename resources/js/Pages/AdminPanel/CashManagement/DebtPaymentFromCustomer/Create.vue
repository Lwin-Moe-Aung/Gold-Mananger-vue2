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
                                <Link :href="route('admin.expenses.index')">
                                    <button class="btn btn-primary float-left mr-3" style="h">
                                        <i class="fas fa-long-arrow-alt-left" aria-hidden="true" ></i>
                                    </button>

                                </Link>
                                <h3 class="card-title">Debt Payment From Customer</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="permissions">Customer</label>
                                            <ContactAutoCompleteSearchComponent
                                                @update:data="selectCustomer"
                                                route_name = "pos.contact_search"
                                                v-model = "customer"
                                                label="search_name"
                                                placeholder="Search Customer"
                                                type="customer"
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
                                                v-model.trim="$v.debt_payment_amount.$model"
                                                class="form-control form-control"
                                                autofocus="autofocus"
                                                autocomplete="off"
                                                @change="customerDebtPayment"
                                            >
                                            <div v-if="!$v.debt_payment_amount.required" class="invalid-feedback">The debt payment amount field is required.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="callout callout-info">
                                    <h5><i class="fas fa-info"></i> Note: {{ numberWithCommas(total_debt_payment_amount_for_cal) }}</h5>
                                    This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
                                </div>
                                <ShowDebtVoucherComponent v-model="customer_id"/>

                                <div class="modal-footer justify-content-right">
                                    <Link :href="route('admin.expenses.index')">
                                        <button type="button" class="btn btn-light text-uppercase" style="letter-spacing: 0.1em;">Cancel</button>
                                    </Link>
                                    <button type="submit" class="btn btn-primary text-uppercase text-white" style="letter-spacing: 0.1em;" >{{ buttonTxt }}</button>
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
    import ShowDebtVoucherComponent from './ShowDebtVoucherComponent';
    // import axios from 'axios';
    import {mapGetters, mapActions} from "vuex";

    export default {
        props: [
            'transactions',
        ],
        components: {
            Datepicker,
            AdminLayout,
            Pagination,
            Link,
            ContactAutoCompleteSearchComponent,
            ShowDebtVoucherComponent,
        },
        data() {
            return {
                form: this.$inertia.form({
                    id: '',
                }),
                customer:[],
                customer_id:null,
                debt_payment_amount:null,
            }
        },
        created() {
            if(this.transactions != null) {

            }
            else {

            }
        },
        watch: {

        },
        computed: {
            ...mapGetters(['total_credits', 'total_debt_payment_amount_for_cal']),
            formTitle() {
                return this.form.id == null ? 'Create New Payment' : 'Edit Current Payment';
            },
            buttonTxt() {
                return this.form.id == null ? 'Create' : 'Update';
            },
            checkMode() {
                return this.form.id == null ? this.createExpense : this.editExpense
            },
        },
        validations: {
            debt_payment_amount:{required},
        },
        methods: {
            ...mapActions(["setTotalDebtPaymentAmount"]),
            numberWithCommas(x) {
                let v = parseInt(x);
                return v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            },
            selectCustomer(value) {
                if(value !== null){
                    this.customer = value;
                    this.customer_id = value.id;
                }else{
                    this.customer = [];
                    this.customer_id = null;
                }
            },
            validationStatus: function(validation) {
                return typeof validation != "undefined" ? validation.$error : false;
            },
            customerDebtPayment(){
                if(this.debt_payment_amount > this.total_credits){
                    alert("debt payment is exceed than total credits");
                    return;
                }
                this.setTotalDebtPaymentAmount(this.debt_payment_amount);
            },
            createExpense() {
                this.$v.$touch();
                if (this.$v.$pendding || this.$v.$error) return;
                this.form.post(this.route('admin.expenses.store'), {
                    preserveScroll: true,
                    onSuccess:() => {
                        Object.assign(this.$data, this.$options.data.call(this));
                        Toast.fire({
                            icon: 'success',
                            title: 'New Expense!'
                        })
                    }
                })
            },
            editExpense() {
                this.$v.$touch();
                if (this.$v.$pendding || this.$v.$error) return;
                this.form.post(this.route('admin.expenses.expenses_update', this.form), {
                    preserveScroll: true,
                    onSuccess:() => {
                        Toast.fire({
                            icon: 'success',
                            title: 'Expense has been updated!'
                        })
                    }
                })
            },
        },

    }
</script>
