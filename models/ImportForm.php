<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 28.07.17
 * Time: 18:18
 */

namespace app\models;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Import form
 * @property string $file
 */
class ImportForm extends Model
{
    public $file;

    public function rules()
    {
        return [
            ['file', 'file', 'extensions' => ['xls', 'xlsx', 'csv']]
        ];
    }

    public function import(){
        $budget = new Buget();
        $budget->created_at = time();
        $budget->save();
        $sp = IOFactory::load(UploadedFile::getInstance($this, 'file')->tempName);
        $sheet = $sp->getSheetByName('Budget file – EXCEL import');
        $range = $this->_getRange($sheet);
        $margeRanges = [];

        for($r = $range['start_row']; $r <= $range['end_row']; $r++){
            for($c = $range['start_col']; $c <= $range['end_col']; $c++) {
                $cell = $sheet->getCell(chr($c) . $r);
                print_r($cell->getValue());
                preg_match_all('/([A-Z]+)([0-9]+):([A-Z]+)([0-9]+)/i', $cell->getMergeRange(),$marge);
                $col = 1;
                $row = 1;
                if(isset($marge[1][0])){
                    $margeRanges[] = $cell->getMergeRange();
                    $col = (ord($marge[3][0]) - ord($marge[1][0]) + 1);
                    $row = ($marge[4][0] - $marge[2][0] + 1);
                }
                $detail = new BugetDetailes();
                $detail->buget_id = $budget->id;
                $detail->col = chr($c);
                $detail->row = $r;
                $detail->value = $cell->getValue();
                $detail->fill = $cell->getStyle()->getFill()->getStartColor()->getRGB();
                $detail->color = $cell->getStyle()->getFont()->getColor()->getRGB();
                $detail->colspan = $col;
                $detail->rowspan = $row;
                $detail->range = $cell->getMergeRange();
                $detail->save();

            }
        }


//        foreach($sheet->getRowIterator() as $r => $row){
//            foreach($row->getCellIterator() as $c => $cell){
//                    if($cell->getStyle()->getFill()->getStartColor()->getRGB() == '000000'
//                    && $cell->getStyle()->getFont()->getColor()->getRGB() == '000000') continue;
//                    preg_match_all('/([A-Z]+)([0-9]+):([A-Z]+)([0-9]+)/i', $cell->getMergeRange(),$marge);
//                    $col = 1;
//                    $row = 1;
//                    if(isset($marge[1][0])){
//                        $margeRanges[] = $cell->getMergeRange();
//                        $col = (ord($marge[3][0]) - ord($marge[1][0]) + 1);
//                        $row = ($marge[4][0] - $marge[2][0] + 1);
//                    }
//                    $detail = new BugetDetailes();
//                    $detail->buget_id = $budget->id;
//                    $detail->col = $c;
//                    $detail->row = $r;
//                    $detail->value = $cell->getValue();
//                    $detail->fill = $cell->getStyle()->getFill()->getStartColor()->getRGB();
//                    $detail->color = $cell->getStyle()->getFont()->getColor()->getRGB();
//                    $detail->colspan = $col;
//                    $detail->rowspan = $row;
//                    $detail->range = $cell->getMergeRange();
//                    $detail->save();
//
//            }
//        }
    }

    /** 
     * @param Spreadsheet $sheet 
     */
    private function _getRange($sheet){
        $start_row = null;
        $start_col = null;
        $end_row = null;
        $end_col = null;
        foreach($sheet->getRowIterator() as $r => $row){
            foreach($row->getCellIterator() as $c => $cell){
                if($cell->getValue() != ''){
                    if(!$start_row || ($start_row && $start_row > $r)){
                        $start_row = $r;
                    }
                    if(!$end_row || ($end_row && $end_row < $r)){
                        $end_row = $r;
                    }
                    if(!$start_col || ($start_col && $start_col > ord($c))){
                        $start_col = ord($c);
                    }
                    if(!$end_col || ($end_col && $end_col < ord($c))){
                        $end_col = ord($c);
                    }
                }
            }
        }
        return [
            'start_row' => $start_row,
            'start_col' => $start_col,
            'end_row' => $end_row,
            'end_col' => $end_col
        ];
    }

//    public function import(){
//        $sp = IOFactory::load(UploadedFile::getInstance($this, 'file')->tempName);
//        $sheet = $sp->getSheetByName('Budget file – EXCEL import');
//        $margeRanges = [];
//        echo '<table border="1">';
//        foreach($sheet->getRowIterator() as $r => $row){
//            echo '<tr>';
//            foreach($row->getCellIterator() as $c => $cell){
//                //echo $r . ' ' . $c;
//                //echo $cell->getCalculatedValue();
//                if(!in_array($cell->getMergeRange(), $margeRanges)){
//                    preg_match_all('/([A-Z]+)([0-9]+):([A-Z]+)([0-9]+)/i', $cell->getMergeRange(),$marge);
//                    $col = 1;
//                    $row = 1;
//                    if(isset($marge[1][0])){
//                        $margeRanges[] = $cell->getMergeRange();
//                        $col = (ord($marge[3][0]) - ord($marge[1][0]) + 1);
//                        $row = ($marge[4][0] - $marge[2][0] + 1);
//                    }
//                    echo '<td colspan="'.$col.'" rowspan="'.$row.'" style="background-color:'.$cell->getStyle()->getFill()->getStartColor()->getRGB().'; color:'.$cell->getStyle()->getFont()->getColor()->getRGB().'">';
//                    echo $cell->getValue();
//                    //echo $cell->getStyle()->getFont()->getColor()->getRGB();
//                    echo '</td>';
//                }
//            }
//            echo '</tr>';
//        }
//        echo '</table>';
//        die();
//    }


}