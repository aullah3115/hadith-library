<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Requests\AddPerson;
use App\Http\Controllers\Controller;
use App\Services\BioAuthorService;

class BioAuthorController extends Controller
{
    public function __construct(BioAuthorService $service){
      $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $authors = $this->service->getAll();

      return response()->json(['authors' => $authors], 200);
    }

    public function store(AddPerson $request)
    {
      $validated = $request->validated();

      $author = $this->service->addBioAuthor($validated);

      return response()->json([
        'author' => $author,
        'status' => 201
      ], 201);
    }

    public function update(Request $request, BioAuthor $bioAuthor)
    {
        //
    }

    public function destroy(BioAuthor $bioAuthor)
    {
        //
    }
}
