<?php

namespace App\Http\Controllers\App;


use Illuminate\Http\Request;
use App\Http\Requests\AddBio;
use App\Http\Controllers\Controller;
use App\Services\BioService;

class BioController extends Controller
{

    public function __construct(BioService $service){
      $this->service = $service;
    }

    public function index()
    {
        //
    }

    public function getText($id){
      $text = $this->service->getBioText($id);

      return response()->json(['text' => $text, 'status' => 201], 201);
    }

    public function biosForNarrator($narrator_id){

      $bios = $this->service->biosForNarrator($narrator_id);

      return response()->json(['bios' => $bios, 'status' => 201], 201);

    }

    public function store(AddBio $request)
    {
      $validated = $request->validated();

      $bio = $this->service->addBio($validated);

      return response()->json([
        'bio' => $bio,
        'status' => 201
      ], 201);
    }

    public function update(Request $request, Bio $bio)
    {
        //
    }

    public function destroy(Bio $bio)
    {
        //
    }
}
