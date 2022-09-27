<template>
    <v-container>
        <v-form
            ref="form"
            v-model="valid"
            lazy-validation
        >
            <v-layout row wrap class="mt-1">
                <v-flex xs3 md3 sm3 class="mt-2 text-center">
                    <span class="badge badge-pill bg-primary">Daily Setup</span>
                </v-flex>
                <v-flex xs5 sm5 md5>
                        <v-text-field
                            outlined
                            dense
                            required
                            :rules="requireRule"
                        >
                        </v-text-field>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs3 md3 sm3 class="mt-2 text-center">
                    <span class="badge badge-pill bg-warning">16 ပဲရည်</span>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            label="ကျပ်"
                            placeholder="ကျပ်"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            label="ပဲ"
                            placeholder="ပဲ"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            label="ရွေး"
                            placeholder="ရွေး"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs3 md3 sm3 class="mt-2 text-center">
                    <span class="badge badge-pill bg-warning">15 ပဲရည်</span>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            label="ကျပ်"
                            placeholder="ကျပ်"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            label="ပဲ"
                            placeholder="ပဲ"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            label="ရွေး"
                            placeholder="ရွေး"
                            required
                            type="number"
                            step=".1"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs3 md3 sm3 class="mt-2 text-center">
                    <span class="badge badge-pill bg-warning">14 ပဲရည်</span>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            label="ကျပ်"
                            placeholder="ကျပ်"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            label="ပဲ"
                            placeholder="ပဲ"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            label="ရွေး"
                            placeholder="ရွေး"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs3 md3 sm3 class="mt-2 text-center">
                    <span class="badge badge-pill bg-warning">14.4 ပဲရည်</span>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            label="ကျပ်"
                            placeholder="ကျပ်"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            label="ပဲ"
                            placeholder="ပဲ"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            label="ရွေး"
                            placeholder="ရွေး"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs3 md3 sm3 class="mt-2 text-center">
                    <span class="badge badge-pill bg-warning">13 ပဲရည်</span>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            label="ကျပ်"
                            placeholder="ကျပ်"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            label="ပဲ"
                            placeholder="ပဲ"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            label="ရွေး"
                            placeholder="ရွေး"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs3 md3 sm3 class="mt-2 text-center">
                    <span class="badge badge-pill bg-warning">12 ပဲရည်</span>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            label="ကျပ်"
                            placeholder="ကျပ်"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        >
                        </v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            label="ပဲ"
                            placeholder="ပဲ"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
                <v-flex xs3 sm3 md3>
                    <v-flex xs6 sm10 md10>
                        <v-text-field
                            label="ရွေး"
                            placeholder="ရွေး"
                            required
                            type="number"
                            solo-inverted
                            dense
                            :rules="requireRule"
                        ></v-text-field>
                    </v-flex>
                </v-flex>
            </v-layout>
        </v-form>
    </v-container>
</template>
<script>
    export default {
        data: () => ({
            requireRule: [
                v => !!v || 'This field is required',
            ],
        }),
        computed: {

        },
        methods: {

        }
    }
</script>
