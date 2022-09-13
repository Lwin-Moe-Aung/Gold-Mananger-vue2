<template>
    <pos-panel-layout>
        <v-row no-gutters>

            <v-col
                cols="12"
                sm="12"
                md="10"
            >
                <TopSearchBar/>
                <v-item-group mandatory class="mt-n1">
                    <v-content class="pa-3">
                        <ShowItemsList/>
                    </v-content>
                </v-item-group>
                <v-content class="pa-3">
                    <v-row >
                        <v-col
                            cols="12"
                            xs="12"
                            sm="12"
                            md="12"
                            lg="3"
                        >
                            <Customer />
                        </v-col>
                        <v-col
                            cols="12"
                            xs="12"
                            sm="12"
                            md="12"
                            lg="9"
                        >
                            <Voucher1 />
                        </v-col>
                    </v-row>
                </v-content>
            </v-col>
            <v-col
                cols="12"
                md="2"
                class="d-none d-lg-flex d-md-none"
            >
                <RightSideBar />
            </v-col>
            <FAB class="d-lg-none d-sm-flex"/>
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

    import FAB from '../../../Components/PosPanel/FAB';
    import RightSideBar from '../../../Components/PosPanel/RightSideBar';

    export default {
        components: {
            PosPanelLayout,
            Customer,
            ItemList,
            Search,
            Voucher1,
            TopSearchBar,
            ShowItemsList,
            RightSideBar,
            FAB
        },
        data() {
            return {
                model:null,
            };
        },

    };
</script>
<style scoped>
.v-tab.withoutupercase {
  text-transform: none !important;
}
.v-tabs {
  width: 50% !important;
}
.v-btn.withoutupercase {
  text-transform: none !important;
}
/*div{
  display:inline-block;
  float:left;
  color:#fff;
  font-size:10px;
}*/

.three {
  width: 50px;
  height: 50px;
}

.four {
  width: 50px;
  height: 25px;
  background: black;
}
.five {
  width: 50px;
  height: 25px;
  background: #042a0f;
}
.six {
  width: 50px;
  height: 25px;
  background: #2c2107;
}
</style>
