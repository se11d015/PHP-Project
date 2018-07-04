<?php
if (isset($_GET["outputtype"])) {
    $outputtype = (int) $_GET["outputtype"];
} else {
    $outputtype = 1;
}

if (isset($_GET["gid"])) {
    $gid = (int) $_GET["gid"];
} else {
    $gid = 0;
}

$i = 0;

$startQuery = "SELECT";
$valueQuery1 = "tgf.gid, taf.utilization_year, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en, tgf.logging_area";
if ($outputtype == 1)
    $valueQuery2 = ", st_astext(tgf.geom) as geomtext";
if ($outputtype == 2)
    $valueQuery2 = ", st_askml(tgf.geom) as geomtext";
if ($outputtype == 3)
    $valueQuery2 = ", tgf.geom as geomtext";
$valueQuery3 = "FROM ".$schemas.".tgforestlogging tgf, ".$schemas.".taforestutilization taf, scadministrative.vasoumname vs";
$whereQuery = "WHERE tgf.utilization_id = taf.utilization_id AND taf.soum_code = vs.soum_code AND tgf.gid = ".$gid;
$selQuery = $startQuery." ".$valueQuery1." ".$valueQuery2." ".$valueQuery3." ".$whereQuery;

$row = $db->query($selQuery);
if (!empty($row)) {
    if ($outputtype == 1 || $outputtype == 3) {
        $buffer = "";
        $buffer .= "№: ".$row[$i]["gid"]."\r\n";
        $buffer .= _p("GisSub4Column3").": ".$row[$i]["utilization_year"]."\r\n";
        $buffer .= _p("GisSub4Column1").": ".$row[$i]["aimag_name_$language_name"]."\r\n";
        $buffer .= _p("GisSub4Column2").": ".$row[$i]["soum_name_$language_name"]."\r\n";
        $buffer .= _p("GisSub4Column5").": ".$row[$i]["logging_area"]."\r\n";;
        $buffer .= _p("GeometryText").": ".$row[$i]["geomtext"]."\r\n";

        $filename = "forestlogging.txt";
        $fullname = "upload/".$filename;
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

    if ($outputtype == 2) {
        # Create an array of strings to hold the lines of the KML file.
        $kml = array('<?xml version="1.0" encoding="UTF-8"?>');
        $kml[] = '<kml xmlns="http://www.opengis.net/kml/2.2">';
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
        $kml[] = '<Data name="'._p("GisSub4Column3").'">';
        $kml[] = '<value><![CDATA[' . $row[$i]["utilization_year"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="'._p("GisSub4Column1").'">';
        $kml[] = '<value><![CDATA[' . $row[$i]["aimag_name_$language_name"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="'._p("GisSub4Column2").'">';
        $kml[] = '<value><![CDATA[' . $row[$i]["soum_name_$language_name"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '<Data name="'._p("GisSub4Column5").'">';
        $kml[] = '<value><![CDATA[' . $row[$i]["logging_area"] . ']]></value>';
        $kml[] = '</Data>';
        $kml[] = '</ExtendedData>';
        $kml[] = '<styleUrl>#generic</styleUrl>';
        $kml[] = $row[$i]['geomtext'];
        $kml[] = '</Placemark>';

        $kml[] = '</Document>';
        $kml[] = '</kml>';
        $kmlOutput = join("\n", $kml);

        header('Content-Type: application/vnd.google-earth.kml+xml kml');
        header('Content-Disposition: attachment; filename="forestlogging.kml"');
        ob_clean();
        flush();
        echo $kmlOutput;
        exit;
    }
} else {
	$notify = " <a class=\"btn btn-danger\" href=\"".$my_url.$my_page.$search_url.$sort_url."\"><i class=\"fa fa-undo\"></i> "._p("BackButton")." </a>";
	show_notification("error", _p("NotRowText"), $notify);
}
?>
