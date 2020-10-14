<?php include("topbit.php");

    $band_name = $_POST['band_name'];

    $find_sql = "SELECT *
    FROM `00_L2_bands`
    JOIN 00_L2_bands_country ON (00_L2_bands.CountryID = 00_L2_bands_country.CountryID)
    JOIN 00_L2_bands_style ON (00_L2_bands.Style1ID  = 00_L2_bands_style.StyleID)
    JOIN 00_L2_bands_style2 ON (00_L2_bands.Style2ID  = 00_L2_bands_style2.StyleID)
    WHERE `Name` LIKE '%$band_name%'     
    
    ";

    $find_query = mysqli_query($dbconnect, $find_sql);
    $find_rs = mysqli_fetch_assoc($find_query);
    $count = mysqli_num_rows($find_query);
    

?>

        <div class="box main">
            <h2>Band Name Results</h2>
            
            
            <?php
            include("results.php"); 
            ?>
            

            
        </div> <!-- / main -->
        
<?php include("bottombit.php")?>
