<?php
class generategeom
{
	function generatePolygonGeom($points, $srid)
	{
		$checkpoints = array();
		$geomPolygonStr = "";
		for ($i=0; $i<sizeof($points); $i++)
		{
			if($points[$i][0]!=NULL && $points[$i][1]!=NULL)
			{
				$checkpoints[$i][0] = $points[$i][0];
				$checkpoints[$i][1] = $points[$i][1];
			}
		}
		if(!empty($checkpoints))
		{	
			if($checkpoints[2][0]!=NULL && $checkpoints[2][1]!=NULL)
			{
				$geomPolygonStr = "ST_GEOMFROMTEXT('POLYGON((";
				for ($i=0; $i<sizeof($checkpoints); $i++)
				{
					$geomPolygonStr .= $checkpoints[$i][0]." ".$checkpoints[$i][1].(($i==sizeof($checkpoints)-1) ? "" : ", ");
				}
				$geomPolygonStr .= ", ".$checkpoints[0][0]." ".$checkpoints[0][1];
				$geomPolygonStr .= "))', ".$srid.")";
			} else
			{
				$geomPolygonStr = "";
			}
		}
		return $geomPolygonStr;
	}
	
	function generateMultiPolygonGeom($points, $srid)
	{
		$checkpoints = array();
		$geomPolygonStr = "";
		for ($i=0; $i<sizeof($points); $i++)
		{
			if($points[$i][0]!=NULL && $points[$i][1]!=NULL)
			{
				$checkpoints[$i][0] = $points[$i][0];
				$checkpoints[$i][1] = $points[$i][1];
			}
		}
		if(!empty($checkpoints))
		{				
			if($checkpoints[2][0]!=NULL && $checkpoints[2][1]!=NULL)
			{
				$geomPolygonStr = "ST_GEOMFROMTEXT('MULTIPOLYGON(((";
				for ($i=0; $i<sizeof($checkpoints); $i++)
				{
					$geomPolygonStr .= $checkpoints[$i][0]." ".$checkpoints[$i][1].(($i==sizeof($checkpoints)-1) ? "" : ", ");
				}
				$geomPolygonStr .= ", ".$checkpoints[0][0]." ".$checkpoints[0][1];
				$geomPolygonStr .= ")))', ".$srid.")";
			} else
			{
				$geomPolygonStr = "";
			}
		}
		return $geomPolygonStr;
	}

	function generatePointGeom($points, $srid)
	{
		if($points[0]!=NULL && $points[1]!=NULL)
		{
			$geomPointStr = "ST_GEOMFROMTEXT('POINT(";
			for ($i=0; $i<sizeof($points); $i++)
			{
				$geomPointStr .= $points[$i].(($i==sizeof($points)-1) ? "" : " ");
			}
			$geomPointStr .= ")', ".$srid.")";
		} else
		{
			$geomPointStr = "";
		}		
		return $geomPointStr;
	}

	function generateMultiPointGeom($points, $srid)
	{
		if($points[0]!=NULL && $points[1]!=NULL)
		{
			$geomPointStr = "ST_GEOMFROMTEXT('MULTIPOINT(";
			for ($i=0; $i<sizeof($points); $i++)
			{
				$geomPointStr .= $points[$i].(($i==sizeof($points)-1) ? "" : " ");
			}
			$geomPointStr .= ")', ".$srid.")";
		} else
		{
			$geomPointStr = "";
		}		
		return $geomPointStr;
	}

	function generateMultiPointsGeom($points, $srid)
	{
		$checkpoints = array();
		$geomPointStr = "";
		for ($i=0; $i<sizeof($points); $i++)
		{
			if($points[$i][0]!=NULL && $points[$i][1]!=NULL)
			{
				$checkpoints[$i][0] = $points[$i][0];
				$checkpoints[$i][1] = $points[$i][1];
			}
		}
		if(!empty($checkpoints))
		{				
			if($checkpoints[1][0]!=NULL && $checkpoints[1][1]!=NULL)
			{
				$geomPointStr = "ST_GEOMFROMTEXT('MULTIPOINT(";
				for ($i=0; $i<sizeof($checkpoints); $i++)
				{
					$geomPointStr .= $checkpoints[$i][0]." ".$checkpoints[$i][1].(($i==sizeof($checkpoints)-1) ? "" : ", ");
				}
				$geomPointStr .= ")', ".$srid.")";
			} else
			{
				$geomPointStr = "";
			}
		}
		return $geomPointStr;
	}
	
	function generateLineGeom($points, $srid)
	{	
		$checkpoints = array();
		$geomLineStr = "";
		for ($i=0; $i<sizeof($points); $i++)
		{
			if($points[$i][0]!=NULL && $points[$i][1]!=NULL)
			{
				$checkpoints[$i][0] = $points[$i][0];
				$checkpoints[$i][1] = $points[$i][1];
			}
		}
		if(!empty($checkpoints))
		{	
			if($checkpoints[1][0]!=NULL && $checkpoints[1][1]!=NULL)
			{
				$geomLineStr = "ST_GEOMFROMTEXT('LINESTRING(";
				for ($i=0; $i<sizeof($checkpoints); $i++)
				{
					$geomLineStr .= $checkpoints[$i][0]." ".$checkpoints[$i][1].(($i==sizeof($checkpoints)-1) ? "" : ", ");
				}
				$geomLineStr .= ")', ".$srid.")";
			} else
			{
				$geomLineStr = "";
			}
		}
		return $geomLineStr;
	}

	function generateMultiLineGeom($points, $srid)
	{	
		$checkpoints = array();
		$geomLineStr = "";
		for ($i=0; $i<sizeof($points); $i++)
		{
			if($points[$i][0]!=NULL && $points[$i][1]!=NULL)
			{
				$checkpoints[$i][0] = $points[$i][0];
				$checkpoints[$i][1] = $points[$i][1];
			}
		}
		if(!empty($checkpoints))
		{
			if($checkpoints[1][0]!=NULL && $checkpoints[1][1]!=NULL)
			{
				$geomLineStr = "ST_GEOMFROMTEXT('MULTILINESTRING((";
				for ($i=0; $i<sizeof($checkpoints); $i++)
				{
					$geomLineStr .= $checkpoints[$i][0]." ".$checkpoints[$i][1].(($i==sizeof($checkpoints)-1) ? "" : ", ");
				}
				$geomLineStr .= "))', ".$srid.")";
			} else
			{
				$geomLineStr = "";
			}
		}
		return $geomLineStr;
	}
	
	function generateGeometryGeom($geom)
	{	
		$geomGeometryStr = "";
		if(!empty($geom))
		{
			$elements = explode('"', $geom);
			$geomGeometryStr = "'";
			$geomGeometryStr .= $elements[1];
			$geomGeometryStr .= "'";
		}
		return $geomGeometryStr;
	}
	
	function generateMultiGeometryGeom($geom)
	{	
		$geomGeometryStr = "";
		if(!empty($geom))
		{
			$elements = explode('"', $geom);
			$geomGeometryStr = "ST_Multi(ST_GeometryN('";
			$geomGeometryStr .= $elements[1];
			$geomGeometryStr .= "',1))";
		}
		return $geomGeometryStr;
	}
	
	function generateMultiGeometryGeomN($geom, $i)
	{	
		$elements = explode('"', $geom);
		$geomGeometryStr = "ST_Multi(ST_GeometryN('";
		$geomGeometryStr .= $elements[1];
		$geomGeometryStr .= "', $i))";
		return $geomGeometryStr;
	}
		
	function transformGeom($newsrid, $oldsrid, $points, $geomtype)
	{
		$st_trans = "ST_Transform(ST_SetSRID(";
		switch ($geomtype)
		{
			case "POLYGON" : $st_trans .= $this->generatePolygonGeom($points, $oldsrid); break;
			case "MULTIPOLYGON" : $st_trans .= $this->generateMultiPolygonGeom($points, $oldsrid); break;
			case "POINT" : $st_trans .= $this->generatePointGeom($points, $oldsrid); break; 
			case "MULTIPOINT" : $st_trans .= $this->generateMultiPointGeom($points, $oldsrid); break;
			case "MULTIPOINTS" : $st_trans .= $this->generateMultiPointsGeom($points, $oldsrid); break;
			case "LINESTRING" : $st_trans .= $this->generateLineGeom($points, $oldsrid); break;
			case "MULTILINESTRING" : $st_trans .= $this->generateMultiLineGeom($points, $oldsrid); break;
			case "GEOM" : $st_trans .= $this->generateGeometryGeom($points); break;
			case "MULTIGEOM" : $st_trans .= $this->generateMultiGeometryGeom($points); break;
		}	
		$st_trans .= ", ".$oldsrid." ), ".$newsrid.")";
		return $st_trans;
	}

	function transformGeomN($newsrid, $oldsrid, $points, $i, $geomtype)
	{
		$st_trans = "ST_Transform(ST_SetSRID(";
		switch ($geomtype)
		{
			case "MULTIGEOMN" : $st_trans .= $this->generateMultiGeometryGeomN($points, $i); break;
		}	
		$st_trans .= ", ".$oldsrid." ), ".$newsrid.")";
		return $st_trans;
	}	
}
?>
