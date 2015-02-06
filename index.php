
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
<script>

$(function() {
    function init() {
        $.ajax({
            type: 'POST',
            data: {
                'mode': 'ini',
            },
            url: 'comet.php',
            success: function(data) {
                disp(data);
                start();
            }
        });
    }

    function start() {
        $.ajax({
            type: 'POST',
            data: {
                'mode': 'chkUpd',
            },
            url: 'comet.php',
            success: function(data) {
                disp(data);
                start();
            }
        });
    }

    $('#btn').click(function() {
        var txt = $('#input').val();

        $.ajax({
            type: 'POST',
            data: {
                'mode': 'write',
                'txt': txt,
            },
            url: 'comet.php',
            success: function(data) {
                $('#input').val('');
            }
        });
    });

    $('#drow').click(function() {

        $.ajax({
            type: 'POST',
            data: {
                'mode': 'drow'
            },
            url: 'comet.php',
            success: function(data) {
            }
        });
    });

    $('#shuffle').click(function() {

        $.ajax({
            type: 'POST',
            data: {
                'mode': 'shuffle'
            },
            url: 'comet.php',
            success: function(data) {
            }
        });
    });

    $('#sset').click(function() {

        $.ajax({
            type: 'POST',
            data: {
                'mode': 'sset'
            },
            url: 'comet.php',
            success: function(data) {
            }
        });
    });

    $('#reset').click(function() {

        $.ajax({
            type: 'POST',
            data: {
                'mode': 'reset'
            },
            url: 'comet.php',
            success: function(data) {
                $("#result").html(data);
            }
        });
    });

    function disp(data){
        $("#result").html(data);
        var parseData = JSON.parse( data );
        if("" !== parseData['deck']){
            var arrDeck = parseData['deck'].split(",");
            var deckCnt = arrDeck.length;
        }else{
            var deckCnt = '0';
        }
        if("" !== parseData['shield']){
            var arrShield = parseData['shield'].split(",");
            var shieldCnt = arrShield.length;
        }else{
            var shieldCnt = '0';
        }
        if("" !== parseData['hand']){
            var arrHand = parseData['hand'].split(",");
            var handCnt = arrHand.length;
        }else{
            var handCnt = '0';
        }
        $("#deckCnt").html(deckCnt);
        $("#shieldCnt").html(shieldCnt);
        $("#handCnt").html(handCnt);
        $("#shieldView").html(parseData['shield']);
        $("#handView").html(parseData['hand']);
    }

//     function stop(){
//         $.ajax({
//             type: 'POST',
//             data: {
//                 'mode': 'stop'
//             },
//             url: 'comet.php',
//             success: function(data) {
//             }
//         });
//     }
//     var timerId = setTimeout("location.reload()", 30000);
//     setInterval(stop, 6000);

    init();

});
</script>
</head>
<body>
    <input type="text" name="input" id="input" value="">
    <button id="btn">input</button>
    <p id="result"></p>
    <button id="shuffle">shuffle</button>
    <br>
    <button id="sset">sset</button>
    <br>
    <button id="drow">drow</button>
    <br>
    <button id="reset">reset</button>
    <br> dc:
    <c id="deckCnt"></c>
    <br> sc:
    <c id="shieldCnt"></c>
    <br> hc:
    <c id="handCnt"></c>
    <br> sv:
    <c id="shieldView"></c>
    <br> dv:
    <c id="handView"></c>
    <br>
</body>
</html>