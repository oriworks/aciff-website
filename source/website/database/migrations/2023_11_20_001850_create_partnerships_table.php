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
        Schema::create('partnership_areas', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name')->unique();

            $table->timestamps();
        });
        Schema::create('partnerships', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->enum('type', [
                'protocol',
                'partnership'
            ])->default('protocol');

            $table->uuid('area_id')->nullable();
            $table->foreign('area_id')->references('id')->on('partnership_areas')->onDelete('set null');

            $table->string('name')->unique();
            $table->string('site')->nullable();
            $table->string('email')->nullable();

            $table->longText('benefits')->nullable();
            $table->longText('comments')->nullable();

            $table->timestamps();
        });
        Schema::create('partnership_contacts', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('partnership_id');
            $table->foreign('partnership_id')->references('id')->on('partnerships')->onDelete('cascade');

            $table->string('name');
            $table->string('value');

            $table->timestamps();
        });
        Schema::create('partnership_addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('partnership_id');
            $table->foreign('partnership_id')->references('id')->on('partnerships')->onDelete('cascade');

            $table->string('name');
            $table->longText('value');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partnership_addresses');
        Schema::dropIfExists('partnership_contacts');
        Schema::dropIfExists('partnerships');
        Schema::dropIfExists('partnerships_areas');
    }
};
