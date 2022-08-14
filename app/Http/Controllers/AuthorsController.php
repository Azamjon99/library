<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Services\AuthorService;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function __construct(public AuthorService $service)
    {}

    public function store(AuthorRequest $request)
    {
        $request->validated;
        $author= $this->service->create($request->all());
        return redirect($author->path());

    }
}
