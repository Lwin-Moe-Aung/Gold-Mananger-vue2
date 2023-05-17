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
                                <h3 class="card-title">Expense Create Form</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="permissions">Expense Category</label>
                                            <div class="row">
                                                <div class="col-sm-10 col-xs-10">
                                                    <multiselect
                                                        v-model.trim="$v.expense_category.$model"
                                                        :options="expense_categories"
                                                        :multiple="false"
                                                        :taggable="true"
                                                        placeholder="Expense Category"
                                                        label="name"
                                                        track-by="id"
                                                        @input="changeExpenseCategory"
                                                        :class="{'is-invalid': validationStatus($v.expense_category)}"
                                                    ></multiselect>
                                                    <div v-if="!$v.expense_category.required" class="invalid-feedback">The Expense Category is required.</div>
                                                </div>
                                                <div class="col-sm-2 col-xs-2">
                                                    <button type="button" class="btn btn-success btn-flat text-white float-right" @click="addExpenseCategoryDialog = true"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.supplier}">
                                                {{ form.errors.supplier }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="name">Reference No: </label>
                                            <!-- <input type="text" class="form-control" placeholder="Name" v-model="form.name" :class="{ 'is-invalid' : form.errors.name }" autofocus="autofocus" autocomplete="off"> -->
                                            <input type="text" v-model="form.ref_no" :class="{'is-invalid': validationStatus($v.form.ref_no)}" class="form-control form-control" autofocus="autofocus" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="permissions">Expense For</label>
                                            <div class="row">
                                                <div class="col-sm-10 col-xs-10">
                                                    <multiselect
                                                        v-model="expense_for"
                                                        :options="expense_fors"
                                                        :multiple="false"
                                                        :taggable="true"
                                                        placeholder="Expense For"
                                                        label="name"
                                                        track-by="id"
                                                        @input="changeExpenseFor"
                                                    ></multiselect>
                                                </div>
                                                <div class="col-sm-2 col-xs-2">
                                                    <button type="button" class="btn btn-success btn-flat text-white float-right" @click="addExpenseForDialog = true"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-4">

                                        <div class="form-group">
                                            <label for="name">Total Amount: </label>
                                            <input type="text" v-model.trim="$v.form.total_amount.$model" :class="{'is-invalid': validationStatus($v.form.total_amount)}" class="form-control form-control" autofocus="autofocus" autocomplete="off">
                                            <div v-if="!$v.form.total_amount.required" class="invalid-feedback">Total Amount field is required.</div>
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.total_amount}">
                                            {{ form.errors.total_amount }}
                                        </div>

                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label>Date:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                    <datepicker
                                                        :value="form.date"
                                                        name="uniquename"
                                                        @selected="selectDate"
                                                        >
                                                    </datepicker>
                                                </div>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.date}">
                                            {{ form.errors.date }}
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="name">Expense Note:</label>
                                            <textarea  class="form-control" placeholder=" Item Description"
                                                v-model="form.additional_notes" :class="{ 'is-invalid' : form.errors.additional_notes }"
                                                autofocus="autofocus" autocomplete="off"
                                                rows="4" cols="70"
                                            >
                                            </textarea>
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.additional_notes}">
                                            {{ form.errors.additional_notes }}
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">

                                        <div class="form-group">
                                            <label for="name">Attach Document: </label>
                                            <input type="file" :class="['form-control',form.errors.image?'border border-danger':'']"  @change="selectImage">
                                            <img class="profile-user-img img-fluid" :src="imageforui" v-if="imageforui">
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.name}">
                                            {{ form.errors.name }}
                                        </div>
                                    </div>

                                </div>
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
        <AddExpenseForOrCategoryDialogComponent
            @update:data="eventExpenseCategoryDialog"
            v-model = "addExpenseCategoryDialog"
            route_name="admin.expense_categories.storeDialog"
            type="ExpenseCategory"
        />
        <AddExpenseForOrCategoryDialogComponent
            @update:data="eventExpenseForDialog"
            v-model = "addExpenseForDialog"
            route_name="admin.expense-fors.storeDialog"
            type="ExpenseFor"
        />
    </div>
</template>
<script>
    import AdminLayout from '../../../../Layouts/AdminPanelLayout';
    import Pagination from '../../../../Components/AdminPanel/Pagination';
    import { Link } from '@inertiajs/inertia-vue';
    import { required, minValue, maxValue} from 'vuelidate/lib/validators'
    import AddExpenseForOrCategoryDialogComponent from '../../../../Components/AdminPanel/AddExpenseForOrCategoryDialogComponent';
    import Datepicker from 'vuejs-datepicker';
    import moment from 'moment';

    export default {
        props: [
            'transaction',
            'expense_categories',
            'expense_fors',
        ],
        components: {
            Datepicker,
            AdminLayout,
            Pagination,
            Link,
            AddExpenseForOrCategoryDialogComponent,
        },
        data() {
            return {
                form: this.$inertia.form({
                    id: null,
                    expense_category_id: null,
                    ref_no: "",
                    expense_for_id: null,
                    total_amount: "",
                    date: "",
                    image: undefined,
                    additional_notes: "",
                    _token: constant.CSRF
                }),
                imageforui: undefined,
                expense_category: null,
                expense_for: null,
                addExpenseCategoryDialog: false,
                addExpenseForDialog: false,

            }
        },
        created() {
            if(this.transaction != null) this.fillData();
            else {
                let date = new Date();
                this.form.date = moment(date).format('YYYY-MM-DD');
            }
        },
        validations: {
            form: {
                date: {required},
                total_amount:{required},
            },
            expense_category:{required},
        },
        methods: {

            eventExpenseCategoryDialog(value) {
                this.addExpenseCategoryDialog = false;
                this.form.expense_category_id = value.id;
                this.expense_category = value;
                this.expense_categories.push(value);
            },
            eventExpenseForDialog( value) {
                this.addExpenseForDialog = false;
                this.form.expense_for_id = value.id;
                this.expense_for = value;
                this.expense_fors.push(value);
            },
            selectDate(date) {
                this.form.date = moment(date).format('YYYY-MM-DD');
            },
            fillData(){
                this.form.id = this.transaction.id;
                this.form.expense_category_id = this.transaction.expense.expense_category_id;
                this.form.ref_no = this.transaction.ref_no;
                this.form.expense_for_id = this.transaction.expense.expense_for_id;
                this.form.total_amount = this.transaction.expense.amount;
                this.form.date = this.transaction.transaction_date;
                this.imageforui = this.transaction.expense.image;
                this.form.additional_notes = this.transaction.expense.additional_notes;
                this.expense_category = this.transaction.expense.expense_category;
                this.expense_for = this.transaction.expense_for;
            },
            changeExpenseCategory() {
                this.form.expense_category_id = this.expense_category != null ? this.expense_category.id : null;
            },
            changeExpenseFor() {
                this.form.expense_for_id = this.expense_for != null ? this.expense_for.id : null;
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
            createExpense() {
                // alert("hello");
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
        computed: {
            showingDailySetup (){
                return this.daily_setup[16].kyat;
            },
            formTitle() {
                return this.form.id == null ? 'Create New Expense' : 'Edit Current Expense';
            },
            buttonTxt() {
                return this.form.id == null ? 'Create' : 'Update';
            },
            checkMode() {
                return this.form.id == null ? this.createExpense : this.editExpense
            },
        },
    }
</script>
