<?php
	if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 11, 2)) 
	{
		if (isset($_POST["excelbttn"]) && (int) $_POST["excelbttn"] == 1) 
		{
		
			$searchQuery = "";
				
			$export_insect_year = (isset($_POST["export_insect_year"])) ? (int) $_POST["export_insect_year"] : 0;		
			$export_aimag_code = (isset($_POST["export_aimag_code"])) ? (int) $_POST["export_aimag_code"] : 0;
			
			if($export_aimag_code==0)
			{
				$searchQuery .= "";
			} else
			{
				$searchQuery .= " AND vs.aimag_code = ".$export_aimag_code;
			}
				
			if($export_insect_year==0)
			{
				$searchQuery .= "";
				
			} else
			{
				$searchQuery .= " AND taf.insect_year = ".$export_insect_year;
			}
			
			$startQuery = "SELECT";
			$valueQuery = "tgf.*, st_astext(tgf.geom) as geomtext, taf.insect_year, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en 
			FROM ".$schemas.".tgforestinsect tgf, ".$schemas.".taforestinsect taf, scadministrative.vasoumname vs";
			$whereQuery = "WHERE tgf.insect_id = taf.insect_id AND taf.soum_code = vs.soum_code";	
			$orderQuery = "ORDER BY taf.insect_year DESC, vs.aimag_name_mn ASC, vs.soum_name_mn ASC";	

			if($checkaimag==1) 
			{
				$whereQuery .= " AND EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = vs.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id."))";
			}

			$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery." ".$orderQuery;
			
			$rows = $db->query($selQuery);

			if(!empty($rows)) 
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
				
				$filename = "upload/forestinsect.xlsx";
				
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
				
				$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("GisSubTitle1"));
				$cellrow++; 

				$cellcol = 0;				
				$sheet->setCellValue($cellname[$cellcol].$cellrow, "№"); $cellcol++; 
				$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("GisSub1Column3")); $cellcol++;
				$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("GisSub1Column1")); $cellcol++;
				$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("GisSub1Column2")); $cellcol++;
				$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("GisSub1Column4")); $cellcol++;
				$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("GisSub1Column5")); $cellcol++;
				$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("GisSub1Column6")); $cellcol++;
				$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("GisSub1Column7")); $cellcol++;
				$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("GeometryText")); $cellcol++;
				
				$cellrow++;
				$cellcol = 0; 
				$cellcol = $cellcol+4;
				$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("GisSub1Unit2")); $cellcol++;
				$cellcol = $cellcol+2;
				$sheet->setCellValue($cellname[$cellcol].$cellrow, _p("GisSub1Unit2")); $cellcol++;	

				$cellrow++;
			
				// Data
				for ($i=0; $i < $count_rows; $i++)
				{	
					$cellcol = 0; 
					
					$sheet->setCellValue($cellname[$cellcol].$cellrow, $i+1); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["insect_year"]); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["aimag_name_$language_name"]); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["soum_name_$language_name"]); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["insect_damage_area"]); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["insect_name"]); $cellcol++;
					if($rows[$i]["control_type"]==1) $control_type = _p("GisSub1MoreColumn1"); 
					else if($rows[$i]["control_type"]==2) $control_type = _p("GisSub1MoreColumn2");
					else if($rows[$i]["control_type"]==3) $control_type = _p("GisSub1MoreColumn3");
					$sheet->setCellValue($cellname[$cellcol].$cellrow, $control_type); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["control_area"]); $cellcol++;
					$sheet->setCellValue($cellname[$cellcol].$cellrow, $rows[$i]["geomtext"]); $cellcol++;
					
					$cellrow++;
				}
				
				// Close file
				$objWriter->save($filename);
				header('Location: '.$filename.'');
			} else {
				show_notification("error", _p("NotDataFileText"), "");
			}
		}

		if (isset($_POST["kmlbttn"]) && (int) $_POST["kmlbttn"] == 1) 
		{
		
			$searchQuery = "";
				
			$export_insect_year = (isset($_POST["export_insect_year"])) ? (int) $_POST["export_insect_year"] : 0;		
			$export_aimag_code = (isset($_POST["export_aimag_code"])) ? (int) $_POST["export_aimag_code"] : 0;
			
			if($export_aimag_code==0)
			{
				$searchQuery .= "";
			} else
			{
				$searchQuery .= " AND vs.aimag_code = ".$export_aimag_code;
			}
				
			if($export_insect_year==0)
			{
				$searchQuery .= "";
				
			} else
			{
				$searchQuery .= " AND taf.insect_year = ".$export_insect_year;
			}
			
			$startQuery = "SELECT";
			$valueQuery = "tgf.*, st_askml(tgf.geom) as geomtext, taf.insect_year, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en 
			FROM ".$schemas.".tgforestinsect tgf, ".$schemas.".taforestinsect taf, scadministrative.vasoumname vs";
			$whereQuery = "WHERE tgf.insect_id = taf.insect_id AND taf.soum_code = vs.soum_code";	
			$orderQuery = "ORDER BY taf.insect_year DESC, vs.aimag_name_mn ASC, vs.soum_name_mn ASC";	

			if($checkaimag==1) 
			{
				$whereQuery .= " AND EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = vs.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id."))";
			}

			$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery." ".$orderQuery;
			
			$rows = $db->query($selQuery);

			if(!empty($rows)) 
			{
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
				$kml[] = '</LineStyle>';
				$kml[] = '<PolyStyle>';
				$kml[] = '<fill>0</fill>';
				$kml[] = '</PolyStyle>';
				$kml[] = '</Style>';		
				
				for ($i = 0; $i < sizeof($rows); $i++) 
				{		
					$kml[] = '<Placemark id="placemark'.$rows[$i]["gid"].'">';
					$kml[] = '<styleUrl>#generic</styleUrl>';			
					$kml[] = '<name>'.htmlentities($rows[$i]["gid"]).'</name>';
					$kml[] = '<ExtendedData>';
					$kml[] = '<Data name="'._p("GisSub1Column3").'">';
					$kml[] = '<value><![CDATA[' . $rows[$i]["insect_year"] . ']]></value>';
					$kml[] = '</Data>';
					$kml[] = '<Data name="'._p("GisSub1Column1").'">';
					$kml[] = '<value><![CDATA[' . $rows[$i]["aimag_name_$language_name"] . ']]></value>';
					$kml[] = '</Data>';
					$kml[] = '<Data name="'._p("GisSub1Column2").'">';
					$kml[] = '<value><![CDATA[' . $rows[$i]["soum_name_$language_name"] . ']]></value>';
					$kml[] = '</Data>';
					$kml[] = '<Data name="'._p("GisSub1Column4").'">';
					$kml[] = '<value><![CDATA[' . $rows[$i]["insect_damage_area"] . ']]></value>';
					$kml[] = '</Data>';
					$kml[] = '<Data name="'._p("GisSub1Column5").'">';
					$kml[] = '<value><![CDATA[' . $rows[$i]["insect_name"] . ']]></value>';
					$kml[] = '</Data>';											
					$kml[] = '</ExtendedData>';
					$kml[] = $rows[$i]['geomtext'];
					$kml[] = '</Placemark>';			
				}
				
				$kml[] = '</Document>';
				$kml[] = '</kml>';
				$kmlOutput = join("\n", $kml);
			
				header('Content-Type: application/vnd.google-earth.kml+xml kml');
				header('Content-Disposition: attachment; filename="forestinsect.kml"');
				ob_clean();
				flush();
				echo $kmlOutput;
				exit;
			} else {
				show_notification("error", _p("NotDataFileText"), "");
			}
		}		
	} else {
		show_notification("error", _p("NotAccessText"), "");
	}
?>