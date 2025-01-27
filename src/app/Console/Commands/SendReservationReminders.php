<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Mail\ReservationReminder;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendReservationReminders extends Command
{
    protected $signature = 'send:reservation-reminders';
    protected $description = 'Send reservation reminders to users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        \Log::info('SendReservationReminders command started.');

        try {
            $today = Carbon::today()->startOfDay();
            \Log::info('Today: ' . $today);

            $reservations = Reservation::whereDate('start_at', $today)->get();
            \Log::info('Reservations count: ' . $reservations->count());

            foreach ($reservations as $reservation) {
                \Log::info('Sending email to: ' . $reservation->user->email);
                Mail::to($reservation->user->email)->send(new ReservationReminder($reservation));
            }

            \Log::info('SendReservationReminders command finished.');
        } catch (\Exception $e) {
            \Log::error('Error in SendReservationReminders: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
        }

        $this->info('Reservation reminders sent successfully.');
    }
}
