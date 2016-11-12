let sentiment;
let req = null;
const label = document.querySelector('#label');
const resetBtn = document.querySelector('#reset');

req = getData('/api' + location.pathname, (data) => {
  sentiment = data.sentiment;

  Donut3D.draw(sentimentToData(sentiment));
  label.textContent = 'All messages';

  req = null;
});

const messages = document.querySelectorAll('.message');
messages.forEach((message) => {
  message.onclick = function() {
    let date = this.querySelector('.date').textContent;
    let id = this.dataset.id;


    const selected = document.querySelector('.message.selected');
    if (selected) {
      selected.classList.remove('selected');
    }
    this.classList.add('selected');

    if (req !== null) {
      req.abort();
    }

    req = getData(`/api/matches/${date}/${id}`, (data) => {
      resetBtn.classList.add('show');

      label.textContent = 'Message #' + data.id;
      Donut3D.transition(sentimentToData(data.sentiment));
      req = null;
    });
  };
});

resetBtn.onclick = function() {
  label.textContent = 'All messages';
  Donut3D.transition(sentimentToData(sentiment));
  document.querySelector('.message.selected').classList.remove('selected');
  this.classList.remove('show');
};



function sentimentToData(sentiment) {
  return [{
    label: "Negatives",
    color: "#E06C75",
    value: sentiment[-1]
  }, {
    label: "Neutrals",
    color: "#61AFEF",
    value: sentiment[0]
  }, {
    label: "Positives",
    color: "#98C379",
    value: sentiment[1]
  }]
}

function getData(url, callback) {
  return requestAsync(url, (status, text) => {
    if (status === 200) {
      callback(JSON.parse(text));
    } else {
      alert(status);
    }
  });
}

function requestAsync(url, callback) {
  var req = new XMLHttpRequest();

  req.addEventListener('load', function() {
    callback(this.status, req.responseText);
  });
  req.addEventListener('error', function() {
    callback(this.status);
  });

  req.open('GET', url, true);
  req.send();

  return req;
}
