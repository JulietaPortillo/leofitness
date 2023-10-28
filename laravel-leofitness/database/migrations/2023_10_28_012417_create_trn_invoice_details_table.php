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
        Schema::create('trn_invoice_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('invoice_id')->index('FK_trn_invoice_details_trn_invoice_1')->comment('links to unique record id of trn_invoice');
            $table->integer('item_amount')->comment('amount of the items');
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned()->index('FK_trn_invoice_details_mst_staff_2');
            $table->bigInteger('updated_by')->unsigned()->index('FK_trn_invoice_details_mst_staff_3');
            $table->unsignedBigInteger('plan_id')->default(1)->index('trn_invoice_details_plan_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trn_invoice_details');
    }
};
