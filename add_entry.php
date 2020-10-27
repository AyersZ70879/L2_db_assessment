<?php include("topbit.php");

// Get Genre list from database
$style_sql="SELECT * FROM `00_L2_bands_style` ORDER BY `00_L2_bands_style`.`Style` ASC";
$style_query=mysqli_query($dbconnect, $style_sql);
$style_rs=mysqli_fetch_assoc($style_query);

$style2_sql="SELECT * FROM `00_L2_bands_style2` ORDER BY `00_L2_bands_style2`.`Style2` ASC";
$style2_query=mysqli_query($dbconnect, $style2_sql);
$style2_rs=mysqli_fetch_assoc($style2_query);
 
// Initialise from variables

$band_name = "";
$formed = "";
$styleID = "";
$style2ID = "";
$split = 0;
$countryID = "";
$numfans = "";
$popular = 1;


$has_errors = "no";

// set up error field colours / visibility (no errors at first)
$band_error = $formed_error = $style_error = $style2_error = $country_error = $numfans_error = "no-error";

$band_field = $formed_field = $style_field = $style2_field = $country_field = $numfans_field = "form-ok";

// Code below excutes when the form is submitted...
if($_SERVER["REQUEST_METHOD"] == "POST") {
    
// Get values from the form
    $band_name = mysqli_real_escape_string($dbconnect, $_POST['band_name']);
    $formed = mysqli_real_escape_string($dbconnect, $_POST['formed']);
    
    $styleID = mysqli_real_escape_string($dbconnect, $_POST['styles']);
    $style2ID = mysqli_real_escape_string($dbconnect, $_POST['styles2']);
    $countryID = mysqli_real_escape_string($dbconnect, $_POST['country']);
    
    // if StyleID, is not blank, get genre so that genre box does not lose its value if there is an error
    if ($styleID != "") {
        $styleitem_sql = "SELECT * FROM `00_L2_bands_style` WHERE `StyleID` = $styleID";
        $styleitem_query=mysqli_query($dbconnect, $styleitem_sql);
        $styleitem_rs=mysqli_fetch_assoc($styleitem_query);
        $style = $styleitem_rs['Style'];
        
    } //end styleID if
    
    // Style 2 ID check
    if ($style2ID != "") {
        $style2item_sql = "SELECT * FROM `00_L2_bands_style2` WHERE `Style2ID` = $style2ID";
        $style2item_query=mysqli_query($dbconnect, $style2item_sql);
        $style2item_rs=mysqli_fetch_assoc($style2item_query);
        $style2 = $style2item_rs['Style2'];
        
    } //end style2ID if
    
    // if CountryID, is not blank, get genre so that genre box does not lose its value if there is an error
    if ($countryID != "") {
        $countryitem_sql = "SELECT * FROM `00_L2_bands_country` WHERE `CountryID` = $countryID";
        $countryitem_query=mysqli_query($dbconnect, $countryitem_sql);
        $scountryitem_rs=mysqli_fetch_assoc($countryitem_query);
        $country = $countryitem_rs['Country'];
        
    } //end CountryID if
    
    
    $split = mysqli_real_escape_string($dbconnect, $_POST['split']);
    $numfans = mysqli_real_escape_string($dbconnect, $_POST['numfans']);
    $popular = mysqli_real_escape_string($dbconnect, isset($_POST['popular']));
   
    
    // error checking will go here
    
    // Check Band Name is not blank
    if ($band_name == "") {
        $has_errors = "yes";
        $band_error = "error-text";
        $band_field = "form-error";
    }
    
    // Check formed
    if ($formed == "") {
        $has_errors = "yes";
        $formed_error = "error-text";
        $formed_field = "form-error";
    }
    
    // Check style entry
    if ($styleID == "") {
        $has_errors = "yes";
        $style_error = "error-text";
        $style_field = "form-error";
    }
    
    // Check style2 entry
    if ($style2ID == "") {
        $has_errors = "yes";
        $style2_error = "error-text";
        $style2_field = "form-error";
    }
    
    // Check country entry
    if ($countryID == "") {
        $has_errors = "yes";
        $country_error = "error-text";
        $country_field = "form-error";
    }
 
    // check number of fans is an integer that is more than 0
    if (!ctype_digit($numfans) || $numfans < 1) {
        $has_errors = "yes";
        $count_error = "error-text";
        $count_field = "form-error";
    }
    
    // if there are no errors
    if ($has_errors == "no") {
    
        
            // Go to success page
            header('Location: add_success.php');
        
            // get country ID if it exists
            $country_sql ="SELECT *
FROM `00_L2_bands_country`
WHERE `CountryName` LIKE '$country'";
            $country_query=mysqli_query($dbconnect, $country_sql);
            $country_rs=mysqli_fetch_assoc($country_query);
            $country_count=mysqli_num_rows($country_query);

            // if country not already in country table, add them and get the 'new' countryID
        if ($country_count > 0) {
            $countryID = $country_rs['CountryID'];
        }

        else {
            $add_dev_sql ="INSERT INTO `ayersz70879`.`00_L2_bands_country` (
`CountryID` ,
`CountryName`
)
VALUES (
NULL , '$dev_name'
);";
            $add_dev_query = mysqli_query($dbconnect,$add_dev_sql);

        // Get developer ID
        $newcountry_sql = "SELECT *
FROM `00_L2_bands_country`
WHERE `CountryName` LIKE '$country'";
        $newcountry_query=mysqli_query($dbconnect, $newcountry_sql);
        $newcountry_rs=mysqli_fetch_assoc($newcountry_query);

        $countryID = $newcountry_rs['CountryID'];

        } // end adding country to country table

        // Add entry to database
        $addentry_sql = "INSERT INTO `ayersz70879`.`00_L2_bands` (`ID`, `Name`, `Formed`, `Split`, `Popular`, `CountryID`, `NumFans`, `Style1ID`, Style2ID`) VALUES (NULL, '$band_name', '$formed', '$split', '$popular', '$countryID', '$numfans', '$styleID', '$style2ID');";
        $addentry_query=mysqli_query($dbconnect,$addentry_sql);
    
        // Get ID for next page
        $getid_sql = "SELECT *
FROM `00_L2_bands`
WHERE `Name` LIKE '$band_name'
AND `Formed` LIKE '$formed'
AND `Split` LIKE '$split'
AND `Popular` = $popular
AND `Style1ID` = $styleID
AND `Style2ID` = $style2ID
AND `CountryID` = $countryID

AND `Rating Count` = $rate_count
AND `Price` = $cost
AND `In App` = $in_app
";
        $getid_query=mysqli_query($dbconnect, $getid_sql);
        $getid_rs=mysqli_fetch_assoc($getid_query);
        
        $ID = $getid_rs['ID'];
        $_SESSION['ID']=$ID;
        
    }   // end of 'no errors' if

    
} // end of button submitted code

?>

        <div class="box main">
            <div class="add-entry">
            <h2>Add An Entry</h2>
            
            <form method="post" enctype="multipart/form-data" 
                  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                
                <!-- App Name (Required) -->
                <div class="<?php echo $app_error; ?>">
                    Please fill in the 'App Name' field
                </div>
                
                <input class="add-field <?php echo $app_field; ?>" type="text" name="app_name" value="<?php echo $app_name; ?>" placeholder="App Name (required) ..." />
                
                <br />
                
                <!-- Subtitle (optional) -->
                <input class="add-field" type="text" name="subtitle" value="<?php echo $subtitle; ?>" placeholder="Subtitle (optional) ..." />
                
                <br />
                
                <!-- URL (required, must start http://) -->
                <div class="<?php echo $url_error; ?>">
                    Please enter a valid 'URL' in the field
                </div>
                
                <input class="add-field <?php echo $url_field; ?>" type="text" name="url" value="<?php echo $url; ?>" placeholder="URL (required) ..." />
                
                <br />
                
                <!-- Genre dropdown (required) -->
                <div class="<?php echo $genre_error; ?>">
                    Please choose a 'Genre'
                </div>
                <select class="adv <?php echo $genre_field; ?>" name="genre">
                    <!-- first / selected option -->
                    
                    <?php 
                    if($genreID=="") {
                        ?>
                    <option value="" selected>Genre (Choose something)...</option>
                    
                    <?php
                        
                    }
                    
                    else {
                       ?> 
                    <option value="<?php echo $genreID; ?>" selected><?php echo $genre; ?></option>
                    <?php 
                    }
                    ?>
                    
                    <!-- get options from database -->
                    <?php
                    
                    do {
                        ?>
                    <option value="<?php echo $genre_rs['GenreID']; ?>"><?php echo $genre_rs['Genre']; ?></option>
                    
                    <?php
                    } // end genre do loop
                    while ($genre_rs=mysqli_fetch_assoc($genre_query))
                    ?>
                        
                </select>
                
                <br />
                
                <!-- Developer Name (required) -->
                <div class="<?php echo $dev_error; ?>">
                    Please enter in the 'Developer'
                </div>
                <input class="add-field <?php echo $dev_field; ?>" type="text" name="dev_name" value="<?php echo $dev_name; ?>" placeholder="Developer Name (required) ..." />
                
                <br />
                
                <!-- Age (set to 0 if left blank) -->
                <input class="add-field" type="text" name="age" value="<?php echo $age; ?>" placeholder="Age (0 for all) ..." />
                
                <br />
                
                <!-- Rating (Number between 0-5, 1 dp) -->
                <div class="<?php echo $rating_error; ?>">
                    Please enter a decimal between 1 and 5
                </div>
                <div>
                    <input class="add-field <?php echo $rating_field; ?>" type="text" name="rating" value="<?php echo $rating; ?>" step="0.1" min="0" max="5" placeholder="Rating (0-5)" />
                </div>
                
                
                <!-- # of ratings (integer more than 0) -->
                <div class="<?php echo $count_error; ?>">
                    Please enter a decimal more than 0
                </div>
                <input class="add-field <?php echo $count_field; ?>" type="text" name="count" value="<?php echo $rate_count; ?>" placeholder="# of Ratings ..." />
                
                <br />
                
                
                <!-- Cost (Decimal 2dp, must be more than 0) -->
                <input class="add-field" type="text" name="price" value="<?php echo $cost; ?>" placeholder="Cost (number only) ..." />
                
                <br /><br />
                
                <!-- In App Purchase box -->
                
                <div>
                
                <input class="adv-txt" type="checkbox" name="in_app" value="0">No In App Purchases

                </div>
                
                
                <br /> 
                                
                <!-- Description text area -->
                <div class="<?php echo $description_error; ?>">
                    Please enter a valid 'Description'
                </div>
                <textarea class="add-field <?php echo $description_field; ?>" name="description" placeholder="Description..." rows="6"><?php echo $description; ?></textarea>
                          
                <!-- Submit Button -->
                <p>
                    <input class="submit advanced-button" type="submit" value="Submit" />
                </p>
                
            </form>
  
            </div> <!-- / add-entry -->
        </div> <!-- / main -->
        
<?php include("bottombit.php")?>