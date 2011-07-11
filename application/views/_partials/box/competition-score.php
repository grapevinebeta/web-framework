<div id="box-competition-score" class="box">
    <?php echo View::factory(
        '_partials/box/header', 
        array(
            'caption' => __('Score and Ranking Details'),
            'buttons' => array('dashboard-pin', 'move', 'show-data'),
            )
        ); 
    ?>
    <div class="box-filters">
        <div class="box-filters-inner">

            <div class="box-filter box-filter-activity">
                <a filter="ogsi" href="#" class="active">OGSI Score</a>
                <span class="separator">|</span> 
                <a filter="avg-star" href="#" class="active">Ave. Star Rating</a>
                <span class="separator">|</span> 
                <a filter="nb-reviews" href="#" class="active">Number of Reviews</a>
                <div class="spacer"></div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="box-content">
        <div class="data-grid-holder" style="display: none;">
            <table class="wide data-grid no-outer-border" cellpadding="5">

                <thead>  
                    <tr>  
                        <th scope="col"></th>   
                    </tr>  
                </thead>  
                    
                <tbody>
                    <tr class="data ogsi">  
                        <th>
                            <span class="score">OGSI Score</span>
                            <span class="rank">-Rank</span>
                            <span class="growth">Growth</span>
                            <span class="rank">-Rank</span>

                        </th>
                        <th>

                            <span class="score"></span>
                            <span class="rank"></span>
                            <span class="growth"></span>
                            <span class="rank"></span>

                        </th>
                    </tr>  
                    <tr class="data avg-star">  
                        <th>
                            <span class="score">Ave. Star Rating</span>
                            <span class="rank">-Rank</span>
                            <span class="growth">Growth</span>
                            <span class="rank">-Rank</span>
                        </th>
                        <th>

                            <span class="score"></span>
                            <span class="rank"></span>
                            <span class="growth"></span>
                            <span class="rank"></span>

                        </th>
                    </tr>  
                    <tr class="data nb-reviews">  
                        <th>
                            <span class="score"># of Reviews</span>
                            <span class="rank">-Rank</span>
                            <span class="growth">Growth</span>
                            <span class="rank">-Rank</span>
                        </th>
                        <th>
                            <span class="score"></span>
                            <span class="rank"></span>
                            <span class="growth"></span>
                            <span class="rank"></span>
                        </th>
                    </tr>  
                </tbody>  
            </table>
        </div>
        
    </div>
</div>