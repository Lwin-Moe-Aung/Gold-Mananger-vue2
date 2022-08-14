<template>
    <div class="row" v-if="button == 'true'">
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
        <div class="col-sm-2 col-xs-2">
            <button type="button" class="btn btn-success btn-flat text-white float-right" @click="addDialog = true"><i class="fas fa-plus"></i></button>
        </div>
        <AddContactDialogComponent
            @update:data="eventDialog"
            v-model = "addDialog"
            title="Add Customer"
            route_name="pos.save_contact"
            type="customer"
        />
    </div>
    <div class="row" v-else>
        <div class="col-sm-12 col-xs-12">
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
    </div>

</template>

<script>
import {throttle} from "lodash";
import axios from "axios";
import AddContactDialogComponent from './AddContactDialogComponent';

export default {
    name: "ContactAutoCompleteSearchComponent",
    props: ["value","route_name","label","placeholder","type","button"],
    components: {
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
        loadData(){
            axios.get(this.route(this.route_name), { params: {type: this.type}})
                .then((response) => {
                    this.data = response.data.data;
            });
        },
        onSearchDataChange: throttle(function (term) {
            axios.get(this.route(this.route_name), { params: { term: term ,type: this.type}})
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
