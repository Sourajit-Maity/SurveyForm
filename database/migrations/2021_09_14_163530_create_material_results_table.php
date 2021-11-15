<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_results', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->string('user_name');
            $table->string('user_email');
            $table->string('company_name');
            $table->string('material_code');
            $table->string('product_name');
            $table->string('package');
            $table->string('market');
            $table->string('location');
            $table->decimal('percentage');
            $table->string('result_id');
            $table->string('company_logo')->nullable();
            $table->foreignId('form_id')->nullable();
            $table->foreignId('user_id')->nullable();
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
        Schema::dropIfExists('material_results');
    }
}
