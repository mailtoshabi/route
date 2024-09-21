<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
    use HasFactory;

    protected $hidden = ['id'];

    protected $guarded = [];

    public function ticket_replyable()
    {
        return $this->morphTo();
    }

}
