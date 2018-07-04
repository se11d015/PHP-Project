<?php
	if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 9, 2)) 
	{
		if (isset($_POST["excelbttn"]) && (int) $_POST["excelbttn"] == 1) 
		{
		
			$searchQuery = "";
				
			$export_cost_year = (isset($_POST["export_cost_year"])) ? (int) $_POST["export_cost_year"] : 0;		
			$export_aimag_code = (isset($_POST["export_aimag_code"])) ? (int) $_POST["export_aimag_code"] : 0;
			
			if($export_aimag_code==0)
			{
				$searchQuery .= "";
			} else
			{
				$searchQuery .= " AND vs.aimag_code = ".$export_aimag_code;
			}
				
			if($export_cost_year==0)
			{
				$searchQuery .= "";
				
			} else
			{
				$searchQuery .= " AND taf.cost_year = ".$export_cost_year;
			}
			
			$startQuery = "SELECT";
			$valueQuery = "taf.*, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en FROM ".$schemas.".tacostreport taf, scadministrative.vasoumname vs";
			$whereQuery = "WHERE taf.soum_code = vs.soum_code";	
			$orderQuery = "ORDER BY taf.cost_year DESC, vs.aimag_name_mn ASC, vs.soum_name_mn ASC";	

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
					
					$filename = "upload/costreport.xlsx";
					
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
					
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSubTitle9"));
					$cellrow++; 

					$cellcol = 0;				
					$sheet->setCellValue($cellname[$cellcol].$cellrow, "№"); $cellcol++; 
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9Column3")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9Column1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9Column2")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9ColumnText2")); $cellcol++;
					
					$cellrow++; 
					$cellcol = 0;
					$cellcol = $cellcol+4;		
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9MoreColumn1")); $cellcol++;
					$cellcol = $cellcol+2;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9MoreColumn2")); $cellcol++;
					$cellcol = $cellcol+2;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9MoreColumn3")); $cellcol++;
					$cellcol = $cellcol+2;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9MoreColumn4")); $cellcol++;
					$cellcol = $cellcol+2;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9MoreColumn5")); $cellcol++;
					$cellcol = $cellcol+2;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9MoreColumn6")); $cellcol++;
					$cellcol = $cellcol+2;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9MoreColumn7")); $cellcol++;
					$cellcol = $cellcol+2;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9MoreColumn8")); $cellcol++;
					$cellcol = $cellcol+2;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9MoreColumn9")); $cellcol++;
					$cellcol = $cellcol+2;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9MoreColumn10")); $cellcol++;
					$cellcol = $cellcol+2;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9MoreColumn11")); $cellcol++;
					$cellcol = $cellcol+2;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9MoreColumn12")); $cellcol++;
					$cellcol = $cellcol+2;	
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9MoreColumn13")); $cellcol++;
					$cellcol = $cellcol+2;	

					$cellrow++; 
					$cellcol = 0;
					$cellcol = $cellcol+4;	
					for ($i=1; $i < 14; $i++) {
						$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9ColumnText3")); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9ColumnText4")); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub9ColumnText5")); $cellcol++;
					}
					
					$cellrow++; 			
					// Data
					for ($i=0; $i < $count_rows; $i++)
					{	
						$cellcol = 0; 
						
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $i+1); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["cost_year"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["aimag_name_$language_name"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["soum_name_$language_name"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["state_reforest"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["local_reforest"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["other_reforest"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["state_thin_clear"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["local_thin_clear"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["other_thin_clear"]); $cellcol++;

						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["state_insect_study"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["local_insect_study"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["other_insect_study"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["state_insect_control"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["local_insect_control"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["other_insect_control"]); $cellcol++;

						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["state_seed_prepare"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["local_seed_prepare"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["other_seed_prepare"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["state_forest_training"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["local_forest_training"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["other_forest_training"]); $cellcol++;

						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["state_forest_equipment"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["local_forest_equipment"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["other_forest_equipment"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["state_other_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["local_other_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["other_other_cost"]); $cellcol++;

						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["state_income_nonforest_product"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["local_income_nonforest_product"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["other_income_nonforest_product"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["state_income_logging"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["local_income_logging"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["other_income_logging"]); $cellcol++;

						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["state_income_fire_indemnity"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["local_income_fire_indemnity"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["other_income_fire_indemnity"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["state_income_indemnity"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["local_income_indemnity"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["other_income_indemnity"]); $cellcol++;

						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["state_income_seedling"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["local_income_seedling"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["other_income_seedling"]); $cellcol++;
							
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