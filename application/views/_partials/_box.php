<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Parameters passed to this view:
 *  - $caption (required) - the name of the box
 *  - $data (optional) - array with two arrays ('headers' and 'rows'),
 *      containing strings for headers and data for each row,
 */

?>

<div class="box-header">
    <div class="box-header-right-buttons">
        <a class="box-header-button-show-graph" href="#" title="Close">g</a>
        <a class="box-header-button-dashboard-pin" href="#" title="Close">p</a>
    </div>
    <div class="box-header-left-buttons">
        <a class="box-header-button-move" href="#" title="Move">m</a>
    </div>
    <?php echo $caption; ?>:
</div>
<div class="box-content padding-5">
    <div class="data-grid-holder" style="display: none;">
        <table class="wide data-grid">
            <?php if (Arr::get($data, 'headers') !== null && count(Arr::get($data, 'headers')) > 0): ?>
                <thead>
                    <tr>
                        <?php
                            $_counter = 0;
                            foreach (Arr::get($data, 'headers') as $header_title) {
                                echo '<th class="column-' . ++$_counter . '">' . $header_title . '</th>';
                            };
                        ?>
                    </tr>
                </thead>
            <?php endif; ?>
            <tfoot>
                <tr>
                    <th class="a-left"><?php echo __('Total'); ?></td>
                    <th class="col-total a-center"></td>
                    <th class="col-positive a-center"></td>
                    <th class="col-neutral a-center"></td>
                    <th class="col-negative a-center"></td>
                    <th class="col-average a-center"></td>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td class="col-site"></td>
                    <td class="col-total a-center"></td>
                    <td class="col-positive a-center"></td>
                    <td class="col-neutral a-center"></td>
                    <td class="col-negative a-center"></td>
                    <td class="col-average a-center"></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="graph-holder"></div>
</div>