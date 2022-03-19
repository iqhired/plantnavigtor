<?php

// converter need absolute path to html file for conversion
// enter your path here

//$GLOBALS['url'] = "http://www.anychart.com/products/anychart/saveas/pdf/";

ob_start();

if (!isset($_POST['file'])) exit;

// creates random file name for the temp image file

function getRandomFileName($folder = "temp/", $ext = ".jpg") {
  $rnd = mt_rand();
  if (file_exists($rnd.$ext)) return getRandomFileName($folder, $ext);
  return $rnd.$ext;
	}

$pictureFileName = getRandomFileName("temp/", '.'.(isset($_POST['fileType']) && $_POST['fileType'] == 'png' ? 'png' : 'jpg'));

// saves temp file

$f = fopen('converterCore/temp/'.$pictureFileName,"wb");
fwrite($f, base64_decode($_POST['file']));
fclose($f);


// creates and saves temp html file
$htmlFileName = getRandomFileName("converterCore/temp/", '.tmp');

$fp = fopen("converterCore/temp/".$htmlFileName, 'x');
fwrite($fp, '<html><body><img src="'.$pictureFileName.'"'
	.($_POST['imageWidth']?' width="'.$_POST['imageWidth'].'"':'')
	.($_POST['imageHeight']?' height="'.$_POST['imageHeight'].'"':'')
	.'></body></html>');
fclose($fp);

require_once('config.php');

// converter need absolute path to html file for conversion

$url = $GLOBALS['url'];
$fileName = urlencode($url."converterCore/temp/".$htmlFileName);

ob_end_clean();

// convert temp html with image and output pdf
// look through converter docs at converterCore/help/index.html
// to learn about converter parameters
header("location: ".$url."converterCore/html2ps.php?process_mode=single&URL=".$fileName."&proxy=&pixels=1024&scalepoints=1&renderimages=1&renderlinks=1&renderfields=1&media=Letter&cssmedia=Screen&leftmargin=15&rightmargin=15&topmargin=15&bottommargin=15&encoding=&headerhtml=&footerhtml=&watermarkhtml=&toc-location=before&smartpagebreak=1&pslevel=3&method=fpdf&pdfversion=1.3&output=0&convert=Convert+File&toKill1=".$pictureFileName."&toKill2=".$htmlFileName);

?>