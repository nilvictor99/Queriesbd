<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->string('document_number', 8)->unique();
            $table->string('cod_verificacion')->nullable();
            $table->string('paternal_last_name')->nullable();
            $table->string('maternal_last_name')->nullable();
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_death')->nullable();
            $table->string('department')->nullable();
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('education_level')->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->date('registration_date')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->string('father')->nullable();
            $table->string('mother')->nullable();
            $table->text('restrictions')->nullable();
            $table->string('address')->nullable();
            $table->string('ubigeo_reniec')->nullable();
            $table->string('ubigeo_inei', 6)->nullable();
            $table->string('ubigeo_sunat', 6)->nullable();
            $table->string('postal_code', 5)->nullable();
            $table->text('photo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};
