<template>
    <div class="row">
        <!-- <div class="col-md-3 col-sm-6" v-for="(voucher_list, index) in voucher_lists" :key="index">

            <div class="card card-primary card-outline direct-chat direct-chat-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        Invoce Number-<span class="badge bg-primary"><a href="">{{ voucher_list.invoice_no }}</a></span>
                    </h3>

                    <div class="card-tools">
                        <span title="3 New Messages" class="badge bg-danger">3</span>

                        <input
                            class="custom-control-input-tool"
                            type="checkbox"
                            :value="voucher_list.id"
                            :id="voucher_list.id"
                            @click="onChangeCheckBox($event)"
                            v-if="total_debt_payment_amount_for_cal != 0"
                            style="width:30px; height:30px;"
                        >
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td>ပစ္စည်း</td>
                                <td>
                                    <img class="w-10 h-10 rounded-full" :src="voucher_list.item.image" alt="" style="width:60px;"/>
                                    <span class="badge bg-primary">{{ voucher_list.item.name }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>စုစုပေါင်း</td>
                                <td><span class="badge bg-warning">{{ numberWithCommas(voucher_list.before_total) }}</span></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>လျော့ငွေ</td>
                                <td><span class="badge bg-warning">{{ numberWithCommas(voucher_list.discount_amount) }}</span></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>ကျသင့်ငွေ</td>
                                <td><span class="badge bg-warning">{{ numberWithCommas(voucher_list.final_total) }}</span></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>ပေးငွေ</td>
                                <td><span class="badge bg-warning">{{ numberWithCommas(voucher_list.paid_money) }}</span></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>ကျန်ငွေ</td>
                                <td><span class="badge bg-warning">{{ numberWithCommas(voucher_list.credit_money) }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <h3 class="card-title">ဆပ်ပီးကျန်ငွေ  - 	&nbsp;</h3>
                    <span class="badge bg-warning">{{ numberWithCommas(voucher_list.credit_money) }}</span>
                </div>
            </div>
        </div> -->
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column" v-for="(voucher_list, index) in voucher_lists" :key="index">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                    Invoce Number-<a href="" class="badge-pill badge-dark">{{ voucher_list.invoice_no }}</a>
                    <input
                        class="custom-control-input-tool float-right"
                        type="checkbox"
                        :value="voucher_list.id"
                        :id="voucher_list.id"
                        v-model="checkBoxLists"
                        @click="onChangeCheckBox($event)"
                        v-if="total_debt_payment_amount != null"
                        style="width:30px; height:30px;"
                        :disabled = "total_debt_payment_amount_for_cal == 0 && checkBoxLists.indexOf(voucher_list.id) == -1"
                    >
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-7">
                            <h2 class="lead"><b>{{ voucher_list.item.name }}</b></h2>
                            <p class="text-muted text-sm">
                                <b>Date: </b> {{ dateTime(voucher_list.created_at)}}
                            </p>
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small">
                                    <b>စုစုပေါင်း : </b>
                                    <span class="badge badge-pill bg-warning">{{ numberWithCommas(voucher_list.before_total) }}</span>
                                </li>
                                <li class="small">
                                    <b>လျော့ငွေ : </b>
                                    <span class="badge badge-pill bg-warning">{{ numberWithCommas(voucher_list.discount_amount) }}</span>
                                </li>
                                <li class="small">
                                    <b>ကျသင့်ငွေ : </b>
                                    <span class="badge badge-pill bg-warning">{{ numberWithCommas(voucher_list.final_total) }}</span>
                                </li>
                                <li class="small">
                                    <b>ပေးငွေ : </b>
                                    <span class="badge badge-pill bg-warning">{{ numberWithCommas(voucher_list.paid_money) }}</span>
                                </li>
                                <li class="small">
                                    <b>ကျန်ငွေ : </b>
                                    <span class="badge badge-pill bg-warning">{{ numberWithCommas(voucher_list.credit_money) }}</span>
                                </li>
                            </ul>

                        </div>
                        <div class="col-5 text-center">
                            <h2><span class="badge badge-pill badge-dark">{{ showIndexNumber(voucher_list) }}</span></h2>
                            <img :src="voucher_list.item.image" alt="user-avatar" class="img-circle img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-right">
                        <p class="text-muted text-sm">
                            <b>ဆပ်ပီးကျန်ငွေ : </b>
                            <span class="badge bg-warning">{{ numberWithCommas2(checkRemainingCredit(voucher_list)) }}</span>
                        </p>
                        <a href="#" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i> View Voucher
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from "axios";
    import {mapGetters, mapActions} from "vuex";
    import moment from 'moment';

    export default {
        name: "ShowDebtVoucherComponent",
        props: ["value"],
        data() {
            return {
                // voucherLists:[],
                checkBoxLists:[],
            };
        },
        created() {

        },
        computed: {
            ...mapGetters(['voucher_lists', 'total_debt_payment_amount', 'total_debt_payment_amount_for_cal', 'checked_voucher_lists']),
        },
        watch: {
            value (val) {
                if(val != null){
                    this.getCreditDataLists(val);
                }else{
                    this.setVoucherLists([]);
                    this.setTotalCredit(null);
                }
            },
            total_debt_payment_amount(value){
                this.checkBoxLists = [];
            }
        },
        methods: {
            ...mapActions(["setTotalCredit", "setCheckedVoucherLists","getCreditDataLists","setVoucherLists"]),
            showIndexNumber(value) {
                let item = this.checked_voucher_lists.find(function(val) {
                    return val.parent_transaction_id == value.id;
                });
                if(typeof item  !== 'undefined' ){
                    return this.checked_voucher_lists.indexOf(item)+1;
                }
                return;
            },
            checkRemainingCredit(value) {
                let item = this.checked_voucher_lists.find(function(val) {
                    return val.parent_transaction_id == value.id;
                });
                if(typeof item  !== 'undefined' ){
                    return item.remaining_credit;
                }
                return "";
            },
            dateTime(value) {
                return moment(value).format('DD/MM/YYYY hh:mm:s A');
            },
            numberWithCommas(x) {
                let v = parseInt(x);
                return v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            },
            numberWithCommas2(v) {
                return v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            },
            onChangeCheckBox(e) {
                let data = {
                    id : e.target.value,
                    status: 'unchecked'
                }
                if (e.target.checked) {
                    data.status = 'checked';
                }
                this.setCheckedVoucherLists(data);
            },
            save() {
                if(this.$refs.form.validate()){
                    let data = new FormData();
                    data.append('name',this.name);

                    axios.post(this.route(this.route_name), data)
                        .then(res => {
                            this.$emit('update:data', res.data.data);
                            this.clearData();
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
        },
    };
</script>
