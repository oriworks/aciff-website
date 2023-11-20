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
        Schema::create('associates', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('social_designation');
            $table->longText('address');
            $table->string('county');
            $table->string('parish');
            $table->string('zip_code');
            $table->string('locality');
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->string('email');
            $table->string('nif');
            $table->string('cae');
            $table->enum('legal', ['plc', 'as', 'ip', 'llc']);
            $table->string('activity');
            $table->string('joint_stock');
            $table->string('num_associates');
            $table->string('num_employees');

            $table->string('contact_name');
            $table->string('contact_job');
            $table->string('contact_phone');
            $table->string('contact_email');

            $table->enum('payment_periodicity', ['yearly', 'semiannual', 'quarterly']);
            $table->enum('payment_type', ['in_store', 'bank_transfer']);

            $table->boolean('consent')->default(false);

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
        Schema::dropIfExists('associates');
    }
};
