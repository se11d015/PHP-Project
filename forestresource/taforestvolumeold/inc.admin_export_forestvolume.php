<?php
	if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 2)) 
	{
		if (isset($_POST["excelbttn"]) && (int) $_POST["excelbttn"] == 1) 
		{
		
			$searchQuery = "";
				
			$export_volume_year = (isset($_POST["export_volume_year"])) ? (int) $_POST["export_volume_year"] : 0;		
			$export_aimag_code = (isset($_POST["export_aimag_code"])) ? (int) $_POST["export_aimag_code"] : 0;
			$export_tree_code = (isset($_POST["export_tree_code"])) ? (int) $_POST["export_tree_code"] : 0;
			
			if($export_aimag_code==0)
			{
				$searchQuery .= "";
			} else
			{
				$searchQuery .= " AND vs.aimag_code = ".$export_aimag_code;
			}
				
			if($export_volume_year==0)
			{
				$searchQuery .= "";
				
			} else
			{
				$searchQuery .= " AND taf.volume_year = ".$export_volume_year;
			}

			if($export_tree_code==0)
			{
				$searchQuery .= "";
				
			} else
			{
				$searchQuery .= " AND taf.tree_code = ".$export_tree_code;
			}
			
			$startQuery = "SELECT";
			$valueQuery = "taf.*, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en, tct.tree_name_mn, tct.tree_name_en FROM ".$schemas.".taforestvolume taf, scadministrative.vasoumname vs, ".$schemas.".tctreetype tct";
			$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.tree_code = tct.tree_code";	
			$orderQuery = "ORDER BY taf.volume_year DESC, vs.aimag_name_mn ASC, vs.soum_name_mn ASC, tct.tree_name_mn, tct.tree_name_en ASC";	

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
					
					$filename = "upload/forestvolume.xlsx";
					
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
					
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSubTitle2"));
					$cellrow++; 
							
					$cellcol = 0;				
					$sheet->setCellValue($cellname[$cellcol].$cellrow, "№"); $cellcol++; 
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub2Column3")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub2Column1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub2Column2")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub2Column7")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub2Column4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub2Column8")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub2Column5")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub2Column6")); $cellcol++;

					$cellrow++;
				
					// Data
					for ($i=0; $i < $count_rows; $i++)
					{	
						$cellcol = 0; 
						
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $i+1); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["volume_year"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["aimag_name_$language_name"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["soum_name_$language_name"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["tree_name_$language_name"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["growing_volume"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["volume_change"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["driedstanding_volume"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["fallen_volume"]); $cellcol++;
						
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