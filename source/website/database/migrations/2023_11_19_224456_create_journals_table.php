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
        Schema::create('journals', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('subject');

            $table->timestamps();
        });
        Schema::create('banner_journal', function (Blueprint $table) {
            $table->uuid('banner_id')->index();
            $table->foreign('banner_id')->references('id')->on('banners')->onDelete('cascade');

            $table->uuid('journal_id')->index();
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');

            $table->integer('sort_order');

            $table->primary(['banner_id','journal_id']);
        });
        Schema::create('information_journal', function (Blueprint $table) {
            $table->id();

            $table->uuid('information_id')->index();
            $table->foreign('information_id')->references('id')->on('information')->onDelete('cascade');

            $table->uuid('journal_id')->index();
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');

            $table->integer('sort_order');

            $table->index(['information_id','journal_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information_journal');
        Schema::dropIfExists('banner_journal');
        Schema::dropIfExists('journals');
    }
};
