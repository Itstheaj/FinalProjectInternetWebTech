document.getElementById('gameForm')?.addEventListener('submit', function(e) {
    const scores = document.querySelectorAll('input[type="number"]');
    scores.forEach(score => {
        if (score.value < 1 || score.value > 100) {
            alert("Scores must be between 1 and 100!");
            e.preventDefault();
        }
    });
});