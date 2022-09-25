<template>
    <v-hover
        v-slot="{ hover }"
        open-delay="200"
    >
        <v-card
            :elevation="hover ? 16 : 2"
            :class="{ 'on-hover': hover }"
            class="mx-auto"
            max-width="700"
            style="margin-top:150px;"
        >
            <v-card-actions class="justify-content-center">
                <v-item-group
                    v-model="step"
                    class="text-center"
                    mandatory
                >
                    <v-item
                        v-for="n in length"
                        :key="`btn-${n}`"
                        v-slot="{ active}"
                    >
                        <v-btn
                            :input-value="active"
                            icon
                        >
                            <v-icon>fas fa-circle</v-icon>
                        </v-btn>
                    </v-item>
                </v-item-group>
            </v-card-actions>

            <v-card-title class="text-h6 font-weight-regular justify-space-between">
                <span>{{ currentTitle }}</span>

            </v-card-title>
            <v-window v-model="step">
                <v-window-item :value="0">
                    <DailySetupForm/>
                </v-window-item>

                <v-window-item :value="1">
                    <DailySetupPurchaseReturnForm/>
                </v-window-item>

                <v-window-item :value="2">
                    <OpeningBalance/>
                </v-window-item>

                <v-window-item :value="3">
                    <div class="pa-4 text-center">
                        <v-img
                            class="mb-4"
                            contain
                            height="128"
                            src="https://cdn.vuetifyjs.com/images/logos/v.svg"
                        ></v-img>
                        <h3 class="text-h6 font-weight-light mb-2">
                            Welcome to Vuetify
                        </h3>
                        <span class="text-caption grey--text">Thanks for signing up!</span>
                    </div>
                </v-window-item>
            </v-window>

            <v-divider></v-divider>

            <v-card-actions>
                <v-btn
                    color="#4DB879"
                    dark
                    v-if="step != 0 && step != 3"
                    @click="step--"
                >
                    Back
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    color="#9C36B5"
                    dark
                    v-if="step != 2 && step != 3"
                    @click="step++"
                >
                    Continue
                </v-btn>

                <v-btn
                    color="#9C36B5"
                    dark
                    v-if="step === 2"
                    @click="saveOpeningData()"
                >
                    Save Data
                </v-btn>
                <v-btn
                    color="#ECBD00"
                    dark
                    v-if="step === 3"
                    @click="saveOpeningData()"
                >
                    Finished
                </v-btn>

            </v-card-actions>
        </v-card>
    </v-hover>
</template>

<script>
    // import DailySetupForm from './DailySetupForm';
    // import DailySetupPurchaseReturnForm from './DailySetupPurchaseReturnForm';
    // import OpeningBalance from './OpeningBalance';
    // import {mapGetters, mapActions} from "vuex";

    export default {
        components: {
            DailySetupForm,
            DailySetupPurchaseReturnForm,
            OpeningBalance
        },
        data: () => ({
            step: 0,
            length:4,
        }),

        computed: {
            currentTitle () {
                switch (this.step) {
                    case 0: return 'Daily Setup'
                    case 1: return 'Daily Setup For Purchase Return'
                    case 2: return 'Opening Balance'
                    default: return 'Finished'
                }
            },
        },
        methods: {
            saveOpeningData() {
                this.step++;

            }
        }
    }
</script>

