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
                             <v-col
                                cols="12"
                                sm="6"
                                md="6"
                            >
                                <v-text-field
                                    v-model = "name"
                                    label="နာမည်*"
                                    required
                                    :rules="validationRules"
                                ></v-text-field>
                            </v-col>
                             <v-col
                                cols="12"
                                sm="6"
                                md="6"
                            >
                                <v-text-field
                                    v-model = "address"
                                    label="လိပ့်စာ*"
                                    required
                                    :rules="validationRules"
                                ></v-text-field>
                            </v-col>
                             <v-col
                                cols="12"
                                sm="6"
                                md="6"
                            >
                                <v-text-field
                                    v-model = "email"
                                    label="email"
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                                md="6"
                                v-if="type == 'supplier'"
                            >
                                <v-text-field
                                    v-model = "supplier_business_name"
                                    label="supplier business name"
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                                md="6"
                            >
                                <v-text-field
                                    v-model = "mobile1"
                                    label="Phone Number1*"
                                    required
                                    :rules="phValidationRules"
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                                md="6"
                            >
                                <v-text-field
                                    v-model = "mobile2"
                                    label="Phone Number2"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                    <small>*indicates required field</small>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="close()"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="save()"
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
        name: "AddContactDialogComponent",
        props: ["value",'route_name','type','title'],

        data() {
            return {
                name: "",
                address: "",
                email: "",
                mobile1: "",
                mobile2: "",
                supplier_business_name: "",
                dialog: false,

                validationRules:[
                    v => !!v || 'Required',
                ],
                phValidationRules:[
                    v => !!v || 'Required',
                    v => /^\d+$/.test(v) || 'Must be a number',
                ],
            };
        },
        created() {

        },
        watch: {
            value (val) {
                this.dialog = val;
            },
        },
        methods: {
            close(){
                this.$emit('update:data', null);
            },
            save() {
                if(this.$refs.form.validate()){
                    let data = new FormData();
                    data.append('name',this.name);
                    data.append('address',this.address);
                    data.append('email',this.email);
                    data.append('mobile1',this.mobile1);
                    data.append('mobile2',this.mobile2);
                    data.append('type',this.type);
                    data.append('supplier_business_name',this.supplier_business_name);

                    axios.post(this.route(this.route_name), data)
                        .then(res => {
                            this.$emit('update:data', res.data.data);
                            this.clearData();
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
            clearData(){
                this.name = '';
                this.address = '';
                this.email = '';
                this.mobile1 = '';
                this.mobile2 = '';
                this.supplier_business_name = '';
            }
        },
    };
</script>
<!-- <style src="vue-multiselect/dist/vue-multiselect.min.css"></style> -->
<style>
    .multiselect__content {
        padding-left: 0px !important;
    }
</style>
