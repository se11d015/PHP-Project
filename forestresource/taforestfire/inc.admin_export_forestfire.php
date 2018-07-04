<?php
	if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 3, 2)) 
	{
		if (isset($_POST["excelbttn"]) && (int) $_POST["excelbttn"] == 1) 
		{
		
			$searchQuery = "";
				
			$export_fire_year = (isset($_POST["export_fire_year"])) ? (int) $_POST["export_fire_year"] : 0;		
			$export_aimag_code = (isset($_POST["export_aimag_code"])) ? (int) $_POST["export_aimag_code"] : 0;
			
			if($export_aimag_code==0)
			{
				$searchQuery .= "";
			} else
			{
				$searchQuery .= " AND vs.aimag_code = ".$export_aimag_code;
			}
				
			if($export_fire_year==0)
			{
				$searchQuery .= "";
				
			} else
			{
				$searchQuery .= " AND taf.fire_year = ".$export_fire_year;
			}
			
			$startQuery = "SELECT";
			$valueQuery = "taf.*, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en FROM ".$schemas.".taforestfire taf, scadministrative.vasoumname vs";
			$whereQuery = "WHERE taf.soum_code = vs.soum_code";	
			$orderQuery = "ORDER BY taf.fire_year DESC, vs.aimag_name_mn ASC, vs.soum_name_mn ASC";	

			if($checkaimag==1) 
			{
				$whereQuery .= " AND EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = vs.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id."))";
			}

			$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery." ".$orderQuery;
			
			$rows = $db->query($selQuery);

			if(!empty($rows)) 
			{
				if (isset($_POST["excelbttn"]) && (int) $_POST["excelbttn"] == 1) 
					{
					/** PHPExcel */
					require("files/phpexcel/PHPExcel.php");
						
					/** PHPExcel_Writer_Excel2007 */
					require("files/phpexcel/PHPExcel/Writer/Excel2007.php");
					
					/** PHPExcel_IOFactory */
					require("files/phpexcel/PHPExcel/IOFactory.php");
					
					// Create new PHPExcel object
					$objPHPExcel = new PHPExcel();
					
					// Reader file
					$objReader = PHPExcel_IOFactory::createReader('Excel2007');
					$objPHPExcel = $objReader->load("files/example.xlsx");
					
					$filename = "upload/forestfire.xlsx";
					
					$cellname = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
					"AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ",
					"BA","BB","BC","BD","BE","BF","BG","BH","BI","BJ","BK","BL","BM","BN","BO","BP","BQ","BR","BS","BT","BU","BV","BW","BX","BY","BZ");
				
					$count_rows = sizeof($rows);
						
					// Writer file
					$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
					
					// Active sheet
					$objPHPExcel->setActiveSheetIndex(0);
					$sheet = $objPHPExcel->getActiveSheet(); 
				
					// Header
					$cellcol = 0;		
					$cellrow = 1; 
					
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSubTitle3"));
					$cellrow++; 

					$cellcol = 0;				
					$sheet->setCellValue($cellname[$cellcol].$cellrow, "№"); $cellcol++; 
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Column3")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Column1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Column2")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn2")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn3")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3ColumnText4")); $cellcol++;
					$cellcol = $cellcol+4;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3ColumnText5")); $cellcol++;
					$cellcol = $cellcol+3;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3ColumnText6")); $cellcol++;
					$cellcol = $cellcol+4;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3ColumnText7")); $cellcol++;
					$cellcol = $cellcol+2;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3ColumnText8")); $cellcol++;
					$cellcol = $cellcol+6;					
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn28")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3ColumnText9")); $cellcol++;
					$cellcol = $cellcol+2;	
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3ColumnText10")); $cellcol++;
					$cellcol = $cellcol+2;	
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3ColumnText11")); $cellcol++;
					$cellcol = $cellcol+6;	
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3ColumnText12")); $cellcol++;
					$cellcol = $cellcol+3;	
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3ColumnText13")); $cellcol++;
					$cellcol = $cellcol+2;	
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3ColumnText14")); $cellcol++;
					$cellcol = $cellcol++;						
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn51")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3ColumnText14")); $cellcol++;
					$cellcol = $cellcol+2;	
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn55")); $cellcol++;
					
					$cellrow++;
					$cellcol = 0; 
					$cellcol = $cellcol+7;			
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn5")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn6")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn7")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn8")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn9")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn10")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn11")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn12")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn13")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn14")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn15")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn16")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn17")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn18")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn19")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn20")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn21")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn22")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn23")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn24")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn25")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn26")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn27")); $cellcol++;
					$cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn29")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn30")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn31")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn32")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn33")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn34")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn35")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn36")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn37")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn38")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn39")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn40")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn41")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn42")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn43")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn44")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn45")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn46")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn47")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn48")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn49")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn50")); $cellcol++;
					$cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn52")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn53")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3MoreColumn54")); $cellcol++;
					$cellcol++;
					
					$cellrow++;
					$cellcol = 0; 
					$cellcol = $cellcol+4;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit2")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit2")); $cellcol++;
					
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit3")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit3")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit3")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit3")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit3")); $cellcol++;
					
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit3")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit3")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit3")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit3")); $cellcol++;
					
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit1")); $cellcol++;
					
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;

					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;

					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit1")); $cellcol++;

					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit2")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit2")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit2")); $cellcol++;

					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;

					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;

					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;

					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit4")); $cellcol++;
					
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit2")); $cellcol++;

					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit2")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit2")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit2")); $cellcol++;

					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub3Unit2")); $cellcol++;
					
					$cellrow++;
				
					// Data
					for ($i=0; $i < $count_rows; $i++)
					{	
						$cellcol = 0; 
						
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $i+1); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["fire_year"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["aimag_name_$language_name"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["soum_name_$language_name"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["fire_number"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["place_name"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["fire_date"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["burnt_forest_area"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["burnt_pasture_area"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["burnt_argiculture_area"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["burnt_grassland_area"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["total_burnt_area"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["burnt_larch_area"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["burnt_pine_area"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["burnt_evergreen_area"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["burnt_othertree_area"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["mobilized_people_number"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["mobilized_car_number"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["mobilized_tractor_number"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["mobilized_motorcycle_number"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["mobilized_cart_number"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["forest_damage_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["pasture_damage_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["wildlife_damage_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["animal_damage_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["ger_damage_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["house_damage_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["fence_damage_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["car_damage_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["grass_damage_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["other_property_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["total_damage_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["died_people_number"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["burnt_people_number"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["affected_people_number"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["fire_source_human"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["fire_source_natural"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["fire_source_outside"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["damp_food_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["damp_petrol_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["damp_aeroplain_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["damp_salary_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["damp_moving_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["damp_other_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["total_damp_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["prevention_technics_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["prevention_canvass_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["prevention_firewarden_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["prevention_training_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["prevention_dustbelt_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["prevention_burntbelt_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["prevention_clearing_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["damage_indemnity_put"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["damage_indemnity_exhaustive"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["causer_address"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["provision_causer_crime"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["provision_causer_administrative"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["provision_causer_fine"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["other"]); $cellcol++;
						
						$cellrow++;
					}
					
					// Close file
					$objWriter->save($filename);
					header('Location: '.$filename.'');
					
				}
			} else {
				show_notification("error", _p("NotDataFileText"), "");
			}
		}
	} else {
		show_notification("error", _p("NotAccessText"), "");
	}
?>