<template>
    <admin-layout>
        <div class="col-12 col-sm-4">

            <div class="info-box bg-light">
                <div class="info-box-content">
                    <a  href="javascript: history.go(-1)">
                        <button class="btn btn-primary float-left mr-3" style="h">
                            <i class="fas fa-long-arrow-alt-left" aria-hidden="true" ></i>
                        </button>
                    </a>
                    <span class="info-box-text text-center text-muted">
                        Expense Detail
                    </span><br>
                    <span class="info-box-number text-center text-muted mb-0">
                        Total Amount : {{ expense.amount }}
                    </span><br>
                    <span class="info-box-number text-center text-muted mb-0">
                        Expense Category : {{ expense.expense_category.name }}
                    </span><br>
                    <span class="info-box-number text-center text-muted mb-0">
                        Expense For : {{ expense.expense_for.name }}
                    </span><br>
                    <span class="info-box-number text-center text-muted mb-0">
                        Date :{{ date }}
                    </span>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '../../../../Layouts/AdminPanelLayout';
    import moment from 'moment';

    export default {
        props: [
            'expense',
        ],
        components: {
            AdminLayout,
        },
        computed: {
            date() {
                return moment(String(this.expense.created_at)).format('YYYY-MM-DD hh:mm')
            }
        }
    }
</script>
