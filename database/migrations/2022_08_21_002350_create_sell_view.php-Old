<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellView extends Migration
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
            CREATE VIEW view_sell_data AS
                SELECT
                    c.id as contact_id,
                    c.email,
                    c.name as contact_name, c.mobile1 ,
                    c.mobile2,c.address,
                    t.invoice_no,t.additional_notes ,
                    t.created_at,
                    seitpro.*
                FROM transactions as t
                INNER JOIN contacts as c ON t.contact_id = c.id
                INNER JOIN view_tsip_data as seitpro ON t.id = seitpro.transaction_id
                WHERE t.type = 'sell';
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

            DROP VIEW IF EXISTS `view_sell_data`;
            SQL;
    }
}
