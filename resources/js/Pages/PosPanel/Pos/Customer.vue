<template>
     <v-col cols="12" sm="3">

            <v-dialog
                transition="dialog-bottom-transition"
                max-width="600"
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-hover
                    v-slot="{ hover }"
                        close-delay="200"
                    >
                        <v-card
                            :elevation="hover ? 16 : 2"
                            :class="{ 'on-hover': hover }"
                            flat class="mx-auto rounded-lg mx-3"
                            v-bind="attrs"
                            v-on="on"

                        >
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="images/pos/customer.jpg" alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center">Daw Hla Hla</h3>

                                    <p class="text-muted text-center" style="font-size: 13px !important;">No2, Hledan, Kamaryouk, Yangon, Myanmar</p>
                                    <p class="text-muted text-center" style="font-size: 13px !important;">09784623735,0998746463</p>


                                    <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>ဝယ်ယူမှုများ</b> <a class="float-right">1,322,678,897</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>ကျန်ငွေ</b> <a class="float-right">543</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>နောက်ဆုံးပေးငွေ</b> <a class="float-right">13,287</a>
                                    </li>
                                    </ul>

                                    <a href="#" class="btn btn-primary btn-block"><b>View Detail</b></a>
                                </div>
                            <!-- /.card-body -->
                            </div>

                        </v-card>
                    </v-hover>
                </template>
                <template v-slot:default="dialog">
                    <v-card>
                        <v-toolbar
                        color="primary"
                        dark
                        >Opening from the bottom</v-toolbar>
                        <v-card-text>
                        <div class="text-h2 pa-12">Hello world!</div>
                        </v-card-text>
                        <v-card-actions class="justify-end">
                        <v-btn
                            text
                            @click="dialog.value = false"
                        >Close</v-btn>
                        </v-card-actions>
                    </v-card>
                </template>
            </v-dialog>
    </v-col>


</template>

<script>

    export default {
        name: 'ItemList',


        data: () => ({
            isLoading: false,
            items: [],
            model: null,
            search: null,
            tab: null,
            select_item: ['1', '2', '3', '4','5', '6', '7', '8'],
            messages: [
                {
                from: 'လက်ကျန်',
                message: `50,000`,
                time: '10:42am',
                color: 'deep-purple lighten-1',
                },
                {
                from: 'ဆပ်ငွေ',
                message: '30,000',
                time: '10:37am',
                color: 'green',
                },
            ],
        }),

        watch: {
            model (val) {
                if (val != null) this.tab = 0
                else this.tab = null
            },
        },
        methods: {
            viewProfileDetail() {
                alert("sssadfasdf");
            }
        }
    }
</script>
<style>
