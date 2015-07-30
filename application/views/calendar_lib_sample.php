<!DOCTYPE html>
<html lang="ko">
    <head>
        <title>달력</title>
        <meta charset="UFT-8">
        <style type="text/css">
            .calendar{
                font-family: Arial;
                font-size: 12px;
            }
            table.calendar{
                margin: auto;
                border-collapse: collapse;
            }

            .calendar .days td {
                width: 80px;
                height: 80px;
                padding: 4px;
                border: 1px solid #999;
                vertical-align: top;
                background-color: #DEF;
            }

            .calendar .days td:hover{
                background-color: #FFF;
            }

            .calendar .highlight {
                font-weight: bold;
                color: #00F;
            }
        </style>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" media="all" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
    </head>
    <body>
        <a href="/index.php/main" style="cursor: pointer;">메인</a>
        <a href="/index.php/classificationCode" style="cursor: pointer;">분류코드관리</a>
        <a href="/index.php/countryCode" style="cursor: pointer;">국가코드관리</a>
        <a href="/index.php/calendar_lib/index/" style="cursor: pointer;">켈린더</a>
        <a href="/index.php/login/logout" style="cursor: pointer;">로그아웃</a>
        <?php echo $calender ?>
        <table class="calendar" style="margin-top: 10px;">
            <tr>
                <td>
                    날짜
                </td>
                <td>
                    <input type="text" id="date" name="date" placeholder="날짜선택" readonly>
                </td>
            </tr>
            <tr>
                <td>
                    일정입력
                </td>
                <td>
                    <input type="text" id="contents" name="contents" placeholder="일정입력">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="button" id="submitBtn" value="저장">
                </td>
            </tr>
        </table>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#date").datepicker({
                    dateFormat: 'yy-mm-dd',
                    prevText: '이전 달',
                    nextText: '다음 달',
                    monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                    monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                    dayNames: ['일', '월', '화', '수', '목', '금', '토'],
                    dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
                    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
                    showMonthAfterYear: true,
                    changeMonth: true,
                    changeYear: true,
                    yearSuffix: '년'
                });
                
                $('#contents').keydown(function () {
                    var date = $("#date").val();
                    var contents = $("#contents").val();
                    var data = {date: date, contents: contents};
                    if (!date) {
                        alert("날짜를 선택해주세요.");
                        $("#date").focus();
                        return false;
                    }
                    if (!contents) {
                        alert("일정을 입력해주세요");
                        $("#contents").focus();
                        return false;
                    }
                    if (date && contents) {
                        $.ajax({
                            dataType: 'text',
                            url: '/index.php/calendar_lib/saveContents',
                            data: data,
                            type: 'POST',
                            success: function (data, status, xhr) {
                                if (data == "SUCCESS") {
                                    alert("일정등록 되었습니다.");
                                    $("#date").val("");
                                    $("#contents").val("");
                                    location.reload();
                                } else {
                                    alert("데이터 처리오류.");
                                }
                            }
                        });
                    }
                });

                $('#submitBtn').click(function () {
                    var date = $("#date").val();
                    var contents = $("#contents").val();
                    var data = {date: date, contents: contents};
                    if (!date) {
                        alert("날짜를 선택해주세요.");
                        $("#date").focus();
                        return false;
                    }
                    if (!contents) {
                        alert("일정을 입력해주세요");
                        $("#contents").focus();
                        return false;
                    }
                    if (date && contents) {
                        $.ajax({
                            dataType: 'text',
                            url: '/index.php/calendar_lib/saveContents',
                            data: data,
                            type: 'POST',
                            success: function (data, status, xhr) {
                                if (data == "SUCCESS") {
                                    alert("일정등록 되었습니다.");
                                    $("#date").val("");
                                    $("#contents").val("");
                                    location.reload();
                                } else {
                                    alert("데이터 처리오류.");
                                }
                            }
                        });
                    }
                });

                $('.calendar .day').click(function () {
                    var day_num = $(this).find('.day_num').html();
                    var day_data = prompt('일정을 입력하세요', $(this).find('.content').html());
                    var data = {day: day_num, data: day_data};
                    if (day_data != null) {
                        $.ajax({
                            url: window.location,
                            type: 'POST',
                            data: data,
                            success: function (msg) {
                                location.reload();
                            }
                        });
                    }
                });
            });
        </script>
    </body>
</html>