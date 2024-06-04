// Wait for the DOM content to be fully loaded
document.addEventListener("DOMContentLoaded", function() {
    // Select all elements with the class 'question'
    const questions = document.querySelectorAll('.question');

    // Iterate over each 'question' element
    questions.forEach(question => {
        // Add a click event listener to each 'question' element
        question.addEventListener('click', function() {
            // Select the next element sibling of the clicked 'question' (the answer)
            const answer = this.nextElementSibling;
            // Toggle the 'active' class on the answer element to show/hide it
            answer.classList.toggle('active');
            // Select the 'plus' button within the clicked 'question'
            const plusButton = this.querySelector('.plus');
            // Toggle the 'rotated' class on the plus button to rotate the icon
            plusButton.classList.toggle('rotated');
        });
    });
});

const alerts = document.querySelectorAll('[class*="alert-"]')
for (const alert of alerts) {
    setTimeout( function() {
        const bootstrapAlert = bootstrap.Alert.getOrCreateInstance(alert);
        bootstrapAlert.close();
    }, 5000);
};

const cassette = document.querySelector('.cassette');
const title = document.querySelector('.title');
const playButton = document.getElementById('playButton');
const stopButton = document.getElementById('stopButton');
const audioElement = new Audio('./audio/Galactic-Adventure.mp3');

playButton.addEventListener('click', () => {
  playButton.style.display = 'none';
  stopButton.style.display = 'inline-flex';
  title.classList.add('running');
  title.style.display = 'block';
  cassette.classList.add('animated');
  audioElement.play();
  setTimeout(() => {
    stopButton.click();
    cassette.classList.remove('animated');
  }, 100000);
});

stopButton.addEventListener('click', () => {
  audioElement.pause();
  audioElement.currentTime = 0; // Rembobine l'audio au début
  playButton.style.display = 'inline-flex';
  stopButton.style.display = 'none';
  title.classList.remove('running');
  title.style.display = 'none';
  cassette.classList.remove('animated');
});