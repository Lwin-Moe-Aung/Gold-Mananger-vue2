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
                        <StepperDailySetupFormComponent/>
                    </div>
                    <div class="stepper-pane" v-if="step == 2">
                        <StepperDailySetupPurchaseReturnFormComponent/>
                    </div>
                    <div class="stepper-pane" v-if="step == 3">
                        <StepperOpeningBalanceComponent/>
                    </div>
                    <div class="stepper-pane" v-if="step == 4">
                        <CongratulationComponent/>
                    </div>
                </div>
                <v-card-actions>
                    <v-btn
                        color="#F0F0F0"
                        @click="step--" :disabled="step == 1"
                    >
                        Back
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="#4D25B9"
                        dark
                        @click="step++" :disabled="step == 4"
                    >
                        Continue
                    </v-btn>
                </v-card-actions>
            </div>
        </v-card>
    </v-hover>
</template>
<script>
    import StepperDailySetupFormComponent from './StepperDailySetupFormComponent';
    import StepperDailySetupPurchaseReturnFormComponent from './StepperDailySetupPurchaseReturnFormComponent';
    import StepperOpeningBalanceComponent from './StepperOpeningBalanceComponent';
    import CongratulationComponent from './CongratulationComponent';


    export default {
        components: {
            StepperDailySetupFormComponent,
            StepperDailySetupPurchaseReturnFormComponent,
            StepperOpeningBalanceComponent,
            CongratulationComponent
        },
        data: () => ({
            step: 1,
            items: [
                { index: 1, title:'Daily Setup Form' },
                { index: 2, title:'Daily Setup For Purchase Return Form' },
                { index:3, title:'Opening Balance Form' },
            ],
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
