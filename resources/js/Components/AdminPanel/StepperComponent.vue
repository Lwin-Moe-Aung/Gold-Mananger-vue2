<template>
    <v-hover
        v-slot="{ hover }"
        open-delay="200"
    >
        <v-card
            :elevation="hover ? 16 : 2"
            :class="{ 'on-hover': hover }"
            class="mx-auto"
            style="margin-top:70px; border-radius: 25px;width: 750px;"
        >
            <v-toolbar
                color="cyan"
                dark
                class="justify-content-center"
            >
                <v-toolbar-title>Opening Day</v-toolbar-title>
            </v-toolbar>
            <div class="wrapper-stepper">
                <div class="stepper">
                    <div class="stepper-progress">
                        <div class="stepper-progress-bar" :style="'width:' + stepperProgress "></div>
                    </div>

                    <div class="stepper-item" :class="{ 'current': step == item.index, 'success': step > item.index }" v-for="item in items" :key="item.index">
                        <div class="stepper-item-counter">
                            <img class="icon-success" src="https://www.seekpng.com/png/full/1-10353_check-mark-green-png-green-check-mark-svg.png" alt="">
                            <span class="number">
                                {{ item.index }}
                            </span>
                        </div>

                        <span class="stepper-item-title">
                            {{ item.title }}
                        </span>
                    </div>
                </div>

                <div class="stepper-content">
                    <div class="stepper-pane" v-if="step == 1">
                        <StepperDailySetupFormComponent
                            v-model="form1"
                            :daily_setup = daily_setup
                        />
                    </div>
                    <div class="stepper-pane" v-if="step == 2">
                        <StepperDailySetupPurchaseReturnFormComponent
                            v-model = "form2"
                            :daily_setup_amount = daily_setup
                            :limitation = limitation
                        />
                    </div>
                    <div class="stepper-pane" v-if="step == 3">
                        <StepperOpeningBalanceComponent
                            v-model="opening_balance_props"
                        />
                    </div>
                    <div class="stepper-pane" v-if="step == 4">
                        <CongratulationComponent/>
                    </div>
                </div>
            </div>
        </v-card>
    </v-hover>
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
            form1: null,
            form2: null,
            daily_setup: null,
            opening_balance_props: null,
            limitation: null,
            step: 1,
            items: [
                { index: 1, title:'Daily Setup Form' },
                { index: 2, title:'Daily Setup For Purchase Return Form' },
                { index:3, title:'Opening Balance Form' },
            ],
        }),
        computed: {
            ...mapGetters(['global_step', 'daily_setup_form', 'daily_setup_for_purchase_return_form', 'opening_balance', 'daily_setup_amount', 'limitation_price']),
            stepperProgress() {
                return ( 100 / 3 ) * ( this.step - 1 ) + '%'
            }
        },
        watch: {
            global_step(value) {
                this.step = value;
            },
            daily_setup_form(value) {
                if(value == null) return;
                this.form1 = value;
            },
            daily_setup_amount(value) {
                this.daily_setup = value;
            },
            limitation_price(value) {
                this.limitation = value;
            },
            daily_setup_for_purchase_return_form(value) {
                if(value == null) return;
                this.form2 = value;
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
<style lang="scss">
    @import "./public/css/scss/components/stepper_component.scss";
</style>
