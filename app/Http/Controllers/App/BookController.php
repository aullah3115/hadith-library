<?php

namespace App\Http\Controllers\App;


use Illuminate\Http\Request;
use App\Http\Requests\AddBook;
use App\Http\Controllers\Controller;
use App\Services\BookService;

class BookController extends Controller
{

    public function __construct(BookService $service){
      $this->service = $service;
    }


    public function index()
    {
      $books = $this->service->getAll();

      return response()->json(['books' => $books, 'response' => 200], 200);
    }

    public function get($book_id)
    {

      $book = $this->service->getById($book_id);

      return response()->json(['book' => $book, 'response' => 200], 200);
    }

    public function store(AddBook $request)
    {
      $validated = $request->validated();

      $book = $this->service->addBook($validated);

      return response()->json([
        'book' => $book,
        'status' => 201
      ], 201);
    }

    public function update(Request $request, Books $books)
    {
        //
    }

    public function destroy(Books $books)
    {
        //
    }
}