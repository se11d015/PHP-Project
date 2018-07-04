<?php
require("config/inc.functions.php");
require("config/inc.session.php");
require("config/inc.language.php");
require("config/inc.cfg.php");
require("config/inc.db.php");
require("notification/inc.alerts.php");

$schemas = "scforestresource";

if (!isset($_SESSION['forestresource_session_id']) && !isset($_SESSION['forestresource_login_name']) && !isset($_SESSION['forestresource_profile']))
{
		header("Location: index.php");
} else {
		$selQuery = "SELECT tu.user_id, tu.lastname, tu.profile FROM ".$schemas.".tausers tu WHERE tu.profile = ".pg_prep($_SESSION['forestresource_profile'])." AND tu.login_name = '".pg_prep($_SESSION['forestresource_login_name'])."' AND tu.login_session = '".pg_prep($_SESSION['forestresource_session_id'])."'";
		$rows = $db->Query($selQuery);
		
		if (!empty($rows)) 
		{	
			$sess_user_name = $rows[0]["lastname"];
			$sess_user_id = $rows[0]["user_id"];

			$sess_profile = $rows[0]["profile"];

			$checkaimag = 0;
			
			$checkQuery = "SELECT aimag_code FROM ".$schemas.".taaimagusers WHERE user_id = ".$sess_user_id;
			$checkrows = $db->Query($checkQuery);
			
			if (!empty($checkrows))
				$checkaimag = 1;
			
			require("templates/inc.admin_head.php");
?>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<?php
	require("templates/inc.admin_nav.php");
	
	$language_name = "mn";
	if($session->get("forestresource_lang") == 1){
		$language_name = "mn";	
	} else if($session->get("forestresource_lang") == 2){
		$language_name = "en";
	}
	
	switch ($menuitem)
	{
		case 1 :
			require("templates/inc.admin_home.php");
			break;
		case 2 :
			require("tagroups/inc.admin_group.php");
			break;
		case 3 : 
			require("tausers/inc.admin_users.php");
			break;
		case 4 : 
			require("tausergroups/inc.admin_usergroups.php");
			break;
		case 5 : 
			require("tagrouproles/inc.admin_grouproles.php");
			break;
		case 6 : 
			require("tauseraimags/inc.admin_useraimags.php");
			break;	
		case 9 : 
			require("metadata/inc.admin_metadata.php");
			break;
		case 11 : 
			require("tctreetype/inc.admin_treetype.php");
			break;
		case 12 : 
			require("tclandtype/inc.admin_landtype.php");
			break;	
		case 13 : 
			require("tcinsectname/inc.admin_insectname.php");
			break;	
		case 21 : 
			require("taforestarea/inc.admin_forestarea.php");
			break;	
		case 22 : 
			require("taforestvolume/inc.admin_forestvolume.php");
			break;
		case 23 : 
			require("taforestfire/inc.admin_forestfire.php");
			break;	
		case 24 : 
			require("taforestinsect/inc.admin_forestinsect.php");
			break;	
		case 25 : 
			require("tareforestation/inc.admin_reforestation.php");
			break;
		case 26 : 
			require("taforestutilization/inc.admin_forestutilization.php");
			break;	
		case 27 : 
			require("taownerforest/inc.admin_ownerforest.php");
			break;	
		case 28 : 
			require("taviolation/inc.admin_violation.php");
			break;		
		case 29 : 
			require("tacostreport/inc.admin_costreport.php");
			break;
		case 31 : 
			require("tgforestinsect/inc.admin_forestinsect.php");
			break;
		case 32 : 
			require("tgreforestation/inc.admin_reforestation.php");
			break;
		case 33 : 
			require("tgplantedforest/inc.admin_plantedforest.php");
			break;
		case 34 : 
			require("tgforestlogging/inc.admin_forestlogging.php");
			break;
		case 35 : 
			require("tgownerforest/inc.admin_ownerforest.php");
			break;			
	}
	require("templates/inc.admin_footer.php"); 
	?>
</body>
</html>
<?php		
	}else
	{
		header("Location: login.php");
	}		
}