<template>
    <div class="row">
        <div class="col-sm-10 col-xs-10">
            <multiselect
                v-model="selectedData"
                :options="data"
                @search-change="onSearchDataChange"
                @input="onSelectedData"
                :label="label"
                track-by="id"
                id="id"
                :placeholder="placeholder"
            >
            </multiselect>
        </div>
        <div class="col-sm-2 col-xs-2" v-if="label == 'product_sku' || label == 'search_name'">
            <button type="button" class="btn btn-success btn-flat text-white float-right" @click="addDialog = true"><i class="fas fa-plus"></i></button>
        </div>
        <AddProductDialogComponent
            v-if="label == 'product_sku'"
            @update:data="eventDialog"
            v-model = "addDialog"
            title="Add Product"
            route_name="admin.products.storeDialog"
        />
        <AddContactDialogComponent
            v-if="label == 'search_name'"
            @update:data="eventDialog"
            v-model = "addDialog"
            title="Add Customer"
            route_name="pos.save_contact"
            type="customer"
        />
    </div>

</template>

<script>
import {throttle} from "lodash";
import axios from "axios";
import AddContactDialogComponent from './AddContactDialogComponent';
import AddProductDialogComponent from './AddProductDialogComponent';

export default {
    name: "AutoCompleteSearchComponent",
    props: ["value","route_name","label","placeholder"],
    components: {
        AddProductDialogComponent,
        AddContactDialogComponent
    },
    created() {
        this.loadData();
    },
    data() {
        return {
            data:[],
            selectedData: undefined,
            addDialog: false,
        }
    },
    watch: {
        value (val) {
            this.selectedData = val;
        },
    },
    methods: {
        eventDialog(value) {
            this.addDialog = false;
            if(value != null){
                this.data.push(value);
                this.onSelectedData(value);
            }
        },
        // eventProductDialog(value){
        //     this.addProductDialog = false;
        //     if(value != null){
        //         this.form.product_id = value.id;
        //         this.product = value;
        //         this.products.push(value);
        //         this.changeProductSku()
        //     }
        // },
        loadData(){
            axios.get(this.route(this.route_name))
                .then((response) => {
                    this.data = response.data.data;
            });
        },
        onSearchDataChange: throttle(function (term) {
            axios.get(this.route(this.route_name, { params: { term: term }}))
                        .then((response) => {
                            this.data = response.data.data;
                    });
            }, 300),
        onSelectedData(value) {
            this.selectedData = value;
            // console.log(this.selectedData.invoice_no)
            this.$emit('update:data', this.selectedData);
        },

    }
}
</script>
