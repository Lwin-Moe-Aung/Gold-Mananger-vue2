<template>
    <v-dialog
        v-model="dialog"
        persistent
        max-width="600px"
        >
        <v-card>
            <v-form ref="form" lazy-validation enctype="multipart/form-data">
                <v-card-title>
                    <span class="text-h5">{{ title }}</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col
                                cols="12"
                                sm="4"
                                md="4"
                            >
                                <v-combobox
                                    v-model="goldQuality"
                                    :items="goldQualitys"
                                    item-text="quality"
                                    item-value="quality"
                                    return-object
                                    label="ပဲရည်"
                                    :rules="validationRules"
                                    required
                                ></v-combobox>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="4"
                                md="4"
                            >
                                <v-combobox
                                    v-model="type"
                                    :items="types"
                                    item-text="name"
                                    item-value="key"
                                    return-object
                                    label="ရွှေ/ကျောက်"
                                    :rules="validationRules"
                                    required
                                ></v-combobox>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="4"
                                md="4"
                            >
                                <v-combobox
                                    v-model="item_name"
                                    :items="item_names"
                                    item-text="name"
                                    item-value="key"
                                    return-object
                                    label="အမျိုးအမည်"
                                    :rules="validationRules"
                                    required
                                ></v-combobox>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                                md="6"
                            >
                                <v-text-field
                                    v-model="name"
                                    label="Name"
                                    :rules="validationRules"
                                    required
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                                md="6"
                            >
                                <v-text-field
                                    v-model="alert_quantity"
                                    label="Alert Quantity*"
                                    required
                                    type="number"
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                                md="6"
                            >
                                <v-text-field
                                    v-model="description"
                                    label="Description*"
                                    required
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                                md="6"
                            >
                                <v-file-input
                                    v-model="image"
                                    label="File input"
                                    show-size
                                >
                                    <template v-slot:selection="{ text }">
                                        <v-chip
                                            small
                                            label
                                            color="primary"
                                        >
                                            {{ text }}
                                        </v-chip>
                                    </template>
                                </v-file-input>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="4"
                                md="4"
                            >
                                <v-checkbox
                                    label="ရွှေချိန်+ကျောက်ချိန်"
                                    color="warning"
                                    input-value="true"
                                    value
                                    disabled
                                ></v-checkbox>
                                <v-checkbox
                                    v-model="gem_weight"
                                    label="ကျောက်ချိန်"
                                    color="error"
                                    value="1"
                                    hide-details
                                ></v-checkbox>
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
        name: "AddProductDialogComponent",
        props: ["value",'route_name','title'],
        data: () => ({
            // dataForCombobox
            goldQuality: null,
            goldQualitys: [],
            type: null,
            types: [],
            item_name: null,
            item_names: [],

            name: '',
            alert_quantity: '',
            description: '',
            image: undefined,
            gem_weight: null,

            dialog: false,
            validationRules:[
                v => !!v || 'Required',
            ],
        }),
        created() {
             this.getQualityDataList();
             this.getTypeDataList();
             this.getItemNameDataList();
        },
        mounted () {
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
            getQualityDataList(){
                axios.get(this.route("admin.gold_qualities.get_list"))
                    .then((response) => {
                        // Object.assign( state.daily_setup, data);
                        this.goldQualitys = response.data.data;
                });
            },
            getTypeDataList(){
                axios.get(this.route("admin.product_types.get_list"))
                    .then((response) => {
                        // Object.assign( state.daily_setup, data);
                        this.types = response.data.data;
                });
            },
            getItemNameDataList(){
                axios.get(this.route("admin.item_names.get_list"))
                    .then((response) => {
                        // Object.assign( state.daily_setup, data);
                        this.item_names = response.data.data;
                });
            },
            save(){
                if(this.$refs.form.validate()){
                    let data = new FormData();
                    data.append('name',this.name);
                    data.append('alert_quantity',this.alert_quantity);
                    data.append('description',this.description);
                    data.append('image',this.image);
                    data.append('quality',JSON.stringify(this.goldQuality));
                    data.append('type',JSON.stringify(this.type));
                    data.append('item_name',JSON.stringify(this.item_name));
                    data.append('gem_weight',this.gem_weight);

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
                this.alert_quantity = '';
                this.description = '';
                this.imageFile = '';
                this.gem_weight = null;
                this.goldQuality = null;
                this.type = null;
                this.item_name = null;
            }
        }
    }
</script>
