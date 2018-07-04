<div class="row">
  <div class="col">
    <?php	
		$my_url = "forestresource.php?id=10";
		$schemas = "scforestresource";	
		
		$sum = 0;
		
		?>
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist"> <a class="nav-item nav-link active" id="nav-sub1-tab" data-toggle="tab" href="#nav-sub1" role="tab" aria-controls="nav-sub1" aria-selected="true"><?php echo _p("ReferenceSubTitle1"); ?></a> <a class="nav-item nav-link" id="nav-sub2-tab" data-toggle="tab" href="#nav-sub2" role="tab" aria-controls="nav-sub2" aria-selected="false"><?php echo _p("ReferenceSubTitle2"); ?></a> <a class="nav-item nav-link" id="nav-sub3-tab" data-toggle="tab" href="#nav-sub3" role="tab" aria-controls="nav-sub3" aria-selected="false"><?php echo _p("ReferenceSubTitle3"); ?></a> <a class="nav-item nav-link" id="nav-sub4-tab" data-toggle="tab" href="#nav-sub4" role="tab" aria-controls="nav-sub4" aria-selected="false"><?php echo _p("ReferenceSubTitle4"); ?></a> </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-sub1" role="tabpanel" aria-labelledby="nav-sub1-tab">
        <?php
			$startQuery = "SELECT";
			$valueQuery = "va.aimag_code, va.aimag_name_mn, va.aimag_name_en, va.soum_code, va.soum_name_mn, va.soum_name_en FROM scadministrative.vasoumname va";
			$orderQuery = "ORDER BY va.aimag_name_mn ASC, va.soum_code ASC";
			
			$selQuery = $startQuery." ".$valueQuery." ".$orderQuery;
		
			$rows = $db->query($selQuery);
			
			if(!empty($rows))
			{

			?>
        <br>
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th colspan="5"><?php echo _p("ReferenceSubTitle1");?></th>
              </tr>
              <tr>
                <th>№</th>
                <th><?php echo _p("ReferenceSub1Column1");?></th>
                <th><?php echo _p("ReferenceSub1Column2");?></th>
                <th><?php echo _p("ReferenceSub1Column3");?></th>
                <th><?php echo _p("ReferenceSub1Column4");?></th>
              </tr>
            </thead>
            <tbody>
              <?php	
					for ($i = 0; $i < sizeof($rows); $i++) 
					{
					?>
              <tr>
                <td><?php echo $i + 1; ?></td>
                <td><?php echo $rows[$i]["aimag_code"]; ?></td>
                <td><?php echo $rows[$i]["aimag_name_$language_name"]; ?></td>
                <td><?php echo $rows[$i]["soum_code"]; ?></td>
                <td><?php echo $rows[$i]["soum_name_$language_name"]; ?></td>
              </tr>
              <?php
					}
					?>
            </tbody>
          </table>
        </div>
        <?php
			}
			?>
      </div>
      <div class="tab-pane fade" id="nav-sub2" role="tabpanel" aria-labelledby="nav-sub2-tab">
        <?php
			$startQuery = "SELECT";
			$valueQuery = "tct.tree_code, tct.science_name, tct.tree_name_mn, tct.tree_name_en, tct.tree_name_ru FROM ".$schemas.".tctreetype tct";
			$orderQuery = "ORDER BY tct.tree_code ASC";
		
			$selQuery = $startQuery." ".$valueQuery." ".$orderQuery;
		
			$rows = $db->query($selQuery);
			
			if(!empty($rows))
			{
			?>
        <br>
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th colspan="5"><?php echo _p("ReferenceSubTitle2");?></th>
              </tr>
              <tr>
                <th><?php echo _p("ReferenceSub2Column1");?></th>
                <th><?php echo _p("ReferenceSub2Column2");?></th>
                <th><?php echo _p("ReferenceSub2Column3");?></th>
                <th><?php echo _p("ReferenceSub2Column4");?></th>
                <th><?php echo _p("ReferenceSub2Column5");?></th>
              </tr>
            </thead>
            <tbody>
              <?php	
					for ($i = 0; $i < sizeof($rows); $i++) 
					{
					?>
              <tr>
                <td><?php echo $rows[$i]["tree_code"]; ?></td>
                <td><?php echo $rows[$i]["science_name"]; ?></td>
                <td><?php echo $rows[$i]["tree_name_mn"]; ?></td>
                <td><?php echo $rows[$i]["tree_name_en"]; ?></td>
                <td><?php echo $rows[$i]["tree_name_ru"]; ?></td>
              </tr>
              <?php
					}
					?>
            </tbody>
          </table>
        </div>
        <?php
			}
			?>
      </div>
      <div class="tab-pane fade" id="nav-sub3" role="tabpanel" aria-labelledby="nav-sub3-tab">
        <?php
			$startQuery = "SELECT";
			$valueQuery = "tct.type_code, tct.type_name_mn, tct.type_name_en, tct.type_name_ru FROM ".$schemas.".tclandtype tct";
			$orderQuery = "ORDER BY tct.type_code ASC";
		
			$selQuery = $startQuery." ".$valueQuery." ".$orderQuery;
		
			$rows = $db->query($selQuery);
			
			if(!empty($rows))
			{
			?>
        <br>
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th colspan="4"><?php echo _p("ReferenceSubTitle3");?></th>
              </tr>
              <tr>
                <th><?php echo _p("ReferenceSub3Column1");?></th>
                <th><?php echo _p("ReferenceSub3Column2");?></th>
                <th><?php echo _p("ReferenceSub3Column3");?></th>
                <th><?php echo _p("ReferenceSub3Column4");?></th>
              </tr>
            </thead>
            <tbody>
              <?php	
					for ($i = 0; $i < sizeof($rows); $i++) 
					{
					?>
              <tr>
                <td><?php echo $rows[$i]["type_code"]; ?></td>
                <td><?php echo $rows[$i]["type_name_mn"]; ?></td>
                <td><?php echo $rows[$i]["type_name_en"]; ?></td>
                <td><?php echo $rows[$i]["type_name_ru"]; ?></td>
              </tr>
              <?php
					}
					?>
            </tbody>
          </table>
        </div>
        <?php
			}
			?>
      </div>
      <div class="tab-pane fade" id="nav-sub4" role="tabpanel" aria-labelledby="nav-sub4-tab">
        <?php
			$startQuery = "SELECT";
			$valueQuery = "tct.insect_code, tct.species_name, tct.order_name_mn, tct.family_name_mn, tct.insect_name_mn, tct.insect_name_en, tct.insect_name_ru	 FROM ".$schemas.".tcinsectname tct";
			$orderQuery = "ORDER BY tct.insect_code ASC";
		
			$selQuery = $startQuery." ".$valueQuery." ".$orderQuery;
		
			$rows = $db->query($selQuery);
			
			if(!empty($rows))
			{
			?>
        <br>
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th colspan="7"><?php echo _p("ReferenceSubTitle4");?></th>
              </tr>
              <tr>
                <th><?php echo _p("ReferenceSub4Column1");?></th>
                <th><?php echo _p("ReferenceSub4Column2");?></th>
                <th><?php echo _p("ReferenceSub4Column3");?></th>
                <th><?php echo _p("ReferenceSub4Column4");?></th>
                <th><?php echo _p("ReferenceSub4Column5");?></th>
                <th><?php echo _p("ReferenceSub4Column6");?></th>
                <th><?php echo _p("ReferenceSub4Column7");?></th>
              </tr>
            </thead>
            <tbody>
              <?php	
					for ($i = 0; $i < sizeof($rows); $i++) 
					{
					?>
              <tr>
                <td><?php echo $rows[$i]["insect_code"]; ?></td>
                <td><?php echo $rows[$i]["order_name_mn"]; ?></td>
                <td><?php echo $rows[$i]["family_name_mn"]; ?></td>
                <td><?php echo $rows[$i]["species_name"]; ?></td>
                <td><?php echo $rows[$i]["insect_name_mn"]; ?></td>
                <td><?php echo $rows[$i]["insect_name_en"]; ?></td>
                <td><?php echo $rows[$i]["insect_name_ru"]; ?></td>
              </tr>
              <?php
					}
					?>
            </tbody>
          </table>
        </div>
        <?php
			}
			?>
      </div>
    </div>
  </div>
</div>
