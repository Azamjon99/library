<?php


namespace App\Services;

use App\Repositories\BookRepository;

class BookService extends BaseService
{

    public function __construct( public BookRepository $bookRepo)
    {}

    public function create($request)
    {
        $this->bookRepo->store(['title'=>$request['title'], 'author'=>$request['title']]);
    }

}
