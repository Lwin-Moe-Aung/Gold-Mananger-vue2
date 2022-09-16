<template>
    <pos-panel-layout>
        <v-app-bar-nav-icon
            class="d-lg-none d-sm-flex black--text"
            @click="changeDrawerSideBar()"
            >
        </v-app-bar-nav-icon>
        <v-card
            color="mt-3"
            flat
            height="200px"
        >
            <v-card-title>
                Customer Details
                <v-spacer></v-spacer>
                <v-spacer></v-spacer>

                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search Customer"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="creditCustomerLists.data"
                sort-by=""
                :items-per-page="5"
                :search="search"
                class="elevation-1"
                >
                <template v-slot:item.total_credit_money="{ item }">
                    <v-chip
                        color= orange
                        dark
                    >
                        {{ item.total_credit_money | formatNumber}}
                    </v-chip>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="editItem(item)"
                    >
                        fas fa-eye
                    </v-icon>
                </template>
            </v-data-table>
        </v-card>
    </pos-panel-layout>
</template>

<script>
    import {mapGetters, mapActions} from "vuex";
    import PosPanelLayout from "../../../../Layouts/PosPanelLayout";
    import axios from 'axios';

    export default {
        components: {
            PosPanelLayout,
        },
        props: [
            'daily_setups',
        ],
        data: () => ({
            dialog: false,
            dialogDelete: false,
            search: "",
            headers: [
                { text: 'Name', value: 'name', sortable: true},
                { text: 'Mobile', value: 'mobile' ,sortable: true},
                { text: 'Address', value: 'address', sortable: true },
                { text: 'Total Credit', value: 'total_credit_money', sortable: true },
                { text: 'Actions', value: 'actions', sortable: false },

            ],
            creditCustomerLists:[],
            customer_id:'',
            paginate:10,
        }),

        computed: {

        },
        watch: {

        },
        created () {
            this.getData();
        },
        methods: {
            ...mapActions(["changeDrawerSideBar"]),
            getData(page = 1) {
                const type = "sell";
                let getDataUrlWithoutPagination =
                    "/pos/pos-get-customers-data-who-have-credits?" +
                    "selectedContact=" +
                    this.customer_id +
                    "&type=" +
                    type;

                const getDataUrl = getDataUrlWithoutPagination.concat(
                    "&paginate=" + this.paginate + "&page=" + page
                );
                axios.get(getDataUrl).then(response => {
                    this.creditCustomerLists = response.data;
                });
            }
        },
    }
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
