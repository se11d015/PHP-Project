<?php

if (isset($_GET["outputtype"])) {
    $outputtype = (int) $_GET["outputtype"];
} else {
    $outputtype = 0;
}

if (isset($_GET["protect_id"])) {
    $protect_id = (int) $_GET["protect_id"];
} else {
    $protect_id = 0;
}

$i = 0;

$startQuery = "SELECT";
$valueQuery1 = "tgpp.*, tcpt.type_name, vas.aimag_name_mn, vas.soum_name_mn ";
$valueQuery3 = "FROM ".$schemas.".tganimalprotection tgpp, ".$schemas.".tcprotectiontype tcpt, scadministrative.vasoumname vas";
if ($outputtype == 1)
    $valueQuery2 = ", tgpp.geom as geomtext";
if ($outputtype == 2)
    $valueQuery2 = ", st_astext(tgpp.geom) as geomtext";
if ($outputtype == 3)
    $valueQuery2 = ", st_askml(tgpp.geom) as geomtext";



$whereQuery = "WHERE tgpp.protect_type = tcpt.type_id AND tgpp.soum_name = vas.soum_code AND tgpp.protect_id = ".$protect_id;


$selQuery = $startQuery . " " . $valueQuery1 . " " . $valueQuery2 . " " . $valueQuery3 . " " . $whereQuery;
//echo $selQuery;
$row = $db->query($selQuery);
if (!empty($row)) {
    if ($outputtype == 1 || $outputtype == 2) {
        $buffer = "";
        $buffer .= "Ялгах дугаар: " . $row[$i]["protect_id"] . "\r\n";
        $buffer .= "Хамгаалах арга хэмжээний төрөл: " . $row[$i]["type_name"] . "\r\n";
        $buffer .= "Хамгаалах арга хэмжээний авсан огноо: " . $row[$i]["protect_date"] . "\r\n";
        $buffer .= "Хамгаалах арга хэмжээ авсан байгууллагын нэр: " . $row[$i]["protect_org"] . "\r\n";
        $buffer .= "Хамгаалах арга хэмжээ авсан байгууллагын регистрийн дугаар: " . $row[$i]["register_number"] . "\r\n";
        $buffer .= "Мэргэжлийн эрхийн гэрчилгээний дугаар: " . $row[$i]["certificate_number"] . "\r\n";
        $buffer .= "Аймаг, хотын нэр: " . $row[$i]["aimag_name_mn"] . "\r\n";
        $buffer .= "Сум, дүүргийн нэр: " . $row[$i]["soum_name_mn"] . "\r\n";
        $buffer .= "Хамгаалах арга хэмжээний авсан газрын нэр: " . $row[$i]["place_name"] . "\r\n";
        $buffer .= "Хамгаалах арга хэмжээний авсан талбайн хэмжээ, га: " . $row[$i]["protect_area"] . "\r\n";
        $buffer .= "Хамгаалах арга хэмжээний авсан ажлын хураангуй: " . $row[$i]["protect_abstract"] . "\r\n";
		$buffer .= "Газарзүйн солбицол: ".$row[$i]["geomtext"]."\r\n";

        $filename = "animalprotectionlocation.txt";
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


        $kml[] = '<Placemark id="placemark' . $row[$i]["protect_id"] . '">';
        $kml[] = '<name>' . htmlentities($row[$i]["protect_id"]) . '</name>';
        $kml[] = '<ExtendedData>';

        $kml[] = '<Data name="Хамгаалах арга хэмжээний төрөл">';
        $kml[] = '<value><![CDATA[' . $row[$i]["type_name"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Хамгаалах арга хэмжээний авсан огноо">';
        $kml[] = '<value><![CDATA[' . $row[$i]["protect_date"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Хамгаалах арга хэмжээ авсан байгууллагын нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["protect_org"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Хамгаалах арга хэмжээ авсан байгууллагын регистрийн дугаар">';
        $kml[] = '<value><![CDATA[' . $row[$i]["register_number"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Мэргэжлийн эрхийн гэрчилгээний дугаар">';
        $kml[] = '<value><![CDATA[' . $row[$i]["certificate_number"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Аймаг, хотын нэр ">';
        $kml[] = '<value><![CDATA[' . $row[$i]["aimag_name_mn"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Сум, дүүргийн нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["soum_name_mn"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Хамгаалах арга хэмжээний авсан газрын нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["place_name"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Хамгаалах арга хэмжээний авсан талбайн хэмжээ, га">';
        $kml[] = '<value><![CDATA[' . $row[$i]["protect_area"] . ']]></value>';
        $kml[] = '</Data>';
		$kml[] = '<Data name="Хамгаалах арга хэмжээний авсан ажлын хураангуй">';
        $kml[] = '<value><![CDATA[' . $row[$i]["protect_abstract"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '</ExtendedData>';
        $kml[] = '<styleUrl>#generic</styleUrl>';
        $kml[] = $row[$i]['geomtext'];
        $kml[] = '</Placemark>';

        $kml[] = '</Document>';
        $kml[] = '</kml>';
        $kmlOutput = join("\n", $kml);

        header('Content-Type: application/vnd.google-earth.kml+xml kml');
        header('Content-Disposition: attachment; filename="animalprotectionlocation.kml"');
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
