<?php include("topbit.php");

    $band_name = mysqli_real_escape_string($dbconnect, $_POST['band_name']);
    $country = mysqli_real_escape_string($dbconnect, $_POST['country']);
    $style = mysqli_real_escape_string($dbconnect, $_POST['styles']);
    $formed = mysqli_real_escape_string($dbconnect, $_POST['formed']);
   

    // Popular
    if (isset($_POST['popular'])) {
        $popular = 0;
    }
    
    else {
        $popular = 1;
    }

// Split
    if (isset($_POST['split'])) {
        $split = 0;
    }
    
    else {
        $split = 1;
    }

   // # of Fans
    $fans_more_less = mysqli_real_escape_string($dbconnect, $_POST['fans_more_less']);
    $fans = mysqli_real_escape_string($dbconnect, $_POST['fans']);

    if ($fans == "") {$fans = 0;
              $fans_more_less = "at least";} // Set fans to 0 if it is blank
    

    if($fans_more_less == "at most") {
       $fans_op = "<=";
    }

    else {
        $fans_op = ">=";
        
        
    } // end fans if / elseif / else


     $find_sql = "SELECT *
    FROM `00_L2_bands`
    JOIN 00_L2_bands_country ON (00_L2_bands.CountryID = 00_L2_bands_country.CountryID)
    JOIN 00_L2_bands_style ON (00_L2_bands.Style1ID  = 00_L2_bands_style.StyleID)
    JOIN 00_L2_bands_style2 ON (00_L2_bands.Style2ID  = 00_L2_bands_style2.StyleID)
    WHERE `Name` LIKE '%$band_name%'     
    AND `CountryName` LIKE '%$country%'
    AND `Formed` LIKE '%$formed%'
    AND `Split` LIKE  '%$split%'
    AND (`Popular` = $popular OR `Popular` = 0)
    AND `NumFans` $fans_op $fans
    AND `Style` LIKE '%$style%'
    
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


