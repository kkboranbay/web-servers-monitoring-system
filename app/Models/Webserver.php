<?php

namespace App\Models;

use App\Enums\WebserverStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webserver extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'status', 'protocol'];

    public function webserverRequestHistory()
    {
        return $this->hasMany(WebserverRequestHistory::class);
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => WebserverStatus::labels()[$value],
        );
    }
}
