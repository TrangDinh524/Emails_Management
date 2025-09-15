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
        Schema::create('email_statistics', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('total_emails_sent')->default(0);
            $table->integer('successful_emails')->default(0);
            $table->integer('failed_emails')->default(0);
            $table->timestamps();
            
            $table->unique('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_statistics');
    }
};