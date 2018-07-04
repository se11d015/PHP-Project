<?php

if (isset($_GET["outputtype"])) {
    $outputtype = (int) $_GET["outputtype"];
} else {
    $outputtype = 0;
}

if (isset($_GET["contagion_id"])) {
    $contagion_id = (int) $_GET["contagion_id"];
} else {
    $contagion_id = 0;
}

$i = 0;

$startQuery = "SELECT";
$valueQuery1 = "tgaco.*, taaim.aimag_name_mn, tasou.soum_name_mn,   takn.kingdom_name_mn, tapn.phylum_name_mn, tacn.class_name_mn, tafn.family_name_mn, taon.order_name_mn, tagn.genus_name_mn, tapl.species_name_mn, vas.aimag_name_mn, vas.soum_name_mn  ";
$valueQuery3 = "FROM scadministrative.taaimagname taaim, scadministrative.tasoumname tasou, " . $schemas . ".takingdomname takn," . $schemas . ".taphylumname tapn," . $schemas . ".taclassname tacn," . $schemas . ".tafamilyname tafn," . $schemas . ".taordername taon," . $schemas . ".tagenusname tagn," . $schemas . ".taanimalname tapl," . $schemas . ".tganimalcontagion tgaco, scadministrative.vasoumname vas";
if ($outputtype == 1)
    $valueQuery2 = ", tgaco.geom as geomtext";
if ($outputtype == 2)
    $valueQuery2 = ", st_astext(tgaco.geom) as geomtext";
if ($outputtype == 3)
    $valueQuery2 = ", st_askml(tgaco.geom) as geomtext";



$whereQuery = "WHERE taaim.aimag_code=tgaco.aimag_name AND tasou.soum_code=tgaco.soum_name AND tapl.species_code = tgaco.species_name AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code  AND  tgaco.contagion_id = " . $contagion_id;


$selQuery = $startQuery . " " . $valueQuery1 . " " . $valueQuery2 . " " . $valueQuery3 . " " . $whereQuery;
echo $selQuery;
$row = $db->query($selQuery);
if (!empty($row)) {
    if ($outputtype == 1 || $outputtype == 2) {
        $buffer = "";
        $buffer .= "Ялгах дугаар: " . $row[$i]["contagion_id"] . "\r\n";
        $buffer .= "Зүйлийн нэр: " . $row[$i]["species_name_mn"] . "\r\n";
        $buffer .= "Халдварт өвчин  гарсан огноо: " . $row[$i]["contagion_date"] . "\r\n";
        $buffer .= "Аймаг, хотын нэр: " . $row[$i]["aimag_name_mn"] . "\r\n";
        $buffer .= "Сум, дүүргийн нэр: " . $row[$i]["soum_name_mn"] . "\r\n";
        $buffer .= "Халдварт өвчин  гарсан газрын нэр: " . $row[$i]["place_name"] . "\r\n";
        $buffer .= "Халдварт өвчний нэр: " . $row[$i]["contagion_name"] . "\r\n";
        $buffer .= "Халдварт өвчинд нэрвэгдсэн хүний тоо" . $row[$i]["sick_number"] . "\r\n";
        $buffer .= "Халдварт өвчний улмаас нас барсан тоо " . $row[$i]["dead_number"] . "\r\n";
		$buffer .= "Зарцуулсан зардлын хэмжээ, мян төг: " . $row[$i]["total_expense"] . "\r\n";
		$buffer .= "Нэмэлт мэдээлэл: " . $row[$i]["additional_info"] . "\r\n";
		$buffer .= "Газарзүйн солбицол: ".$row[$i]["geomtext"]."\r\n";

        $filename = "animalcontagionlocation.txt";
        $fullname = "upload/" . $filename;
        $handle = fopen($fullname, "w");
        fputs($handle, $buffer);
        fclose($handle);

        if (file_exists($fullname)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($fullname));
            ob_clean();
            flush();
            readfile($fullname);
            exit;
        }
    }

    if ($outputtype == 3) {
        # Create an array of strings to hold the lines of the KML file.
        $kml = array('<?xml version="1.0" encoding="UTF-8"?>');
        $kml[] = '<kml xmlns="http://earth.google.com/kml/2.1">';
        $kml[] = '<Document>';
        $kml[] = '<Style id="generic">';
        $kml[] = '<IconStyle>';
        $kml[] = '<scale>1.3</scale>';
        $kml[] = '<Icon>';
        $kml[] = '<href>http://maps.google.com/mapfiles/kml/pushpin/red-pushpin.png</href>';
        $kml[] = '</Icon>';
        $kml[] = '<hotSpot x="20" y="2" xunits="pixels" yunits="pixels"/>';
        $kml[] = '</IconStyle>';
        $kml[] = '<LineStyle>';
        $kml[] = '<color>ff0000ff</color>';
        $kml[] = '<width>2</width>';
        $kml[] = '</LineStyle>';
        $kml[] = '<PolyStyle>';
        $kml[] = '<fill>0</fill>';
        $kml[] = '</PolyStyle>';
        $kml[] = '</Style>';


        $kml[] = '<Placemark id="placemark' . $row[$i]["contagion_id"] . '">';
        $kml[] = '<name>' . htmlentities($row[$i]["contagion_id"]) . '</name>';
        $kml[] = '<ExtendedData>';

        $kml[] = '<Data name="Зүйлийн нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["species_name_mn"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Халдварт өвчин  гарсан огноо">';
        $kml[] = '<value><![CDATA[' . $row[$i]["contagion_date"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Аймаг, хотын нэр ">';
        $kml[] = '<value><![CDATA[' . $row[$i]["aimag_name_mn"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Сум, дүүргийн нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["soum_name_mn"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Халдварт өвчин  гарсан газрын нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["place_name"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Халдварт өвчний нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["contagion_name"] . ']]></value>';
        $kml[] = '</Data>';
		$kml[] = '<Data name="Халдварт өвчинд нэрвэгдсэн хүний тоо">';
        $kml[] = '<value><![CDATA[' . $row[$i]["sick_number"] . ']]></value>';
        $kml[] = '</Data>';
		$kml[] = '<Data name="Халдварт өвчинд нэрвэгдсэн хүний тоо">';
        $kml[] = '<value><![CDATA[' . $row[$i]["dead_number"] . ']]></value>';
        $kml[] = '</Data>';
		$kml[] = '<Data name="Халдварт өвчний улмаас нас барсан тоо">';
        $kml[] = '<value><![CDATA[' . $row[$i]["total_expense"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Нэмэлт мэдээлэл">';
        $kml[] = '<value><![CDATA[' . $row[$i]["additional_info"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '</ExtendedData>';
        $kml[] = '<styleUrl>#generic</styleUrl>';
        $kml[] = $row[$i]['geomtext'];
        $kml[] = '</Placemark>';

        $kml[] = '</Document>';
        $kml[] = '</kml>';
        $kmlOutput = join("\n", $kml);

        header('Content-Type: application/vnd.google-earth.kml+xml kml');
        header('Content-Disposition: attachment; filename="animalcontagionlocation.kml"');
        ob_clean();
        flush();
        echo $kmlOutput;
        exit;
    }
} else {
    $notify = "Таны хайсан мэдээлэл байхгүй байна. <a href=\"" . $my_url . $my_page . $search_url . $sort_url . "\">Буцах</a>";
    show_notification("error", "", $notify);
}
?>
