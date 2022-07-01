<template>
    <div class="card card-primary card-outline" data-select2-id="32">
        <div class="card-header">
            <h3 class="card-title">Select Form and Show Daily Setup</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body" style="display: block;" data-select2-id="31">
            <div class="row">
                <div class="col-12 col-sm-4 border-right">
                    <div class="form-group">
                        <label for="permissions">ပဲရည်</label>
                        <multiselect
                            v-model="goldQuality"
                            :options="goldQualitys"
                            :multiple="false"
                            :taggable="true"
                            placeholder="Supplier name"
                            label="name"
                            track-by="quality"
                            @input="onChangeQ"
                        ></multiselect>
                    </div>
                </div>
                <div class="col-12 col-sm-4 border-right">
                    <div class="form-group">
                        <label for="permissions">ရွှေ/ကျောက်</label>
                        <multiselect
                            v-model="type"
                            :options="types"
                            :multiple="false"
                            :taggable="true"
                            placeholder="ရွှေ/ကျောက်"
                            label="name"
                            track-by="id"
                            @input="onChangeT"
                        ></multiselect>
                    </div>
                </div>
                <div class="col-12 col-sm-4 border-right">
                    <div class="form-group">
                        <label for="permissions">အမျိုးအစား</label>
                        <multiselect
                            v-model="item_name"
                            :options="item_names"
                            :multiple="false"
                            :taggable="true"
                            placeholder="အမျိုးအစား"
                            label="name"
                            track-by="id"
                            @input="onChangeItemName"
                        ></multiselect>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
    import axios from 'axios';
    import {mapGetters, mapActions} from "vuex";

    export default {
        name: 'ThreeMultiSelectComponent',
        props: ["value"],
        data: () => ({
            // combobox
            // dataForCombobox:[],
            goldQuality: null,
            goldQualitys: [],
            type: null,
            types: [],
            item_name: null,
            item_names: [],
            // end combobox
        }),
        async created() {
            await this.getDataForCombobox();
        },
        watch: {
            value(val){
                this.setDailySetup(val);
            }
        },
        methods: {
            async getDataForCombobox(){
                await axios.get(this.route("pos.get_data_for_combobox"))
                    .then((response) => {
                        this.goldQualitys = response.data.goldQualitys;
                });
            },
            setDailySetup(newValue) {
                if(newValue.length > 3){
                    var q = newValue.charAt(0)+newValue.charAt(1);
                    var t = newValue.charAt(2);
                    var i_n = newValue.charAt(3);
                }else{
                    var q = newValue.charAt(0);
                    var t = newValue.charAt(1);
                    var i_n = newValue.charAt(2);
                }
                let g_Quality  = this.goldQualitys.find(function(val) {
                    return val.quality == q;
                });

                this.goldQuality = g_Quality;
                this.types = this.goldQuality.types;
                let type_e = this.types.find(function(val) {
                    return val.key == t;
                });
                this.type = type_e;
                this.item_names = this.type.item_names
                let item_n = this.item_names.find(function(val) {
                    return val.key == i_n;
                });
                this.item_name = item_n;
            },
            onChangeQ (entry) {
                this.$emit('update:data', "");
                if(this.goldQuality == null){
                    this.type = null;
                    this.item_name = null;
                    return;
                }
                this.type = null;
                this.types = this.goldQuality.types;
                this.item_name = null;
                this.item_names = [];
            },
            onChangeT (entry) {
                this.$emit('update:data', "");
                if(this.type == null){
                    this.item_name = null;
                    return;
                }
                this.item_name = null;
                this.item_names = this.type.item_names;
            },
            onChangeItemName (entry) {
                if(this.goldQuality == null && this.type == null  && this.item_name == null ) return;
                let product_sku = this.goldQuality.quality+this.type.key+this.item_name.key;
                this.$emit('update:data', product_sku);
            },
        }
    }
</script>
