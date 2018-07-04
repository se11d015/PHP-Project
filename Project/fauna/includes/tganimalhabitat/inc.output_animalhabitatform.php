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
$valueQuery1 = "taaht.*, takn.kingdom_name_mn, tapn.phylum_name_mn, tacn.class_name_mn, tafn.family_name_mn, taon.order_name_mn, tagn.genus_name_mn, tapl.species_name_mn  ";
$valueQuery3 = "FROM " . $schemas . ".takingdomname takn," . $schemas . ".taphylumname tapn," . $schemas . ".taclassname tacn," . $schemas . ".tafamilyname tafn," . $schemas . ".taordername taon," . $schemas . ".tagenusname tagn," . $schemas . ".taanimalname tapl," . $schemas . ".tganimalhabitat taaht";
if ($outputtype == 1)
    $valueQuery2 = ", taaht.geom as geomtext";
if ($outputtype == 2)
    $valueQuery2 = ", st_astext(taaht.geom) as geomtext";
if ($outputtype == 3)
    $valueQuery2 = ", st_askml(taaht.geom) as geomtext";

$whereQuery = "WHERE tapl.species_code = taaht.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code  AND  taaht.gid = " . $gid;

$selQuery = $startQuery . " " . $valueQuery1 . " " . $valueQuery2 . " " . $valueQuery3 . " " . $whereQuery;

$row = $db->query($selQuery);
if (!empty($row)) {
    

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
        $kml[] = '<Data name="Зүйлийн нэр">';
        $kml[] = '<value><![CDATA[' . $row[$i]["species_name_mn"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Судалгаа хийсэн он">';
        $kml[] = '<value><![CDATA[' . $row[$i]["evaluated_date"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Тархацын зургийг хийсэн он">';
        $kml[] = '<value><![CDATA[' . $row[$i]["gyear"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="Тархацын зургийн хийсэн байгууллагын нэр">';
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
        header('Content-Disposition: attachment; filename="animalhabitat.kml"');
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
