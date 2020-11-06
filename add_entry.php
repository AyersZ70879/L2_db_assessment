<?php include("topbit.php");

// Get style list from database
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
$split = 1;
$country = "";
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
    
    
    $styleID = mysqli_real_escape_string($dbconnect, $_POST['style']);
    $style2ID = mysqli_real_escape_string($dbconnect, $_POST['style2']);
    $country = mysqli_real_escape_string($dbconnect, $_POST['country']);
    
    // if StyleID, is not blank, get style so that style box does not lose its value if there is an error
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
    
    
    $numfans = mysqli_real_escape_string($dbconnect, $_POST['numfans']);
    $split = mysqli_real_escape_string($dbconnect, $_POST['split']);
    $popular = mysqli_real_escape_string($dbconnect, $_POST['popular']);
   
    
    // error checking will go here
    
    // Check Band Name is not blank
    if ($band_name == "") {
        $has_errors = "yes";
        $band_error = "error-text";
        $band_field = "form-error";
    }
    
    // check formed is an integer that is more than 0
    if (!ctype_digit($formed) || $formed < 1) {
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

    // Check country entry
    if ($country == "") {
        $has_errors = "yes";
        $country_error = "error-text";
        $country_field = "form-error";
    }
 
    // check number of fans is an integer that is more than 0
    if (!ctype_digit($numfans) || $numfans < 1) {
        $has_errors = "yes";
        $numfans_error = "error-text";
        $numfans_field = "form-error";
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
            $add_country_sql ="INSERT INTO `ayersz70879`.`00_L2_bands_country` (
`CountryID` ,
`CountryName`
)
VALUES (
NULL , '$country'
);";
            $add_country_query = mysqli_query($dbconnect,$add_country_sql);

        // Get developer ID
        $newcountry_sql = "SELECT *
FROM `00_L2_bands_country`
WHERE `CountryName` LIKE '$country'";
        $newcountry_query=mysqli_query($dbconnect, $newcountry_sql);
        $newcountry_rs=mysqli_fetch_assoc($newcountry_query);

        $countryID = $newcountry_rs['CountryID'];

        } // end adding country to country table

        
        // Add entry to database
        $addentry_sql = "INSERT INTO `ayersz70879`.`00_L2_bands`(`ID`, `Name`, `Formed`, `Split`, `Popular`, `CountryID`, `NumFans`, `Style1ID`, `Style2ID`) VALUES (NULL, '$band_name', '$formed', '$split', '$popular', '$countryID', '$numfans', '$styleID', '$style2ID');";
        
        $addentry_query=mysqli_query($dbconnect,$addentry_sql);
    
        // Get ID for next page
        $getid_sql = "SELECT *
FROM `00_L2_bands`
WHERE `Name` LIKE '%a%'
ORDER BY `00_L2_bands`.`ID` DESC

";
        $getid_query=mysqli_query($dbconnect, $getid_sql);
        $getid_rs=mysqli_fetch_assoc($getid_query);
        
        $ID = $getid_rs['ID'];
        $_SESSION['ID']=$ID;
        echo "ID: ".$ID;
        
    }   // end of 'no errors' if

    
} // end of button submitted code

?>

        <div class="box main">
            <div class="add-entry">
            <h2>Add An Entry</h2>
            
            <form method="post" enctype="multipart/form-data" 
                  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                
                <!-- Band Name (Required) -->
                <div class="<?php echo $band_error; ?>">
                    Please fill in the 'Band Name' field
                </div>
                
                <input class="add-field <?php echo $band_field; ?>" type="text" name="band_name" value="<?php echo $band_name; ?>" placeholder="Band Name (required) ..." />
                
                <br />
                
                <!-- Formed -->
                <div class="<?php echo $formed_error; ?>">
                    Please fill in the 'Formed' with a decimal more than 0
                </div>
                
                <input class="add-field <?php echo $formed_field; ?>" type="text" name="formed" value="<?php echo $formed; ?>" placeholder="Formed (required) ..." />
                
                <br />
                
                
                <!-- Style dropdown (required) -->
                <div class="<?php echo $style_error; ?>">
                    Please choose a 'Style'
                </div>
                <select class="adv <?php echo $style_field; ?>" name="style">
                    <!-- first / selected option -->
                    
                    <?php 
                    if($styleID=="") {
                        ?>
                    <option value="" selected>Style (Choose something)...</option>
                    
                    <?php
                        
                    }
                    
                    else {
                       ?> 
                    <option value="<?php echo $styleID; ?>" selected><?php echo $style; ?></option>
                    <?php 
                    }
                    ?>
                    
                    <!-- get options from database -->
                    <?php
                    
                    do {
                        ?>
                    <option value="<?php echo $style_rs['StyleID']; ?>"><?php echo $style_rs['Style']; ?></option>
                    
                    <?php
                    } // end style do loop
                    while ($style_rs=mysqli_fetch_assoc($style_query))
                    ?>
                        
                </select>
                
                <br />
                
                <!-- Style 2 dropdown (required) -->
                <select class="adv <?php echo $style2_field; ?>" name="style2">
                    <!-- first / selected option -->
                    
                    <?php 
                    if($style2ID=="") {
                        ?>
                    <option value="" selected>2nd Style (Choose something)...</option>
                    
                    <?php
                        
                    }
                    
                    else {
                       ?> 
                    <option value="<?php echo $style2ID; ?>" selected><?php echo $style2; ?></option>
                    <?php 
                    }
                    ?>
                    
                    <!-- get options from database -->
                    <?php
                    
                    do {
                        ?>
                    <option value="<?php echo $style2_rs['Style2ID']; ?>"><?php echo $style2_rs['Style2']; ?></option>
                    
                    <?php
                    } // end style2 do loop
                    while ($style2_rs=mysqli_fetch_assoc($style2_query))
                    ?>
                        
                </select>
                
                <br />
                
                
                <!-- Country (required) -->
                <div class="<?php echo $country_error; ?>">
                    Please enter in the 'Country'
                </div>
                <input class="add-field <?php echo $country_field; ?>" type="text" name="country" value="<?php echo $country; ?>" placeholder="Originating Country (required)..." />
                
                <br />
                
                
                <!-- # of fans (integer more than 0) -->
                <div class="<?php echo $numfans_error; ?>">
                    Please enter a decimal more than 0
                </div>
                <input class="add-field <?php echo $numfans_field; ?>" type="text" name="numfans" value="<?php echo $numfans; ?>" placeholder="# of Fans ..." />
                
                
                
                <br /><br />
                
                <!-- Popular box -->
                
                <div>
                <input type="hidden" name="popular" value="1" />
                <input class="adv-txt" type="checkbox" name="popular" value="0">Band is popular (well known)

                </div>
                
                <!-- Split box -->
                
                <div>
                
                <input type="hidden" name="split" value="1" />
                <input class="adv-txt" type="checkbox" name="split" value="0">Band is still together

                </div>
                
                                      
                <!-- Submit Button -->
                <p>
                    <input class="submit advanced-button" type="submit" value="Submit" />
                </p>
                
            </form>
  
            </div> <!-- / add-entry -->
        </div> <!-- / main -->
        
<?php include("bottombit.php")?>