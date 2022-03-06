<template>
    <v-app :style="{background: $vuetify.theme.themes.dark.background}">
        <SideBar />
        <SideBarRight />
        <v-container style="margin-left: 68px; padding: 39px;">
          <!-- Main content -->
                  <slot></slot>
          <!-- /.content -->
        </v-container>
    </v-app>
</template>

<script>
    import SideBar from '../Components/PosPanel/SideBar'
    import SideBarRight from '../Components/PosPanel/SideBarRight'

    export default {
        components: {
            SideBar,
            SideBarRight,
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