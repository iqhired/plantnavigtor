<!DOCTYPE html>
<html>
<head>
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <script src="<?php echo $siteURL; ?>/assets/js/BrowserPrint-3.0.216.min.js"></script>
    <script src="<?php echo $siteURL; ?>/assets/js/BrowserPrint-Zebra-1.0.216.min.js"></script>
</head>
<body>
<script>
    function ss(url) {
        send(url);
        // sendFile(url);
    }
    function ss1(url,cnt) {
        for(var i = 1; i <= cnt; i++) {
            send(url);
            // sendFile(url);
        }
    }
</script>
</body>
</html>