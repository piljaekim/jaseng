<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <title>엑셀 미리보기</title>
        <style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}
        
	#body {
		margin: 0 15px 0 15px;
	}
        
	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
    </head>
    <body>
        <div id="container">
            <form style="display: block; height: 100%; width: 100%;" method="post" action="/index.php/excel/foreignBrandsDataSave">
                <table style="display: block;width: 100%;" border="1">
                    <tr>
                        <td colspan="5">
                            <input type="submit" value="업로드" style="width: 100%;">
                        </td>
                    </tr>
                    <input type="hidden" name="totalRows" value="<?= $total_rows?>">
                    <?php 
                        $i = 0;
                        $j = 0;
                        $k = 0;
                        foreach ($sheetData_a as $row) { 
                            if($row['A'] == '마드리드'){
                                $k++;
//                                echo $k;
                            }
                            if($row['J'] && $i > 0){
                                
                                $j++;
                            }
                    ?>
                    <tr>
                        <td>
                            <?= $i?>
                        </td>
                        <td>
                            <input type="hidden" name="col_A[]" value="<?=$row['A'] ?>">
                            <?=$row["A"]?>
                        </td>
                        <td>
                            <input type="hidden" name="col_B[]" value="<?=$row['B']?>">
                            <?=$row['B']?>
                        </td>
                        <td>
                            <input type="hidden" name="col_C[]" value="<?=PHPExcel_Style_NumberFormat::toFormattedString($row['C'], "YYYY-mm-dd");?>">
                            <?=PHPExcel_Style_NumberFormat::toFormattedString($row['C'], "YYYY-mm-dd");?>
                        </td>
                        <td>
                            <input type="hidden" name="col_D[]" value="<?= $row['D']?>">
                            <?php if($row['J'] && $i > 0){
//                                echo $k;
//                                echo $j;
                                ?>
                            <input type="hidden" name="col_D1<?= $k?>[]" value="<?=$row['D']?>">
                            <?php }?>
                            <?=$row['D']?>
                        </td>
                        <td>
                            <input type="hidden" name="col_E[]" value="<?=PHPExcel_Style_NumberFormat::toFormattedString($row['E'], "YYYY-mm-dd");?>">
                            <?php if($row['J'] && $i > 0){
//                                echo $k;
//                                echo $j;
                                ?>
                            <input type="hidden" name="col_E1<?= $k?>[]" value="<?=PHPExcel_Style_NumberFormat::toFormattedString($row['E'], "YYYY-mm-dd");?>">
                            <?php }?>
                            <?=PHPExcel_Style_NumberFormat::toFormattedString($row['E'], "YYYY-mm-dd");?>
                        </td>
                        <td>
                            <input type="hidden" name="col_F[]" value="<?=PHPExcel_Style_NumberFormat::toFormattedString($row['F'], "YYYY-mm-dd");?>">
                            <?php if($row['J'] && $i > 0){
//                                echo $k;
//                                echo $j;
                                ?>
                            <input type="hidden" name="col_F1<?= $k?>[]" value="<?=PHPExcel_Style_NumberFormat::toFormattedString($row['F'], "YYYY-mm-dd");?>">
                            <?php }?>
                            <?=PHPExcel_Style_NumberFormat::toFormattedString($row['F'], "YYYY-mm-dd");?>
                        </td>
                        <td>
                            <input type="hidden" name="col_G[]" value="<?= $row['G']?>">
                            <?php if($row['J'] && $i > 0){
//                                echo $k;
//                                echo $j;
                                ?>
                            <input type="hidden" name="col_G1<?= $k?>[]" value="<?=$row['G']?>">
                            <?php }?>
                            <?=$row['G']?>
                        </td>
                        <td>
                            <input type="hidden" name="col_H[]" value="<?= $row['H']?>">
                            <?=$row['H']?>
                        </td>
                        <td>
                            <input type="hidden" name="col_I[]" value="<?= $row['I']?>">
                            <?=$row['I']?>
                        </td>
                        <td>
                            <input type="hidden" name="col_J[]" value="<?=$row['J']?>">
                            <?php if($row['J'] && $i > 0){
//                                echo $k;
//                                echo $j;
                                ?>
                            <input type="hidden" name="col_J1<?= $k?>[]" value="<?=$row['J']?>">
                            <?php }?>
                            <?=$row['J']?>
                        </td>
                        <td>
                            <input type="hidden" name="col_K[]" value="<?= $row['K']?>">
                            <?php if($row['J'] && $i > 0){
//                                echo $k;
//                                echo $j;
                                ?>
                            <input type="hidden" name="col_K1<?= $k?>[]" value="<?=$row['K']?>">
                            <?php }?>
                            <?=$row['K']?>
                        </td>
                        <td>
                            <input type="hidden" name="col_L[]" value="<?= $row['L']?>">
                            <?php if($row['J'] && $i > 0){
//                                echo $k;
//                                echo $j;
                                ?>
                            <input type="hidden" name="col_L1<?= $k?>[]" value="<?=$row['L']?>">
                            <?php }?>
                            <?=$row['L']?>
                        </td>
                    </tr>
                    <?php 
                        $i++;
                    }
                    ?>
                </table>
            </form>
        </div>
    </body>
</html>