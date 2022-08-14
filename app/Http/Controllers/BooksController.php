<?php

namespace App\Http\Controllers;

use App\Http\Requests\BooksRequest;
use App\Services\BookService;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function __construct(public BookService $bookService)
    {
        # code...
    }
    public function store(BooksRequest $request)
    {
        $request->validated;
        $this->bookService->create($request->all());
    }
}
