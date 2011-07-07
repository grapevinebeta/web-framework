<div class="box-filters">
    <div class="box-filters-inner">
        <?php foreach($filters as $filter => $label): ?>

        <div class="box-filter-label box-filter-<?php echo $filter ?>-label"><?php echo __($label); ?></div>
        <div class="box-filter box-filter-<?php echo __($filter); ?>"></div>
        <div class="spacer"></div>
        <?php endforeach; ?>
        <div class="clear"></div>
    </div>
</div>
<?php if(isset($has_pager)): ?>
<div class="box-pager">
    <a class="prev" href="#">&lt;</a>
    Page <span class="page">1</span> of <span class="pageCount">1</span>
    <a class="next" href="#">&gt;</a>
</div>
<?php endif; ?>