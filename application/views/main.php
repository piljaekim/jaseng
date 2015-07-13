<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <title>메인</title>
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
		margin: 25% 0;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
    </head>
    <body>
        <div id="container">
            <a href="/index.php/main" style="cursor: pointer;">메인</a>
            <a href="/index.php/classificationCode" style="cursor: pointer;">분류코드관리</a>
            <a href="/index.php/countryCode" style="cursor: pointer;">국가코드관리</a>
            <form style="display: block; height: 100%; width: 100%;" method="post" enctype="multipart/form-data" action="/index.php/excel/videoDataLoadExcel">
                <table style="display: block; margin: 0 35%;">
                    <tr>
                        <td>
                            영상제작 목록 업로드..
                        </td>
                        <td>
                            <input type="file" name="videoExcelUpFile">
                        </td>
                        <td>
                            <input type="submit" value="미리보기">
                        </td>
                    </tr>
                </table>
            </form>
            <form style="display: block; height: 100%; width: 100%;" method="post" enctype="multipart/form-data" action="/index.php/excel/donationDataLoadExcel">
                <table style="display: block; margin: 0 35%;">
                    <tr>
                        <td>
                            기부내역 목록 업로드
                        </td>
                        <td>
                            <input type="file" name="donationExcelUpFile">
                        </td>
                        <td>
                            <input type="submit" value="미리보기">
                        </td>
                    </tr>
                </table>
            </form>
            <form style="display: block; height: 100%; width: 100%;" method="post" enctype="multipart/form-data" action="/index.php/excel/korPatentDataLoadExcel">
                <table style="display: block; margin: 0 35%;">
                    <tr>
                        <td>
                            국내특허 목록 업로드
                        </td>
                        <td>
                            <input type="file" name="korPatentExcelUpFile">
                        </td>
                        <td>
                            <input type="submit" value="미리보기">
                        </td>
                    </tr>
                </table>
            </form>
            <form style="display: block; height: 100%; width: 100%;" method="post" enctype="multipart/form-data" action="/index.php/excel/domesticBrandsDataLoadExcel">
                <table style="display: block; margin: 0 35%;">
                    <tr>
                        <td>
                            국내상표 목록 업로드
                        </td>
                        <td>
                            <input type="file" name="domesticBrandsExcelUpFile">
                        </td>
                        <td>
                            <input type="submit" value="미리보기">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>