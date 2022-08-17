<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashOutView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement($this->dropView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    private function createView(): string
    {
        return <<<SQL
            CREATE VIEW view_cashout_data AS
                SELECT t.id as transaction_id,
                    c.id as contact_id,
                    c.name, c.mobile1 ,
                    c.mobile2,c.address,
                    t.invoice_no,t.additional_notes ,
                    t.type,t.created_at,
                    exp.name as expense_category_name,
                    CASE
                            WHEN t.type = 'purchase' THEN t.final_total
                            WHEN t.type = 'debt_payment_to_supplier' THEN t.debt_paid_money
                            WHEN t.type = 'sell' THEN t.credit_money
                            WHEN t.type = 'expense' THEN exp.amount
                            ELSE 0
                    END as amount

                    FROM transactions as t
                    LEFT JOIN (
                            SELECT ee.transaction_id ,ee.amount,ec.name FROM expenses as ee
                            INNER JOIN expense_categories as ec
                            ON ee.expense_category_id = ec.id
                        ) AS exp ON exp.transaction_id = t.id
                    LEFT JOIN contacts as c ON t.contact_id = c.id

                    WHERE t.type = 'purchase'
                    OR t.type = 'expense'
                    OR t.type = 'debt_payment_to_supplier'
                    OR t.type = 'sell'
                    AND
                        CASE t.type
                            WHEN 'sell' THEN t.credit_money != 0
                        END
            SQL;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    private function dropView(): string
    {
        return <<<SQL

            DROP VIEW IF EXISTS `view_cashout_data`;
            SQL;
    }
}
