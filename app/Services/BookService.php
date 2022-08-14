<?php


namespace App\Services;

use App\Repositories\BookRepository;

class BookService extends BaseService
{

    public function __construct(  BookRepository $repo)
    {
        $this->repo = $repo;
    }

}
