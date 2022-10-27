<template>
    <v-simple-table
        fixed-header
        height="300px"
    >
        <template v-slot:default>
            <thead>
                <tr>
                    <th class="text-left">
                        #
                    </th>
                    <th class="text-left">
                        Invoice No
                    </th>
                    <th class="text-left">
                        Name
                    </th>
                    <th class="text-left">
                        Amount
                    </th>
                    <th class="text-left">
                        Product SKU
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(item, index) in value"
                    :key="index"
                >
                    <td>{{ index+1 }}</td>
                    <td>
                        <Link :href="route('admin.sells.show',item.transaction_id)" v-if="status == 'sells'">
                            {{ item.invoice_no }}
                        </Link>
                        <Link :href="route('admin.purchases.show',item.transaction_id)" v-else>
                            {{ item.invoice_no }}
                        </Link>
                    </td>
                    <td>{{ item.contact_name }}</td>
                    <td>{{ item.final_total }}</td>
                    <td>{{ item.product_sku }}</td>
                </tr>
            </tbody>
        </template>
    </v-simple-table>
</template>
<script>
    import { Link } from '@inertiajs/inertia-vue'
    export default {
        name: "ShowSellTransactionListsComponent",
        props: ["value","status"],
        components: {
            Link,
        },
    }
</script>
