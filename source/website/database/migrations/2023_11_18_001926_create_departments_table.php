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
        Schema::create('departments', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('entity_id')->nullable();
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('set null');

            $table->string('name')->unique();
            $table->string('friendly_name')->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('locality')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->integer('sort_order');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
