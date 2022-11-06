<?php

namespace App\Models;

use App\Enums\WebserverStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebserverRequestHistory extends Model
{
    use HasFactory;

    protected $fillable = ['webserver_id', 'status', 'response_at'];
    protected $table = 'webserver_request_history';

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => WebserverStatus::labels()[$value],
        );
    }
}
