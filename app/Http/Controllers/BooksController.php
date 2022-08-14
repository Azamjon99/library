<?php

namespace App\Http\Controllers;

use App\Http\Requests\BooksRequest;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function __construct(public BookService $bookService)
    {}
    public function store(BooksRequest $request)
    {
        $request->validated;
        $book= $this->bookService->create($request->all());
        return redirect($book->path());

    }
    public function update($id,BooksRequest $request)
    {
       $request->validated;
       $book =$this->bookService->edit($request->all(), $id);
       return redirect($book->path());

    }
    public function delete($id)
    {
        $this->bookService->delete($id);
        return redirect('/books');
    }
}
