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
        Schema::table('trn_invoice', function (Blueprint $table) {
            //
            $table->foreign('member_id', 'FK_trn_invoice_mst_members_1')->references('id')->on('members')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('created_by', 'FK_trn_invoice_mst_staff_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by', 'FK_trn_invoice_mst_staff_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trn_invoice', function (Blueprint $table) {
            //
            $table->dropForeign('FK_trn_invoice_mst_members_1');
            $table->dropForeign('FK_trn_invoice_mst_staff_1');
            $table->dropForeign('FK_trn_invoice_mst_staff_2');
        });
    }
};
