<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pokemon', function (Blueprint $table) {
            $table->json('types')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('pokemon', function (Blueprint $table) {
            $table->dropColumn('types');
        });
    }
};

