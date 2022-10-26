<template>
    <v-simple-table
        fixed-header
        height="300px"
    >
        <template v-slot:default>
            <thead>
                <tr>
                    <th class="text-left">
                        Invoice No
                    </th>
                    <th class="text-left">
                        Customer
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
                    v-for="item in value"
                    :key="item.transaction_id"
                >
                    <td>{{ item.invoice_no }}</td>
                    <td>{{ item.contact_name }}</td>
                    <td>{{ item.final_total }}</td>
                    <td>{{ item.product_sku }}</td>
                </tr>
            </tbody>
        </template>
    </v-simple-table>
</template>
<script>
    export default {
        name: "ShowSellTransactionListsComponent",
        props: ["value"],
        data: () => ({

        }),


    }
</script>
