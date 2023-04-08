@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form id="surveyForm">
                    <label for="surveyTitle">Survey Title</label>
                    <input type="text" id="surveyTitle" name="survey_title" required>
                    <br>
                    <div id="questionsContainer">
                        <!-- Questions will be dynamically added here -->
                    </div><br>
                    <button type="submit">Submit</button>

                    <!-- Add a question button -->
                    <button id="addQuestionBtn">Add Question</button>
                </form>
            </div>
        </div>
    </div>
    <!-- JavaScript code -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addQuestionBtn = document.getElementById('addQuestionBtn');
            const questionsContainer = document.getElementById('questionsContainer');

            // Add question button click event
            addQuestionBtn.addEventListener('click', function(event) {
                event.preventDefault();

                // Create a new question div
                const questionDiv = document.createElement('div');
                questionDiv.classList.add('question');

                // Create question input
                const questionInput = document.createElement('input');
                questionInput.setAttribute('type', 'text');
                questionInput.setAttribute('placeholder', 'Enter question text');

                // Create question type select
                const questionTypeSelect = document.createElement('select');
                const questionTypeOptions = ['text', 'textarea', 'date', 'number'];
                for (const option of questionTypeOptions) {
                    const optionElement = document.createElement('option');
                    optionElement.textContent = option;
                    questionTypeSelect.appendChild(optionElement);
                }

                // Append question input and select to question div
                questionDiv.appendChild(questionInput);
                questionDiv.appendChild(questionTypeSelect);

                // Append question div to questions container
                questionsContainer.appendChild(questionDiv);
            });

            // Form submit event
            const surveyForm = document.getElementById('surveyForm');
            surveyForm.addEventListener('submit', function(event) {
                event.preventDefault();

                // Collect form data
                const formData = new FormData(surveyForm);
                const questions = [];

                // Loop through each question div
                const questionDivs = document.getElementsByClassName('question');
                for (const questionDiv of questionDivs) {
                    const question = {
                        text: questionDiv.querySelector('input').value,
                        type: questionDiv.querySelector('select').value
                    };
                    questions.push(question);
                }

                // Prepare data to be sent to API
                const data = {
                    questions: questions,
                    survey_title: document.getElementById('surveyTitle').value
                };

                // Send POST request to API
                fetch('/api/v1/survey', {
                        method: 'POST',
                        body: JSON.stringify(data),
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
        });
    </script>
@endsection
