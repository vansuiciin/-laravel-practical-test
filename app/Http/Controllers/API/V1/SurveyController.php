<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\API\V1\BaseController as BaseController;
use Validator;
use App\Events\SurveySubmitEvent;
use App\Http\Resources\SurveyResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Survey;
use App\Models\Questions;

class SurveyController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.survey');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'questions.*.text' => 'required|string', // Adjust validation rules based on your form data structure
            'questions.*.type' => 'required|in:text,textarea,date,number',
            'survey_title' => 'required',
        ]);
        // Create a new survey
        $survey = Survey::create(['title' => $request->input('survey_title')]);
        
        // Loop through the questions data
        foreach ($request->input('questions') as $questionData) {
            // Create a new question with the provided data
            $question = new Questions([
                'title' => $questionData['text'],
                'type' => $questionData['type'],
            ]);

            // Add the question to the survey using lazy loading
            $survey->questions()->save($question);
        }

        return $this->sendResponse([],'Servey submit successfully.');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
        $validatedData = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => 'required',
            'date_of_birth' => 'required|date',
            'gender' => 'required',
        ]);

        if($validatedData->fails()){
            return $this->sendError('Validation Error.', $validatedData->errors());  
        }

        // Create user logic here
        // ...
        $user = Auth::user();
        $input = $request->all();
        $input['email'] = $user->email ;
        // Trigger SurveySubmitEvent event
        // event(new SurveySubmitEvent(
        //     $input['email'],
        //     $input['name'],
        //     $input['phone_number'],
        //     $input['date_of_birth'],
        //     $input['gender']
        // ));
        $survey = Survey::where('user_id', $user->id)->first();
        if(is_null($survey)){
            $input['user_id'] = Auth::id();
            $data = Survey::create($input);
        }else{
            $data = $survey->update($input);
        }
        $success['data'] = new SurveyResource($data);

        return $this->sendResponse($success, 'Servey submit successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Survey $survey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Survey $survey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Survey $survey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Survey $survey)
    {
        //
    }
}
