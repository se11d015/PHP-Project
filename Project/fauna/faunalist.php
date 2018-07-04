<?php
require("config/inc.cfg.php");
require("config/inc.db.php");
require("config/inc.functions.php");

$startQuery = "SELECT takingdomname.kingdom_name, takingdomname.kingdom_name_mn, taphylumname.phylum_name, taphylumname.phylum_name_mn, 
taclassname.class_name, taclassname.class_name_mn, taordername.order_name, taordername.order_name_mn, 
tafamilyname.family_name, tafamilyname.family_name_mn, tagenusname.genus_name, tagenusname.genus_name_mn, 
taanimalname.species_code, taanimalname.species_name, taanimalname.citation_author, taanimalname.citation_year, 
 taanimalname.species_name_mn, taanimalname.species_name_en, taanimalname.species_name_ru, taanimalname.synonyms_name, taanimalname.basionum_name";
$fromQuery = "FROM scfauna.takingdomname, scfauna.taphylumname, scfauna.taclassname, scfauna.taordername, scfauna.tafamilyname, scfauna.tagenusname, scfauna.taanimalname";
$whereQuery = "WHERE takingdomname.kingdom_code = taphylumname.kingdom_code AND taphylumname.phylum_code = taclassname.phylum_code AND 
taclassname.class_code = taordername.class_code AND taordername.order_code = tafamilyname.order_code AND 
tafamilyname.family_code = tagenusname.family_code AND tagenusname.genus_code = taanimalname.genus_code AND taclassname.class_code = 1";
$orderQuery = "ORDER BY taclassname.class_name_mn ASC, taordername.order_name_mn ASC, tafamilyname.family_name_mn ASC, tagenusname.genus_name ASC, taanimalname.species_name ASC";

$selQuery = $startQuery." ".$fromQuery." ".$whereQuery." ".$orderQuery;

$rows = $db->query($selQuery);
echo json_encode(array("result"=>$rows), JSON_UNESCAPED_UNICODE);
?>