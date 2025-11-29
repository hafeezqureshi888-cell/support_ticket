<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use Illuminate\Support\Str;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Technical Issues' => 'support_technical',
            'Account & Billing' => 'support_billing',
            'Product & Service' => 'support_product',
            'General Inquiry' => 'support_general',
            'Feedback & Suggestions' => 'support_feedback',
        ];

        foreach ($departments as $type => $connection) {
            $this->command->info("Seeding tickets for: $type ($connection)");

            // Create a ticket instance to set the connection
            $ticket = new Ticket();
            $ticket->setConnection($connection);

            // Check if we already have tickets to avoid duplicates if run multiple times
            if ($ticket->count() > 0) {
                continue;
            }

            for ($i = 1; $i <= 5; $i++) {
                $ref = 'TKT-' . strtoupper(Str::random(6));
                
                $newTicket = new Ticket();
                $newTicket->setConnection($connection);
                $newTicket->fill([
                    'ticket_ref' => $ref,
                    'ticket_type' => $type,
                    'full_name' => "User $i",
                    'email' => "user$i@example.com",
                    'phone' => "123456789$i",
                    'subject' => "$type Issue #$i",
                    'description' => "This is a sample description for ticket #$i in $type.",
                    'status' => 'Open',
                ]);
                $newTicket->save();
            }
        }
    }
}
