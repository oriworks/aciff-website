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
        Schema::create('suggestions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');
            $table->string('phone');
            $table->string('email');

            $table->uuid('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');

            $table->string('subject');
            $table->longText('content');

            $table->timestamp('solved_at')->nullable();
            $table->string('solved_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggestions');
    }
};
