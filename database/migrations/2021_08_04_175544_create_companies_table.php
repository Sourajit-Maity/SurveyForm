<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('res_company_name')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('website_name')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->longtext('address')->nullable();
            $table->longtext('company_details')->nullable();
            $table->string('logo')->nullable();
            $table->foreignId('manager_id')->nullable()->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('companies');
    }
}
