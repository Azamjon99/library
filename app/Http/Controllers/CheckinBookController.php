<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Exception;
use Illuminate\Http\Request;

class CheckinBookController extends Controller
{
    public function store(Book $book)
    {
        try{
            $book->checkin(auth()->user());

        } catch(Exception $exception){
            return response([], 404);
        }
    }
}
