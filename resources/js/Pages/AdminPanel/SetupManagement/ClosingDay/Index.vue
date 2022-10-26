<template>
    <admin-layout>
        <CashInAndStockInHandComponent status="2"/>
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

