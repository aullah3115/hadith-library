<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Requests\AddPerson;
use App\Http\Controllers\Controller;
use App\Services\NarratorService;

class NarratorController extends Controller
{
    public function __construct(NarratorService $service){
      $this->service = $service;
    }

    public function index()
    {

      $narrators = $this->service->getAll();

      return response()->json(['narrators' => $narrators], 200);

    }

    public function getById($id){
      return response()->json(['narrator' => 'narrator'], 200);
    }

    public function store(AddPerson $request)
    {
      $validated = $request->validated();

      $narrator = $this->service->addNarrator($validated);

      return response()->json([
        'narrator' => $narrator,
        'status' => 201
      ]);
    }

    public function update(Request $request, Narrators $narrators)
    {
        //
    }

    public function destroy(Narrators $narrators)
    {
        //
    }
}
