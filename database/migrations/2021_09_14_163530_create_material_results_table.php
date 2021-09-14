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
            $table->integer('company_id')->nullable();
            $table->string('product_name');
            $table->string('package');
            $table->string('market');
            $table->string('location');
            $table->decimal('percentage');
            $table->string('result_id');
            $table->foreignId('form_id')->nullable()->references('id')->on('forms')->onDelete('cascade');
            $table->integer('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
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