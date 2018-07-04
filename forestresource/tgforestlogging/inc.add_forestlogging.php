<?php
if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 14, 2)) 
{
	if (isset($_GET["utilization_id" ]))
	{
		$utilization_id = (int) $_GET["utilization_id"];
	}else
	{
		$utilization_id = 0;
	}
	
	$i = 0;	
	
	$startQuery = "SELECT";
	$valueQuery = "taf.utilization_id, taf.utilization_year, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en FROM ".$schemas.".taforestutilization taf, scadministrative.vasoumname vs";
	
	if($sess_profile==1)
		$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.utilization_id = ".$utilization_id;
	else
		$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.utilization_id = ".$utilization_id." AND taf.user_id = ".$sess_user_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function addsubmitform()
{
    document.getElementById("insertforestlogginggeombttn").value = "1";
    document.mainform.submit();
}
function summary_logged(){
    var f1, f2;
	if (document.getElementById("logged_timber").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("logged_timber").value)) f1=0;
		f1 = document.getElementById("logged_timber").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("logged_firewood").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("logged_firewood").value)) f2=0;
		 f2 = document.getElementById("logged_firewood").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}

	document.getElementById("logged_total").value = parseFloat(f1+f2);			
}

function select_geom(selectobj)
{
	if (selectobj[selectobj.selectedIndex].value=="1")
	{
		document.getElementById("geom_1").hidden = false;
		document.getElementById("geom_2").hidden = true;
		document.getElementById("geom_3").hidden = true;
		document.getElementById("geom_4").hidden = true;
		document.getElementById("geom_5").hidden = true;				
	}
	if (selectobj[selectobj.selectedIndex].value=="2")
	{
		document.getElementById("geom_1").hidden = true;
		document.getElementById("geom_2").hidden = false;
		document.getElementById("geom_3").hidden = true;
		document.getElementById("geom_4").hidden = true;
		document.getElementById("geom_5").hidden = true;				
	}
	if (selectobj[selectobj.selectedIndex].value=="3")
	{
		document.getElementById("geom_1").hidden = true;
		document.getElementById("geom_2").hidden = true;
		document.getElementById("geom_3").hidden = false;
		document.getElementById("geom_4").hidden = true;
		document.getElementById("geom_5").hidden = true;				
	}
	if (selectobj[selectobj.selectedIndex].value=="4")
	{
		document.getElementById("geom_1").hidden = true;
		document.getElementById("geom_2").hidden = true;
		document.getElementById("geom_3").hidden = true;
		document.getElementById("geom_4").hidden = false;
		document.getElementById("geom_5").hidden = true;			
	}
	if (selectobj[selectobj.selectedIndex].value=="5")
	{
		document.getElementById("geom_1").hidden = true;
		document.getElementById("geom_2").hidden = true;
		document.getElementById("geom_3").hidden = true;
		document.getElementById("geom_4").hidden = true;
		document.getElementById("geom_5").hidden = false;				
	}		
}
</script>

<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("AddText5")." "._p("GisSubTitle4")." "._p("AddText6"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="alert alert-warning" role="alert"><?php echo _p("AlertText"); ?></div>
          <form class="form" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="utilization_id" id="utilization_id" value="<?php echo $row[$i]["utilization_id"]; ?>">
            <div class="form-group row">
              <label class="col-md-3 col-form-label"><?php echo _p("GisSub4Column3"); ?>:</label>
              <div class="col-md-4">
                <input type="text" readonly class="form-control-plaintext" value="<?php echo $row[$i]["utilization_year"]; ?>"/>
              </div>
            </div>				
            <div class="form-group row">
              <label class="col-md-3 col-form-label"><?php echo _p("GisSub4Column1"); ?>:</label>
              <div class="col-md-4">
                <input type="text" readonly class="form-control-plaintext" value="<?php echo $row[$i]["aimag_name_$language_name"]; ?>"/>
              </div>
            </div>
			 <div class="form-group row">
              <label class="col-md-3 col-form-label"><?php echo _p("GisSub4Column2"); ?>:</label>
              <div class="col-md-4">
                <input type="text" readonly class="form-control-plaintext" value="<?php echo $row[$i]["soum_name_$language_name"]; ?>"/>
              </div>
            </div>		
			  <div class="form-group row col-md-12">
			    <table>
				 <tbody>
				    <tr>
					  <th style="width: 5%">№</th>
					  <th colspan="2" style="width: 35%"><?php echo _p("GisSub4ColumnText1");?></th>
					  <th style="width: 10%"><?php echo _p("GisSub4ColumnText2");?></th>
					  <th><?php echo _p("GisSub4ColumnText3");?></th>
					  <th><?php echo _p("Description");?></th>
				    </tr>
					<tr>
					  <th>1.</th>
					  <td colspan="2"><?php echo _p("GisSub4Column4");?></td>
					  <td><?php echo _p("GisSub4Unit1");?></td>
					  <td>
					    <div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="logging_type" id="logging_type" value="1" checked>
						  <label class="form-check-label" for="inlineCheckbox1"><?php echo _p("GisSub4MoreColumn4");?></label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="logging_type" id="logging_type" value="2">
						  <label class="form-check-label" for="inlineCheckbox2"><?php echo _p("GisSub4MoreColumn5");?></label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="logging_type" id="logging_type" value="3">
						  <label class="form-check-label" for="inlineCheckbox3"><?php echo _p("GisSub4MoreColumn6");?></label>
						</div></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextCheckbox"); ?></span></td>
					</tr>
					<tr>
					  <th>2.</th>
					  <td colspan="2"><?php echo _p("GisSub4Column5");?></td>
					  <td><?php echo _p("GisSub4Unit2");?></td>
					  <td><input type="text" class="form-control" name="logging_area" id="logging_area"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
					</tr>
					  <tr>
						<th rowspan="3">3.</th>
						<td rowspan="3"><?php echo _p("GisSub4Column6");?></td>
						<td><?php echo _p("GisSub4MoreColumn1");?></td>
						<td><?php echo _p("GisSub4Unit3");?></td>
						<td><input type="text" class="form-control" name="logged_timber" id="logged_timber" onChange="summary_logged()"/></td>
						<td><span class="form-text text-muted"><?php echo _p("AlertTextReal10"); ?></span></td>
					  </tr>
					  <tr>
						<td><?php echo _p("GisSub4MoreColumn2");?></td>
						<td><?php echo _p("GisSub4Unit3");?></td>
						<td><input type="text" class="form-control" name="logged_firewood" id="logged_firewood" onChange="summary_logged()"/></td>
						<td><span class="form-text text-muted"><?php echo _p("AlertTextReal10"); ?></span></td>
					  </tr>
					  <tr>
						<td><?php echo _p("GisSub4MoreColumn3");?></td>
						<td><?php echo _p("GisSub4Unit3");?></td>
						<td><input type="text" disabled class="form-control" name="logged_total" id="logged_total"/></td>
						<td><span class="form-text text-muted"><?php echo _p("AlertTextReal10"); ?></span></td>
					  </tr>
					<tr>
					  <th>4.</th>
					  <td colspan="2"><?php echo _p("GeomColumn1");?></td>
					  <td colspan="2"><?php echo seldata("geom_srid", "form-control", $GEOMETRY_SRID, 4326); ?></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextSelect"); ?></span></td>
					</tr>
					<tr>
					  <th>5.</th>
					  <td colspan="2"><?php echo _p("GeomColumn2");?></td>
					  <td colspan="2"><select name="geom_type" id="geom_type" class="form-control" onChange="select_geom(this)">
						<option value="1" selected="selected"><?php echo _p("GeomType1"); ?></option>
						<option value="2"><?php echo _p("GeomType2"); ?></option>
						<option value="3"><?php echo _p("GeomType3"); ?></option>
						<option value="4"><?php echo _p("GeomType4"); ?></option>
						<option value="5"><?php echo _p("GeomType5"); ?></option>
						</select></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextSelect"); ?></span></td>
					</tr>
					<tr>
					  <th>6.</th>
					  <td colspan="5">
						<div id="geom_1">
							<table class="table table-bordered">
							  <tr>
								<td colspan="3"><?php echo _p("GeomText1"); ?></td>
							  </tr>
							  <tr>
								<td><strong>№</strong></td>
								<td><strong><?php echo _p("GeomColumn3"); ?></strong></td>
								<td><strong><?php echo _p("GeomColumn4"); ?></strong></td>
							  </tr>
							  <tr>
								<td>1</td>
								<td><input type="text" name="y1" id="y1" class="form-control"/></td>
								<td><input type="text" name="x1" id="x1" class="form-control"/></td>
							  </tr>
							  <tr>
								<td>2</td>
								<td><input type="text" name="y2" id="y2" class="form-control"/></td>
								<td><input type="text" name="x2" id="x2" class="form-control"/></td>
							  </tr>
							  <tr>
								<td>3</td>
								<td><input type="text" name="y3" id="y3" class="form-control"/></td>
								<td><input type="text" name="x3" id="x3" class="form-control"/></td>
							  </tr>
							  <tr>
								<td>4</td>
								<td><input type="text" name="y4" id="y4" class="form-control"/></td>
								<td><input type="text" name="x4" id="x4" class="form-control"/></td>
							  </tr>
							  <tr>
								<td>5</td>
								<td><input type="text" name="y5" id="y5" class="form-control"/></td>
								<td><input type="text" name="x5" id="x5" class="form-control"/></td>
							  </tr>
							  <tr>
								<td>6</td>
								<td><input type="text" name="y6" id="y6" class="form-control"/></td>
								<td><input type="text" name="x6" id="x6" class="form-control"/></td>
							  </tr>
							  <tr>
								<td>7</td>
								<td><input type="text" name="y7" id="y7" class="form-control"/></td>
								<td><input type="text" name="x7" id="x7" class="form-control"/></td>
							  </tr>
							  <tr>
								<td>8</td>
								<td><input type="text" name="y8" id="y8" class="form-control"/></td>
								<td><input type="text" name="x8" id="x8" class="form-control"/></td>
							  </tr>
							  <tr>
								<td>9</td>
								<td><input type="text" name="y9" id="y9" class="form-control"/></td>
								<td><input type="text" name="x9" id="x9" class="form-control"/></td>
							  </tr>
							  <tr>
								<td>10</td>
								<td><input type="text" name="y10" id="y10" class="form-control"/></td>
								<td><input type="text" name="x10" id="x10" class="form-control"/></td>
							  </tr>
							</table>
						</div>	
						<div id="geom_2" hidden="hidden">
						  <table class="table">
							<tr>
								<td colspan="2"><?php echo _p("GeomText2"); ?></td>
							</tr>
							<tr>
							  <td style="width: 35%"><?php echo _p("GeomColumn5");?></td>
							  <td><input type="file" name="geom_file" id="geom_file" /></td>
							</tr>
						  </table>
						</div>	
						<div id="geom_3" hidden="hidden">
						  <table class="table">
							<tr>
								<td colspan="7"><?php echo _p("GeomText3"); ?></td>
							</tr>
							<tr>
								<td rowspan="2"><strong>№</strong></td>
								<td colspan="3"><strong><?php echo _p("GeomColumn3"); ?></strong></td>
								<td colspan="3"><strong><?php echo _p("GeomColumn4"); ?></strong></td>
							</tr>
							<tr>
								<td><strong><?php echo _p("GeomColumn6"); ?></strong></td>
								<td><strong><?php echo _p("GeomColumn7"); ?></strong></td>
								<td><strong><?php echo _p("GeomColumn8"); ?></strong></td>
								<td><strong><?php echo _p("GeomColumn6"); ?></strong></td>
								<td><strong><?php echo _p("GeomColumn7"); ?></strong></td>
								<td><strong><?php echo _p("GeomColumn8"); ?></strong></td>
							</tr>
							<tr>
								<td>1</td>
								<td><input type="text" name="y1_deg" id="y1_deg" class="form-control"/></td>
								<td><input type="text" name="y1_min" id="y1_min" class="form-control"/></td>
								<td><input type="text" name="y1_sec" id="y1_sec" class="form-control"/></td>
								<td><input type="text" name="x1_deg" id="x1_deg" class="form-control"/></td>
								<td><input type="text" name="x1_min" id="x1_min" class="form-control"/></td>
								<td><input type="text" name="x1_sec" id="x1_sec" class="form-control"/></td>
							</tr>
							<tr>
								<td>2</td>
								<td><input type="text" name="y2_deg" id="y2_deg" class="form-control"/></td>
								<td><input type="text" name="y2_min" id="y2_min" class="form-control"/></td>
								<td><input type="text" name="y2_sec" id="y2_sec" class="form-control"/></td>
								<td><input type="text" name="x2_deg" id="x2_deg" class="form-control"/></td>
								<td><input type="text" name="x2_min" id="x2_min" class="form-control"/></td>
								<td><input type="text" name="x2_sec" id="x2_sec" class="form-control"/></td>
							</tr>
							<tr>
								<td>3</td>
								<td><input type="text" name="y3_deg" id="y3_deg" class="form-control"/></td>
								<td><input type="text" name="y3_min" id="y3_min" class="form-control"/></td>
								<td><input type="text" name="y3_sec" id="y3_sec" class="form-control"/></td>
								<td><input type="text" name="x3_deg" id="x3_deg" class="form-control"/></td>
								<td><input type="text" name="x3_min" id="x3_min" class="form-control"/></td>
								<td><input type="text" name="x3_sec" id="x3_sec" class="form-control"/></td>
							</tr>
							<tr>
								<td>4</td>
								<td><input type="text" name="y4_deg" id="y4_deg" class="form-control"/></td>
								<td><input type="text" name="y4_min" id="y4_min" class="form-control"/></td>
								<td><input type="text" name="y4_sec" id="y4_sec" class="form-control"/></td>
								<td><input type="text" name="x4_deg" id="x4_deg" class="form-control"/></td>
								<td><input type="text" name="x4_min" id="x4_min" class="form-control"/></td>
								<td><input type="text" name="x4_sec" id="x4_sec" class="form-control"/></td>
							</tr>
							<tr>
								<td>5</td>
								<td><input type="text" name="y5_deg" id="y5_deg" class="form-control"/></td>
								<td><input type="text" name="y5_min" id="y5_min" class="form-control"/></td>
								<td><input type="text" name="y5_sec" id="y5_sec" class="form-control"/></td>
								<td><input type="text" name="x5_deg" id="x5_deg" class="form-control"/></td>
								<td><input type="text" name="x5_min" id="x5_min" class="form-control"/></td>
								<td><input type="text" name="x5_sec" id="x5_sec" class="form-control"/></td>
							  </tr>
							  <tr>
								<td>6</td>
								<td><input type="text" name="y6_deg" id="y6_deg" class="form-control"/></td>
								<td><input type="text" name="y6_min" id="y6_min" class="form-control"/></td>
								<td><input type="text" name="y6_sec" id="y6_sec" class="form-control"/></td>
								<td><input type="text" name="x6_deg" id="x6_deg" class="form-control"/></td>
								<td><input type="text" name="x6_min" id="x6_min" class="form-control"/></td>
								<td><input type="text" name="x6_sec" id="x6_sec" class="form-control"/></td>
							</tr>
							<tr>
								<td>7</td>
								<td><input type="text" name="y7_deg" id="y7_deg" class="form-control"/></td>
								<td><input type="text" name="y7_min" id="y7_min" class="form-control"/></td>
								<td><input type="text" name="y7_sec" id="y7_sec" class="form-control"/></td>
								<td><input type="text" name="x7_deg" id="x7_deg" class="form-control"/></td>
								<td><input type="text" name="x7_min" id="x7_min" class="form-control"/></td>
								<td><input type="text" name="x7_sec" id="x7_sec" class="form-control"/></td>
							</tr>
							<tr>
								<td>8</td>
								<td><input type="text" name="y8_deg" id="y8_deg" class="form-control"/></td>
								<td><input type="text" name="y8_min" id="y8_min" class="form-control"/></td>
								<td><input type="text" name="y8_sec" id="y8_sec" class="form-control"/></td>
								<td><input type="text" name="x8_deg" id="x8_deg" class="form-control"/></td>
								<td><input type="text" name="x8_min" id="x8_min" class="form-control"/></td>
								<td><input type="text" name="x8_sec" id="x8_sec" class="form-control"/></td>
							</tr>
							<tr>
								<td>9</td>
								<td><input type="text" name="y9_deg" id="y9_deg" class="form-control"/></td>
								<td><input type="text" name="y9_min" id="y9_min" class="form-control"/></td>
								<td><input type="text" name="y9_sec" id="y9_sec" class="form-control"/></td>
								<td><input type="text" name="x9_deg" id="x9_deg" class="form-control"/></td>
								<td><input type="text" name="x9_min" id="x9_min" class="form-control"/></td>
								<td><input type="text" name="x9_sec" id="x9_sec" class="form-control"/></td>
							</tr>
							<tr>
								<td>10</td>
								<td><input type="text" name="y10_deg" id="y10_deg" class="form-control"/></td>
								<td><input type="text" name="y10_min" id="y10_min" class="form-control"/></td>
								<td><input type="text" name="y10_sec" id="y10_sec" class="form-control"/></td>
								<td><input type="text" name="x10_deg" id="x10_deg" class="form-control"/></td>
								<td><input type="text" name="x10_min" id="x10_min" class="form-control"/></td>
								<td><input type="text" name="x10_sec" id="x10_sec" class="form-control"/></td>
							</tr>
						  </table>
						</div>	
						<div id="geom_4" hidden="hidden">
						  <table class="table">
							<tr>
								<td colspan="2"><?php echo _p("GeomText4"); ?></td>
							</tr>
							<tr>
							  <td style="width: 35%"><?php echo _p("GeomColumn5");?></td>
							  <td><input type="file" name="geom_file_dms" id="geom_file_dms" /></td>
							</tr>
						  </table>
						</div>	
						<div id="geom_5" hidden="hidden">
						  <table class="table">
							<tr>
							  <td style="width: 35%"><?php echo _p("GeomColumn9");?></td>
							  <td><textarea name="geom_value" id="geom_value" class="form-control" rows="6"></textarea></td>
							</tr>
						  </table>
						</div>
					  </td>
					</tr>
				  </tbody>
				</table>
			  </div>			  
			  <input type="hidden" id="insertforestlogginggeombttn" name="insertforestlogginggeombttn" value="0"/>
              <div class="form-group row col-md-10 justify-content-center">
                <div>
                  <button type="button" class="btn btn-primary" onclick="addsubmitform()"><i class="fa fa-check"></i> <?php echo _p("SaveButton");?></button>
                  <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("UndoButton");?></a> </div>
              </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
<?php 
	} else {
		$notify = " <a class=\"btn btn-danger\" href=\"".$my_url.$my_page.$search_url.$sort_url."\"><i class=\"fa fa-undo\"></i> "._p("BackButton")." </a>";
		show_notification("error", _p("NotRowText"), $notify);
	}
} else {
	show_notification("error", _p("NotAccessText"), "");
}		
?>
