<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Questions;

class SurveyController extends Controller
{
    public function index(){
        return view('pages.survey.index');
    }

    public function list(){
        $survey = Survey::with('questions')->get();
        return view('pages.survey.list',compact('survey'));
    }
}
