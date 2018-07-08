<?php

namespace App\Http\Controllers\App;


use Illuminate\Http\Request;
use App\Http\Requests\AddPerson;
use App\Http\Controllers\Controller;
use App\Services\AuthorService;

class AuthorController extends Controller
{

    public function __construct(AuthorService $service){
      $this->service = $service;
    }

    public function index()
    {
        $authors = $this->service->getAll();

        return response()->json(['authors' => $authors], 200);
    }

    public function store(AddPerson $request)
    {
      $validated = $request->validated();

      $author = $this->service->addAuthor($validated);

      return response()->json([
        'author' => $author,
        'status' => 201,
      ], 201);
    }

    public function update(Request $request, Author $author)
    {
        //
    }

    public function destroy(Author $author)
    {
        //
    }
}
