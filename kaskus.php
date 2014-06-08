 <html>
<head>
<link rel="stylesheet" type="text/css" href="default.css" media="screen"/>
<title>Parsing XML</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
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
		<a href="parseweb.php">Hot Thread kaskus.co.id</a>
		<a href="parseweb2.php">Link Menuju Ke nblindonesia.com</a>
		<iframe src="clock.htm" style="border:0;height:30px;position:absolute;right:110px;width:400px;"></iframe>
		<div class="clearer"><span></span></div>
	</div>
	<div class="main">		
		<div class="content">
		<p style="font-size:12pt;">Thread Populer Dari http://kaskus.co.id</p>
		<style>
		{margin: 0; padding: 0;}
ul {
  list-style-type: none;
  width: 400px;
  display: block;
  padding: 0px;
  
  border: 1px solid #f1f1f1;
  -webkit-border-radius: 2px;
     -moz-border-radius: 2px;
          border-radius: 2px;
  -webkit-box-shadow: 0 4px 8px rgba(0, 0, 0, 0.055);
     -moz-box-shadow: 0 4px 8px rgba(0, 0, 0, 0.055);
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.055);
  -webkit-transition: all 0.2s ease-in-out;
     -moz-transition: all 0.2s ease-in-out;
       -o-transition: all 0.2s ease-in-out;
          transition: all 0.2s ease-in-out;
}

h6  {
  font: bold 14px/1.5 Helvetica, Verdana, sans-serif; 
}


li img {
  float: left;
  margin: 0 15px 0 0; 
}


li p {

  font: 200 12px/1.5 Georgia, Times New Roman, serif;

}


li {

  padding: 10px;

  overflow: auto;

  border-bottom:1px dotted #E4E4E4;

  background: #F8F8F8;

}

li:nth-child(odd) { background: #fff; }



li:hover {

  background: #eee;

  cursor: pointer;

}

a{ text-decoration:none; color:#000;

}
		</style>
		<?php
function readHTML($url){
      $data = curl_init();
      curl_setopt($data, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($data, CURLOPT_URL, $url);
      $result = curl_exec($data);
             curl_close($data);
              return $result;
         }
         $codeHTML =  readHTML('http://www.kaskus.co.id/');
         $explode = explode('<ul>', $codeHTML);
         $explodeAgain = explode('</ul>', $explode[1]);
         echo "<ul>".$explodeAgain[0]."</ul>";
         ?>	
		
		</div>
		<div style="width:500px;position:absolute;bottom:0;margin:0;padding:0;color:blue;font-weight:bold;font-size:11px;">
    
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