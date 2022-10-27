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
                        Expense For
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
                        <Link :href="route('admin.expenses.show', item.transaction_id)">
                            {{ item.expense_category_name }}
                        </Link>
                    </td>
                    <td>{{ item.amount }}</td>
                </tr>
            </tbody>
        </template>
    </v-simple-table>
</template>
<script>
    import { Link } from '@inertiajs/inertia-vue'
    export default {
        name: "ShowExpenseListsComponent",
        props: ["value"],
        components: {
            Link,
        },
    }
</script>
