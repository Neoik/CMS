<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Port;

class Shipping extends Model
{
    /*
    pending
    approved
    shipping
    delivered
    rejected
    */
    public const STATUS_PENDING     = 0;
    public const STATUS_APPROVED    = 1;
    public const STATUS_SHIPPING    = 2;
    public const STATUS_DELIVERED   = 3;
    public const STATUS_REJECTED    = 4;

    public function port(){
        return $this->hasmany('App\Port');
    }

    public function port_name($port_id) {
        return Port::find($port_id)->name;
    }

    public function src_name() {
        return $this->port_name($this->departure_port_id);
    }

    public function dst_name() {
        return $this->port_name($this->arrival_port_id);
    }
}
