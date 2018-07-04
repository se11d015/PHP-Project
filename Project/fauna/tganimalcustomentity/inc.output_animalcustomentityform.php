<?php

if (isset($_GET["outputtype"])) {
    $outputtype = (int) $_GET["outputtype"];
} else {
    $outputtype = 0;
}

if (isset($_GET["entity_id"])) {
    $entity_id = (int) $_GET["entity_id"];
} else {
    $entity_id = 0;
}

$i = 0;
$startQuery = "SELECT";
$valueQuery1 = "tgcen.*, taaim.aimag_name_mn, tasou.soum_name_mn ";
$valueQuery3 = "FROM ".$schemas.".tganimalcustomentity tgcen, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou ";
if ($outputtype == 1)
    $valueQuery2 = ", tgcen.geom as geomtext";
if ($outputtype == 2)
    $valueQuery2 = ", st_astext(tgcen.geom) as geomtext";
if ($outputtype == 3)
    $valueQuery2 = ", st_askml(tgcen.geom) as geomtext";
$whereQuery = "WHERE tgcen.entity_id =".$entity_id."  AND taaim.aimag_code=tgcen.aimag_name  AND tasou.soum_code=tgcen.soum_name";
$selQuery = $startQuery . " " . $valueQuery1 . " " . $valueQuery2 . " " . $valueQuery3 . " " . $whereQuery;
echo $selQuery;
$row = $db->query($selQuery);
if (!empty($row)) {
    if ($outputtype == 1 || $outputtype == 2) {



        $buffer = "";
		$buffer .= "Ялгах дугаар: " . $row[$i]["entity_id"] . "\r\n";
		$buffer .= "Аймаг, хотын нэр: " . $row[$i]["aimag_name_mn"] . "\r\n";
        $buffer .= "Сум, дүүргийн нэр: " . $row[$i]["soum_name_mn"] . "\r\n";
        $buffer .= "Хуулийн этгээдийн төрөл: " . getdata($CUSTOM_ENTITY_TYPE, $row[$i]["entity_type"]) . "\r\n";
        $buffer .= "Экспортлогч, импортлогчийн нэр: " . $row[$i]["entity_name"] . "\r\n";
        $buffer .= "Pегистрийн дугаар: " . $row[$i]["register_number"] . "\r\n";
        
        $buffer .= "Байршлын хаяг: " . $row[$i]["location_address"] . "\r\n";
        $buffer .= "Утасны дугаар: " . $row[$i]["tel_number"] . "\r\n";
		$buffer .= "Факсын дугаар: " . $row[$i]["fax_number"] . "\r\n";
        $buffer .= "Имэйл: " . $row[$i]["email_address"] . "\r\n";
		$buffer .= "Вэб хаяг: " . $row[$i]["web_address"] . "\r\n";
        $buffer .= "Шуудангийн хаяг: " . $row[$i]["postal_address"] . "\r\n";
        $buffer .= "Газарзүйн солбицол: " . $row[$i]["geomtext"] . "\r\n";

        $filename = "animalcustomentity.txt";
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


        $kml[] = '<Placemark id="placemark' . $row[$i]["picture_id"] . '">';
        $kml[] = '<name>' . htmlentities($row[$i]["picture_id"]) . '</name>';
        $kml[] = '<ExtendedData>';

         $kml[] = '<Data name="Ялгах дугаар">';
        $kml[] = '<value><![CDATA[' . $row[$i]["entity_id"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Аймаг, хотын нэр ">';
        $kml[] = '<value><![CDATA[' . $row[$i]["aimag_name_mn"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Сум, дүүргийн нэр ">';
        $kml[] = '<value><![CDATA[' . $row[$i]["soum_name_mn"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Хуулийн этгээдийн төрөл ">';
        $kml[] = '<value><![CDATA[' . getdata($CUSTOM_ENTITY_TYPE, $row[$i]["entity_type"]). ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Экспортлогч, импортлогчийн нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["entity_name"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Экспортлогч, импортлогчийн регистрийн дугаар р">';
        $kml[] = '<value><![CDATA[' . $row[$i]["register_number"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Байршил">';
        $kml[] = '<value><![CDATA[' . $row[$i]["location_address"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Утасны дугаар">';
        $kml[] = '<value><![CDATA[' . $row[$i]["tel_number"] . ']]></value>';
        $kml[] = '</Data>';
		$kml[] = '<Data name="Факсын дугаар ">';
		$kml[] = '<value><![CDATA[' . $row[$i]["fax_number"] . ']]></value>';
        $kml[] = '</Data>';
		$kml[] = '<Data name="Имэйл ">';
		$kml[] = '<value><![CDATA[' . $row[$i]["email_address"] . ']]></value>';
        $kml[] = '</Data>';
		$kml[] = '<Data name="Вэб хаяг ">';
		$kml[] = '<value><![CDATA[' . $row[$i]["web_address"] . ']]></value>';
        $kml[] = '</Data>';
		$kml[] = '<Data name="Шуудангийн хаяг ">';
		$kml[] = '<value><![CDATA[' . $row[$i]["postal_address"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '</ExtendedData>';
        $kml[] = '<styleUrl>#generic</styleUrl>';
        $kml[] = $row[$i]['geomtext'];
        $kml[] = '</Placemark>';

        $kml[] = '</Document>';
        $kml[] = '</kml>';
        $kmlOutput = join("\n", $kml);

        header('Content-Type: application/vnd.google-earth.kml+xml kml');
        header('Content-Disposition: attachment; filename="animalcustomentitylocation.kml"');
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



