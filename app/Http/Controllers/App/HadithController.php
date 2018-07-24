<?php

namespace App\Http\Controllers\App;


use Illuminate\Http\Request;
use App\Http\Requests\AddHadith;
use App\Http\Requests\AddLink;
use App\Http\Controllers\Controller;
use App\Services\HadithService;

class HadithController extends Controller
{
    public function __construct(HadithService $hadith_service){
      $this->hadith_service = $hadith_service;
    }

    public function index($hadith_id)
    {
        $hadith = $this->hadith_service->getById($hadith_id);

        return response()->json(['hadith' => $hadith, 'response' => 200], 200);
    }

    public function getChain($hadith_id)
    {

      $chain = $this->hadith_service->getChain($hadith_id);

      return response()->json([
        'chain' => $chain,
        'status' => 201
      ]);
    }

    public function addLink(AddLink $request){

      $validated = $request->validated();

      $link = $this->hadith_service->addLink($validated);

      return response()->json([
        'link' => $link,
        'status' => 201
      ]);
    }

    public function linkHadith(Request $request){

      //return $request->all();
      $this->hadith_service->linkHadith($request->all());
      //TODO add Reqeest class
      return response()->json([
        'linked_hadith' => $request->all(),
        'status' => 201
      ]);
    }

    public function getLinkedHadith($hadith_id){
      //return $hadith_neo_id;
      $linked_hadiths = $this->hadith_service->getLinkedHadith($hadith_id);

      return response()->json([
        'linked_hadiths' => $linked_hadiths,
        'status' => 201
      ]);
    }

    public function getSuggestedHadith($hadith_id){
      //return $hadith_neo_id;
      $suggested_hadiths = $this->hadith_service->getSuggestedHadith($hadith_id);

      return response()->json([
        'suggested_hadiths' => $suggested_hadiths,
        'status' => 201
      ]);
    }

    public function store(AddHadith $request)
    {
      $validated = $request->validated();

      $hadith = $this->hadith_service->addHadith($validated);

      return response()->json([
        'hadith' => $hadith,
        'status' => 201
      ]);
    }

    public function update(Request $request)
    {
        $hadith = $this->hadith_service->updateHadith($request->all());

        return response()->json([
          'hadith' => $hadith,
          'status' => 201
        ]);
    }

    public function destroy(Hadith $hadith)
    {
        //
    }
}
