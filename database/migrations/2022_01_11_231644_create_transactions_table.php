<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('user_type');
            $table->integer('branch_id');
            $table->integer('customer_id')->nullable();
            $table->string('txn_ref');
            $table->enum('txn_type', ['credit','debit']);
            $table->enum('option', ['cash','bank']);
            $table->enum('purpose', ['deposit', 'transfer', 'withdrawal', 'reversal', 'commission', 'logistics', 'loan']);
            $table->unsignedFloat('amount', 20, 2);
            $table->unsignedFloat('balance_before', 20, 2);
            $table->unsignedFloat('balance_after', 20, 2);
            $table->string('description');
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
