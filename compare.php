<?php
session_start();
$data = $_SESSION['game_data'];
$totalDivergence = 0;
$validCount = 0;

foreach ($data as &$game) {
    if ($game['critic_score'] !== "N/A") {
        // Calculate absolute difference: |User - Critic|
        $diff = abs($game['user_score'] - $game['critic_score']);
        $game['divergence'] = $diff;
        $totalDivergence += $diff;
        $validCount++;
    } else {
        $game['divergence'] = "Unknown";
    }
}

// Formula: Average Divergence
$avgDivergence = ($validCount > 0) ? $totalDivergence / $validCount : 0;
$_SESSION['final_analysis'] = $data;
$_SESSION['score'] = $avgDivergence;

header("Location: results.php");