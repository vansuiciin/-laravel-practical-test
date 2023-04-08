@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1>Survey List</h1>

                @foreach ($survey as $item)
                    <h3>{{ $item->title }}</h3>
                    <form id="surveyForm">
                        <input type="hidden" name="surbey_id" value="{{ $item->id }}">
                        @csrf

                        @foreach ($item->questions as $question)
                            <div class="form-group">
                                <label for="{{ $question['id'] }}">{{ $question['title'] }}</label>
                                @if ($question['type'] == 'text')
                                    <input type="text" name="{{ $question['id'] }}" id="{{ $question['id'] }}"
                                        class="form-control">
                                @elseif($question['type'] == 'textarea')
                                    <textarea name="{{ $question['id'] }}" id="{{ $question['id'] }}" class="form-control"></textarea>
                                @elseif($question['type'] == 'date')
                                    <input type="date" name="{{ $question['id'] }}" id="{{ $question['id'] }}"
                                        class="form-control">
                                @elseif($question['type'] == 'number')
                                    <input type="number" name="{{ $question['id'] }}" id="{{ $question['id'] }}"
                                        class="form-control">
                                @endif
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                @endforeach
                <script>
                    // Form submit event
                    const surveyForm = document.getElementById('surveyForm');
                    surveyForm.addEventListener('submit', function(event) {
                        event.preventDefault();

                        // Collect form data
                        const formData = new FormData(surveyForm);
                        console.log('JSON.stringify(formData)' + JSON.stringify(formData));
                        // Send POST request to API
                        fetch('/api/v1/survey/store', {
                                method: 'POST',
                                body: JSON.stringify(formData),
                                headers: {
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Handle API response
                                console.log(data);
                                alert('save sucessfully. can clear data');
                            })
                            .catch(error => {
                                // Handle API error
                                console.error(error);
                            });
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
