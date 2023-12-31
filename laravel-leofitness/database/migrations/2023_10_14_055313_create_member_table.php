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
        Schema::create('members', function (Blueprint $table) {
            $table->bigInteger('id', true)->comment('Unique Record Id for system');
            $table->string('member_code', 50)->unique('member_id')->comment('Unique member id for reference');
            $table->string('name', 50)->comment('member\'s name');
            $table->date('DOB')->comment('member\'s date of birth');
            $table->string('email', 50)->unique('email')->comment('member\'s email id');
            $table->string('address', 200)->comment('member\'s address');
            $table->boolean('status')->comment('0 for inactive , 1 for active');
            $table->string('proof_name', 50)->comment('name of the proof provided by member');
            $table->char('gender', 50)->comment('member\'s gender');
            $table->string('contact', 11)->unique('contact')->comment('member\'s contact number');
            $table->string('emergency_contact', 11);
            $table->string('health_issues', 50);
            $table->integer('pin_code');
            $table->string('occupation', 50);
            $table->string('aim', 50);
            $table->string('source', 50);
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned()->index('FK_members_users_1');
            $table->bigInteger('updated_by')->unsigned()->index('FK_members_users_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
