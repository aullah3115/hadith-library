<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Requests\AddHadithComment;
use App\Http\Controllers\Controller;
use App\Services\HadithCommentService;
//use Illuminate\Http\File;

class HadithCommentController extends Controller
{

    public function __construct(HadithCommentService $service){
      $this->service = $service;
    }

    public function index()
    {
        //
    }

    public function getText($comment_id)
    {
        $text = $this->service->getCommentaryText($comment_id);
        return response()->json([
          'text' => $text,
          'status' => 201
        ]);
    }

    public function commentsForHadith($hadith_id){

      $comments = $this->service->commentsForHadith($hadith_id);

      return response()->json([
        'comments' => $comments,
        'status' => 201
      ]);


    }

    public function store(AddHadithComment $request)
    {
      $validated = $request->validated();

      $comment = $this->service->addComment($validated);

      return response()->json([
        'comment' => $comment,
        'status' => 201
      ], 201);
    }

    public function update(Request $request, HadithComment $hadithComment)
    {
        //
    }

    public function destroy(HadithComment $hadithComment)
    {
        //
    }
}
