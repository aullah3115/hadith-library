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

    public function getById($narrator_id){

      $narrator = $this->service->getById($narrator_id);

      return response()->json(['narrator' => $narrator], 200);
    }

    public function getTeachers($narrator_id){

      $teachers = $this->service->getTeachers($narrator_id);

      return response()->json(['teachers' => $teachers], 200);
    }

    public function getStudents($narrator_id){

      $students = $this->service->getStudents($narrator_id);

      return response()->json(['students' => $students], 200);
    }

    public function getNarrations($student_id, $teacher_id){

      $data = ['student_id' => $student_id, 'teacher_id' => $teacher_id];
      $narrations = $this->service->getNarrations($data);

      return response()->json(['narrations' => $narrations], 200);
    }

    public function getAllNarrations($narrator_id){
      $narrations = $this->service->getAllNarrations($narrator_id);

      return response()->json(['narrations' => $narrations], 200);
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
