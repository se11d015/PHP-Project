<?php
	if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 2)) 
	{
		if (isset($_POST["excelbttn"]) && (int) $_POST["excelbttn"] == 1) 
		{
		
			$searchQuery = "";
				
			$export_owner_year = (isset($_POST["export_owner_year"])) ? (int) $_POST["export_owner_year"] : 0;		
			$export_aimag_code = (isset($_POST["export_aimag_code"])) ? (int) $_POST["export_aimag_code"] : 0;
			
			if($export_aimag_code==0)
			{
				$searchQuery .= "";
			} else
			{
				$searchQuery .= " AND vs.aimag_code = ".$export_aimag_code;
			}
				
			if($export_owner_year==0)
			{
				$searchQuery .= "";
				
			} else
			{
				$searchQuery .= " AND taf.owner_year = ".$export_owner_year;
			}
			
			$startQuery = "SELECT";
			$valueQuery = "taf.*, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en FROM ".$schemas.".taownerforest taf, scadministrative.vasoumname vs";
			$whereQuery = "WHERE taf.soum_code = vs.soum_code";	
			$orderQuery = "ORDER BY taf.owner_year DESC, vs.aimag_name_mn ASC, vs.soum_name_mn ASC";	

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
					
					$filename = "upload/ownerforest.xlsx";
					
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
					
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSubTitle7"));
					$cellrow++; 

					$cellcol = 0;				
					$sheet->setCellValue($cellname[$cellcol].$cellrow, "№"); $cellcol++; 
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7Column3")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7Column1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7Column2")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7ColumnText4")); $cellcol++;
					$cellcol = $cellcol+3;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7ColumnText5")); $cellcol++;
					$cellcol = $cellcol+3;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7MoreColumn9")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7MoreColumn10")); $cellcol++;					

					$cellrow++;
					$cellcol = 0; 
					$cellcol = $cellcol+4;			
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7MoreColumn1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7MoreColumn2")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7MoreColumn3")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7MoreColumn4")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7MoreColumn5")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7MoreColumn6")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7MoreColumn7")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7MoreColumn8")); $cellcol++;
					
					$cellrow++;
					$cellcol = 0; 
					$cellcol = $cellcol+4;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7Unit1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7Unit1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7Unit1")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7Unit1")); $cellcol++;
					
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7Unit2")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7Unit2")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7Unit2")); $cellcol++;					
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7Unit2")); $cellcol++;
					
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7Unit3")); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("ResourceSub7Unit3")); $cellcol++;					
					
					$cellrow++;
				
					// Data
					for ($i=0; $i < $count_rows; $i++)
					{	
						$cellcol = 0; 
						
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $i+1); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["owner_year"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["aimag_name_$language_name"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["soum_name_$language_name"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["owner_community_number"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["owner_organization_number"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["owner_other_number"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["total_owner_number"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["owner_community_area"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["owner_organization_area"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["owner_other_area"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["total_owner_area"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["owner_location"]); $cellcol++;
						$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["order_number"]); $cellcol++;
						
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