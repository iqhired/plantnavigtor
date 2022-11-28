<script>
    function calcTime(city, offset) {
        d = new Date();
        utc = d.getTime() + (d.getTimezoneOffset() * 60000);
        nd = new Date(utc + (3600000 * offset));
        return nd;
    }
    // Set the date we're counting down to
    var iddd<?php echo $countervariable; ?> = $("#id<?php echo $countervariable; ?>").val();
    console.log(iddd<?php echo $countervariable; ?>);
    var countDownDate<?php echo $countervariable; ?> = new Date(iddd<?php echo $countervariable; ?>).getTime();
    // Update the count down every 1 second
    var x = setInterval(function () {
        // Get today's date and time
        var now = calcTime('Chicago', '-6');
        //new Date().getTime();
        // Find the distance between now and the count down date
        var distance = now - countDownDate<?php echo $countervariable; ?>;
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        //console.log(days + "d " + hours + "h "+ minutes + "m " + seconds + "s ");
        //console.log("------------------------");
        // Output the result in an element with id="demo"
        document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = days + "d " + hours + "h "
            + minutes + "m " + seconds + "s ";
        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = "EXPIRED";
        }
    }, 1000);
</script>