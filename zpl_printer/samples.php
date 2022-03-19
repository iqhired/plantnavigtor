<?php
  ob_start();
  
  $title = 'WebClientPrint for PHP Samples';
?>

<h2>Available Samples</h2>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <h2>
                    <a href="DemoPrintCommands.php"><i class="icon fa fa-barcode"></i>&nbsp;Raw Data Printing</a>
                </h2>
                <p>
                    Send any <strong>raw data &amp; commands</strong> supported by the client printer like <strong>Epson ESC/POS, HP PCL, PostScript, Zebra ZPL and Eltron EPL, and more!</strong>
                </p>
            </div>

        </div>

    </div>


<?php
  $content = ob_get_contents();
  ob_clean();
  
  include("template.php");
?>

