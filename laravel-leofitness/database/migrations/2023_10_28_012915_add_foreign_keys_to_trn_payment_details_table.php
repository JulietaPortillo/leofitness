<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('trn_payment_details', function (Blueprint $table) {
            //
            $table->foreign('invoice_id', 'FK_trn_payment_details_1')->references('id')->on('trn_invoice')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('created_by', 'FK_trn_payment_details_mst_staff_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by', 'FK_trn_payment_details_mst_staff_3')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trn_payment_details', function (Blueprint $table) {
            //
            $table->dropForeign('FK_trn_payment_details_1');
            $table->dropForeign('FK_trn_payment_details_mst_staff_2');
            $table->dropForeign('FK_trn_payment_details_mst_staff_3');
        });
    }
};
