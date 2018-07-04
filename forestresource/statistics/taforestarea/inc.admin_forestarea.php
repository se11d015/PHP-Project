<?php
//$HORIZONTAL_ELEMENT_ID = array("1"=>_p("StatisticsRow1"), "2"=>_p("StatisticsRow2"), "3"=>_p("StatisticsRow3"), "4"=>_p("StatisticsRow4"));
//$HORIZONTAL_ELEMENT_NAME = array("1"=>"area_year", "2"=>"aimag_code", "3"=>"soum_code", "4"=>"type_code");

$HORIZONTAL_ELEMENT_ID = array("2"=>_p("StatisticsRow2"), "3"=>_p("StatisticsRow3"), "4"=>_p("StatisticsRow4"));
$HORIZONTAL_ELEMENT_NAME = array("2"=>"aimag_code", "3"=>"soum_code", "4"=>"type_code");
$VERTICAL_ELEMENT_ID = array("1"=>_p("StatisticsSub1Column1"), "2"=>_p("StatisticsSub1Column2"));
$VERTICAL_ELEMENT_NAME = array("1"=>"forest_area", "2"=>"area_change");
$VERTICAL_ELEMENT_UNIT = array("1"=>_p("StatisticsSub1UNIT"), "2"=>_p("StatisticsSub1UNIT"));

$selQuery = "SELECT MIN(taf.area_year) minyear, MAX(taf.area_year) maxyear FROM ".$schemas.".taforestarea taf";
$rowyear = $db->query($selQuery);	

if(!empty($rowyear) && $rowyear[0]["minyear"]>0) 
	$minyear = $rowyear[0]["minyear"];

if(!empty($rowyear) && $rowyear[0]["maxyear"]>0) 
	$today = $rowyear[0]["maxyear"];

$statistic_aimag_code =  0;
$statistic_horizontal_id = 2;
$statistic_vertical_id = 1;
$statistic_year = $today;
	
if (isset($_POST["searchforestareabttn"])) 
{
	$statistic_aimag_code = (isset($_POST["statistic_aimag_code"])) ? (int) $_POST["statistic_aimag_code"] : 0;
	
	$statistic_horizontal_id = (isset($_POST["statistic_horizontal_id"])) ? (int) $_POST["statistic_horizontal_id"] : 2;
	
	$statistic_vertical_id = (isset($_POST["statistic_vertical_id"])) ? (int) $_POST["statistic_vertical_id"] : 1;

	$statistic_year = (isset($_POST["statistic_year"]) && (int) $_POST["statistic_year"]>0) ? (int) $_POST["statistic_year"] : $today;
	
	if($statistic_year < $minyear)
		$statistic_year = $minyear;
}
	
require("statistics/taforestarea/inc.search_forestarea.php");	

$searchQuery = "";

if ($statistic_aimag_code == 0) 
{
	$searchQuery .= "";
} else 
{
	$searchQuery .= " AND va.aimag_code = ".$statistic_aimag_code;
}
	
if ($statistic_year == 0) 
{
	$searchQuery .= "";
}else
{
	$searchQuery .= " AND taf.area_year = ".$statistic_year;
}

$statistic_horizontal_name = $HORIZONTAL_ELEMENT_NAME[$statistic_horizontal_id];
$statistic_vertical_name = $VERTICAL_ELEMENT_NAME[$statistic_vertical_id];

$startQuery = "SELECT DISTINCT ";
$valueQuery = "sum(taf.".$statistic_vertical_name.") as sum_total";
$fromQuery = "FROM ".$schemas.".taforestarea taf, scadministrative.vasoumname va";
$whereQuery = "WHERE taf.soum_code = va.soum_code";
$groupQuery = "GROUP BY";
$sortQuery = "ORDER BY";

if($statistic_horizontal_id==1){
	$valueQuery .= ", taf.area_year";
	$groupQuery .= " taf.area_year";
	$sortQuery .= " taf.area_year DESC";
}else if($statistic_horizontal_id==2){
	$valueQuery .= ", va.aimag_name_mn, va.aimag_name_en";
	$groupQuery .= " va.aimag_name_mn, va.aimag_name_en";
	$sortQuery .= " va.aimag_name_mn, va.aimag_name_en";
}else if($statistic_horizontal_id==3){
	$valueQuery .= ", va.soum_name_mn, va.soum_name_en";
	$groupQuery .= " va.soum_name_mn, va.soum_name_en";
	$sortQuery .= " va.soum_name_mn, va.soum_name_en";	
}else if($statistic_horizontal_id==4){
	$valueQuery .= ", tcl.type_name_mn, tcl.type_name_en";
	$fromQuery .= ", ".$schemas.".tclandtype tcl";
	$whereQuery .= " AND taf.type_code = tcl.type_code";
	$groupQuery .= " tcl.type_name_mn, tcl.type_name_en";
	$sortQuery .= " tcl.type_name_mn, tcl.type_name_en";
}

$selQuery = $startQuery." ".$valueQuery." ".$fromQuery." ".$whereQuery." ".$searchQuery." ".$groupQuery." ".$sortQuery;
//echo $selQuery;
$rows = $db->query($selQuery);

$count = 10;

if(!empty($rows)) 
{
	$count = sizeof($rows)+1;
?>
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-sub1" role="tab" aria-controls="nav-sub1" aria-selected="true"><?php echo _p("StatisticsBrowseText1"); ?></a>
    <a class="nav-item nav-link" id="nav-sub2-tab" data-toggle="tab" href="#nav-sub2" role="tab" aria-controls="nav-sub2" aria-selected="false"><?php echo _p("StatisticsBrowseText2"); ?></a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-sub1" role="tabpanel" aria-labelledby="nav-sub1-tab">
    <br>
	<div class="table-responsive">
	  <table id="forestresource_datatables" class="table table-bordered table-hover" title_name="<?php echo _p("ResourceSubTitle1"); ?>" file_name="statisticsdata" column_name="0, 1, 2" language_name="<?php echo $language_name;?>" page_count="<?php echo $count;?>">
		<thead>
		  <tr>
			<th><?php echo _p("Number");?></th>
			<th><?php echo _p($HORIZONTAL_ELEMENT_ID[$statistic_horizontal_id]); ?></th>
			<th><?php echo _p($VERTICAL_ELEMENT_ID[$statistic_vertical_id]); ?></th>
		  </tr>
		</thead>
		<tbody>
		  <?php	
		    $sum_total = 0;
		    $check_negative =0;
		   
			for ($i = 0; $i < sizeof($rows); $i++) 
			{
				$sum_total = $sum_total + $rows[$i]["sum_total"];
				if($rows[$i]["sum_total"]<=0) $check_negative++;
			?>
		  <tr>
			<td><?php echo $i + 1; ?></td>
			<td><?php 
					if($statistic_horizontal_id==1){
						echo $rows[$i]["area_year"]; 
					}else if($statistic_horizontal_id==2){
						echo $rows[$i]["aimag_name_$language_name"]; 
					}else if($statistic_horizontal_id==3){
						echo $rows[$i]["soum_name_$language_name"]; 
					}else if($statistic_horizontal_id==4){
						echo $rows[$i]["type_name_$language_name"]; 
					}
				?></td>
			<td><?php echo $rows[$i]["sum_total"]; ?></td>
		  </tr>
		  <?php
			}
			?>
		  <tr>
			<th>-</th>
			<th><?php echo _p("StatisticsBrowseText3"); ?></th>
			<th><?php echo $sum_total; ?></th>
		  </tr>
		</tbody>
	  </table>
	</div>
  </div>
  <div class="tab-pane fade" id="nav-sub2" role="tabpanel" aria-labelledby="nav-sub2-tab">
	<br>
	<div class="pull-left">
		<button type="button" class="chart_option1 btn btn-success" id="column"><i class="fa fa-bar-chart"></i> </button>
		<button type="button" class="chart_option1 btn btn-success" id="line"><i class="fa fa-line-chart"></i> </button>
		<button type="button" class="chart_option1 btn btn-success" id="bar"><i class="fa fa-align-left"></i> </button>
		<button type="button" class="chart_option1 btn btn-success" id="area"><i class="fa fa-area-chart"></i> </button>
		<?php if($check_negative==0) { ?>
		<button type="button" class="chart_option1 btn btn-success" id="pie"><i class="fa fa-pie-chart"></i> </button>
		<?php } ?>
	</div>
	<div id="highchart-container1"></div>
  </div>
</div>
<script>
$(function() {
	var datacategories = [
		<?php for ($i=0; $i < sizeof($rows); $i++){ 	
			if($statistic_horizontal_id==1){
				echo "'".$rows[$i]["area_year"]."', ";
			} else if($statistic_horizontal_id==2){
				echo "'".$rows[$i]["aimag_name_$language_name"]."', "; 
			} else if($statistic_horizontal_id==3){
				echo "'".$rows[$i]["soum_name_$language_name"]."', ";
			} else if($statistic_horizontal_id==4){
				echo "'".$rows[$i]["type_name_$language_name"]."', ";
			}
		
		} ?>
	];
	var dataseries = [{
		name: '<?php echo $VERTICAL_ELEMENT_ID[$statistic_vertical_id]; ?>',		
		data: [			
		<?php for ($i=0; $i < sizeof($rows); $i++) { 
			if($statistic_horizontal_id==1){
				echo "[ '".$rows[$i]["area_year"]."', ";
			} else if($statistic_horizontal_id==2){
				echo "[ '".$rows[$i]["aimag_name_$language_name"]."', "; 
			} else if($statistic_horizontal_id==3){
				echo "[ '".$rows[$i]["soum_name_$language_name"]."', ";
			} else if($statistic_horizontal_id==4){
				echo "[ '".$rows[$i]["type_name_$language_name"]."', ";
			}
			if(!empty($rows[$i]["sum_total"])) echo round($rows[$i]["sum_total"],2)." ], "; else echo "0 ], "; } ?>
		], 
		color: Highcharts.getOptions().colors[3]
	}];

		//create a variable so we can pass the value dynamically
	var chartype = 'column';
 
	//On page load call the function setDynamicChart
	setDynamicChart(chartype);
 
	//jQuery part - On Click call the function setDynamicChart(dynval) and pass the chart type
	$('.chart_option1').click(function(){
		//get the value from 'a' tag
		var chartype = $(this).attr('id');
		setDynamicChart(chartype);
	});
 
	//function is created so we pass the value dynamically and be able to refresh the HighCharts on every click
 
	function setDynamicChart(chartype){
		$('#highchart-container1').highcharts({
			chart: {
				type: chartype,
			},
			credits: {
				enabled: false,
			},
			title: {
				text: '<?php echo $VERTICAL_ELEMENT_ID[$statistic_vertical_id]; ?>',
			},
			xAxis: {
				categories: datacategories,
			},
			yAxis: {
				title: {
					text: '<?php echo $VERTICAL_ELEMENT_UNIT[$statistic_vertical_id]; ?>',
				}
			},	
			tooltip: {
				shared: true,
				useHTML: true,
				crosshairs: [true,true],
			},
			plotOptions: {
				line: {
					dataLabels: {
						enabled: true,
					}, 
					tooltip: {
						headerFormat: '{point.key} <br>',
						pointFormat: '{series.name}: <strong>{point.y}</strong> <br>',
					},					
				}, 
				area: {
					dataLabels: {
						enabled: true,
					},
					fillOpacity: 0.5, 
					tooltip: {
						headerFormat: '{point.key} <br>',
						pointFormat: '{series.name}: <strong>{point.y}</strong> <br>',
					},	
				}, 
				column: {
					dataLabels: {
						enabled: true,
					},
					pointPadding: 0.2,
					borderWidth: 0,
					groupPadding: 0,
					shadow: false,
					tooltip: {
						headerFormat: '{point.key} <br>',
						pointFormat: '{series.name}: <strong>{point.y}</strong> <br>',
					},					
				},
				bar: {
					dataLabels: {
						enabled: true,
					},
					pointPadding: 0.2,
					borderWidth: 0,
					groupPadding: 0,
					shadow: false,
					tooltip: {
						headerFormat: '{point.key} <br>',
						pointFormat: '{series.name}: <strong>{point.y}</strong> <br>',
					},					
				},
				pie: {
					size:'100%',
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '<strong>{point.name}</strong>: {point.percentage:.1f} %',
					},
					showInLegend: true,
					tooltip: {
						pointFormat: '{point.y} <?php echo $VERTICAL_ELEMENT_UNIT[$statistic_vertical_id]; ?>, {point.percentage:.1f}%'
					},	
				}
			},
			series: dataseries,
		});
	}   
});

</script>
<?php
	} else {
		show_notification("error", _p("NotRowText"), "");	
	}
?>

