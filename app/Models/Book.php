<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function path()
    {
        return '/books/' . $this->id;
    }
    public function setAuthorIdAttribute(int $author)
    {
        $author = Author::firstOrCreate(['name'=>$author]);
        $this->attributes['author_id'] =  $author->id;
    }

    public function checkout(User $user)
    {
        $this->reservations()->create([
            'user_id' =>$user->id,
            'check_out_at' =>now(),
        ]);
    }
    public function checkin(User $user)
    {
       $reservation= $this->reservations()->where('user_id', $user->id)->whereNotNull('check_out_at')->whereNull('check_in_at')->first();
       if(is_null($reservation)){
        throw new Exception();

       }
       $reservation->update(['check_in_at'=>now()]);

    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
