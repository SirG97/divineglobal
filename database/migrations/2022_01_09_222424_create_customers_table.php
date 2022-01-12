<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('surname');
            $table->string('middle_name')->nullable();
            $table->string('dob')->nullable();
            $table->enum('sex', ['male', 'female']);
            $table->string('resident_state')->nullable();
            $table->string('resident_lga')->nullable();
            $table->string('resident_address')->nullable();
            $table->string('occupation')->nullable();
            $table->string('office_address')->nullable();
            $table->string('state')->nullable();
            $table->string('lga')->nullable();
            $table->string('hometown')->nullable();
            $table->string('phone')->nullable();
            $table->string('next_of_kin')->nullable();
            $table->string('relationship')->nullable();
            $table->string('nokphone')->nullable();
            $table->string('acc_no')->nullable();
            $table->string('branch')->nullable();
            $table->string('group')->nullable();
            $table->string('sb_card_no_from')->nullable();
            $table->string('sb_card_no_to')->nullable();
            $table->string('sb')->nullable();
            $table->string('initial_unit')->nullable();
            $table->integer('user_id');
            $table->integer('wallet_id')->nullable();
            $table->integer('branch_id');
            $table->string('bank_name')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('daily_amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
