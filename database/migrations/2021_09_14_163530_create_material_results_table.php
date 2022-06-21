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
            $table->integer('assign_company_id');
            $table->string('user_name');
            $table->string('user_email');
            $table->string('company_name');
            $table->string('material_code')->nullable();
            $table->string('product_name')->nullable();
            $table->string('package')->nullable();
            $table->string('market')->nullable();
            $table->string('location')->nullable();
            $table->decimal('percentage')->nullable();
            $table->string('project_name')->nullable();
            $table->string('project_date')->nullable();
            $table->string('attachment')->nullable();
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
