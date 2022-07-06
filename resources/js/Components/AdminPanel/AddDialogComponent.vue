<template>
    <v-dialog
        v-model="dialog"
        persistent
        max-width="600px"
        >
        <v-card>
            <v-form ref="form" lazy-validation>
                <v-card-title>
                    <span class="text-h5">Add Gold Quality</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    v-model = "name"
                                    label="name*"
                                    required
                                    :rules="validationRules"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model = "key"
                                    label="key*"
                                    required
                                    :rules="keyValidationRules"
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
        name: "AddDialogComponent",
        props: ["value",'route_name'],
        data: () => ({
            name:'',
            key: '',
            dialog: false,
            keyValidationRules:[
                v => !!v || 'Required',
                v => (v || '' ).length <= 1 || 'only one key allow'
            ],
            validationRules:[
                v => !!v || 'Required',
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
                this.name = '';
                this.key = '';
            },
            save(){
                if(this.$refs.form.validate()){
                    let data = new FormData();
                    data.append('name',this.name);
                    data.append('key',this.key);
                    axios.post(this.route(this.route_name), data)
                        .then(res => {
                            this.$emit('update:data', res.data.data);
                            this.name = '';
                            this.key = '';
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            }
        }
    }
</script>
