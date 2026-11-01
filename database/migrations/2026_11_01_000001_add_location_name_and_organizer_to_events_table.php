<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('location_name')->nullable()->after('location_id');
            $table->string('organizer')->nullable()->after('location_name');
            $table->foreignId('location_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['location_name', 'organizer']);
            $table->foreignId('location_id')->nullable(false)->change();
        });
    }
};
