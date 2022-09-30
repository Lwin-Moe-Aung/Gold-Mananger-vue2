<template>
    <div class="congratulations ">
        <img src="/images/stepperImages/congrat.svg" alt="success" id="congrat">
        <div class="text">
            <h1>Congratulation!</h1>
            <p>You have successfully open a day</p>
            <p class="muted">- Have a good day!</p>
        </div>
        <div class="space"></div>
        <v-card-actions class="card-actions">
            <Link :href="route('admin.dashboard.index')">
                <v-btn
                    color="#ECBD00"
                    outlined
                    rounded
                    text
                >
                    Go to Dashboard
                </v-btn>
            </Link>
        </v-card-actions>
    </div>
</template>
<script>
    import { Link } from '@inertiajs/inertia-vue';
    export default {
        components: {
            Link,
        },
        data: () => ({

        }),
        created() {

        },
        methods: {

        }
    }
    </script>
