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
        Schema::create('trn_cheque_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('payment_id')->index('FK_trn_cheque_details_trn_payment_details');
            $table->string('number', 50);
            $table->date('date');
            $table->boolean('status')->comment('0 = recieved , 1 = deposited , 2 = cleared , 3 = bounced');
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned()->index('FK_trn_cheque_details_mst_users');
            $table->bigInteger('updated_by')->unsigned()->index('FK_trn_cheque_details_mst_users_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trn_cheque_details');
    }
};
