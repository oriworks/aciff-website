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
        Schema::create('pages', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('subject')->unique();
            $table->string('slug')->unique();

            $table->enum('view', [
                'home',
                'page',
                'membership-form',
                'contact-form',
                'information-list',
                'protocols-and-partnerships'
            ])->default('page');

            $table->longText('content')->nullable();

            $table->timestamp('publish_at')->nullable();
            $table->timestamp('publish_to')->nullable();

            $table->uuid('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
