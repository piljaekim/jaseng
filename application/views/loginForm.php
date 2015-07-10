<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <title>로그인</title>
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
            <form style="display: block; height: 100%; width: 100%;" method="post" action="/index.php/Login_ok/loginOk">
                <table style="display: block; margin: 0 35%;">
                    <tr>
                        <td>
                            <input type="text" name="id" value="" placeholder="아이디">
                        </td>
                        <td rowspan="2">
                            <input type="submit" value="로그인" style="width: 100%; height: 100%;">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" name="pwd" value="" placeholder="비밀번호">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>