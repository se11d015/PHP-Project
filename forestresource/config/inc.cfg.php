<?php
$_MY_CONF["DATABASE_USER"] = "forestresource_user";
$_MY_CONF["DATABASE_NAME"] = "forestdb";
$_MY_CONF["DATABASE_SERVER"] = "localhost";
$_MY_CONF["DATABASE_PASS"] = "";
$_MY_CONF["DATABASE_PORT"] = "5432";

$PAGE_COUNT = 10;
$RECORD_COUNTS = array("10"=>"10", "25"=>"25", "50"=>"50", "100"=>"100");

$USER_PROFILE = array("1"=>_p("UsersProfile1"), "2"=>_p("UsersProfile2"), "3"=>_p("UsersProfile3"));
$USER_ACTIVE = array("t"=>_p("UsersActive1"), "f"=>_p("UsersActive2"));

$ROLE_TYPE = array("1"=>"SELECT", "2"=>"INSERT");
$ITEM_TYPE = array("1"=>_p("ResourceSubTitle1"), "2"=>_p("ResourceSubTitle2"), "3"=>_p("ResourceSubTitle3"), "4"=>_p("ResourceSubTitle4"), "5"=>_p("ResourceSubTitle5"), 
"6"=>_p("ResourceSubTitle6"), "7"=>_p("ResourceSubTitle7"), "8"=>_p("ResourceSubTitle8"), "9"=>_p("ResourceSubTitle9"), "10"=>_p("ReferenceTitle"), 
"11"=>_p("GisSubTitle1"), "12"=>_p("GisSubTitle2"), "13"=>_p("GisSubTitle3"), "14"=>_p("GisSubTitle4"), "15"=>_p("GisSubTitle5"));

$PDF_TYPES = array('pdf');
$_MY_CONF["MANAGEMENT_PATH"] = "tgownerforest";

$TABLE_ID = array("1"=>_p("ResourceSubTitle1"), "2"=>_p("ResourceSubTitle2"), "3"=>_p("ResourceSubTitle3"), "4"=>_p("ResourceSubTitle4"), "5"=>_p("ResourceSubTitle5"), 
"6"=>_p("ResourceSubTitle6"), "7"=>_p("ResourceSubTitle7"), "8"=>_p("ResourceSubTitle8"), "9"=>_p("ResourceSubTitle9"), 
"10"=>_p("GisSubTitle1"), "11"=>_p("GisSubTitle2"), "12"=>_p("GisSubTitle3"), "13"=>_p("GisSubTitle4"), "14"=>_p("GisSubTitle5"));
$TABLE_NAME = array("1"=>"taforestarea", "2"=>"taforestvolume", "3"=>"taforestfire", "4"=>"taforestinsect", 
"5"=>"tareforestation", "6"=>"taforestutilization", "7"=>"taownerforest", "8"=>"taviolation", "9"=>"tacostreport", 
"10"=>"tgforestinsect","11"=>"tgreforestation", "12"=>"tgplantedforest", "13"=>"tgforestlogging", "14"=>"tgownerforest");
$PK_NAME = array("1"=>"area_id", "2"=>"volume_id", "3"=>"fire_id", "4"=>"insect_id", 
"5"=>"reforest_id", "6"=>"utilization_id", "7"=>"owner_id", "8"=>"violation_id", "9"=>"cost_id", 
"10"=>"gid", "11"=>"gid", "12"=>"gid", "13"=>"gid", "14"=>"gid");
$METADATA_TYPE = array("1"=>_p("MetadataType1"), "2"=>_p("MetadataType2"), "3"=>_p("MetadataType3"), "4"=>_p("MetadataType4"));

$GEOMETRY_STATUS = array("1"=>_p("GeometryStatus1"), "2"=>_p("GeometryStatus2"), "3"=>_p("GeometryStatus3"), "4"=>_p("GeometryStatus4"));
$GEOMETRY_SRID = array("4326"=>"WGS 84", "32645"=>"UTM 45N", "32646"=>"UTM 46N", "32647"=>"UTM 47N", "32648"=>"UTM 48N", "32649"=>"UTM 49N", "32650"=>"UTM 50N");
$GEOMETRY_TYPE = array("POINT"=>_p("GeometryType1"), "LINESTRING"=>_p("GeometryType2"), "POLYGON"=>_p("GeometryType3"), "MULTIPOINT"=>_p("GeometryType4"), "MULTILINESTRING"=>_p("GeometryType5"), "MULTIPOLYGON"=>_p("GeometryType6"));
?>
