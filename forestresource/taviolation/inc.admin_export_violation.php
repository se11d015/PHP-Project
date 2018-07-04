<?php
	if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 8, 2)) 
	{
		if (isset($_POST["excelbttn"]) && (int) $_POST["excelbttn"] == 1) 
		{
		
			$searchQuery = "";
				
			$export_violation_year = (isset($_POST["export_violation_year"])) ? (int) $_POST["export_violation_year"] : 0;		
			$export_aimag_code = (isset($_POST["export_aimag_code"])) ? (int) $_POST["export_aimag_code"] : 0;
			
			if($export_aimag_code==0)
			{
				$searchQuery .= "";
			} else
			{
				$searchQuery .= " AND vs.aimag_code = ".$export_aimag_code;
			}
				
			if($export_violation_year==0)
			{
				$searchQuery .= "";
				
			} else
			{
				$searchQuery .= " AND taf.violation_year = ".$export_violation_year;
			}
			
			$startQuery = "SELECT";
			$valueQuery = "taf.*, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en FROM ".$schemas.".taviolation taf, scadministrative.vasoumname vs";
			$whereQuery = "WHERE taf.soum_code = vs.soum_code";	
			$orderQuery = "ORDER BY taf.violation_year DESC, vs.aimag_name_mn ASC, vs.soum_name_mn ASC";	

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
					
					$filename = "upload/violation.xlsx";
					
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
					
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSubTitle8"));
					$cellrow++; 

					$cellcol = 0;				
					$sheet->setCellValue($cellname[$cellcol].$cellrow, "№"); $cellcol++; 
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8Column3")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8Column1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8Column2")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8MoreColumn1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8MoreColumn2")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8MoreColumn3")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8MoreColumn4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8ColumnText4")); $cellcol++;
					$cellcol = $cellcol+1;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8MoreColumn7")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8MoreColumn8")); $cellcol++;

					$cellrow++;
					$cellcol = 0; 
					$cellcol = $cellcol+8;			
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8MoreColumn5")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8MoreColumn6")); $cellcol++;
					
					$cellrow++;
					$cellcol = 0; 
					$cellcol = $cellcol+4;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8Unit1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8Unit2")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8Unit3")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8Unit1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8Unit4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8Unit5")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub8Unit3")); $cellcol++;
					
					$cellrow++;
				
					// Data
					for ($i=0; $i < $count_rows; $i++)
					{	
						$cellcol = 0; 
						
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $i+1); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["violation_year"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["aimag_name_mn"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["soum_name_mn"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["violation_number"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["illegallogging_wood"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["place_name"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["escheat_tools_number"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["forfeit_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["indemnity_cost"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["illegal_nontimberproduct"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["violation_note"]); $cellcol++;
						
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