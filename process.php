<?php
session_start(); //starts a new session or resumes an existing one,
//allowing data to be saved and accessed in different pages

if ($_SERVER["REQUEST_METHOD"] == "POST") {//checks if the form was submitted using HTTP method
    $apiKey = "YOUR_API_KEY_HERE"; //placed 
    $results = [];

    for ($i = 1; $i <= 3; $i++) {
        $title = urlencode($_POST["game$i"]);
        $userScore = $_POST["score$i"];

        $url = "https://api.rawg.io/api/games?key=$apiKey&search=$title";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if ($data['count'] > 0) {
            $game = $data['results'][0];
            $results[] = [
                'name' => $game['name'],
                'user_score' => $userScore,
                'critic_score' => $game['metacritic'] ?? "N/A",
                'image' => $game['background_image']
            ];
        } else {
            // Error handling: if game not found
            header("Location: video_game.php?error=notfound&game=" . $_POST["game$i"]);
            exit();
        }
    }
    $_SESSION['game_data'] = $results;
    header("Location: compare.php");
}