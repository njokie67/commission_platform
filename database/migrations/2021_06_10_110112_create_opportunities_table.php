<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('system_id')->nullable();
            $table->string('organization_system_id')->nullable();
            $table->string('lead_system_id')->nullable();
            $table->string('status_system_id')->nullable();
            $table->string('user_system_id')->nullable();
            $table->string('value')->nullable();
            $table->string('period')->nullable();
            $table->string('value_formatted')->nullable();
            $table->string('currency')->nullable();
            $table->string('expected_value')->nullable();
            $table->string('annualized_value')->nullable();
            $table->string('annualized_expected_value')->nullable();
            $table->string('date_won')->nullable();
            $table->string('date_lost')->nullable();
            $table->string('confidence')->nullable();
            $table->string('note')->nullable();
            $table->string('sale_rep_id')->nullable();
            $table->string('date_created')->nullable();
            $table->string('date_updated')->nullable();
            $table->string('updated_by_name')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('status_label')->nullable();
            $table->string('status_type')->nullable();
            $table->string('status_display_name')->nullable();
            $table->string('lead_name')->nullable();
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
        Schema::dropIfExists('opportunities');
    }
}
