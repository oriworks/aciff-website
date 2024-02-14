<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->renameColumn('view', 'view_old');
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->enum('view', [
                'home',
                'page',
                'membership-form',
                'contact-form',
                'information-list',
                'protocols-and-partnerships',
                'history'
            ])->default('page')->nullable();
        });

        DB::statement("UPDATE pages SET view = view_old");

        Schema::table('pages', function (Blueprint $table) {
            //Drop the old column
            $table->dropColumn('view_old');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->renameColumn('view', 'view_old');
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->enum('view', [
                'home',
                'page',
                'membership-form',
                'contact-form',
                'information-list',
                'protocols-and-partnerships'
            ])->default('page')->nullable();
        });

        DB::statement("UPDATE pages SET view = view_old");

        Schema::table('pages', function (Blueprint $table) {
            //Drop the old column
            $table->dropColumn('view_old');
        });
    }
};
