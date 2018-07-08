<?php

namespace App\Http\Controllers\App;

use App\Eloquent\Entities\HadithTranslation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\HadithTranslationService;

class HadithTranslationController extends Controller
{

  public function __construct(HadithTranslationService $service){
    $this->service = $service;
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function translationsForHadith($hadith_id){

      $translations = $this->service->translationsForHadith($hadith_id);

      return response()->json([
        'translations' => $translations,
        'status' => 201
      ]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $translation = $this->service->addTranslation($request->all());

      return response()->json([
        'translation' => $translation,
        'status' => 201
      ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Eloquent\Entities\HadithTranslation  $hadithTranslation
     * @return \Illuminate\Http\Response
     */
    public function show(HadithTranslation $hadithTranslation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Eloquent\Entities\HadithTranslation  $hadithTranslation
     * @return \Illuminate\Http\Response
     */
    public function edit(HadithTranslation $hadithTranslation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Eloquent\Entities\HadithTranslation  $hadithTranslation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HadithTranslation $hadithTranslation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Eloquent\Entities\HadithTranslation  $hadithTranslation
     * @return \Illuminate\Http\Response
     */
    public function destroy(HadithTranslation $hadithTranslation)
    {
        //
    }
}
