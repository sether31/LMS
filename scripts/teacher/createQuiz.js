let currentCount = 0;

function generateQuestions(){
  const numQuestion = Number(document.querySelector('#num-question').value);
  const passingScore = Number(document.querySelector('#passing-score').value);

  if(numQuestion <= 0 || numQuestion > 50){
    alert("Quiz length should be at least 1 but not greater than 50.");
    document.querySelector('#num-question').value = '';
    return;
  }

  if(passingScore < 0 || passingScore > 100) {
    alert("Passing score must be between 0 and 100.");
    document.querySelector('#passing-score').value = '';
    return;
  }

  const form = document.querySelector('#quiz-form');
  form.innerHTML = 
  `
    <input type="hidden" name="question-count" value="${numQuestion}">
    <input type="hidden" name="passing-score" value="${passingScore}">
    <div class="title">
      <label for="title">Title:</label>  
      <input type="text" name="quiz-title" id="title" required>  
    </div>
  `;

  currentCount = numQuestion;

  for(let i = 1; i <= numQuestion; i++){
    form.appendChild(createQuestionBlock(i));
  }

  form.appendChild(createSubmitButton());
}

function createQuestionBlock(index){
  const div = document.createElement('div');
  div.className = 'question-container';
  div.id = `question-${index}`;

  div.innerHTML = 
  `
    <h3>Question ${index}</h3>
    <label>Question:</label>
    <input type="text" name="question-${index}" class="question" required>
    ${createChoice(index,'a')}
    ${createChoice(index,'b')}
    ${createChoice(index,'c')}
    ${createChoice(index,'d')}
  `;
  return div;
}

function createChoice(index, letter){
  const choice = letter.toUpperCase();
  return `
    <label class="choice-label">
      <input type="radio" name="answer-${index}" value="${choice}" required>
      ${choice}:
      <input type="text" name="choice-${index}-${letter}" required>
    </label>
  `;
}

function createSubmitButton(){
  const btn = document.createElement('button');
  btn.type = 'submit';
  btn.id = 'submit-btn';
  btn.className = 'btn-primary';
  btn.textContent = 'Save Quiz';
  return btn;
}
