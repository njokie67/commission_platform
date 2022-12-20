<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('currency')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->string('name')->nullable();
            $table->string('system_id')->nullable();
            $table->string('leads_email')->nullable();
            $table->string('date_created')->nullable();
            $table->string('created_by')->nullable();
            $table->string('refresh')->default(0);
            $table->integer('commission')->default(5);
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
        Schema::dropIfExists('organizations');
    }
}
