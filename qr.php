<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="description" content="HTML5 QR Code Usage Example">
    <script src="./assets/js/jsqrcode-combined.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="./assets/js/html5-qrcode.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#reader').html5_qrcode(function(data){
                    $('#result').html(data);
                },
                function(error){
                    $('#error').html("Scanning...");
                }, function(videoError){
                    $('#error').html("Camera error.");
                }
            );
        });
    </script>
    <title>HTML5 QR code Reader</title>
</head>
<body>
<h1>HTML5 QR Code Reader Usage Example</h1>
<span id="error" style='color:darkred;' class="center"></span>
<div id="reader" style="width:300px;height:250px"></div>
<span id="result" class="center"></span>
</body>
</html>
