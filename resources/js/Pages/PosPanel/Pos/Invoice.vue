<template>
    <v-app>
        <v-main>
            Hello World
        </v-main>
    </v-app>
</template>
<script>
    export default {
        name: 'Search',
        created() {
            // console.log("hello invoice page");
            window.addEventListener("load", window.print());
        },

    }
</script>
