<template>
    <admin-layout>
        <v-app>
            <v-container>
                <v-alert
                    prominent
                    type="error"
                    >
                    <v-row align="center">
                        <v-col class="grow">
                            You need to verify and close day first!
                        </v-col>
                        <v-col class="shrink">
                            <Link :href="route('admin.closing-days.index')">
                                <v-btn>
                                    Go To Close a Day
                                </v-btn>
                            </Link>
                        </v-col>
                    </v-row>
                </v-alert>
            </v-container>
        </v-app>
    </admin-layout>
</template>
<script>
    import AdminLayout from '../../../Layouts/AdminPanelLayout';
    import { Link } from '@inertiajs/inertia-vue'
    export default {
        components: {
            AdminLayout,
            Link
        },
    }
</script>
