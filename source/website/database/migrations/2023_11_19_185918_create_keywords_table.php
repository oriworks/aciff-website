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
        Schema::morphUsingUuids();
        Schema::create('keywords', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name')->unique();
            $table->string('slug')->unique();

            $table->timestamps();
        });
        Schema::create('keywordables', function (Blueprint $table) {
            $table->uuid('keyword_id')->index();
            $table->foreign('keyword_id')->references('id')->on('keywords')->onDelete('cascade');

            $table->morphs('keywordable');

            $table->primary(['keyword_id', 'keywordable_type', 'keywordable_id'], 'keywordables_keyword_id_keywordable_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keywordables');
        Schema::dropIfExists('keywords');
    }
};
