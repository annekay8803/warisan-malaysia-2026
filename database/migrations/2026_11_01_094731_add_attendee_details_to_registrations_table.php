<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('attendee_name')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedInteger('number_of_tickets')->default(1);
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn([
                'attendee_name',
                'phone',
                'number_of_tickets'
            ]);
        });
    }
};