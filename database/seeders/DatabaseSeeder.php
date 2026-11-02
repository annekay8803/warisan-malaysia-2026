<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Location;
use App\Models\Performer;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Demo data for a fresh database (local, testing and deployed server).
 *
 * Run with:  php artisan migrate:fresh --seed
 *
 * The seeder is idempotent (updateOrCreate / firstOrCreate), so running it
 * again will not create duplicates.
 *
 * Demo accounts
 *   admin : admin@warisan.test / Admin@12345
 *   user  : user@warisan.test  / User@12345
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---------- Accounts (two user levels) ----------
        User::updateOrCreate(
            ['email' => 'admin@warisan.test'],
            ['name' => 'Administrator', 'password' => 'Admin@12345', 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'user@warisan.test'],
            ['name' => 'Demo User', 'password' => 'User@12345', 'role' => 'user']
        );

        // ---------- Locations ----------
        $istana = Location::firstOrCreate(['name' => 'Istana Budaya'], [
            'address' => 'Jalan Tun Razak', 'city' => 'Kuala Lumpur', 'state' => 'Wilayah Persekutuan',
        ]);
        $pasarSeni = Location::firstOrCreate(['name' => 'Pasar Seni'], [
            'address' => 'Jalan Hang Kasturi', 'city' => 'Kuala Lumpur', 'state' => 'Wilayah Persekutuan',
        ]);
        $dataran = Location::firstOrCreate(['name' => 'Dataran Sejarah, Bandaraya Melaka'], [
            'address' => 'Jalan Kota', 'city' => 'Melaka', 'state' => 'Melaka',
        ]);

        // ---------- Performers ----------
        $seriBudaya = Performer::firstOrCreate(['name' => 'Seri Budaya Group'], [
            'performance_type' => 'Traditional Dance',
            'description' => 'A cultural troupe performing Malay, Chinese, Indian and Borneo dances.',
        ]);
        $bloomphoto = Performer::firstOrCreate(['name' => 'Bloomphoto'], [
            'performance_type' => 'Food & Culinary Showcase',
            'description' => 'Organiser of heritage food festivals and photography exhibitions.',
        ]);
        $motac = Performer::firstOrCreate(['name' => 'MOTAC'], [
            'performance_type' => 'Heritage Exhibition',
            'description' => 'Ministry of Tourism, Arts and Culture Malaysia.',
        ]);

        // ---------- Events (linked to locations and performers) ----------
        $dance = Event::firstOrCreate(['title' => 'Malaysia Traditional Dance Festival'], [
            'category' => 'Traditional Arts & Dance',
            'description' => 'A festival showcasing traditional Malaysian dances and cultural performances.',
            'location_id' => $istana->id, 'location_name' => 'Istana Budaya',
            'performer_id' => $seriBudaya->id, 'organizer' => 'Seri Budaya Group',
            'event_date' => '2026-10-10', 'status' => 'completed',
        ]);

        $food = Event::firstOrCreate(['title' => 'Malaysian Heritage Food Festival'], [
            'category' => 'Food & Culinary Heritage',
            'description' => 'A cultural event celebrating traditional Malaysian food and heritage.',
            'location_id' => $pasarSeni->id, 'location_name' => 'Pasar Seni, KL',
            'performer_id' => $bloomphoto->id, 'organizer' => 'Bloomphoto',
            'event_date' => '2026-12-12', 'status' => 'upcoming',
        ]);

        $melaka = Event::firstOrCreate(['title' => 'Melaka Historical Heritage Exhibition'], [
            'category' => 'Historical Heritage',
            'description' => 'Explore the rich history of Melaka through an educational heritage exhibition '
                . 'showcasing historical landmarks, traditional architecture and cultural influences.',
            'location_id' => $dataran->id, 'location_name' => 'Dataran Sejarah, Bandaraya Melaka',
            'performer_id' => $motac->id, 'organizer' => 'MOTAC',
            'event_date' => '2027-08-01', 'status' => 'upcoming',
        ]);

        // ---------- Schedules (programme for each event) ----------
        $this->schedule($dance, 'Opening Ceremony', '10:00:00', '10:30:00');
        $this->schedule($dance, 'Traditional Dance Performances', '10:30:00', '13:00:00');
        $this->schedule($food, 'Food Stalls Open', '09:00:00', '12:00:00');
        $this->schedule($food, 'Heritage Cooking Demonstration', '14:00:00', '16:00:00');
        $this->schedule($melaka, 'Guided Exhibition Tour', '10:00:00', '12:00:00');
    }

    /** Create a schedule item once per event + activity name. */
    private function schedule(Event $event, string $activity, string $start, string $end): void
    {
        Schedule::firstOrCreate(
            ['event_id' => $event->id, 'activity_name' => $activity],
            ['start_time' => $start, 'end_time' => $end]
        );
    }
}
