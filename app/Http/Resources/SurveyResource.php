<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            // Add other fields you want to expose in the API
        ];
    }
}
