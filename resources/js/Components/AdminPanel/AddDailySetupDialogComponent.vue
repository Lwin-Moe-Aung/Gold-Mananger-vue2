<template>
    <v-dialog
        v-model="dialog"
        persistent
        max-width="600px"
        >
        <v-card>
            <v-form ref="form" lazy-validation>
                <v-card-title>
                    <span class="text-h5">{{ title }}</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    v-model = "daily_price"
                                    label="16 ပဲရည်တန်ဖိုး*"
                                    required
                                    :rules="validationRules"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="close"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="save"
                    >
                        Save
                    </v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>
</template>
<script>
    import axios from "axios";

    export default {
        name: "AddDailySetupDialogComponent",
        props: ["value",'route_name','title','type'],
        data: () => ({
            daily_price:'',
            dialog: false,
            validationRules:[
                v => !!v || 'Required',
                v => /^\d+$/.test(v) || 'Must be a number',
            ],
        }),
        watch: {
            value (val) {
                this.dialog = !this.dialog;
            },
        },
        methods: {
            close(){
                this.$emit('update:data', null);
            },
            save(){
                if(this.$refs.form.validate()){
                    let data = new FormData();
                    data.append('daily_price',this.daily_price);
                    data.append('type',this.type);
                    axios.post(this.route(this.route_name), data)
                        .then(res => {
                            this.$emit('update:data', res.data.data);
                            this.daily_price = '';
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            }
        }
    }
</script>
