<template>
    <v-sheet class="mx-auto" elevation="8" max-width="1090">
        <v-slide-group
            active-class="success"
            show-arrows
            v-model="model"
            >
            <v-slide-item
                v-for="(item,index) in items"
                :key="index"
                v-slot:default="{ active }"
            >
                <v-card
                    :color="active ? '#F6EFEF' : 'white'"
                    :class="active ? 'borderme' : 'borderout'"
                    class="d-flex align-center rounded-lg mx-2 mt-1 mb-1"
                    dark
                    height="130"
                    @click="onCardClick(index)"
                    flat
                >
                    <v-row @click="select(item)">
                        <v-col cols="12" sm="12">
                            <v-list-item
                                two-line
                                class="text-center"
                            >
                                <v-list-item-content>
                                    <div
                                        align="center"
                                        justify="center"
                                    >
                                        <v-img
                                            :src="item.image1"
                                            max-height="90"
                                            max-width="90"
                                            contain
                                        ></v-img>
                                    </div>
                                    <v-list-item-subtitle
                                        :class="
                                            active
                                                ? 'brown--text'
                                                : 'black--text'
                                        "
                                        class="caption mt-1"
                                        >{{
                                            item.name
                                        }}</v-list-item-subtitle
                                    >
                                </v-list-item-content>
                            </v-list-item>
                        </v-col>
                    </v-row>
                </v-card>
            </v-slide-item>
        </v-slide-group>
    </v-sheet>
</template>

<script>
    import {mapGetters, mapActions} from "vuex";

    export default {
        data() {
            return {
                model:null,
            };
        },
        watch: {
            searchProductSku (val) {
                val && val !== this.selectProductSku && this.querySelections(val)
            },
        },
        methods: {
            ...mapActions(["searchItem", "selectItem", "searchItemByItemSpe"]),
            onCardClick(n){
                this.model = n ;
            },
            select(item) {
                this.selectItem(item);
            },
        },
        computed: {
            ...mapGetters(['items','toast_message','toast_icon']),
        },
        created() {
            this.unwatch1 = this.$store.watch(
                (state, getters) => getters.items,
                (newValue, oldValue) => {
                    // let item = newValue.find(function(val) {
                    //     return newValue.indexOf(val) == 0;
                    // });
                    // this.select(item);
                    // this.onCardClick(0);
                    Toast.fire({
                        icon: this.toast_icon,
                        title: this.toast_message
                    })

                },
            );

        },
        beforeDestroy() {
            this.unwatch1();
        },
    };
</script>
