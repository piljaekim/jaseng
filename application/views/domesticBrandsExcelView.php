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
            <form style="display: block; height: 100%; width: 100%;" method="post" action="/index.php/excel/domesticBrandsDataSave">
                <table style="display: block;width: 100%;" border="1">
                    <tr>
                        <td colspan="5">
                            <input type="submit" value="업로드" style="width: 100%;">
                        </td>
                    </tr>
                    <input type="hidden" name="totalRows" value="<?= $total_rows?>">
                    <?php 
                        $i = 0;
                        foreach ($sheetData_a as $row) { 
                    ?>
                    <tr>
                        <td>
                            <?= $i?>
                        </td>
                        <td>
                            <input type="hidden" name="col_A[][]" value="<?=$row['A'] ?>">
                            <?php if($row['A']){?>
                            <input type="hidden" name="col_A1[]" value="<?=$row['A'] ?>">
                            <?php }?>
                            <?=$row["A"]?>
                        </td>
                        <td>
                            <input type="hidden" name="col_B[]" value="<?= PHPExcel_Style_NumberFormat::toFormattedString($row['B'], "YYYY-mm-dd");?>">
                            <?=PHPExcel_Style_NumberFormat::toFormattedString($row['B'], "YYYY-mm-dd");?>
                        </td>
                        <td>
                            <input type="hidden" name="col_C[]" value="<?= $row['C']?>">
                            <?=$row['C']?>
                        </td>
                        <td>
                            <input type="hidden" name="col_D[]" value="<?= $row['D']?>">
                            <?=$row['D']; ?>
                        </td>
                        <td>
                            <input type="hidden" name="col_E[]" value="<?= $row['E']?>">
                            <?=$row['E']?>
                        </td>
                        <td>
                            <input type="hidden" name="col_F[]" value="<?= $row['F']?>">
                            <?=$row['F']?>
                        </td>
                        <td>
                            <input type="hidden" name="col_G[]" value="<?= $row['G']?>">
                            <?=$row['G']?>
                        </td>
                        <td>
                            <input type="hidden" name="col_H[]" value="<?= $row['H']?>">
                            <?=$row['H']?>
                        </td>
                        <td>
                            <input type="hidden" name="col_I[]" value="<?= PHPExcel_Style_NumberFormat::toFormattedString($row['I'], "YYYY-mm-dd");?>">
                            <?=PHPExcel_Style_NumberFormat::toFormattedString($row['I'], "YYYY-mm-dd");?>
                        </td>
                        <td>
                            <input type="hidden" name="col_J[]" value="<?= PHPExcel_Style_NumberFormat::toFormattedString($row['J'], "YYYY-mm-dd");?>">
                            <?=PHPExcel_Style_NumberFormat::toFormattedString($row['J'], "YYYY-mm-dd");?>
                        </td>
                        <td>
                            <input type="hidden" name="col_K[]" value="<?= $row['K']?>">
                            <?=$row['K']?>
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