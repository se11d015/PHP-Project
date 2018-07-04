<?php
require("config/inc.cfg.php");
require("config/inc.session.php");
require("config/inc.functions.php");
require("config/inc.db.php");
require("notification/inc.alerts.php");

$schemas = "scfauna";

if (!isset($_SESSION['fauna_session_id']) && !isset($_SESSION['fauna_login_name']) && !isset($_SESSION['fauna_profile']))
{
		header("Location: login.php");
} else {
		$selQuery = "SELECT tu.user_id, tu.lastname, tu.profile FROM ".$schemas.".tausers tu WHERE tu.profile = ".$_SESSION['fauna_profile']." AND tu.login_name = '".$_SESSION['fauna_login_name']."' AND tu.login_session = '".$_SESSION['fauna_session_id']."'";
		$rows = $db->Query($selQuery);
		
		if (!empty($rows)) 
		{	
			$sess_user_name = $rows[0]["lastname"];
			$sess_user_id = $rows[0]["user_id"];
			$sess_profile = $rows[0]["profile"];
			
			require("templates/inc.admin_head.php");
?>
<body data-spy="scroll" data-target="sidebar">
<div class="container">
  <div class="row">
    <div class="span12">
      <?php
			require("templates/inc.admin_nav.php");
			?>
    </div>
  </div>
  <div class="top-table"></div>
  <div class="row">
    <div class="span12 sidebar">
      <?php
			switch ($menuitem)
			{
				case 1:
					require("templates/inc.admin_home.php");
					break;
				case 2:
					require("tagroups/inc.admin_group.php");
					break;
				case 3: 
					require("tausers/inc.admin_user.php");
					break;
				case 5: 
					require("tausergroups/inc.admin_usergroups.php");
					break;
				case 7: 
					require("tagrouproles/inc.admin_grouproles.php");
					break;
				case 10: 
					require("templates/inc.animal_home.php");
					break;
				case 11: 
					require("takingdomname/inc.admin_kingdomname.php");
					break;
				case 12: 
					require("taphylumname/inc.admin_phylumname.php");
					break;
				case 13: 
					require("taclassname/inc.admin_classname.php");
					break;
				case 14: 
					require("taordername/inc.admin_ordername.php");
					break;
				case 15: 
					require("tafamilyname/inc.admin_familyname.php");
					break;
				case 16: 
					require("tagenusname/inc.admin_genusname.php");
					break;
				case 17: 
					require("taanimalname/inc.admin_animalname.php");
					break;
				
				case 20: 
					require("templates/inc.distribution_home.php");
					break;
				case 21: 
					require("taanimalinfo/inc.admin_animalinfo.php");
					break;
				case 22: 
					require("taanimalresource/inc.admin_animalresource.php");
					break;
				case 23: 
					require("taanimalstatus/inc.admin_animalstatus.php");
					break;
				case 25: 
					require("tganimalpicture/inc.admin_animalpicture.php");
					break;
				case 26: 
					require("tganimalherbarium/inc.admin_animalherbarium.php");
					break;
				case 27: 
					require("tcreferencestatus/inc.admin_referencestatus.php");
					break;
				case 28: 
					require("tganimalhabitat/inc.admin_animalhabitat.php");
					break;
				case 29: 
					require("tganimalzone/inc.admin_animalzone.php");
					break;
				
				case 30: 
					require("taredlist/inc.admin_redlist.php");
					break;  
				case 31: 
					require("taredbook/inc.admin_redbook.php");
					break;  
				case 32: 
					require("tcredliststatus/inc.admin_redliststatus.php");
					break;
				
				case 40: 
					require("taanimalresearchreport/inc.admin_animalresearchreport.php");
					break; 
				case 41: 
					require("tcresearchtype/inc.admin_researchtype.php");
					break;  
				case 42: 
					require("tcbudgettype/inc.admin_budgettype.php");
					break; 
				
				case 50: 
					require("templates/inc.custom_home.php");
					break;
				case 51: 
					require("tganimalcustomentity/inc.admin_animalcustomentity.php");
					break; 
				case 52: 
					require("taanimalcustompermission/inc.admin_animalcustompermission.php");
					break;
				case 53: 
					require("taanimalcustomname/inc.admin_animalcustomname.php");
					break;
					
				case 60: 
					require("templates/inc.org_home.php");
					break;  
				case 61: 
					require("tganimalorg/inc.admin_animalorg.php");
					break;  
				case 62: 
					require("tcactivitytype/inc.admin_activitytype.php");
					break;   
				case 63: 
					require("tcreporttype/inc.admin_reporttype.php");
					break;    
				case 64: 
					require("taanimalorgpermission/inc.admin_animalorgpermission.php");
					break; 
				case 65: 
					require("taanimalorgreport/inc.admin_animalorgreport.php");
					break; 
					
				case 70: 
					require("templates/inc.use_home.php");
					break; 
				case 71: 
					require("tganimaluseentity/inc.admin_animaluseentity.php");
					break; 
				case 72: 
					require("taanimalusepermission/inc.admin_animalusepermission.php");
					break; 
				case 73: 
					require("taanimalusename/inc.admin_animalusename.php");
					break; 
				case 74: 
					require("taanimalusepayment/inc.admin_animalusepayment.php");
					break;
									
				case 80: 
					require("tganimalprotection/inc.admin_animalprotection.php");
					break; 
				case 81: 
					require("tcprotectiontype/inc.admin_protectiontype.php");
					break ;
				case 82: 
					require("tcexpensetype/inc.admin_expensetype.php");
					break;  
					
				case 100: 
					require("tganimaloffence/inc.admin_animaloffence.php");
					break; 
				case 110: 
					require("tganimalcontagion/inc.admin_animalcontagion.php");
					break; 
				case 122: 
					require("templates/inc.use_zone.php");
					break;
                case 29: 
					require("tganimalzone/inc.admin_animalzone.php");
					break;
                case 120: 
					require("taanimalmng/inc.admin_animalmng.php");
					break;					
				case 121: 
					require("tcfiletype/inc.admin_filetype.php");
					break; 
			}
			?>
    </div>
  </div>
  <div class="row">
    <div class="span12">
      <?php
			require("templates/inc.footer_nav.php");
			?>
    </div>
  </div>
</div>
</body>
</html><?php		
		}else
		{
			header("Location: login.php");
		}		
}
?>
