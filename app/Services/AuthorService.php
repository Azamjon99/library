<?php


namespace App\Services;

use App\Repositories\AuthorRepository;

class AuthorService extends BaseService
{

    public function __construct(AuthorRepository $repo)
    {
        $this->repo = $repo;
    }

}
