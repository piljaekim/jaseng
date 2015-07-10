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
            <form style="display: block; height: 100%; width: 100%;" method="post" action="/index.php/excel/donationDataSave">
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
                            <input type="hidden" name="col_A[]" value="<?= PHPExcel_Style_NumberFormat::toFormattedString($row['A'], "YYYY-mm-dd"); ?>">
                            <?= PHPExcel_Style_NumberFormat::toFormattedString($row["A"], "YYYY-mm-dd");?>
                        </td>
                        <td>
                            <input type="hidden" name="col_B[]" value="<?= $row['B']?>">
                            <?=$row['B']?>
                        </td>
                        <td>
                            <input type="hidden" name="col_C[]" value="<?= $row['C']?>">
                            <?=$row['C']?>
                        </td>
                        <td>
                            <input type="hidden" name="col_D[]" value="<?= $row['D']?>">
                            <?php if($i != 0){?>
                            <?=number_format($row['D']); ?>
                            <?php } ?>
                        </td>
                        <td>
                            <input type="hidden" name="col_E[]" value="<?= $row['E']?>">
                            <?=$row['E']?>
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