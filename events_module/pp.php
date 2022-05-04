<!DOCTYPE html>
<html>
<head>
	<script src="../assets/js/BrowserPrint.js"></script>
	<script src="../assets/js/DevDemo.js"></script>
</head>
<body>
<input type="button" value="Send File 1" onclick="ss('f1')"><br/><br/>
<!-- <input type="button" value="Send File 1" onclick="sendFile('f1');"><br/><br/> -->
<script>
    function ss(url) {
        sendFile(url);
    }
</script>
</body>
</html>