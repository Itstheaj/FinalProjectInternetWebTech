<?php
session_start(); //starts a new session or resumes an existing one,
//allowing data to be saved and accessed in different pages

if ($_SERVER["REQUEST_METHOD"] == "POST") { //checks if the form was submitted using HTTP method
    $apiKey = "YOUR_API_KEY_HERE"; //placed for unique rawg api key authenticate 
    $results = []; //

    for ($i = 1; $i <= 3; $i++) {
        $title = urlencode($_POST["game$i"]); //gathers game title safe for URL
        $userScore = $_POST["score$i"]; //gathers user score for the game

        //constructs specific web address needed to search for that game title
        $url = "https://api.rawg.io/api/games?key=$apiKey&search=$title";
        $response = file_get_contents($url); //make request for rawg
        $data = json_decode($response, true); //converts the JSON response into a PHP array 

        if ($data['count'] > 0) { //checks if any games were found in the search results
            $game = $data['results'][0]; //takes the first game from the search
            $results[] = [ //adds game details to the results array
                'name' => $game['name'], //game title 
                'user_score' => $userScore, //user's score for the game
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