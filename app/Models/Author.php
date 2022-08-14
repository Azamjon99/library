<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function path()
    {
        return '/authors/' . $this->id;
    }
    protected $dates=['dob'];
    public function setDoBAtrribute($dob)
    {
        $this->attributes['dob'] = Carbon::parse($dob);
    }
}
