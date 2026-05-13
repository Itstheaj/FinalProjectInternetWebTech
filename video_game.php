<?php include 'header.php'; ?>
<form id="gameForm" action="process.php" method="POST">
    <h2>Enter Your Top 3 Games</h2>
    <div class="input-group">
        <input type="text" name="game1" placeholder="Game Title 1" required>
        <input type="number" name="score1" placeholder="Your Score (1-100)" min="1" max="100" required>
    </div>
    <div class="input-group">
        <input type="text" name="game2" placeholder="Game Title 2" required>
        <input type="number" name="score2" placeholder="Your Score (1-100)" min="1" max="100" required>
    </div>
    <div class="input-group">
        <input type="text" name="game3" placeholder="Game Title 3" required>
        <input type="number" name="score3" placeholder="Your Score (1-100)" min="1" max="100" required>
    </div>
    <button type="submit">Analyze My Taste</button>
</form>
<?php include 'footer.php'; ?>