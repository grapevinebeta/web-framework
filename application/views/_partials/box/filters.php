<div class="box-filters">
    <div class="box-filters-inner">
        <?php foreach($filters as $filter => $label): ?>

        <div class="box-filter-label box-filter-<?php echo $filter ?>-label"><?php echo __($label); ?></div>
        <div class="box-filter box-filter-<?php echo __($filter); ?>"></div>
        <div class="spacer"></div>
        <?php endforeach; ?>
        <div class="clear"></div>
    </div>
    <div class="pager">
        <a href="#">&lt;</a>
        Page <span class="page">1</span> of <span class="pageCount">1</span>
        <a href="#">&gt;</a>
        
    </div>
</div>