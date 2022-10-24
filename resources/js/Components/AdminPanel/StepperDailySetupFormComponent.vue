<template>
    <v-container>
        <v-form
            ref="form"
            v-model="valid"
            lazy-validation
        >
            <v-layout row wrap class="mt-1">
                <v-flex xs3 md3 sm3 class="mt-2 text-center">
                    <span class="badge badge-pill bg-primary">Daily Setup</span>
                </v-flex>
                <v-flex xs5 sm5 md5>
                    <v-text-field
                        v-model = "daily_setup_amount"
                        @change="onChange"
                        type="number"
                        min="0"
                        oninput="if(this.value < 0) this.value = 0;"
                        outlined
                        dense
                        required
                        :rules="requireRule"
                    >
                    </v-text-field>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs3 md3 sm3 class="mt-2 text-center">
                    <span class="badge badge-pill bg-warning">16 ပဲရည်</span>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_16_pal.market_price"
                            label="ပေါက်ဈေး"
                            outlined
                            clearable
                            dense
                            disabled
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_16_pal.kyat"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            type="number"
                            label="ကျပ်"
                            outlined
                            clearable
                            dense
                            required
                            :rules="requireRule"
                            @change="changeKyat(16,$event)"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_16_pal.pal"
                            label="ပဲ"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_16_pal.yway"
                            label="ရွေး"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs3 md3 sm3 class="mt-2 text-center">
                    <span class="badge badge-pill bg-warning">15 ပဲရည်</span>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_15_pal.market_price"
                            label="ပေါက်ဈေး"
                            outlined
                            clearable
                            dense
                            disabled
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_15_pal.kyat"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ကျပ်"
                            outlined
                            clearable
                            dense
                            required
                            type="number"
                            :rules="requireRule"
                            @change="changeKyat(15,$event)"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_15_pal.pal"
                            label="ပဲ"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_15_pal.yway"
                            label="ရွေး"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs3 md3 sm3 class="mt-2 text-center">
                    <span class="badge badge-pill bg-warning">14 ပဲရည်</span>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_14_pal.market_price"
                            label="ပေါက်ဈေး"
                            outlined
                            clearable
                            dense
                            disabled
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_14_pal.kyat"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ကျပ်"
                            outlined
                            clearable
                            dense
                            required
                            type="number"
                            :rules="requireRule"
                            @change="changeKyat(14,$event)"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_14_pal.pal"
                            label="ပဲ"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_14_pal.yway"
                            label="ရွေး"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs3 md3 sm3 class="mt-2 text-center">
                    <span class="badge badge-pill bg-warning">14.4 ပဲရည်</span>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_144_pal.market_price"
                            label="ပေါက်ဈေး"
                            outlined
                            clearable
                            dense
                            disabled
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_144_pal.kyat"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ကျပ်"
                            outlined
                            clearable
                            dense
                            required
                            type="number"
                            :rules="requireRule"
                            @change="changeKyat(144,$event)"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_144_pal.pal"
                            label="ပဲ"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_144_pal.yway"
                            label="ရွေး"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs3 md3 sm3 class="mt-2 text-center">
                    <span class="badge badge-pill bg-warning">13 ပဲရည်</span>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_13_pal.market_price"
                            label="ပေါက်ဈေး"
                            outlined
                            clearable
                            dense
                            disabled
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_13_pal.kyat"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ကျပ်"
                            outlined
                            clearable
                            dense
                            required
                            type="number"
                            :rules="requireRule"
                            @change="changeKyat(13,$event)"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_13_pal.pal"
                            label="ပဲ"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_13_pal.yway"
                            label="ရွေး"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs3 md3 sm3 class="mt-2 text-center">
                    <span class="badge badge-pill bg-warning">12 ပဲရည်</span>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_12_pal.market_price"
                            label="ပေါက်ဈေး"
                            outlined
                            clearable
                            dense
                            disabled
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_12_pal.kyat"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ကျပ်"
                            outlined
                            clearable
                            dense
                            required
                            type="number"
                            :rules="requireRule"
                            @change="changeKyat(12,$event)"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_12_pal.pal"
                            label="ပဲ"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs2 sm2 md2>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_12_pal.yway"
                            label="ရွေး"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
            </v-layout>
            <v-card-actions class="card-actions float-right">
                <v-btn
                    class="float-right"
                    color="#4D25B9"
                    outlined
                    rounded
                    text
                    @click="submit()"
                >
                    Continue
                </v-btn>

            </v-card-actions>
        </v-form>
    </v-container>
</template>
<script>
    import {mapGetters, mapActions} from "vuex";
    export default {
        name:"StepperDailySetupFormComponent",
        data: () => ({
            form:{
                quality_16_pal: { key:16, market_price:null, kyat: null, pal: null, yway: null },
                quality_15_pal: { key:15, market_price:null, kyat: null, pal: null, yway: null },
                quality_14_pal: { key:14, market_price:null, kyat: null, pal: null, yway: null },
                quality_144_pal: { key:144, market_price:null, kyat: null, pal: null, yway: null },
                quality_13_pal: { key:13, market_price:null, kyat: null, pal: null, yway: null },
                quality_12_pal: { key:12, market_price:null, kyat: null, pal: null, yway: null },
            },
            daily_setup_amount: null,
            valid: true,
            requireRule: [
                v => !!v || 'This field is required',
            ],
        }),

        methods: {
            ...mapActions(["setGlobalStep", "setDailySetupForm", "setDailySetupAmount"]),
            submit () {
                if(!this.$refs.form.validate()) return;
                this.setGlobalStep();
                this.setDailySetupForm({...this.form});
                this.setDailySetupAmount(this.daily_setup_amount);
            },

            onChange() {
                this.setDailySetupForm({});
                //16
                this.form.quality_16_pal.kyat = Number(this.daily_setup_amount);
                this.form.quality_16_pal.market_price = this.form.quality_16_pal.kyat;
                this.form.quality_16_pal.pal = this.form.quality_16_pal.kyat / 16;
                this.form.quality_16_pal.yway = this.form.quality_16_pal.pal / 8;
                //15
                this.form.quality_15_pal.kyat = this.form.quality_16_pal.kyat - this.form.quality_16_pal.pal;
                this.form.quality_15_pal.market_price = this.form.quality_15_pal.kyat;
                this.form.quality_15_pal.pal = this.form.quality_15_pal.kyat / 16;
                this.form.quality_15_pal.yway = this.form.quality_15_pal.pal / 8;
                //14
                this.form.quality_14_pal.kyat = this.form.quality_16_pal.kyat - (this.form.quality_16_pal.pal * 2);
                this.form.quality_14_pal.market_price = this.form.quality_14_pal.kyat;
                this.form.quality_14_pal.pal = this.form.quality_14_pal.kyat / 16;
                this.form.quality_14_pal.yway = this.form.quality_14_pal.pal / 8;
                //144
                this.form.quality_144_pal.kyat = this.form.quality_14_pal.kyat + (this.form.quality_14_pal.yway * 4);
                this.form.quality_144_pal.market_price = this.form.quality_144_pal.kyat;
                this.form.quality_144_pal.pal = this.form.quality_144_pal.kyat / 16;
                this.form.quality_144_pal.yway = this.form.quality_144_pal.pal / 8;
                //13
                this.form.quality_13_pal.kyat = this.form.quality_16_pal.kyat - (this.form.quality_16_pal.pal * 3);
                this.form.quality_13_pal.market_price = this.form.quality_13_pal.kyat;
                this.form.quality_13_pal.pal = this.form.quality_13_pal.kyat / 16;
                this.form.quality_13_pal.yway = this.form.quality_13_pal.pal / 8;
                //12
                this.form.quality_12_pal.kyat = this.form.quality_16_pal.kyat - (this.form.quality_16_pal.pal * 4);
                this.form.quality_12_pal.market_price = this.form.quality_12_pal.kyat;
                this.form.quality_12_pal.pal = this.form.quality_12_pal.kyat / 16;
                this.form.quality_12_pal.yway = this.form.quality_12_pal.pal / 8;
            },
            changeKyat(key,value) {
                this.setDailySetupForm({});
                let pal = value / 16;
                let yway = pal / 8;
                switch(key) {
                    case 16:
                        this.form.quality_16_pal.kyat = value;
                        this.form.quality_16_pal.pal = pal;
                        this.form.quality_16_pal.yway = yway;
                        break;
                    case 15:
                        this.form.quality_15_pal.pal = pal;
                        this.form.quality_15_pal.yway = yway;
                        break;
                    case 14:
                        this.form.quality_14_pal.pal = pal;
                        this.form.quality_14_pal.yway = yway;
                        break;
                    case 144:
                        this.form.quality_144_pal.pal = pal;
                        this.form.quality_144_pal.yway = yway;
                        break;
                    case 13:
                        this.form.quality_13_pal.pal = pal;
                        this.form.quality_13_pal.yway = yway;
                        break;
                    case 12:
                        this.form.quality_12_pal.pal = pal;
                        this.form.quality_12_pal.yway = yway;
                        break;
                    default:
                        break;
                }
            }

        }
    }
</script>
