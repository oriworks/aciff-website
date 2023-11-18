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
        Schema::create('emails', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('email')->unique();
            $table->string('token');

            $table->timestamp('verified_at')->nullable();
            $table->timestamp('canceled_at')->nullable();

            $table->timestamps();
        });
        // Polymorphic Relationships Many to Many
        Schema::create('mailing_listables', function (Blueprint $table) {
            $table->uuid('email_id')->index();
            $table->foreign('email_id')->references('id')->on('emails')->onDelete('cascade');

            $table->morphs('mailing_listable', 'mailing_listables_mailing_listable_index');

            $table->primary(['email_id', 'mailing_listable_type', 'mailing_listable_id'], 'mailing_listables_email_id_mailing_listable_index');
        });
        Schema::create('mail_queues', function (Blueprint $table) {
            $table->morphs('emailable');
            $table->morphs('mailable');
            $table->integer('retry')->default(0);
            $table->primary(['emailable_type', 'emailable_id', 'mailable_type', 'mailable_id', 'retry'], 'mail_queues_emailable_mailable_index');

            $table->integer('priority')->default(0);

            $table->timestamp('sent_at')->nullable();
            $table->integer('sent')->default(0);
            $table->timestamp('delivered_at')->nullable();
            $table->integer('delivered')->default(0);
            $table->timestamp('viewed_at')->nullable();
            $table->integer('viewed')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_queues');
        Schema::dropIfExists('mailing_listables');
        Schema::dropIfExists('emails');
    }
};
