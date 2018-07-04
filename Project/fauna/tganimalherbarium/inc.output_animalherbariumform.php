<?php

if (isset($_GET["outputtype"])) {
    $outputtype = (int) $_GET["outputtype"];
} else {
    $outputtype = 0;
}

if (isset($_GET["herbarium_id"])) {
    $herbarium_id = (int) $_GET["herbarium_id"];
} else {
    $herbarium_id = 0;
}

$i = 0;

$startQuery = "SELECT";
$valueQuery1 = "tgph.*, takn.kingdom_name_mn, tapn.phylum_name_mn, tacn.class_name_mn, tafn.family_name_mn, taon.order_name_mn, tagn.genus_name_mn, tapl.species_name_mn, vas.aimag_name_mn, vas.soum_name_mn  ";
$valueQuery3 = "FROM " . $schemas . ".takingdomname takn," . $schemas . ".taphylumname tapn," . $schemas . ".taclassname tacn," . $schemas . ".tafamilyname tafn," . $schemas . ".taordername taon," . $schemas . ".tagenusname tagn," . $schemas . ".taanimalname tapl," . $schemas . ".tganimalherbarium tgph, scadministrative.vasoumname vas";
if ($outputtype == 1)
    $valueQuery2 = ", tgph.geom as geomtext";
if ($outputtype == 2)
    $valueQuery2 = ", st_astext(tgph.geom) as geomtext";
if ($outputtype == 3)
    $valueQuery2 = ", st_askml(tgph.geom) as geomtext";

$whereQuery = "WHERE tapl.species_code = tgph.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code  AND  tgph.herbarium_id = " . $herbarium_id;

$selQuery = $startQuery . " " . $valueQuery1 . " " . $valueQuery2 . " " . $valueQuery3 . " " . $whereQuery;

$row = $db->query($selQuery);
if (!empty($row)) {
    if ($outputtype == 1 || $outputtype == 2) {
        $buffer = "";
        $buffer .= "Ялгах дугаар: " . $row[$i]["herbarium_id"] . "\r\n";
        $buffer .= "Зүйлийн нэр: " . $row[$i]["species_code"] . "\r\n";
        $buffer .= "Цуглуулгын төрөл: " . $row[$i]["herbarium_type"] . "\r\n";
        $buffer .= "Цуглуулга хийсэн огноо: " . $row[$i]["collected_date"] . "\r\n";
        $buffer .= "Цуглуулгын нэр: " . $row[$i]["herbarium_name"] . "\r\n";
        $buffer .= "Цуглуулгын дугаар: " . $row[$i]["collecting_number"] . "\r\n";
        $buffer .= "Цуглуулга хийсэн аймгийн нэр: " . $row[$i]["aimag_name_mn"] . "\r\n";
        $buffer .= "Цуглуулга хийсэн сумын нэр: " . $row[$i]["soum_name_mn"] . "\r\n";
        $buffer .= "Цуглуулга хийсэн газрын нэр: " . $row[$i]["place_name"] . "\r\n";
        $buffer .= "Цуглуулга хийсэн судлаачийн нэр: " . $row[$i]["collector_name"] . "\r\n";
        $buffer .= "Цуглуулгыг тодорхойлсон судлаачийн нэр: " . $row[$i]["determiner_name"] . "\r\n";
        $buffer .= "Цуглуулгын тайлбар: " . $row[$i]["herbarium_description"] . "\r\n";
		$buffer .= "Газарзүйн солбицол: ".$row[$i]["geomtext"]."\r\n";

        $filename = "animalherbariumlocation.txt";
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


        $kml[] = '<Placemark id="placemark' . $row[$i]["herbarium_id"] . '">';
        $kml[] = '<name>' . htmlentities($row[$i]["herbarium_id"]) . '</name>';
        $kml[] = '<ExtendedData>';

        $kml[] = '<Data name="Зүйлийн нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["species_code"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Цуглуулгын төрөл">';
        $kml[] = '<value><![CDATA[' . $row[$i]["herbarium_type"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Цуглуулга хийсэн огноо">';
        $kml[] = '<value><![CDATA[' . $row[$i]["collected_date"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Цуглуулгын нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["herbarium_name"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Цуглуулгын дугаар">';
        $kml[] = '<value><![CDATA[' . $row[$i]["collecting_number"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Цуглуулга хийсэн аймгийн нэр ">';
        $kml[] = '<value><![CDATA[' . $row[$i]["aimag_name_mn"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Цуглуулга хийсэн сумын нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["soum_name_mn"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Цуглуулга хийсэн газрын нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["place_name"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Цуглуулга хийсэн судлаачийн нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["collector_name"] . ']]></value>';
        $kml[] = '</Data>';
		$kml[] = '<Data name="Цуглуулгыг тодорхойлсон судлаачийн нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["determiner_name"] . ']]></value>';
        $kml[] = '</Data>';
		$kml[] = '<Data name="Цуглуулгын тайлбар">';
        $kml[] = '<value><![CDATA[' . $row[$i]["herbarium_description"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '</ExtendedData>';
        $kml[] = '<styleUrl>#generic</styleUrl>';
        $kml[] = $row[$i]['geomtext'];
        $kml[] = '</Placemark>';

        $kml[] = '</Document>';
        $kml[] = '</kml>';
        $kmlOutput = join("\n", $kml);

        header('Content-Type: application/vnd.google-earth.kml+xml kml');
        header('Content-Disposition: attachment; filename="animalherbariumlocation.kml"');
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
