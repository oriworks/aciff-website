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
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->integer('sort_order');

            $table->string('name')->unique();
            $table->string('slug')->unique();

            $table->uuid('parent_id')->nullable();
            $table->foreign('parent_id')
                ->references('id')
                ->on('categories')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
