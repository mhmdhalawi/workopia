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

        Schema::table('sessions', function (Blueprint $table) {
            $table->dropColumn('user_id');

            $table->foreignUuid('user_id')->nullable()->index()->after('id');
        });
    }

    public function down(): void
    {

        Schema::table('sessions', function (Blueprint $table) {
            $table->dropColumn('user_id');

            $table->foreignId('user_id')->nullable()->index()->after('id');
        });
    }
};
