<template>
    <v-container>
        <v-form
            ref="form"
            v-model="valid"
            lazy-validation
        >
            <v-layout row wrap class="mt-5">
                <v-flex xs4 md4 sm4 class="mt-2 text-center">
                    <span class="badge badge-pill bg-primary">Opening Balance</span>
                </v-flex>
                <v-flex xs6 sm6 md6>
                        <v-text-field
                            v-model = "opening_balance"
                            min="0"
                            oninput="if(this.value < 0) this.value = 0;"
                            placeholder="opening balance"
                            outlined
                            dense
                            required
                            :rules="requireRule"
                        >
                        </v-text-field>
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
                    @click="submit()"
                    outlined
                    rounded
                    text
                >
                    Finished
                </v-btn>
            </v-card-actions>
        </v-form>
    </v-container>
</template>
<script>
    import { mapActions} from "vuex";
    export default {
        name:"StepperOpeningBalanceComponent",
        data: () => ({
            opening_balance: null,
            valid: true,
            requireRule: [
                v => !!v || 'This field is required',
            ],
        }),
        methods: {
            ...mapActions(["setGlobalStep", "reduceGlobalStep", "setOpeningBalance", "saveData"]),
            submit () {
                if(!this.$refs.form.validate()) return;
                this.setOpeningBalance(this.opening_balance);
                this.setGlobalStep();
                this.saveData();
            }
        }
    }
</script>
