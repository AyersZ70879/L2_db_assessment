<?php include("topbit.php");

    $app_name = mysqli_real_escape_string($dbconnect, $_POST['app_name']);
    $developer = mysqli_real_escape_string($dbconnect, $_POST['dev_name']);
    $genre = mysqli_real_escape_string($dbconnect, $_POST['genre']);
    $cost = mysqli_real_escape_string($dbconnect, $_POST['cost']);
   
    // Cost code (to handle when cost is not specified...)
    if ($cost=="") {
        $cost_op = ">=";
        $cost = 0;
    }
    else {
        $cost_op = "<=";
    }
    


    // In App Purchases
    if (isset($_POST['in_app'])) {
        $in_app = 0;
    }
    
    else {
        $in_app = 1;
    }

    // Ratings
    $rating_more_less = mysqli_real_escape_string($dbconnect, $_POST['rate_more_less']);
    $rating = mysqli_real_escape_string($dbconnect, $_POST['rating']);

    if ($rating == "") {$rating = 0;
                        $rating_more_less = "at least";}// Set age to 0 if it is blank
    

    if($rating_more_less == "at most") {
        $rate_op = "<=";
    }

    else {
        $rate_op = ">=";
        
        
    } // end rating if / elseif / else

    // Age
    $age_more_less = mysqli_real_escape_string($dbconnect, $_POST['age_more_less']);
    $age = mysqli_real_escape_string($dbconnect, $_POST['age']);

    if ($age == "") {$age = 0;
                     $age_more_less = "at least";} // Set age to 0 if it is blank

    if($age_more_less == "at most") {
        $age_op = "<=";
    }

    else {
        $age_op = ">=";
        
        
        
    } // end age if / elseif / else


    $find_sql = "SELECT * FROM `00_L2_games`
    JOIN 00_L2_games_genre ON (00_L2_games.GenreID = 00_L2_games_genre.GenreID)
    JOIN 00_L2_games_developer ON (00_L2_games.DeveloperID = 00_L2_games_developer.DeveloperID)
    WHERE `Name` LIKE '%$app_name%'
    AND `DevName` LIKE '%$developer%'
    AND `Genre` LIKE '%$genre%'
    AND `Price` $cost_op '$cost'
    AND (`In App` = $in_app OR `In App` = 0)
    AND `User Rating` $rate_op $rating
    AND `Age` $age_op $age
    
    ";
    $find_query = mysqli_query($dbconnect, $find_sql);
    $find_rs = mysqli_fetch_assoc($find_query);
    $count = mysqli_num_rows($find_query);
    

?>

        <div class="box main">
            <h2>Advanced Search Results</h2>
            
            
            <?php
            include("results.php"); 
            ?>
            

            
        </div> <!-- / main -->
        
<?php include("bottombit.php")?>
