<template>
    <v-col cols="12" sm="3">
        <v-hover v-slot="{ hover }" close-delay="200">
            <v-card
                :elevation="hover ? 16 : 2"
                :class="{ 'on-hover': hover }"
                flat
                class="mx-auto rounded-lg mx-3 no-print"
            >
                 <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="images/pos/customer.jpg" alt="User profile picture">
                        </div>
                        <!-- combobox -->
                            <v-combobox
                                v-model="customerInfo"
                                :items="customerList"
                                item-text="name"
                                item-value="id"
                                return-object
                                label="ပဲရည်"
                            ></v-combobox>
                       <!-- combobox -->
                        <v-container v-if="customerInfo != null">

                            <p class="text-muted text-center" style="font-size: 13px !important;" >{{customerInfo.address}}</p>
                            <p class="text-muted text-center" style="font-size: 13px !important;">{{customerInfo.mobile1}},{{customerInfo.mobile2}}</p>


                            <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>ဝယ်ယူမှုများ</b> <a class="float-right">{{customerInfo.total_amount}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>ကျန်ငွေ</b> <a class="float-right">500,000</a>
                            </li>
                            <li class="list-group-item">
                                <b>နောက်ဆုံးပေးငွေ</b> <a class="float-right">15,000</a>
                            </li>
                            </ul>

                            <a href="#" class="btn btn-primary btn-block" style="color: white !important;"><b>View Detail</b></a>

                        </v-container>

                    </div>
                <!-- /.card-body -->
                </div>
            </v-card>
        </v-hover>
    </v-col>
</template>

<script>
    import axios from "axios";
    export default {
        data() {
            return {
                // combobox
                customerInfo: null,
                customerList: [],
                // end combobox
            };
        },
        created() {
            this.getCustomerInfo();
        },
        methods: {
            getCustomerInfo() {
                axios.get(this.route("pos.customer_search"))
                    .then((response) => {
                        this.customerList = response.data.customerList;
                });
            },
        },
    };
</script>
