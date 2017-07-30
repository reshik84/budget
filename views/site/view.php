<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\Buget
 */

?>
<table border="1">
    <?php
    $margeRanges = [];
    for($row = $model->start_row; $row <= $model->end_row; $row++): ?>
        <tr data-row="<?= $row ?>">
        <?php for($col = $model->start_col; $col <= $model->end_col; $col++): ?>
            <?php
            $colspan = 1;
            $rowspan = 1;
            $ceil = $model->getDetailsByColRow($col, $row);
            if($ceil) {
                $show = 1;
                if (!in_array($ceil->range, $margeRanges)) {
                    preg_match_all('/([A-Z]+)([0-9]+):([A-Z]+)([0-9]+)/i', $ceil->range, $marge);
                    if (isset($marge[1][0])) {
                        $margeRanges[] = $ceil->range;
                        $colspan = (ord($marge[3][0]) - ord($marge[1][0]) + 1);
                        $rowspan = ($marge[4][0] - $marge[2][0] + 1);
                    }
                } else {
                    $show = 0;
                }
            }
            ?>
            <?php if($ceil && $show): ?>
            <td colspan="<?php echo $colspan; ?>" rowspan="<?php echo $rowspan ?>" style="background-color: #<?php echo $ceil?$ceil->fill:'' ?>; color: #<?php echo $ceil?$ceil->color:'' ?>">
                   <?php echo $ceil->value; ?>
            </td>
            <?php else: ?>
            <?php endif; ?>
        <?php endfor; ?>
        </tr>
    <?php endfor; ?>
</table>
