<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashInView extends Migration
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
                CREATE VIEW view_cashin_data AS
                    SELECT t.id as transaction_id,
                                c.id as contact_id,
                                c.name, c.mobile1 ,
                                c.mobile2,c.address,
                                t.invoice_no,t.additional_notes ,
                                t.type,t.transaction_date,
                                CASE
                                        WHEN t.type = 'sell' THEN t.final_total
                                        WHEN t.type = 'debt_payment_from_customer' THEN t.debt_paid_money
                                        WHEN t.type = 'purchase' THEN t.credit_money
                                        ELSE 0
                                END as amount
                    FROM transactions as t
                    INNER JOIN contacts as c ON t.contact_id = c.id
                    WHERE t.type = 'sell'
                    OR t.type = 'debt_payment_from_customer'
                    OR t.type = 'purchase'
                    AND
                        CASE t.type
                            WHEN 'purchase' THEN t.credit_money != 0
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

            DROP VIEW IF EXISTS `view_cashin_data`;
            SQL;
    }
}
