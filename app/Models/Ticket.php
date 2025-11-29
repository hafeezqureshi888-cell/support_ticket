<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Map ticket types to connection names
    public static $typeConnectionMap = [
        'Technical Issues' => 'support_technical',
        'Account & Billing' => 'support_billing',
        'Product & Service' => 'support_product',
        'General Inquiry' => 'support_general',
        'Feedback & Suggestions' => 'support_feedback',
    ];

    public function getConnectionName()
    {
        // If the instance has a ticket_type set, use it to determine connection
        if ($this->ticket_type && isset(self::$typeConnectionMap[$this->ticket_type])) {
            return self::$typeConnectionMap[$this->ticket_type];
        }

        // Default to default connection if not set (should not happen for saving)
        return parent::getConnectionName();
    }
}
