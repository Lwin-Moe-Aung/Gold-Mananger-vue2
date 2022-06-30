<template>
        <multiselect
            v-model="selectedData"
            :options="data"
            @search-change="onSearchDataChange"
            @input="onSelectedData"
            label="item_sku"
            track-by="id"
            id="id"
            placeholder="Search Item Sku"

            >
        </multiselect>
</template>

<script>
import {throttle} from "lodash";
import axios from "axios";

export default {
    name: 'txt',
    created() {
        this.loadData();
    },
    data() {
        return {
            data:[],
            selectedData: undefined,
        }
    },
    methods: {
        loadData(){
            axios.get(this.route("admin.item_sku_search"))
                .then((response) => {
                    this.data = response.data.data;
            });
        },
        onSearchDataChange: throttle(function (term) {
            axios.get(this.route("admin.item_sku_search", { params: { term: term }}))
                        .then((response) => {
                            this.data = response.data.data;
                    });
            }, 300),
        onSelectedData(value) {
            this.selectedData = value;
            this.$emit('update:data', this.selectedData.item_sku);
        },

    }
}
</script>
