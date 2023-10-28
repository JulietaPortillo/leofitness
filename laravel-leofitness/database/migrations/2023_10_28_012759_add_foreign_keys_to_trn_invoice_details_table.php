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
        Schema::table('trn_invoice_details', function (Blueprint $table) {
            //
            $table->foreign('created_by', 'FK_trn_invoice_details_mst_staff_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by', 'FK_trn_invoice_details_mst_staff_3')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('invoice_id', 'FK_trn_invoice_details_trn_invoice_1')->references('id')->on('trn_invoice')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('plan_id')->references('id')->on('plans')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trn_invoice_details', function (Blueprint $table) {
            //
        });
    }
};
