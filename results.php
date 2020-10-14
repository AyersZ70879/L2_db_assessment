<?php
            
            if($count < 1) {
              
                ?>
            <div class="error">
            
            Sorry! There are no results that match your search.
            Please use the search box in the side bar to try again.
                
            </div> <!-- end error -->
            
            
            <?php    
            } // end no results if
            else {
                do
                {
                    ?>
            <!-- Results fo here -->
            <div class="results">
                
                <!-- Name -->
                
                <div class="flex_container">
                    <div>
                    
                        <span class="sub_heading">
                            
                            <div>
                            
                                <?php echo $find_rs['Name']; ?> 
                                
                                
                            </div>
                            
                        </span>
                    </div> <!-- /Name -->
                    
                </div>
                <br />
                
                 <!-- Formed / split -->
                
                <div class="flex-container">
                    
                    <b>Formed:</b> <?php echo $find_rs['Formed']; 
                    ?>
                    <!-- Split -->
                    
                    <?php
                    if($find_rs['Split'] > 0) 
                    {
                      ?>
                <i>- (The band has split)</i>
                    
                    <?php
                        } // end of split
                    ?> 
                    
                </div> 
                    
                    
                
                
                <div class="flex-container">
                
                    <b>Country: </b><?php echo $find_rs['CountryName'];?> <br />
                
                    </div> <!-- / country -->

                 <!-- Popular -->
                <?php
                    if($find_rs['Popular'] == 0) 
                    {
                      ?>
                <p>The band is: Popluar 
                    <?php 
                        if($find_rs['Popular'] == 1) 
                        {
                            ?>
                                The band is: Less Known
                            
                           <?php
                           
                        } // end less Popular
                    ?>
                    
                </p>
                <?php
                    }  // end popular
                    ?>
                
                <p>
                    
                <div class="flex-container">    
                <!-- Style -->
                <b>Style/s:</b> 
                    
                    <?php echo $find_rs['Style']; ?>
                      
                    
                    
                    <!-- Style 2 -->
                    
                      <?php                                           
                        if($find_rs['Style2ID'] > 0) 
                        {
                            
                        ?>
                        and <?php
                        echo $find_rs['Style2'];
                            
                            
                        
                    } // end of style 2 if statement
                    ?>
                    
                </div>
                    
                     <br /> 
                Number of Fans: <b><?php echo $find_rs['NumFans'];?></b> and up
                
            </p>
           
                
            </div> <!-- / results -->
            
            <br />
            
            <?php
                } // end results 'do'
                
                while
                    ($find_rs=mysqli_fetch_assoc($find_query));
                
                
            } // end else
            
            
            ?>