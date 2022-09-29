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
                            v-model = "form.daily_setup_amount"
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
                            v-model = "form.quality_16_pal.kyat"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            type="number"
                            label="ကျပ်"
                            placeholder="ကျပ်"
                            required
                            solo-inverted
                            dense
                            :rules="requireRule"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_16_pal.pal"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ပဲ"
                            placeholder="ပဲ"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_16_pal.yway"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ရွေး"
                            placeholder="ရွေး"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
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
                            v-model = "form.quality_15_pal.kyat"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ကျပ်"
                            placeholder="ကျပ်"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_15_pal.pal"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ပဲ"
                            placeholder="ပဲ"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_15_pal.yway"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ရွေး"
                            placeholder="ရွေး"
                            required
                            type="number"
                            step=".1"
                            solo-inverted
                            dense
                            :rules="requireRule"
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
                            v-model = "form.quality_14_pal.kyat"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ကျပ်"
                            placeholder="ကျပ်"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_14_pal.pal"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ပဲ"
                            placeholder="ပဲ"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_14_pal.yway"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ရွေး"
                            placeholder="ရွေး"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
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
                            v-model = "form.quality_144_pal.kyat"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ကျပ်"
                            placeholder="ကျပ်"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_144_pal.pal"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ပဲ"
                            placeholder="ပဲ"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_144_pal.yway"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ရွေး"
                            placeholder="ရွေး"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
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
                            v-model = "form.quality_13_pal.kyat"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ကျပ်"
                            placeholder="ကျပ်"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_13_pal.pal"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ပဲ"
                            placeholder="ပဲ"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_13_pal.yway"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ရွေး"
                            placeholder="ရွေး"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
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
                            v-model = "form.quality_12_pal.kyat"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ကျပ်"
                            placeholder="ကျပ်"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_12_pal.pal"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ပဲ"
                            placeholder="ပဲ"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            v-model = "form.quality_12_pal.yway"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            label="ရွေး"
                            placeholder="ရွေး"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
            </v-layout>
            <v-card-actions class="card-actions">
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
    export default {
        props: ['value'],
        data: () => ({
            form:{
                daily_setup_amount: null,
                quality_16_pal: { kyat: null, pal: null, yway: null },
                quality_15_pal: { kyat: null, pal: null, yway: null },
                quality_14_pal: { kyat: null, pal: null, yway: null },
                quality_144_pal: { kyat: null, pal: null, yway: null },
                quality_13_pal: { kyat: null, pal: null, yway: null },
                quality_12_pal: { kyat: null, pal: null, yway: null },
            },
            valid: true,
            requireRule: [
                v => !!v || 'This field is required',
            ],
        }),

        created() {
            if(this.value == null) return;
            this.form.daily_setup_amount = this.value.daily_setup_amount;
            this.form.quality_16_pal.kyat = this.value.quality_16_pal.kyat;
            this.form.quality_16_pal.pal = this.value.quality_16_pal.pal;
            this.form.quality_16_pal.yway = this.value.quality_16_pal.yway;
            this.form.quality_15_pal.kyat = this.value.quality_15_pal.kyat;
            this.form.quality_15_pal.pal = this.value.quality_15_pal.pal;
            this.form.quality_15_pal.yway = this.value.quality_15_pal.yway;
            this.form.quality_14_pal.kyat = this.value.quality_14_pal.kyat;
            this.form.quality_14_pal.pal = this.value.quality_14_pal.pal;
            this.form.quality_14_pal.yway = this.value.quality_14_pal.yway;
            this.form.quality_144_pal.kyat = this.value.quality_144_pal.kyat;
            this.form.quality_144_pal.pal = this.value.quality_144_pal.pal;
            this.form.quality_144_pal.yway = this.value.quality_144_pal.yway;
            this.form.quality_13_pal.kyat = this.value.quality_13_pal.kyat;
            this.form.quality_13_pal.pal = this.value.quality_13_pal.pal;
            this.form.quality_13_pal.yway = this.value.quality_13_pal.yway;
            this.form.quality_12_pal.kyat = this.value.quality_12_pal.kyat;
            this.form.quality_12_pal.pal = this.value.quality_12_pal.pal;
            this.form.quality_12_pal.yway = this.value.quality_12_pal.yway;
        },

        methods: {
            ...mapActions(["setGlobalStep", "setDailySetupForm"]),
            submit () {
                if(!this.$refs.form.validate()) return;
                this.setGlobalStep();
                this.setDailySetupForm(this.form);
            },

            onChange() {
                this.form.quality_16_pal.kyat = Number(this.form.daily_setup_amount);
                this.form.quality_16_pal.pal = this.form.daily_setup_amount / 16;
                this.form.quality_16_pal.yway = this.form.quality_16_pal.pal / 8;
                this.form.quality_15_pal.kyat = this.form.daily_setup_amount - this.form.quality_16_pal.pal;
                this.form.quality_15_pal.pal = this.form.quality_15_pal.kyat / 16;
                this.form.quality_15_pal.yway = this.form.quality_15_pal.pal / 8;
                this.form.quality_14_pal.kyat = this.form.daily_setup_amount - (this.form.quality_16_pal.pal * 2);
                this.form.quality_14_pal.pal = this.form.quality_14_pal.kyat / 16;
                this.form.quality_14_pal.yway = this.form.quality_14_pal.pal / 8;
                this.form.quality_144_pal.kyat = this.form.daily_setup_amount - (this.form.quality_16_pal.pal * 2);
                this.form.quality_144_pal.pal = this.form.quality_144_pal.kyat / 16;
                this.form.quality_144_pal.yway = this.form.quality_144_pal.pal / 8;
                this.form.quality_13_pal.kyat = this.form.daily_setup_amount - (this.form.quality_16_pal.pal * 3);
                this.form.quality_13_pal.pal = this.form.quality_13_pal.kyat / 16;
                this.form.quality_13_pal.yway = this.form.quality_13_pal.pal / 8;
                this.form.quality_12_pal.kyat = this.form.daily_setup_amount - (this.form.quality_16_pal.pal * 4);
                this.form.quality_12_pal.pal = this.form.quality_12_pal.kyat / 16;
                this.form.quality_12_pal.yway = this.form.quality_12_pal.pal / 8;
            }
        }
    }
</script>
