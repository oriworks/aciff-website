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
        Schema::create('mailing_lists', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name')->unique();
            $table->text('description')->nullable();

            $table->timestamps();
        });
        Schema::create('email_mailing_list', function (Blueprint $table) {
            $table->uuid('email_id')->index();
            $table->foreign('email_id')->references('id')->on('emails')->onDelete('cascade');

            $table->uuid('mailing_list_id')->index();
            $table->foreign('mailing_list_id')->references('id')->on('mailing_lists')->onDelete('cascade');

            $table->primary(['email_id', 'mailing_list_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_mailing_list');
        Schema::dropIfExists('mailing_lists');
    }
};
