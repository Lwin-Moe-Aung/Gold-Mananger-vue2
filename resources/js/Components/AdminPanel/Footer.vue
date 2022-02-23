<template>
    <footer class="main-footer">
        <strong>Copyright &copy; 2022-{{ currentDate.getFullYear() }} <Link href="#">Gold-Manager</Link>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0
        </div>
    </footer>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue'

    export default {
        components: {
            Link,
        },
        data() {
            return {
                currentDate: new Date,
            }
        }
    }
</script>