<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('res_company_name')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('registration_number')->nullable();
            $table->text('detail')->nullable();
            $table->string('logo');
            $table->string('email')->unique();
            $table->string('phone')->nullable()->unique();
            $table->longtext('address')->nullable();
            $table->foreignId('company_id')->constrained('companies')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('sub_companies');
    }
}
