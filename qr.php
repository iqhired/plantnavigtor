<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<div id="reader" style="width: 500px"></div>
<div id="container" style="width: 600px"></div>
<script>
    const html5QrCode = new Html5Qrcode("reader");
    const qrCodeSuccessCallback = (decodedText, decodedResult) => {
        document.getElementById('container').textContent = decodedText;
        /* handle success */
    };
    const config = { fps: 10, qrbox: { width: 250, height: 250 } ,supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]};

    // If you want to prefer back camera
    html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);

</script>