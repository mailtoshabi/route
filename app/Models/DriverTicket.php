<?php

namespace App\Models;

use App\Http\Utilities\Utility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverTicket extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function driver() {
        return $this->belongsTo(Driver::class);
    }

    public function replies()
    {
        return $this->morphMany(TicketReply::class, 'ticket_replyable');
    }

    public function getStatusTextAttribute() {
        if($this->status ==Utility::TICKET_CUSTOMER_POSTED) return 'Customer Posted';
        else if($this->status ==Utility::TICKET_ADMIN_REPLIED) return 'Admin Replied';
        else return 'Admin Replied';
    }
}
