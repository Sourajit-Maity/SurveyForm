<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_id')->nullable();
            $table->string('employee_id')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('user_company_id')->nullable();
            $table->string('form_id')->nullable();
            $table->longText('message')->nullable(); 
            $table->boolean('assign')->default(false)->nullable();  
            $table->boolean('forward')->default(false)->nullable(); 
            $table->boolean('share')->default(false)->nullable(); 
            $table->string('assign_id')->nullable();
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
        Schema::dropIfExists('assign_companies');
    }
}
