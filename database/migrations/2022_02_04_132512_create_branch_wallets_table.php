<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('branch_wallets', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->unsignedFloat('balance', 20, 2)->default(0);
            $table->unsignedFloat('bank', 20, 2)->default(0);
            $table->unsignedFloat('cash', 20, 2)->default(0);
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
        Schema::dropIfExists('branch_wallets');
    }
}
