<template>
    <div>
        <pos-panel-layout>
           
            <Search/>
            <ItemList/>
            <v-toolbar color="#EEEEEE" flat class="toolbar-middle">
              <v-toolbar-title class="mb-7">Customer Profile</v-toolbar-title><v-spacer></v-spacer><span class="mb-7" color="grey">Open Voucher</span>
            </v-toolbar>
            <v-row>
                <Customer/>
                <Voucher1/>
                <Voucher2/>

            </v-row>
            
        </pos-panel-layout>
    </div>
</template>

<script>
    import PosPanelLayout from '../../../Layouts/PosPanelLayout';
    import Customer from './Customer';
    import ItemList from './ItemList';
    import Search from './Search';
    import Voucher1 from './Voucher1';
    import Voucher2 from './Voucher2';
    export default {
        components: {
            PosPanelLayout,
            Customer,
            ItemList,
            Search,
            Voucher1,
            Voucher2
        },
       
    }
</script>
            
<style>
.v-card.borderme {
    border: 2px solid #704232 !important;
}
.v-card.borderout{
  border: 1px solid #BCAAA4 !important;
}
.voucher-row{
  margin-bottom: -22px;
}
.voucher-row1{
  margin-bottom: -37px;
}
.toolbar-middle{
  height: 40px !important;
}
/* .v-toolbar__content{
  height: 31px !important;
} */
.v-timeline{
  padding-top: 0 !important;
}
</style>