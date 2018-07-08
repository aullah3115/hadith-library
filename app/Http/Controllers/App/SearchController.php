<?php

namespace App\Http\Controllers\App;

//use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SearchService;

class SearchController extends Controller
{

    public function __construct(SearchService $service){
      $this->service = $service;
    }

    public function search(Request $request){
      $data = $request->all();

      $results = $this->service->search($data);
      return response()->json(['results' => $results, 'status' => 200]);
    }
}
