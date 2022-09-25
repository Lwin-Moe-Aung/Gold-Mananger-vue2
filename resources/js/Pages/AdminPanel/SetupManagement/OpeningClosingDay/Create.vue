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
            <v-stepper v-model="e1">
                <v-stepper-header>
                    <v-stepper-step
                        :complete="e1 > 1"
                        step="1"
                    >
                        Name of step 1
                    </v-stepper-step>

                    <v-divider></v-divider>

                    <v-stepper-step
                        :complete="e1 > 2"
                        step="2"
                    >
                        Name of step 2
                    </v-stepper-step>

                    <v-divider></v-divider>

                    <v-stepper-step step="3">
                        Name of step 3
                    </v-stepper-step>
                </v-stepper-header>

                <v-stepper-items>
                    <v-stepper-content step="1">
                        <v-card
                            class="mb-12"
                            height="200px"
                        ></v-card>

                        <v-btn
                            color="#ECBD00"
                            dark
                            @click="e1 = 2"
                        >
                            Continue
                        </v-btn>

                        <v-btn
                            color="#4DB879"
                            dark
                        >
                            Cancel
                        </v-btn>
                    </v-stepper-content>

                    <v-stepper-content step="2">
                        <v-card
                            class="mb-12"
                            color="grey lighten-1"
                            height="200px"
                        ></v-card>

                        <v-btn
                            color="#ECBD00"
                            dark
                            @click="e1 = 3"
                        >
                            Continue
                        </v-btn>

                        <v-btn
                            color="#4DB879"
                            dark
                        >
                            Cancel
                        </v-btn>
                    </v-stepper-content>

                    <v-stepper-content step="3">
                        <v-card
                            class="mb-12"
                            color="grey lighten-1"
                            height="200px"
                        ></v-card>

                        <v-btn
                            color="#ECBD00"
                            dark
                            @click="e1 = 1"
                        >
                            Continue
                        </v-btn>

                        <v-btn
                            color="#4DB879"
                            dark
                        >
                            Cancel
                        </v-btn>
                    </v-stepper-content>
                </v-stepper-items>
            </v-stepper>
        </v-card>
    </v-hover>
</template>

<script>
    export default {
      data () {
        return {
          e1: 1,
        }
      },
    }
</script>
