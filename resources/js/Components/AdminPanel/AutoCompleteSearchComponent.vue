<template>
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
</template>

<script>
import {throttle} from "lodash";
import axios from "axios";

export default {
    name: "AutoCompleteSearchComponent",
    props: ["value","route_name","label","placeholder"],
    created() {
        this.loadData();
    },
    data() {
        return {
            data:[],
            selectedData: undefined,
        }
    },
    watch: {
        value (val) {
            this.selectedData = val;
        },
    },
    methods: {
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
