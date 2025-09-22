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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->morphs('profileable');
            $table->foreignId('identification_type_id')->nullable()->constrained()->onDelete('set null');
            $table->string('document_number', 11)->nullable();
            $table->string('full_name')->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('education_level')->nullable();
            $table->string('blood_type')->nullable();
            $table->text('description')->nullable();
            $table->json('adicional_data')->nullable();
            $table->json('characteristics')->nullable();
            $table->text('photo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
