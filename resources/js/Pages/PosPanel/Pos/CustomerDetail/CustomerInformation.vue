<template>
    <v-row>
        <v-list
            three-line
            subheader
            v-if="value != null"
        >
            <v-subheader>Customer Information</v-subheader>
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title>Customer Name</v-list-item-title>
                    <v-list-item-subtitle>{{value.name}}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title>Email</v-list-item-title>
                    <v-list-item-subtitle>{{ value.email }}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title>Phone</v-list-item-title>
                    <v-list-item-subtitle>{{ value.mobile1 }} , {{ value.mobile2 }}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title>Address</v-list-item-title>
                    <v-list-item-subtitle>{{ value.address }}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title>Date</v-list-item-title>
                    <v-list-item-subtitle>{{ formatDateTime(value.created_at) }}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
        </v-list>
        <v-divider></v-divider>
    </v-row>

</template>
<script>
    import moment from 'moment';
    export default {
        name: "CustomerInformation",
        props: ["value"],
        components: {

        },
        created() {

        },
        data() {
            return {
            }
        },
        watch: {

        },
        methods: {
            formatDateTime(value) {
                return moment(String(value)).format('YYYY-MM-DD hh:mm')
            }
        }
    }
  </script>
