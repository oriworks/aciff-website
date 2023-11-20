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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary(['id']);

            $table->uuid('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('menu_items')->onDelete('set null');

            $table->string('name');
            $table->unsignedInteger('sort_order');

            $table->uuid('page_id')->nullable();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('set null');

            $table->string('link')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
