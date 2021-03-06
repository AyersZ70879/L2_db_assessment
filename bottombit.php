<div class="box side">
    
     <h2><a class="side" href="add_entry.php">Add an App</a> | <a class="side" href="showall.php">Show All</a></h2>
           
            <form class="searchform" method="post" action="band_name.php" enctype="multipart/form-data">
            
                <input class="search" type="text" name="band_name" size="40" value="" required placeholder="Band Name..."/>
               
                <input class="submit" type="submit" name="find_band_name"    value="&#xf002;" />
               
            </form>
            
            
            <br />
            <hr />
            <br />
    
           <div class="advanced-frame">
            
            <h2>Advanced Search</h2>
                
            <form class="searchform" method="post" action="adv_results.php" enctype="multipart/form-data">
            
            <input class="adv" type="text" name="band_name" size="40" value="" placeholder="Band Name"/>
            
                
            <!-- Country  -->
            
            <input class="adv" type="text" name="country" size="40" value="" placeholder="Originating Country"/>  
                
            <!-- Formed -->
            <div class="flex-container">
                
                <div class="adv-text">
                    Formed: 
                </div> <!-- / formed label -->
                
                <div>
                    <input class="adv" type="text" name="formed" size="4" value="" placeholder="Band Formed..."/>
                </div> <!-- / input box -->
                
            </div> <!-- / formed flexbox -->
                
            <!-- Popular Checkbox -->
            <input class="adv-txt" type="checkbox" name="popular" value="0">Popular (Band is well known)
                
            <br />
            <!-- Split Checkbox -->
                
            <input class="adv-txt" type="checkbox" name="split" value="0">Band is still together
                
            <!-- Styles -->
            <div class="flex-container">
                <select class="search adv" name="styles">
                
            <option value="" selected>Styles...</option>
                
            <!-- get option from database -->
                <?php 
                $style_sql="SELECT * FROM `00_L2_bands_style` ORDER BY `00_L2_bands_style`.`Style` ASC ";
                $style_query=mysqli_query($dbconnect, $style_sql);
                $style_rs=mysqli_fetch_assoc($style_query);
                
                do{
                    ?>
                
                <option value="<?php echo $style_rs['Style']; ?>"><?php echo $style_rs['Style']; ?></option>
                
                <?php
                        
                    
                } // end style do loop
                
                while($style_rs=mysqli_fetch_assoc($style_query))
                
                ?>
                
            </select>
                                
            </div> <!-- / style flexbox -->
                
            <!-- Fans -->
            <div class="flex-container">
                <div class="adv-txt">
                # of Fans:
                </div> <!-- / fans label -->
                
                <div>
                    <select class="search adv" name="fans_more_less">
                        <option value="" selected>Choose...</option>
                        <option value="at least">At Least</option>
                        <option value="at most">At Most</option>                    
                    </select>
                </div> <!-- / fans drop down -->
                
                <div>
                    <input class="adv" type="text" name="fans" size="3" value="" placeholder=""/>
                </div> <!-- / fans amount -->
                
                </div> <!-- / fans flexbox --> 
                
            <!-- Search button is below -->
            <input class="submit advanced-button" type="submit" name="advanced" value="Search &nbsp; &#xf002;" />
            
                
            </form>
            
            </div> <!-- / advanced frame -->  

            
        </div> <!-- / side bar -->
        
        <div class="box footer">
            CC Zarah Ayers 2020
        </div> <!-- / footer -->
                
        
    </div> <!-- / wrapper -->
    
            
</body>
