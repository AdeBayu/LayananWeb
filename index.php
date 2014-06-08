<html>
<head>
<link rel="stylesheet" type="text/css" href="default.css" media="screen"/>
<title>Parsing XML</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
     <script type="text/javascript" language="javascript">
    </script>
</head>
<body>
<div class="top">
	<div class="header">
		<div class="left">
			
		</div>
		<div class="right">
		<img style="width:210px;height:150px;" src="img/me.jpg"></img>	
		</div>
	</div>	
</div>
<div class="container">	
	<div class="navigation">
		<a href="index.php">Home</a>
		<a href="kaskus.php">Hot Thread kaskus.co.id</a>
		<a href="nbl.php">Link Menuju ke nblindonesia.com</a>
		
	<iframe src="clock.htm" style="border:0;height:30px;position:absolute;right:110px;width:400px;"></iframe>	
		<div class="clearer"><span></span></div>
	</div>
	<div class="main">		
		<div class="content">
		
		</div>
		<div class="sidenav">
<div id="catalog">
			<h2><span>CUACA</span></h2>
			<?php
  function startElement($parser, $name, $attrs) {
    global $insideitem, $tag, $title, $description, $link, $pubDate;
    if ($insideitem) {
      $tag = $name;
    } elseif ($name == "ITEM") {
      $insideitem = true;
    }
  }
  function endElement($parser, $name) {
    global $insideitem, $tag, $title, $description, $link, $pubDate, $i;
   if (!$i) {
      $i=1;
    }
    if (($name == "ITEM") && ($i<=5)) {
     $i++;
      printf("<h3><a href='%s' class=main target=_blank>%s</a></h3>%s<p>%s</p>",
    trim($link),trim($title), substr($pubDate,0,16), $description);
    $title = "";
    $description = "";
    $link = "";
    $pubDate="";
    $insideitem = false;
  }
}
function characterData($parser, $data) {
  global $insideitem, $tag, $title, $description, $link, $pubDate;
  if ($insideitem) {
    switch ($tag) {
    case "TITLE":
    $title .= $data;
    break;
    case "DESCRIPTION":
    $description .= $data;
    break;
    case "LINK":
    $link .= $data;
    break;
    case "PUBDATE":
    $pubDate .= $data;
    break;
    }
  }
  }
  $insideitem = false;
  $tag = "";
  $title = "";
  $description = "";
  $link = "";
  $pubDate ="";
  $xml_parser = xml_parser_create();
  xml_set_element_handler($xml_parser, "startElement", "endElement");
  xml_set_character_data_handler($xml_parser, "characterData");
  $fp = fopen("http://xml.weather.yahoo.com/forecastrss?w=1048554&u=c","r");
  while ($datarss = fread($fp, 4096))
    xml_parse($xml_parser, $datarss, feof($fp))
  or die(sprintf("XML error: %s pada baris %d",
  xml_error_string(xml_get_error_code($xml_parser)),
  xml_get_current_line_number($xml_parser)));
  fclose($fp);
  xml_parser_free($xml_parser);
?>
		</div>
		</div>
		<div class="clearer"><span></span></div>
	</div>
	<div class="footer">ARI, ADE & FAHMI  &copy;
	</div>
</div>
</body>
</html>