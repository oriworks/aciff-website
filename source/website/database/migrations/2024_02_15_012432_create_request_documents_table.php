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
        Schema::create('request_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');
            $table->string('phone');
            $table->string('email');

            $table->uuid('document_id')->nullable();
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('set null');

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
        Schema::dropIfExists('request_documents');
    }
};
