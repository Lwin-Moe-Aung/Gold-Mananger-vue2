<template>
    <div class="row">
        <div class="col-md-3 col-sm-6" v-for="(voucherList, index) in voucherLists" :key="index">
            <div class="card card-primary card-outline direct-chat direct-chat-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        Invoce Number-<span class="badge bg-primary"><a href="">{{ voucherList.invoice_no }}</a></span>
                    </h3>

                    <div class="card-tools">
                        <span title="3 New Messages" class="badge bg-danger">3</span>

                        <input
                            class="custom-control-input-tool"
                            type="checkbox"
                            :value="voucherList.id"
                            :id="voucherList.id"
                            @click="onChangeCheckBox($event)">
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td>ပစ္စည်း</td>
                                <td>
                                    <img class="w-10 h-10 rounded-full" :src="voucherList.item.image" alt="" style="width:60px;"/>
                                    <span class="badge bg-primary">{{ voucherList.item.name }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>စုစုပေါင်း</td>
                                <td><span class="badge bg-warning">{{ numberWithCommas(voucherList.before_total) }}</span></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>လျော့ငွေ</td>
                                <td><span class="badge bg-warning">{{ numberWithCommas(voucherList.discount_amount) }}</span></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>ကျသင့်ငွေ</td>
                                <td><span class="badge bg-warning">{{ numberWithCommas(voucherList.final_total) }}</span></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>ပေးငွေ</td>
                                <td><span class="badge bg-warning">{{ numberWithCommas(voucherList.paid_money) }}</span></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>ကျန်ငွေ</td>
                                <td><span class="badge bg-warning">{{ numberWithCommas(voucherList.credit_money) }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <h3 class="card-title">ဆပ်ပီးကျန်ငွေ  - 	&nbsp;</h3>
                    <span class="badge bg-warning">{{ numberWithCommas(voucherList.credit_money) }}</span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from "axios";
    import {mapGetters, mapActions} from "vuex";

    export default {
        name: "ShowDebtVoucherComponent",
        props: ["value"],
        data() {
            return {
                voucherLists:[],
            };
        },
        created() {

        },
        watch: {
            value (val) {
                if(val != null){
                    this.getTotalCredit(val);
                }else{
                    this.voucherLists = [];
                    this.setTotalCredit(null);
                }
            },
        },
        methods: {
            ...mapActions(["setTotalCredit", "setCheckedVoucherLists"]),
            getTotalCredit(customer_id){
                axios.get(this.route('admin.getTotalCredit'), { params: { customer_id: customer_id }})
                    .then((response) => {
                        this.voucherLists = response.data.data;
                        this.setTotalCredit(response.data.total_credits);
                });
            },
            numberWithCommas(x) {
                let v = parseInt(x);
                return v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            },
            onChangeCheckBox(e) {
                if (e.target.checked) {
                    console.log(e.target.value + "checked")
                }else{
                    console.log(e.target.value + "unchecked")
                }
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
