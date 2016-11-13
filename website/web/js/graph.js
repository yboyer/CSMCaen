let sentiment;
let req = null;
const label = document.querySelector('#label');
const resetBtn = document.querySelector('#reset');
const neutralsCheckbox = document.querySelector('#neutralsCB');
let currentSentiment = null;
let includeNeutral = neutralsCheckbox.checked;

// Global graph
const resume = document.querySelector('#resume');
const globalSentiment = {
  '-1': resume.dataset['-1'],
  '0': resume.dataset['0'],
  '1': resume.dataset['1'],
};
label.textContent = 'All messages';
currentSentiment = globalSentiment;
Donut3D.draw(sentimentToData(globalSentiment));

// Messages interactions
const messages = document.querySelectorAll('.message');
messages.forEach((message) => {
  message.onclick = function() {
    const id = this.dataset.id;
    const sentiment = {
      '-1': this.dataset['-1'],
      '0': this.dataset['0'],
      '1': this.dataset['1'],
    };
    currentSentiment = sentiment;

    // Remove selected element
    const selected = document.querySelector('.message.selected');
    if (selected) {
      selected.classList.remove('selected');
    }
    this.classList.add('selected');

    resetBtn.classList.add('show');

    label.textContent = 'Message #' + id;
    Donut3D.transition(sentimentToData(sentiment));
  };
});

neutralsCheckbox.onchange = function() {
  includeNeutral = this.checked;
  
  const svg = document.querySelector('#graph');
  while (svg.firstChild) {
    svg.removeChild(svg.firstChild);
  }

  Donut3D.draw(sentimentToData(currentSentiment));
}

resetBtn.onclick = function() {
  label.textContent = 'All messages';
  Donut3D.transition(sentimentToData(globalSentiment));
  document.querySelector('.message.selected').classList.remove('selected');
  this.classList.remove('show');
};



function sentimentToData(sentiment) {
  const data = [{
    label: "Negatives",
    color: "#E06C75",
    value: sentiment[-1]
  }, {
    label: "Positives",
    color: "#98C379",
    value: sentiment[1]
  }];

  if (includeNeutral) {
    data.push({
      label: "Neutrals",
      color: "#61AFEF",
      value: sentiment[0]
    });
  }

  return data;
}
