<template>
    <div>
        <admin-layout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Purchase
                </h2>
            </template>
            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-tools" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">
                                        <Link :href="route('admin.purchases.create')">
                                            <button type="button" class="btn btn-info text-white text-uppercase" style="letter-spacing: 0.1em;">
                                                Create
                                            </button>
                                        </Link>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </admin-layout>
    </div>
</template>


<script>
    import AdminLayout from '../../../../Layouts/AdminPanelLayout';
    import moment from 'moment';
    import Pagination from '../../../../Components/AdminPanel/Pagination';
    import { pickBy, throttle } from 'lodash';
    import { Link } from '@inertiajs/inertia-vue';

    export default {
        props: [

            ],
        components: {
            AdminLayout,
            Pagination,
            Link
        },
        data() {
            return {
            }
        },
        computed: {

        },
        watch: {
        },

        methods: {
        }
    }
</script>
