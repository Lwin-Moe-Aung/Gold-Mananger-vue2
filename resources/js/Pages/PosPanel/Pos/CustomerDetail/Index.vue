<template>
    <pos-panel-layout>
        <v-card
            color="grey lighten-4"
            flat
            height="200px"
            tile
        >
            <v-toolbar dense >
                <v-app-bar-nav-icon
                    class="d-lg-none d-sm-flex black--text"
                    @click="changeDrawerSideBar()"
                    >
                </v-app-bar-nav-icon>
                <v-toolbar-title>Table</v-toolbar-title>
                <v-spacer></v-spacer>
            </v-toolbar>
            <v-data-table
                :headers="headers"
                :items="daily_Setup.data"
                sort-by=""
                class="elevation-1"
                >
                <template v-slot:top>
                    <v-toolbar
                        flat
                    >
                        <v-toolbar-title>Customer Detail</v-toolbar-title>
                        <v-divider
                            class="mx-4"
                            inset
                            vertical
                            ></v-divider>
                        <v-spacer></v-spacer>

                        <v-dialog
                            v-model="dialog"
                            max-width="500px"
                            >
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                color="primary"
                                dark
                                class="mb-2"
                                v-bind="attrs"
                                v-on="on"
                                >
                                New Daily Setup
                                </v-btn>
                            </template>
                            <!-- edit form -->
                            <v-card>
                                <v-card-title>
                                    <span class="text-h5">{{ formTitle }}</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col
                                                cols="12"
                                                sm="10"
                                                md="10"
                                                v-if="editedIndex > -1"
                                            >

                                                <v-text-field
                                                    :value="dateTime(editedItem.created_at)"
                                                    label="Date Time"
                                                    disabled
                                                ></v-text-field>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="10"
                                                md="10"
                                            >

                                                <v-text-field
                                                    v-model="editedItem.daily_price"
                                                    label="Daily Price"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-card-text>

                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="close"
                                    >
                                        Cancel
                                    </v-btn>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="save"
                                    >
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-dialog v-model="dialogDelete" max-width="500px">
                            <v-card>
                                <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                    <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                                    <v-spacer></v-spacer>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-toolbar>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="editItem(item)"
                    >
                        fas fa-edit
                    </v-icon>
                    <v-icon
                        small
                        @click="deleteItem(item)"
                    >
                        delete
                    </v-icon>
                </template>
                <template v-slot:no-data>
                    <v-btn
                        color="primary"
                        @click="initialize"
                    >
                        Reset
                    </v-btn>
                </template>
            </v-data-table>
        </v-card>
    </pos-panel-layout>
</template>

<script>
    import {mapGetters, mapActions} from "vuex";
    import PosPanelLayout from "../../../../Layouts/PosPanelLayout";
    import moment from 'moment';
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
            headers: [
                { text: 'Daily Pirice', align: 'start', value: 'daily_price'},
                { text: 'Date', value: 'created_at' },
                { text: 'Actions', value: 'actions', sortable: false },
            ],
            daily_Setup:[],
            editedIndex: -1,
            editedItem: {
                daily_price: '',
                created_at: '',
            },
            defaultItem: {
                daily_price: '',
                created_at: '',
            },
        }),

        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Daily Setup' : 'Edit Daily Setup'
            },
        },

        watch: {
            dialog (val) {
                val || this.close()
            },
            dialogDelete (val) {
                val || this.closeDelete()
            },
        },
        created () {
            this.daily_Setup = this.daily_setups;
        },
        methods: {
            ...mapActions(["changeDrawerSideBar"]),
            dateTime(value) {
                return moment(value).format('DD/MM/YYYY hh:mm:s A');
            },
            editItem (item) {
                this.editedIndex = this.daily_Setup.data.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },
            deleteItem (item) {
                this.editedIndex = this.daily_Setup.data.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialogDelete = true
            },
            deleteItemConfirm () {
                let data = new FormData();
                data.append('id',this.editedItem.id);

                axios.post('/pos/daily_setups/delete',data)
                    .then(res => {
                        this.daily_Setup.data.splice(this.editedIndex, 1)
                        this.closeDelete()
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            close () {
                this.dialog = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
            },
            closeDelete () {
                this.dialogDelete = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
            },
            async save () {
                if (this.editedIndex > -1) {
                    await this.update()
                } else {
                    await this.saveNew()
                }
                this.close()
            },
            async saveNew () {
                let data = new FormData();
                data.append('daily_price',this.editedItem.daily_price);
                await axios.post('/pos/daily_setups/store',data)
                    .then(res => {
                        console.log(res.data.data);
                        this.daily_Setup.data.push(res.data.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            async update() {
                let data = new FormData();
                data.append('id',this.editedItem.id);
                data.append('daily_price',this.editedItem.daily_price);
                await axios.post('/pos/daily_setups/update',data)
                    .then(res => {
                        console.log("update");
                        console.log(this.daily_Setup.data[this.editedIndex]);
                        console.log(this.editedItem);
                        Object.assign(this.daily_Setup.data[this.editedIndex], this.editedItem)
                    })
                    .catch(function (error) {
                        console.log(error);
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
