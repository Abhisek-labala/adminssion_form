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
       // migration file
Schema::create('admission_requests', function (Blueprint $table) {
    $table->id();
    $table->string('patient_name');
    $table->string('patient_id');
    $table->string('patient_email');
    $table->string('doctor_name');
    $table->string('department');
    $table->date('admission_date');
    $table->text('reason');
    $table->enum('status', ['Pending', 'Approved', 'Cancelled'])->default('Pending');
    $table->string('hospital_name');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_requests');
    }
};
