<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;

class CheckoutBookController extends Controller
{
   
    public function store(Book $book)
    {
        $book->checkout(auth()->user());
    }
}
