<template>
    <v-hover
        v-slot="{ hover }"
        open-delay="200"
    >
        <v-card
            :elevation="hover ? 16 : 2"
            :class="{ 'on-hover': hover }"
            class="mx-auto"
            style="margin-top:70px; border-radius: 25px;"
        >
            <div class="wrapper-stepper">
                <div class="stepper">
                    <div class="stepper-progress">
                        <div class="stepper-progress-bar" :style="'width:' + stepperProgress "></div>
                    </div>

                    <div class="stepper-item" :class="{ 'current': step == item, 'success': step > item }" v-for="item in 4" :key="item">
                        <div class="stepper-item-counter">
                            <img class="icon-success" src="https://www.seekpng.com/png/full/1-10353_check-mark-green-png-green-check-mark-svg.png" alt="">
                            <span class="number">
                                {{ item }}
                            </span>
                        </div>
                        <span class="stepper-item-title">
                            Paso {{ item }}
                        </span>
                    </div>
                </div>

                <div class="stepper-content">
                    <div class="stepper-pane" v-if="step == 1">
                        <StepperDailySetupFormComponent/>
                    </div>
                    <div class="stepper-pane" v-if="step == 2">
                        <StepperDailySetupPurchaseReturnFormComponent/>
                    </div>
                    <div class="stepper-pane" v-if="step == 3">
                        <StepperOpeningBalanceComponent/>
                    </div>
                    <div class="stepper-pane" v-if="step == 4">
                        hello world success!!
                    </div>
                </div>

                <div class="controls">
                    <button class="btn" @click="step--" :disabled="step == 1">
                        Anterior
                    </button>
                    <button class="btn btn--green-1" @click="step++" :disabled="step == 4">
                        Siguiente
                    </button>
                </div>
            </div>
        </v-card>
    </v-hover>
</template>
<script>
    import StepperDailySetupFormComponent from './StepperDailySetupFormComponent';
    import StepperDailySetupPurchaseReturnFormComponent from './StepperDailySetupPurchaseReturnFormComponent';
    import StepperOpeningBalanceComponent from './StepperOpeningBalanceComponent';

    export default {
        components: {
            StepperDailySetupFormComponent,
            StepperDailySetupPurchaseReturnFormComponent,
            StepperOpeningBalanceComponent
        },
        data: () => ({
            step: 1
        }),
        computed: {
            stepperProgress() {
                return ( 100 / 3 ) * ( this.step - 1 ) + '%'
            }
        },
    }
</script>
<style lang="scss">
    @import "./public/css/scss/components/stepper_component.scss";
</style>
