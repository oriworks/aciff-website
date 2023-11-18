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
        Schema::create('newsletters', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->morphs('newsletterable');

            $table->uuid('sender_id')->nullable();
            $table->foreign('sender_id')->references('id')->on('senders')->onDelete('set null');

            $table->timestamps();
        });
        Schema::create('mailing_list_newsletter', function (Blueprint $table) {
            $table->uuid('mailing_list_id')->index();
            $table->foreign('mailing_list_id')->references('id')->on('mailing_lists')->onDelete('cascade');

            $table->uuid('newsletter_id')->index();
            $table->foreign('newsletter_id')->references('id')->on('newsletters')->onDelete('cascade');

            $table->primary(['mailing_list_id', 'newsletter_id']);

            $table->timestamp('send_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mailing_list_newsletter');
        Schema::dropIfExists('newsletters');
    }
};
