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