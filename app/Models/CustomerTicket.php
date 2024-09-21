<?php

namespace App\Models;

use App\Http\Utilities\Utility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTicket extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer() {
        return $this->belongsTo(Customer::class);
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

    public function current_handler() {
        return $this->belongsTo(User::class,'handler');
    }

    public function scopeOpen($query) {
        return $query->where('status',Utility::ITEM_ACTIVE);
    }

    public function scopeClosed($query) {
        return $query->where('status',Utility::ITEM_INACTIVE);
    }
}
