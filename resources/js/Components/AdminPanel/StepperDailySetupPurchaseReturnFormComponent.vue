<template>
    <v-container>
        <v-form
            ref="form"
            v-model="valid"
            lazy-validation
        >
            <v-layout row wrap class="mt-1">
                <v-flex xs3 md3 sm3 class="mt-2 text-center">
                    <span class="badge badge-pill bg-primary">limitation Price</span>
                </v-flex>
                <v-flex xs5 sm5 md5>
                        <v-text-field
                            v-model = "limitation_price"
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
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_16_pal.kyat"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            type="number"
                            label="ကျပ်"
                            required
                            outlined
                            clearable
                            dense
                            :rules="requireRule"
                            @change="changeKyat(16, $event)"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_16_pal.pal"
                            label="ပဲ"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_16_pal.yway"
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
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_15_pal.kyat"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ကျပ်"
                            required
                            type="number"
                            outlined
                            clearable
                            dense
                            :rules="requireRule"
                            @change="changeKyat(15, $event)"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_15_pal.pal"
                            label="ပဲ"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_15_pal.yway"
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
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_14_pal.kyat"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ကျပ်"
                            required
                            type="number"
                            outlined
                            clearable
                            dense
                            :rules="requireRule"
                            @change="changeKyat(14, $event)"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_14_pal.pal"
                            label="ပဲ"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_14_pal.yway"
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
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_144_pal.kyat"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ကျပ်"
                            required
                            type="number"
                            outlined
                            clearable
                            dense
                            :rules="requireRule"
                            @change="changeKyat(144, $event)"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_144_pal.pal"
                            label="ပဲ"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_144_pal.yway"
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
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_13_pal.kyat"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ကျပ်"
                            required
                            type="number"
                            outlined
                            clearable
                            dense
                            :rules="requireRule"
                            @change="changeKyat(13, $event)"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_13_pal.pal"
                            label="ပဲ"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_13_pal.yway"
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
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            :value = "form.quality_12_pal.kyat"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ကျပ်"
                            placeholder="ကျပ်"
                            required
                            type="number"
                            outlined
                            clearable
                            dense
                            :rules="requireRule"
                            @change="changeKyat(12, $event)"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_12_pal.pal"
                            label="ပဲ"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_12_pal.yway"
                            label="ရွေး"
                            outlined
                            dense
                            disabled
                        ></v-text-field>
                    </v-flex>
                </v-flex>
            </v-layout>
            <v-card-actions class="card-actions">
                <v-btn
                    class="mr-3"
                    color="#272727"
                    @click="reduceGlobalStep()"
                    outlined
                    rounded
                    text
                >
                    Back
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn
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
    import constant from '../../constant';

    export default {
        name:"StepperDailySetupPurchaseReturnFormComponent",
        data: () => ({
            form:{
                quality_16_pal: { key:16, kyat: null, pal: null, yway: null },
                quality_15_pal: { key:15, kyat: null, pal: null, yway: null },
                quality_14_pal: { key:14, kyat: null, pal: null, yway: null },
                quality_144_pal: { key:144, kyat: null, pal: null, yway: null },
                quality_13_pal: { key:13, kyat: null, pal: null, yway: null },
                quality_12_pal: { key:12, kyat: null, pal: null, yway: null },
                _token: constant.CSRF
            },
            limitation_price: null,
            valid: true,
            requireRule: [
                v => !!v || 'This field is required',
            ],
        }),
        watch: {
            daily_setup_amount(){
                this.onChange();
            }
        },
        computed: mapGetters(['daily_setup_amount']),
        methods: {
            ...mapActions(["setGlobalStep", "setDailySetupPurchaseReturnForm", "reduceGlobalStep", "setLimitationPrice"]),
            submit () {
                if(!this.$refs.form.validate()) return;
                this.setGlobalStep();
                this.setDailySetupPurchaseReturnForm(this.form);

            },
            onChange() {
                if(this.daily_setup_amount == null) return;
                console.log("on change event");
                this.setDailySetupPurchaseReturnForm({});
                let amount = Number(this.daily_setup_amount) - Number(this.limitation_price);
                this.form.quality_16_pal.kyat = Number(amount);
                this.form.quality_16_pal.pal = this.form.quality_16_pal.kyat / 16;
                this.form.quality_16_pal.yway = this.form.quality_16_pal.pal / 8;
                this.form.quality_15_pal.kyat = amount - this.form.quality_16_pal.pal;
                this.form.quality_15_pal.pal = this.form.quality_15_pal.kyat / 16;
                this.form.quality_15_pal.yway = this.form.quality_15_pal.pal / 8;
                this.form.quality_14_pal.kyat = amount - (this.form.quality_16_pal.pal * 2);
                this.form.quality_14_pal.pal = this.form.quality_14_pal.kyat / 16;
                this.form.quality_14_pal.yway = this.form.quality_14_pal.pal / 8;
                this.form.quality_144_pal.kyat = this.form.quality_14_pal.kyat + (this.form.quality_14_pal.yway * 4);
                this.form.quality_144_pal.pal = this.form.quality_144_pal.kyat / 16;
                this.form.quality_144_pal.yway = this.form.quality_144_pal.pal / 8;
                this.form.quality_13_pal.kyat = amount - (this.form.quality_16_pal.pal * 3);
                this.form.quality_13_pal.pal = this.form.quality_13_pal.kyat / 16;
                this.form.quality_13_pal.yway = this.form.quality_13_pal.pal / 8;
                this.form.quality_12_pal.kyat = amount - (this.form.quality_16_pal.pal * 4);
                this.form.quality_12_pal.pal = this.form.quality_12_pal.kyat / 16;
                this.form.quality_12_pal.yway = this.form.quality_12_pal.pal / 8;

                this.setDailySetupPurchaseReturnForm(this.form);
                this.setLimitationPrice(this.limitation_price)
            },
            changeKyat(key,value) {
                this.setDailySetupPurchaseReturnForm({});
                let pal = value / 16;
                let yway = pal / 8;

                switch(key) {
                    case 16:
                        this.form.quality_16_pal.kyat = value;
                        this.form.quality_16_pal.pal = pal;
                        this.form.quality_16_pal.yway = yway;
                        break;
                    case 15:
                        this.form.quality_15_pal.kyat = value;
                        this.form.quality_15_pal.pal = pal;
                        this.form.quality_15_pal.yway = yway;
                        break;
                    case 14:
                        this.form.quality_14_pal.kyat = value;
                        this.form.quality_14_pal.pal = pal;
                        this.form.quality_14_pal.yway = yway;
                        break;
                    case 144:
                        this.form.quality_144_pal.kyat = value;
                        this.form.quality_144_pal.pal = pal;
                        this.form.quality_144_pal.yway = yway;
                        break;
                    case 13:
                        this.form.quality_13_pal.kyat = value;
                        this.form.quality_13_pal.pal = pal;
                        this.form.quality_13_pal.yway = yway;
                        break;
                    case 12:
                        this.form.quality_12_pal.kyat = value;
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
