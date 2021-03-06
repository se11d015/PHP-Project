<?php

if (isset($_GET["outputtype"])) {
    $outputtype = (int) $_GET["outputtype"];
} else {
    $outputtype = 0;
}

if (isset($_GET["picture_id"])) {
    $picture_id = (int) $_GET["picture_id"];
} else {
    $picture_id = 0;
}

$i = 0;
$startQuery = "SELECT";
$valueQuery = "tganp.*, tadn.phylum_name_mn, taon.order_name_mn, tafn.family_name_mn,  tapl.species_name_mn,tapl.species_name, taaim.aimag_name_mn, tasou.soum_name_mn  FROM ".$schemas.".tganimalpicture tganp,".$schemas.".takingdomname takn,".$schemas.".taphylumname tadn,".$schemas.".taclassname tacn,".$schemas.".taordername taon,".$schemas.".tafamilyname tafn,".$schemas.".tagenusname tagn,".$schemas.".taanimalname tapl, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou ";
$whereQuery = "WHERE tganp.picture_id =".$picture_id." AND tganp.species_code = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tadn.phylum_code  AND tadn.kingdom_code=takn.kingdom_code  AND taaim.aimag_code=tganp.aimag_name  AND tasou.soum_code=tganp.soum_name";

$startQuery = "SELECT";
$valueQuery1 = "tganp.*, tadn.phylum_name_mn, taon.order_name_mn, tafn.family_name_mn,  tapl.species_name_mn,tapl.species_name, taaim.aimag_name_mn, tasou.soum_name_mn ";
$valueQuery3 = "FROM ".$schemas.".tganimalpicture tganp,".$schemas.".takingdomname takn,".$schemas.".taphylumname tadn,".$schemas.".taclassname tacn,".$schemas.".taordername taon,".$schemas.".tafamilyname tafn,".$schemas.".tagenusname tagn,".$schemas.".taanimalname tapl, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou ";
if ($outputtype == 1)
    $valueQuery2 = ", tganp.geom as geomtext";
if ($outputtype == 2)
    $valueQuery2 = ", st_astext(tganp.geom) as geomtext";
if ($outputtype == 3)
    $valueQuery2 = ", st_askml(tganp.geom) as geomtext";
$whereQuery = "WHERE tganp.picture_id =".$picture_id." AND tganp.species_code = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tadn.phylum_code  AND tadn.kingdom_code=takn.kingdom_code  AND taaim.aimag_code=tganp.aimag_name  AND tasou.soum_code=tganp.soum_name";

$selQuery = $startQuery . " " . $valueQuery1 . " " . $valueQuery2 . " " . $valueQuery3 . " " . $whereQuery;

$row = $db->query($selQuery);
if (!empty($row)) {
    if ($outputtype == 1 || $outputtype == 2) {



        $buffer = "";
        $buffer .= "Ялгах дугаар: " . $row[$i]["picture_id"] . "\r\n";
        $buffer .= "Зүйлийн нэр: " . $row[$i]["species_name_mn"] . "\r\n";
        $buffer .= "Зураг авсан огноо: " . $row[$i]["photo_date"] . "\r\n";
        $buffer .= "Зургийн гарчиг: " . $row[$i]["photo_title"] . "\r\n";
        $buffer .= "Зураг авсан аймгийн нэр: " . $row[$i]["aimag_name_mn"] . "\r\n";
        $buffer .= "Зураг авсан сумын нэр: " . $row[$i]["soum_name_mn"] . "\r\n";
        $buffer .= "Зургийг авсан газрын нэр: " . $row[$i]["photo_place"] . "\r\n";
        $buffer .= "Зургийг авсан хүний нэр: " . $row[$i]["photo_auhtor"] . "\r\n";
        $buffer .= "Газарзүйн солбицол: " . $row[$i]["geomtext"] . "\r\n";

        $filename = "animalpicture.txt";
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
        $kml[] = '<value><![CDATA[' . $row[$i]["picture_id"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Зүйлийн нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["species_name_mn"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Зураг авсан огноо">';
        $kml[] = '<value><![CDATA[' . $row[$i]["photo_date"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Зургийн гарчиг">';
        $kml[] = '<value><![CDATA[' . $row[$i]["photo_title"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Зураг авсан аймгийн нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["aimag_name"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Зураг авсан сумын нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["soum_name"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Зургийг авсан газрын нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["photo_place"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Зургийг авсан хүний нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["photo_auhtor"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '</ExtendedData>';
        $kml[] = '<styleUrl>#generic</styleUrl>';
        $kml[] = $row[$i]['geomtext'];
        $kml[] = '</Placemark>';

        $kml[] = '</Document>';
        $kml[] = '</kml>';
        $kmlOutput = join("\n", $kml);

        header('Content-Type: application/vnd.google-earth.kml+xml kml');
        header('Content-Disposition: attachment; filename="animalpicturelocation.kml"');
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
