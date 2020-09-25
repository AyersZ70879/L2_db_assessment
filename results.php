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
                    </div> <!-- /Title -->
                    
                </div>
                <br />
                
                 <!-- Formed / split -->
                
                <div class="flex-container">
                    
                    <b>Formed:</b> <?php echo $find_rs['Formed'];?> 
                    <?php 
                        if($find_rs['Split'] != "0")
                        {
                            
                        ?>
                    <div>
                
                        <b>Split: </b><?php echo $find_rs['Split']; ?>
                            
                    </div> <!-- /split -->
                    
                    <?php
                        }
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
                <p>Popluar 
                    <?php 
                        if($find_rs['Popular'] == 1) 
                        {
                            ?>
                                Less Known
                            
                           <?php
                           
                        } // end less Popular
                    ?>
                    
                </p>
                <?php
                    }  // end popular
                    ?>
                
                <p>
                <!-- Style -->
                <b>Style/s:</b> <?php echo $find_rs['Style'];?> <br />               
                Number of Fans <b><?php echo $find_rs['NumFans'];?></b> and up
                
            </p>
           
                
            </div> <!-- / results -->
            
            <br />
            
            <?php
                } // end results 'do'
                
                while
                    ($find_rs=mysqli_fetch_assoc($find_query));
                
                
            } // end else
            
            
            ?>