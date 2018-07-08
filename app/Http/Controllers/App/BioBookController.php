<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Requests\AddBioBook;
use App\Http\Controllers\Controller;
use App\Services\BioBookService;

class BioBookController extends Controller
{
    public function __construct(BioBookService $service){
      $this->service = $service;
    }

    public function index()
    {
      $books = $this->service->getAll();

      return response()->json(['books' => $books, 'response' => 200], 200);
    }

    public function store(AddBioBook $request)
    {
      $validated = $request->validated();

      $book = $this->service->addBook($validated);

      return response()->json([
        'book' => $book,
        'status' => 201
      ], 201);
    }

    public function update(Request $request, BioBook $bioBook)
    {
        //
    }

    public function destroy(BioBook $bioBook)
    {
        //
    }
}
