<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <title>국가코드관리</title>
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
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" media="all" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#mostUse").hide(0, true);
                $("#canUse").hide(0, true);
                $("#useCheckVal").val("0");
                // Dialog     
                    $('.dialog').dialog({
                     autoOpen: false,
                     width: 330,
                     buttons: {
                      "닫기": function() { 
                       $(this).dialog("close"); 
                      } 
                     }
                    });
            });
            function useCheck() {
                var code = $("#code").val();
                var data = {country_code: code};
                if (!code) {
                    $("#mostUse").hide(0, true);
                    $("#canUse").hide(0, true);
                    $("#useCheckVal").val("0");
                } else {
                    $.ajax({
                        dataType: 'text',
                        //            url: '/inc/data.php',
                        url: '/index.php/countryCode/useCheck',
                        data: data,
                        type: 'POST',
                        success: function (data, status, xhr) {
//                            alert(data);
                            if (data == 'SUCCESS') {
                                $("#canUse").show(true);
                                $("#mostUse").hide(0, true);
                                $("#useCheckVal").val("1");
                            } else {
                                $("#mostUse").show(0, true);
                                $("#canUse").hide(0, true);
                                $("#useCheckVal").val("0");
                            }
                        }
                    });
                }
            }

            function formSubmit() {
                var useCheck = $("#useCheckVal").val();
                if(!$("#code_name").val()){
                    alert("국가명을 입력하세요");
                    return false;
                }
                if (useCheck == '0') {
                    alert("코드를 확인해주세요");
                    return false;
                } else if (useCheck == '1') {
                    document.dataForm.submit();
                }
            }
            
            function openDialog(idx){
                $('#dialog'+idx+'').dialog('open');
                return false;
            }
        </script>
    </head>
    <body>
        <div id="container">
            <a href="/index.php/main" style="cursor: pointer;">메인</a>
            <a href="/index.php/classificationCode" style="cursor: pointer;">분류코드관리</a>
            <a href="/index.php/countryCode" style="cursor: pointer;">국가코드관리</a>
            <a href="/index.php/calendar_lib/index/" style="cursor: pointer;">켈린더</a>
            <a href="/index.php/login/logout" style="cursor: pointer;">로그아웃</a>
            <table style="display: block; margin: 0 35%; text-align: center;" border="1">
                <tr>
                    <td>코드번호</td>
                    <td>국가명</td>
                    <td>데이터수정</td>
                    <td>사용유무</td>
                </tr>
                <?php foreach ($list as $row) { ?>
                <tr>
                        <td><?= $row['COUNTRY_CODE']?></td>
                        <td><?= $row['CODE_NAME']?></td>
                        <td><input type="button" onclick="openDialog(<?= $row['COUNTRY_CODE_IDX']?>);" value="수정"></td>
                        <td>
                            <select id="is_use" name="is_use">
                                <option value="T" <?php if($row['IS_USE']=='T') echo 'selected'?>>사용</option>
                                <option value="F" <?php if($row['IS_USE']=='F') echo 'selected'?>>미사용</option>
                            </select>
                        </td>
                    </tr>
                    <div id="dialog<?= $row['COUNTRY_CODE_IDX']?>" class="dialog" title="<?= $row['CODE_NAME']?>수정">
                        <form name="updateForm" method="post" action="/index.php/countryCode/upDateCodeName">
                            <input type="hidden" name="idx" value="<?= $row['COUNTRY_CODE_IDX']?>">
                            코드이름 <input name="code_name" type="text" value="<?= $row['CODE_NAME']?>" required>
                            <input type="submit" value="수정">
                        </form>
                    </div>
                    <?php }
                ?>
            </table>
            <form name="dataForm" style="display: block; height: 100%; width: 100%;" method="post" action="/index.php/countryCode/saveData">
                <table style="display: block;">
                    <tr>
                        <td style="width: 60px;">
                            국가코드
                        </td>
                        <td>
                            <input type="text" id="code" name="country_code" placeholder="국가코드" onkeyup="useCheck();" maxlength="5" required>
                            <span id="mostUse" style="color: red;">이미 사용중인 코드입니다.</span>
                            <span id="canUse" style="color: blue;">사용가능한 코드입니다.</span>
                            <input type="hidden" id="useCheckVal">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            국가명
                        </td>
                        <td>
                            <input type="text" id="code_name" name="code_name" placeholder="국가명" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="button" value="저장" onclick="formSubmit();" style="width: 100%;">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>