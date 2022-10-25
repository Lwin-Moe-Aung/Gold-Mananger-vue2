<template>
    <v-stepper v-model="step">
        <v-stepper-header>
            <v-stepper-step
                :complete="step > 1"
                step="1"
            >
                Daily Setup Form
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step
                :complete="step > 2"
                step="2"
            >
                Daily Setup For Purchase Return Form
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step
                :complete="step > 3"
                step="3"
            >
                Opening Balance Form
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step step="4">
                Success
            </v-stepper-step>
        </v-stepper-header>

        <v-stepper-items>
            <v-stepper-content step="1">
                <StepperDailySetupFormComponent/>
            </v-stepper-content>

            <v-stepper-content step="2">
                <StepperDailySetupPurchaseReturnFormComponent/>
            </v-stepper-content>

            <v-stepper-content step="3">
                <StepperOpeningBalanceComponent/>
            </v-stepper-content>

            <v-stepper-content step="4">
                <CongratulationComponent/>
            </v-stepper-content>
        </v-stepper-items>
    </v-stepper>
</template>
<script>
    import StepperDailySetupFormComponent from './StepperDailySetupFormComponent';
    import StepperDailySetupPurchaseReturnFormComponent from './StepperDailySetupPurchaseReturnFormComponent';
    import StepperOpeningBalanceComponent from './StepperOpeningBalanceComponent';
    import CongratulationComponent from './CongratulationComponent';
    import {mapGetters, mapActions} from "vuex";

    export default {
        components: {
            StepperDailySetupFormComponent,
            StepperDailySetupPurchaseReturnFormComponent,
            StepperOpeningBalanceComponent,
            CongratulationComponent
        },
        data: () => ({
            daily_setup: null,
            opening_balance_props: null,
            step: 1,
            items: [
                { index: 1, title:'Daily Setup Form' },
                { index: 2, title:'Daily Setup For Purchase Return Form' },
                { index: 3, title:'Opening Balance Form' },
                { index: 4, title:'Success' },
            ],
        }),
        computed: mapGetters(['global_step', 'opening_balance', 'daily_setup_amount']),

        watch: {
            global_step(value) {
                this.step = value;
            },
            daily_setup_amount(value) {
                this.daily_setup = value;
            },
            opening_balance(value) {
                if(value == null) return;
                this.opening_balance_props = value;
            }

        },
        methods: {
            ...mapActions([""]),
        }
    }
</script>
