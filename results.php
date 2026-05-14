<?php 
session_start();
include 'header.php'; 
$analysis = $_SESSION['final_analysis'];
$score = $_SESSION['score'];
?>

<h2>Your Results</h2>
<p>Your Average Divergence: <strong><?php echo round($score, 2); ?></strong></p>

<div class="results-grid">
    <?php foreach ($analysis as $game): ?>
    <div class="card">
        <img src="<?php echo $game['image']; ?>" width="100">
        <h3><?php echo $game['name']; ?></h3>
        <p>You: <?php echo $game['user_score']; ?> | Critics: <?php echo $game['critic_score']; ?></p>
    </div>
    <?php endforeach; ?>
</div>

<?php include 'footer.php'; ?>