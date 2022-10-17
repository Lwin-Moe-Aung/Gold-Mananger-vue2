<template>
    <admin-layout>
        <CashInAndStockInHandComponent title="Let Close A Day!"/>
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

