<div id="box-competition-score" class="box">
    <?php echo View::factory(
        '_partials/box/header', 
        array(
            'caption' => __('Score and Ranking Details'),
            'buttons' => array('dashboard-pin', 'move', 'show-data'),
            )
        ); 
    ?>
    <div class="box-content">
        <div class="data-grid-holder" style="display: none;">
            <table class="wide data-grid no-outer-border" cellpadding="5">
  
        <thead>  
            <tr>  
                <th scope="col"></th>   
                <th scope="col">Best</th>   
                <th scope="col">Classic</th>   
                <th scope="col">Bryan</th>   
                <th scope="col">Ross Downing</th>   
                <th scope="col">Brian Harris</th>   
                <th scope="col">Mac</th>   
                <th scope="col">Baton Rougue</th>   
            </tr>  
        </thead>  
 
  
        <tbody>  
            <tr>  
                <th>OGSI Score
                    <br />-Rank
                    <br />Growth
                    <br />-Rank
                    
                </th>
                <th>
                    
                    <span class="score"></span>
                    <span class="rank"></span>
                    <span class="growth"></span>
                    <span class="rank"></span>
                    
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>  
            <tr>  
                <th>OGSI Score
                    <br />-Rank
                    <br />Growth
                    <br />-Rank
                    
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>  
            <tr>  
                <th>Ave. Star Rating
                    <br />-Rank
                    <br />Growth
                    <br />-Rank
                    
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>  
            <tr>  
                <th># of Reviews
                    <br />-Rank
                    <br />Growth
                    <br />-Rank
                    
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>  
        </tbody>  
            </table>
        </div>
        
    </div>
</div>