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
        Schema::create('system_mails', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->nullableMorphs('system_mailable');

            $table->string('notification_type');

            $table->index(['notification_type', 'system_mailable_type', 'system_mailable_id'], 'system_mails_notification_type_system_mailable_index');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_mails');
    }
};
