<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleRepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_reps', function (Blueprint $table) {
            $table->id();
            $table->string('date_created')->nullable();
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('system_id')->nullable();
            $table->string('email')->nullable();
            $table->string('image')->nullable();
            $table->string('phone')->nullable();
            $table->string('date_updated')->nullable();
            $table->integer('commissionpaid')->default(0);
            $table->string('organization_system_id')->nullable();
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
        Schema::dropIfExists('sale_reps');
    }
}
