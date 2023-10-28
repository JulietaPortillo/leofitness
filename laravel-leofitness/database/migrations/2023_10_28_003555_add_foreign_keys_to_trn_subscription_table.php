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
        Schema::table('trn_subscriptions', function (Blueprint $table) {
            //
            $table->foreign('member_id', 'FK_trn_subscriptions_members_1')->references('id')->on('members')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('plan_id', 'FK_trn_subscriptions_mst_plans_2')->references('id')->on('plans')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('created_by', 'FK_trn_subscriptions_mst_staff_3')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by', 'FK_trn_subscriptions_mst_staff_4')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('invoice_id', 'FK_trn_subscriptions_trn_invoice')->references('id')->on('trn_invoice')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trn_subscriptions', function (Blueprint $table) {
            //
            $table->dropForeign('FK_trn_subscriptions_mst_members_1');
            $table->dropForeign('FK_trn_subscriptions_mst_plans_2');
            $table->dropForeign('FK_trn_subscriptions_mst_staff_3');
            $table->dropForeign('FK_trn_subscriptions_mst_staff_4');
            $table->dropForeign('FK_trn_subscriptions_trn_invoice');
        });
    }
};
