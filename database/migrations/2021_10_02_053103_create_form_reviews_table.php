<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('forms')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('from_company_id')->constrained('companies')->onUpdate('cascade')->onDelete('cascade'); 
            $table->foreignId('from_employee_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade'); 
            $table->foreignId('to_company_id')->constrained('companies')->onUpdate('cascade')->onDelete('cascade'); 
            $table->foreignId('to_employee_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade'); 
            $table->tinyInteger('status')->default(1)->comment('1:reviewed, 2:edited, 3:created');
            $table->longText('message')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_reviews');
    }
}
