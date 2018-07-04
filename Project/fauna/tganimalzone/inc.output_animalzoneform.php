<?php

if (isset($_GET["outputtype"])) {
    $outputtype = (int) $_GET["outputtype"];
} else {
    $outputtype = 0;
}

if (isset($_GET["gid"])) {
    $gid = (int) $_GET["gid"];
} else {
    $gid = 0;
}

$i = 0;

$startQuery = "SELECT";
$valueQuery1 = "tgazo.*, takn.kingdom_name_mn, tapn.phylum_name_mn, tacn.class_name_mn, taaim.aimag_name_mn, tasou.soum_name_mn  ";
$valueQuery3 = "FROM scadministrative.taaimagname taaim, scadministrative.tasoumname tasou, " . $schemas . ".takingdomname takn," . $schemas . ".taphylumname tapn," . $schemas . ".taclassname tacn, " . $schemas . ".tganimalzone tgazo";
if ($outputtype == 1)
    $valueQuery2 = ", tgazo.geom as geomtext";
if ($outputtype == 2)
    $valueQuery2 = ", st_astext(tgazo.geom) as geomtext";
if ($outputtype == 3)
    $valueQuery2 = ", st_askml(tgazo.geom) as geomtext";

$whereQuery = "WHERE tgazo.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND taaim.aimag_code=tgazo.aimag_name AND tasou.soum_code=tgazo.soum_name  AND  tgazo.gid = " . $gid;

$selQuery = $startQuery . " " . $valueQuery1 . " " . $valueQuery2 . " " . $valueQuery3 . " " . $whereQuery;

$row = $db->query($selQuery);
if (!empty($row)) {
    if ($outputtype == 1 || $outputtype == 2) {
        $buffer = "";
        $buffer .= "Ялгах дугаар: " . $row[$i]["gid"] . "\r\n";
        $buffer .= "Ангийн  нэр: " . $row[$i]["class_name_mn"] . "\r\n";
		$buffer .= "Зүйлийн нэрc: " . $row[$i]["species_names"] . "\r\n";
		$buffer .= "Хэрэгжих аймаг, хотын нэр : " . $row[$i]["aimag_name_mn"] . "\r\n";
		$buffer .= "Хэрэгжих сум, дүүргийн нэр : " . $row[$i]["soum_name_mn"] . "\r\n";
        $buffer .= "Бүсийн нэр: " . $row[$i]["zone_name"] . "\r\n";
        $buffer .= "Бүсийн  зургийг хийсэн он: " . $row[$i]["zone_year"] . "\r\n";
        $buffer .= "Бүсийн  зургийн хийсэн байгууллагын нэр: " . $row[$i]["org_name"] . "\r\n";
        $buffer .= "Тархсан байршлын нэр: " . $row[$i]["place_name"] . "\r\n";
        $buffer .= "Нэмэлт мэдээлэл: " . $row[$i]["additional_info"] . "\r\n";
        $buffer .= "Газарзүйн солбицол: " . $row[$i]["geomtext"] . "\r\n";

        $filename = "animalzone.txt";
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


        $kml[] = '<Placemark id="placemark' . $row[$i]["gid"] . '">';
        $kml[] = '<name>' . htmlentities($row[$i]["gid"]) . '</name>';
        $kml[] = '<ExtendedData>';

        $kml[] = '<Data name="Ялгах дугаар">';
        $kml[] = '<value><![CDATA[' . $row[$i]["gid"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Ангийн  нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["class_name_mn"] . ']]></value>';
        $kml[] = '</Data>';
		$kml[] = '<Data name="Зүйлийн нэрc">';
        $kml[] = '<value><![CDATA[' . $row[$i]["species_names"] . ']]></value>';
        $kml[] = '</Data>';
		$kml[] = '<Data name="Хэрэгжих аймаг, хотын нэр ">';
        $kml[] = '<value><![CDATA[' . $row[$i]["aimag_name_mn"] . ']]></value>';
        $kml[] = '</Data>';
		$kml[] = '<Data name="Хэрэгжих сум, дүүргийн нэр ">';
        $kml[] = '<value><![CDATA[' . $row[$i]["soum_name_mn"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Бүсийн нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["zone_name"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Бүсийн  зургийг хийсэн он">';
        $kml[] = '<value><![CDATA[' . $row[$i]["zone_year"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Бүсийн зургийн хийсэн байгууллагын нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["org_name"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Тархсан байршлын нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["place_name"] . ']]></value>';
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
        header('Content-Disposition: attachment; filename="animalzonelocation.kml"');
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
