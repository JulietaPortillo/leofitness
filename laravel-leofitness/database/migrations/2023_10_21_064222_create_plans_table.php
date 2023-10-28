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
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plan_code', 50)->unique()->comment('Unique plan id for reference');
            $table->integer('service_id')->index();
            $table->string('plan_name', 50)->comment('Name of the plan');
            $table->text('plan_details')->comment('Plan details');
            $table->integer('days')->comment('Duration of the plan in days');
            $table->integer('amount')->comment('Amount to charge for the plan');
            $table->boolean('status')->default(true)->comment('0 for inactive, 1 for active');
            $table->unsignedBigInteger('created_by')->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
