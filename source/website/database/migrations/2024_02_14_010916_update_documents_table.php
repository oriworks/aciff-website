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
            $table->timestamp('publish_at')->nullable();
            $table->timestamp('downloadable_at')->nullable();
            $table->timestamp('requestable_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('publish_at');
            $table->dropColumn('downloadable_at');
            $table->dropColumn('requestable_at');
        });
    }
};