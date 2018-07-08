<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Requests\AddCommentary;
use App\Http\Controllers\Controller;
use App\Services\CommentaryService;

class CommentaryController extends Controller
{

    public function __construct(CommentaryService $service){
      $this->service = $service;
    }

    public function index($book_id = null)
    {
      if(!$book_id){
        $commentaries = $this->service->getAll();
      } else {
        $commentaries = $this->service->getForBook($book_id);
      }


      return response()->json(['commentaries' => $commentaries, 'response' => 200], 200);
    }

    public function store(AddCommentary $request)
    {
      $validated = $request->validated();

      $commentary = $this->service->addCommentary($validated);

      return response()->json([
        'commentary' => $commentary,
        'status' => 201
      ], 200);
    }

    public function update(Request $request, Commentary $commentary)
    {
        //
    }

    public function destroy(Commentary $commentary)
    {
        //
    }
}
