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
        Schema::table('documents', function (Blueprint $table) {
            $table->string('attachment');
            $table->string('attachment_name');
            $table->unsignedInteger('attachment_num_pages');
            $table->unsignedInteger('attachment_original_size');
            $table->unsignedInteger('attachment_compress_size')->nullable();
            $table->unsignedInteger('attachment_num_image')->default(0);
            $table->json('attachment_pages')->nullable();
            $table->uuid('queue_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('attachment');
            $table->dropColumn('attachment_name');
            $table->dropColumn('attachment_num_pages');
            $table->dropColumn('attachment_original_size');
            $table->dropColumn('attachment_compress_size');
            $table->dropColumn('attachment_num_image');
            $table->dropColumn('attachment_pages');
            $table->dropColumn('queue_id');
        });
    }
};
