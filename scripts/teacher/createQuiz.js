let currentCount = 0;

function generateQuestions(){
  let numQuestion = Number(document.querySelector('#num-question').value);

  if(numQuestion <= 0 || numQuestion > 50){
    alert("Quiz length should be at least 1 but not greater than 50.");
    document.querySelector('#num-question').value = '';
    return;
  }

  const passingScore = Number(document.querySelector('#passing-score').value);

  if(passingScore < 0 || passingScore > 100){
    alert("Passing score must be between 0 and 100.");
    document.querySelector('#passing-score').value = '';
    return;
  }


  const form = document.querySelector('#quiz-form');
  form.innerHTML = '';

  form.innerHTML += `
    <input type="hidden" name="question-count" id="question-count" value="${numQuestion}">
    <input type="hidden" name="passing-score" id="passing-score-hidden" value="${passingScore}">
    <div class="title">
      <label for="title">Title:</label>  
      <input type="text" name="quiz-title" id="title">  
    </div>
  `;

  currentCount = 0;

  for(let i = 1; i <= numQuestion; i++){
    createQuestion(i);
    currentCount++;
  }

  updateQuestionCount();
  updateSubmitButton();
}

function createQuestion(index){
  const div = document.createElement('div');
  div.className = 'question-container';
  div.id = `question-${index}`;

  div.innerHTML += `
    <h3>Question ${index}</h3>

    <label>Question Type:</label>
    <select name="type-${index}" onchange="updateAnswer(${index}, this.value)">
      <option value="radio">Single Answer</option>
      <option value="checkbox">Multiple Answers</option>
    </select>

    <label>Question:</label>
    <input type="text" name="question-${index}" required>

    <label>Choice A:</label>
    <input type="text" name="choice-${index}-a" required>

    <label>Choice B:</label>
    <input type="text" name="choice-${index}-b" required>

    <label>Choice C:</label>
    <input type="text" name="choice-${index}-c" required>

    <label>Choice D:</label>
    <input type="text" name="choice-${index}-d" required>

    <div id="answer-block-${index}">
      ${generateRadio(index)}
    </div>
  `;

  document.querySelector('#quiz-form').appendChild(div);
}

function generateRadio(index){
  return `
    <fieldset>
      <legend><strong>Select the correct answer:</strong></legend>
      <label><input type="radio" name="answer-${index}" value="A" required> A</label><br>
      <label><input type="radio" name="answer-${index}" value="B"> B</label><br>
      <label><input type="radio" name="answer-${index}" value="C"> C</label><br>
      <label><input type="radio" name="answer-${index}" value="D"> D</label>
    </fieldset>
  `;
}

function generateCheckbox(index){
  return `
    <fieldset>
      <legend><strong>Select correct answer(s):</strong></legend>
      <label><input type="checkbox" name="answer-${index}[]" value="A"> A</label><br>
      <label><input type="checkbox" name="answer-${index}[]" value="B"> B</label><br>
      <label><input type="checkbox" name="answer-${index}[]" value="C"> C</label><br>
      <label><input type="checkbox" name="answer-${index}[]" value="D"> D</label>
    </fieldset>
  `;
}

function updateAnswer(index, type){
  const answerBlock = document.getElementById(`answer-block-${index}`);
  answerBlock.innerHTML = type === 'checkbox' ? generateCheckbox(index) : generateRadio(index);
}

function addQuestion(){
  currentCount++;
  createQuestion(currentCount);
  updateQuestionCount();
  updateSubmitButton();  // Notice we use the centralized version
}

function removeLastQuestion(){
  if (currentCount > 0) {
    const last = document.querySelector(`#question-${currentCount}`);
    if (last) {
      last.remove();
    }
    currentCount--;
    updateQuestionCount();
    updateSubmitButton();  // Same here
  }
}

function updateQuestionCount(){
  let questionCountInput = document.querySelector('#question-count');

  if (!questionCountInput) {
    // Create the hidden input if it doesn't exist
    questionCountInput = document.createElement('input');
    questionCountInput.type = 'hidden';
    questionCountInput.name = 'question-count';
    questionCountInput.id = 'question-count';
    document.querySelector('#quiz-form').appendChild(questionCountInput);
  }

  questionCountInput.value = currentCount;
}

function updateSubmitButton(){
  const form = document.querySelector('#quiz-form');
  let submitBtn = document.querySelector('#submit-btn');

  if (currentCount > 0 && !submitBtn) {
    submitBtn = document.createElement('button');
    submitBtn.id = 'submit-btn';
    submitBtn.className = 'btn-primary';
    submitBtn.textContent = 'Save Quiz';
    submitBtn.type = 'submit';
    form.appendChild(submitBtn);
  } else if (currentCount > 0 && submitBtn) {
    form.appendChild(submitBtn);
  } else if (currentCount === 0 && submitBtn) {
    submitBtn.remove();
  }
}
