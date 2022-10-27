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
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(item, index) in value"
                    :key="index"
                >
                    <td>{{ index+1 }}</td>
                    <td>
                        <Link :href="route('admin.debt-payment-from-customers.show', item.transaction_id)" v-if="status == 'debt_from_customer'">
                            {{ item.invoice_no }}
                        </Link>
                        <Link :href="route('admin.debt-payment-to-suppliers.show', item.transaction_id)" v-else>
                            {{ item.invoice_no }}
                        </Link>
                    </td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.amount }}</td>
                </tr>
            </tbody>
        </template>
    </v-simple-table>
</template>
<script>
    import { Link } from '@inertiajs/inertia-vue'

    export default {
        name: "ShowDebtTransactionListsComponent",
        props: ["value","status"],
        components: {
            Link,
        },
    }
</script>
