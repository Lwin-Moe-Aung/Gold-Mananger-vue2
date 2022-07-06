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
                                    v-model = "quality"
                                    label="quality*"
                                    type="number"
                                    min=0
                                    max=16
                                    required
                                    :rules="validationRules"
                                    oninput="if(Number(this.value) > Number(this.max)) this.value = this.max;"
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
                        @click="saveQuality"
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
        name: "AddQualityDialogComponent",
        props: ["value"],
        data: () => ({
            quality:'',
            dialog: false,
            validationRules:[
                v => !!v || 'Required',
                v => /^\d+$/.test(v) || 'limitation error',
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
                this.quality = '';
            },
            saveQuality(){
                if(this.$refs.form.validate()){
                    let data = new FormData();
                    data.append('quality',this.quality);
                    axios.post(this.route("admin.gold_qualities.store"), data)
                        .then(res => {
                            this.$emit('update:data', res.data.data);
                            this.quality = '';
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            }
        }
    }
</script>
