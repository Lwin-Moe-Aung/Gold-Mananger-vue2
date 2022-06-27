<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4 fix">
        <!-- Brand Logo -->
        <Link :href="route('admin.dashboard.index')" class="brand-link">
            <img :src="'/images/users/default_profile.png'" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{ $page.props.user.name }}</span>
        </Link>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img :src="'/images/users/default_profile.png'" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ $page.props.user.name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                    <li class="nav-item menu-open">
                        <Link :href="route('admin.dashboard.index')" class="nav-link" :class="route().current('admin.dashboard.*') ? 'active' : ' '">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <!-- <i class="nav-icon fas fa-table"></i> -->
                            <p>
                                User Management
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin || $page.props.auth.hasRole.cashier">
                                <Link :href="route('admin.admins.index')" class="nav-link" :class="route().current('admin.admins.*') ? 'active' : ' '">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Admins
                                    </p>
                                </Link>
                            </li>
                            <li class="nav-item" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin || $page.props.auth.hasRole.cashier">
                                <Link :href="route('admin.users.index')" class="nav-link" :class="route().current('admin.users.*') ? 'active' : ' '">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Users
                                    </p>
                                </Link>
                            </li>
                            <li class="nav-item" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin || $page.props.auth.hasRole.cashier">
                                <Link :href="route('admin.roles.index')" class="nav-link" :class="route().current('admin.roles.*') ? 'active' : ' '">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Roles
                                    </p>
                                </Link>
                            </li>
                            <li class="nav-item" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">
                                <Link :href="route('admin.permissions.index')" class="nav-link" :class="route().current('admin.permissions.*') ? 'active' : ' '">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Permissions
                                    </p>
                                </Link>
                            </li>
                        </ul>
                    </li>
                     <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-address-book"></i>
                            <!-- <i class="nav-icon fas fa-table"></i> -->
                            <p>
                                Contact Management
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin || $page.props.auth.hasRole.cashier">
                                <Link :href="route('admin.customers.index')" class="nav-link" :class="route().current('admin.customers.*') ? 'active' : ' '">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Customer
                                    </p>
                                </Link>
                            </li>
                            <li class="nav-item" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin || $page.props.auth.hasRole.cashier">
                                <Link :href="route('admin.suppliers.index')" class="nav-link" :class="route().current('admin.suppliers.*') ? 'active' : ' '">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Supplier
                                    </p>
                                </Link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fab fa-product-hunt"></i>
                            <p>
                                Product Management
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin || $page.props.auth.hasRole.cashier">
                                <Link :href="route('admin.products.index')" class="nav-link" :class="route().current('admin.products.*') ? 'active' : ' '">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Products
                                    </p>
                                </Link>
                            </li>
                            <li class="nav-item" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin || $page.props.auth.hasRole.cashier">
                                <Link :href="route('admin.product_types.index')" class="nav-link" :class="route().current('admin.product_types.*') ? 'active' : ' '">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Product Type
                                    </p>
                                </Link>
                            </li>
                            <li class="nav-item" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin || $page.props.auth.hasRole.cashier">
                                <Link :href="route('admin.item_names.index')" class="nav-link" :class="route().current('admin.item_names.*') ? 'active' : ' '">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Item Name
                                    </p>
                                </Link>
                            </li>
                            <li class="nav-item" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin || $page.props.auth.hasRole.cashier">
                                <Link :href="route('admin.daily_setups.index')" class="nav-link" :class="route().current('admin.daily_setups.*') ? 'active' : ' '">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Daily Setup
                                    </p>
                                </Link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fab fa-product-hunt"></i>
                            <p>
                                Orders Management
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin || $page.props.auth.hasRole.cashier">
                                <Link :href="route('admin.sells.index')" class="nav-link" :class="route().current('admin.sells.*') ? 'active' : ' '">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Order Lists
                                    </p>
                                </Link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fab fa-product-hunt"></i>
                            <p>
                                Purchase Management
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin || $page.props.auth.hasRole.cashier">
                                <Link :href="route('admin.purchases.index')" class="nav-link" :class="route().current('admin.purchases.*') ? 'active' : ' '">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Purchase Lists
                                    </p>
                                </Link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-header">MISCELLANEOUS</li>
                    <li class="nav-item">
                        <Link :href="route('dashboard')" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Site
                            </p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <form @submit.prevent="logout">
                            <button type="submit" class="nav-button">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>
<script>
    import { Link } from '@inertiajs/inertia-vue'
    export default {
        components: {
            Link,
        },
        methods: {
            logout() {
                this.$inertia.post(route('post.logout'));
            },
        }
    }
</script>
