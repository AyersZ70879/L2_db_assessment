<?php include("topbit.php");

    $band_name = $_POST['band_name'];

    $find_sql = "SELECT *
    FROM `00_L2_games`
    JOIN 00_L2_games_genre ON (00_L2_games.GenreID = 00_L2_games_genre.GenreID)
    JOIN 00_L2_games_developer ON (00_L2_games.DeveloperID = 00_L2_games_developer.DeveloperID)
    WHERE `Name` LIKE '%$name_dev%' OR `DevName` LIKE '%$name_dev%'     
    
    ";

    $find_query = mysqli_query($dbconnect, $find_sql);
    $find_rs = mysqli_fetch_assoc($find_query);
    $count = mysqli_num_rows($find_query);
    

?>

        <div class="box main">
            <h2>Name / Developer Results</h2>
            
            
            <?php
            include("results.php"); 
            ?>
            

            
        </div> <!-- / main -->
        
<?php include("bottombit.php")?>
