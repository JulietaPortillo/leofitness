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
        Schema::create('trn_payment_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('invoice_id')->index('FK_trn_payment_details_1')->comment('links to unique record id of trn_invoice');
            $table->integer('payment_amount')->comment('amount of transaction being done');
            $table->string('mode', 50)->comment('1 = Cash , 0 = Cheque');
            $table->string('note', 50)->comment('misc. note');
            $table->timestamps();
            $table->integer('created_by')->unsigned()->index('FK_trn_payment_details_mst_staff_2');
            $table->integer('updated_by')->unsigned()->index('FK_trn_payment_details_mst_staff_3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trn_payment_details');
    }
};
