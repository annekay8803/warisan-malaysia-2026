<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds free-text venue / organizer columns and makes location_id optional.
 *
 * FIX: this file replaces "2026_11_01_000001_add_location_name_and_organizer_to_events_table".
 * The old name sorted BEFORE "create_events_table", so a fresh `php artisan migrate`
 * (e.g. on a deployment server or in the test database) failed with
 * "Table 'events' doesn't exist". The hasColumn() guards make this migration safe
 * to run on a database where the old version was already applied.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (! Schema::hasColumn('events', 'location_name')) {
                $table->string('location_name')->nullable()->after('location_id');
            }

            if (! Schema::hasColumn('events', 'organizer')) {
                $table->string('organizer')->nullable()->after('location_name');
            }

            $table->foreignId('location_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'organizer')) {
                $table->dropColumn('organizer');
            }

            if (Schema::hasColumn('events', 'location_name')) {
                $table->dropColumn('location_name');
            }
        });
    }
};
