<template>
    <v-layout v-if="items.length > 0" class="mb-n6 mt-n4">
        <carousel-3d
            :controls-visible="true"
            :clickable="true"
            :key="items.length"
            :listData="items"
            :height="200"
            >
            <slide :index="i" :key="i" v-for="(item, i) in items">
                <figure>
                    <v-img
                        max-height="166"
                        :src="item.image"
                        ></v-img>
                    <figcaption>
                        <v-btn
                            @click="select(item)"
                            text color="white">
                            {{ item.name }}
                        </v-btn>
                    </figcaption>
                </figure>
            </slide>
        </carousel-3d>

    </v-layout>
</template>

<script>
    import {mapGetters, mapActions} from "vuex";
    import { Carousel3d, Slide } from "vue-carousel-3d";

    export default {
        components: {
            Carousel3d,
            Slide,
        },
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
            ...mapGetters(['items','toast_message','toast_icon','reset_voucher_form']),
        },
        created() {
            this.unwatch1 = this.$store.watch(
                (state, getters) => getters.items,
                (newValue, oldValue) => {
                    this.onCardClick(-3);
                    Toast.fire({
                        icon: this.toast_icon,
                        title: this.toast_message
                    })

                },
            );
            this.unwatch2 = this.$store.watch(
                (state, getters) => getters.reset_voucher_form,
                (newValue, oldValue) => {
                    if(newValue)this.onCardClick(-3);
                },
            );

        },
        beforeDestroy() {
            this.unwatch1();
            this.unwatch2();

        },
    };
</script>
