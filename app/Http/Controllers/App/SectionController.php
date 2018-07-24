<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Requests\AddSection;
use App\Http\Controllers\Controller;
use App\Services\SectionService;

class SectionController extends Controller
{

    public function __construct(SectionService $service){
      $this->service = $service;
    }

    public function index($book_id, $parent_id = null)
    {

      $sections = $this->service->getAll($book_id, $parent_id);

      return response()->json(['sections' => $sections, 'response' => 200], 200);
    }

    public function getParent($parent_id)
    {
        $parent = $this->service->getById($parent_id);

        return response()->json($parent, 200);
    }

    public function getHadith($parent_id)
    {

      $hadiths = $this->service->getHadith($parent_id);

      return response()->json(['hadiths' => $hadiths, 'response' => 200], 200);
    }

    public function store(AddSection $request)
    {

          $validated = $request->validated();

          $section = $this->service->addSection($validated);

          return response()->json([
            'section' => $section,
            'status' => 201
          ]);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        
        $section = $this->service->updateSection($data);

        return response()->json([
          'section' => $section,
          'status' => 201
        ]);
    }

    public function destroy(Section $section)
    {
        //
    }
}
