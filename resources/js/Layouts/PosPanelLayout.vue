<template>
    <v-app :style="{background: $vuetify.theme.themes.dark.background}">
        <!-- <v-row no-gutters>
            <v-col
                lg="1"
                class="d-none d-lg-flex d-md-none"
            >
                <SideBar/>
            </v-col>
            <v-col
                lg="9"
                md="12"
                xs="12"
                sm="12"
            >
                <slot></slot>
            </v-col>
            <FAB class="d-lg-none d-sm-flex"/>
            <v-col
                lg="2"
                class="d-none d-lg-flex d-md-none"
            >
                <RightSideBar />
            </v-col>
        </v-row> -->
        <v-row no-gutters>

            <SideBar/>
            <v-col
                lg="11"
                md="12"
                xs="12"
                sm="12"
                class = "offset-xl-1"
            >
                <slot></slot>
            </v-col>
            <!-- <FAB class="d-lg-none d-sm-flex"/>
            <v-col
                lg="2"
                class="d-none d-lg-flex d-md-none"
            >
                <RightSideBar />
            </v-col> -->
        </v-row>
    </v-app>
</template>

<script>
    import SideBar from '../Components/PosPanel/SideBar'
    // import FAB from '../Components/PosPanel/FAB'
    // import RightSideBar from '../Components/PosPanel/RightSideBar'

    export default {
        components: {
            SideBar,
            // RightSideBar,
            // FAB
        },
        data: () => ({

        }),
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
