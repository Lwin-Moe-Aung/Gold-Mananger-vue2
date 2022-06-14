<template>
    <pos-panel-layout>
        <v-toolbar color="rgba(0,0,0,0)" flat>
            <v-row>
                <v-col cols="12" sm="12">
                    <v-card flat class="rounded-lg mx-2">
                        <v-row>
                            <!-- search bar -->
                            <TopSearchBar/>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>
        </v-toolbar>
        <v-item-group mandatory class="mt-n1">
            <v-container>
                <!-- item list showing -->
                <ShowItemsList/>
            </v-container>
        </v-item-group>
        <v-toolbar color="#EEEEEE" flat class="toolbar-middle">
            <v-toolbar-title class="mb-7">Customer Profile</v-toolbar-title>
            <v-spacer></v-spacer >
            <span class="mb-7" color="grey">Open Voucher</span>
        </v-toolbar>
        <v-row>
            <Customer />
            <Voucher1 />
        </v-row>
    </pos-panel-layout>
</template>

<script>
import PosPanelLayout from "../../../Layouts/PosPanelLayout";
import Customer from "./Customer";
import ItemList from "./ItemList";
import Search from "./Search";
import Voucher1 from "./Voucher1";
import TopSearchBar from "./TopSearchBar";
import ShowItemsList from "./ShowItemsList";

export default {
    components: {
        PosPanelLayout,
        Customer,
        ItemList,
        Search,
        Voucher1,
        TopSearchBar,
        ShowItemsList
    },
    data() {
        return {
            model:null,
        };
    },

};
</script>
<!--
<style>
.v-card.borderme {
    border: 2px solid #704232 !important;
}
.v-card.borderout {
    border: 1px solid #bcaaa4 !important;
}
.voucher-row {
    margin-bottom: -22px;
}
.voucher-row1 {
    margin-bottom: -37px;
}
.toolbar-middle {
    height: 40px !important;
}
/* .v-toolbar__content{
  height: 31px !important;
} */
.v-timeline {
    padding-top: 0 !important;
}
.v-toolbar__content {
    height: 71px !important;
}
</style> -->
