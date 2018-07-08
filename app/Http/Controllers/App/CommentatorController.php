<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Requests\AddPerson;
use App\Http\Controllers\Controller;
use App\Services\CommentatorService;

class CommentatorController extends Controller
{

    public function __construct(CommentatorService $service){
      $this->service = $service;
    }

    public function index()
    {
      $commentators = $this->service->getAll();

      return response()->json(['commentators' => $commentators], 200);
    }

    public function store(AddPerson $request)
    {
      $validated = $request->validated();

      $commentator = $this->service->addCommentator($validated);

      return response()->json([
        'commentator' => $commentator,
        'status' => 201
      ], 201);
    }

    public function update(Request $request, Commentator $commentator)
    {
        //
    }

    public function destroy(Commentator $commentator)
    {
        //
    }
}
