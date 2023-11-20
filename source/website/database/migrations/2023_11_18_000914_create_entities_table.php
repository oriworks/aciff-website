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
        Schema::create('entities', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name')->unique();
            $table->string('friendly_name')->nullable();
            $table->string('facebook')->nullable();
            $table->boolean('facebook_like')->default(false);
            $table->boolean('facebook_share')->default(false);
            $table->string('twitter')->nullable();
            $table->boolean('twitter_like')->default(false);
            $table->boolean('twitter_share')->default(false);
            $table->string('instagram')->nullable();
            $table->boolean('instagram_like')->default(false);
            $table->boolean('instagram_share')->default(false);
            $table->string('linked_in')->nullable();
            $table->boolean('linked_in_like')->default(false);
            $table->boolean('linked_in_share')->default(false);
            $table->boolean('email_share')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entities');
    }
};
