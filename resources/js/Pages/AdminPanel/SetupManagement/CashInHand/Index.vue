<template>
    <admin-layout>
        <CashInAndStockInHandComponent title="View Cash In Hand!"/>
    </admin-layout>
</template>

<script>
    import AdminLayout from '../../../../Layouts/AdminPanelLayout';
    import CashInAndStockInHandComponent from '../../../../Components/AdminPanel/CashInAndStockInHandComponent';


    export default {
        components: {
            AdminLayout,
            CashInAndStockInHandComponent
        },

    }
</script>

