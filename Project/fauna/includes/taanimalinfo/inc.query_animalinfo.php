
<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 10); ?> дэлгэрэнгүй харах</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($row[$i]["fauna_filename1"]) || !empty($row[$i]["fauna_filename2"]) || !empty($row[$i]["fauna_filename3"]) || !empty($row[$i]["dist_filename"])) { ?>
      <tr>
        <td colspan="2"><?php if (!empty($row[$i]["fauna_filename1"])) { ?>
          <div class="span2"> <a href="#" data-toggle="lightbox" data-target="#lightbox1" > <img  class="thumbnail" src="<?php echo $row[$i]["picture_pathname"].$row[$i]["fauna_filename1"];?>"  title="Амьтны зураг"/></a>
            <!-- Modal -->
            <div class="lightbox hide fade" id="lightbox1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class='lightbox-content'>
                <button type="button" class="close" data-dismiss="lightbox" aria-hidden="true">&times;</button>
                <img  src="<?php echo $row[$i]["picture_pathname"].$row[$i]["fauna_filename1"];?>" /> </div>
            </div>
            </a>
            <p align="center">Амьтны зураг 1</p>
          </div>
          <?php } ?>
          <?php if (!empty($row[$i]["fauna_filename2"])) { ?>
          <div class="span2"> <a href="#" data-toggle="lightbox" data-target="#lightbox2" > <img  class="thumbnail" src="<?php echo $row[$i]["picture_pathname"].$row[$i]["fauna_filename2"];?>"  title="Амьтны зураг"/></a>
            <!-- Modal -->
            <div class="lightbox hide fade" id="lightbox2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class='lightbox-content'>
                <button type="button" class="close" data-dismiss="lightbox" aria-hidden="true">&times;</button>
                <img  src="<?php echo $row[$i]["picture_pathname"].$row[$i]["fauna_filename2"];?>" /> </div>
            </div>
            </a>
            <p align="center">Амьтны зураг 2</p>
          </div>
          <?php } ?>
          <?php if (!empty($row[$i]["fauna_filename3"])) { ?>
          <div class="span2"> <a href="#" data-toggle="lightbox" data-target="#lightbox3" > <img  class="thumbnail" src="<?php echo $row[$i]["picture_pathname"].$row[$i]["fauna_filename3"];?>"  title="Амьтны зураг"/></a>
            <!-- Modal -->
            <div class="lightbox hide fade" id="lightbox3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class='lightbox-content'>
                <button type="button" class="close" data-dismiss="lightbox" aria-hidden="true">&times;</button>
                <img  src="<?php echo $row[$i]["picture_pathname"].$row[$i]["fauna_filename3"];?>" /> </div>
            </div>
            </a>
            <p align="center">Амьтны зураг 3</p>
          </div>
          <?php } ?>
          <?php if (!empty($row[$i]["dist_filename"])) { ?>
          <div class="span2"> <a href="#" data-toggle="lightbox" data-target="#lightbox4" > <img  class="thumbnail" src="<?php echo $row[$i]["picture_pathname"].$row[$i]["dist_filename"];?>"  title="Амьтны зураг"/></a>
            <!-- Modal -->
            <div class="lightbox hide fade" id="lightbox4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class='lightbox-content'>
                <button type="button" class="close" data-dismiss="lightbox" aria-hidden="true">&times;</button>
                <img  src="<?php echo $row[$i]["picture_pathname"].$row[$i]["dist_filename"];?>" /> </div>
            </div>
            </a>
            <p align="center">Тархалтын зураг </p>
          </div>
          <?php } ?></td>
      </tr>
      <?php } ?>
      <tr>
        <td class="span4"><strong>Аймгийн нэр:</strong></td>
        <td><?php 
			if(!empty($row[$i]["kingdom_name"])) echo $row[$i]["kingdom_name"]; 
			if(!empty($row[$i]["kingdom_name_mn"])) echo " - ".$row[$i]["kingdom_name_mn"]; 
			if(!empty($row[$i]["kingdom_name_en"])) echo " - ".$row[$i]["kingdom_name_en"]; 
			if(!empty($row[$i]["kingdom_name_ru"])) echo " - ".$row[$i]["kingdom_name_ru"];
			?></td>
      </tr>
      <tr>
        <td><strong>Хүрээний нэр:</strong></td>
        <td><?php 
			if(!empty($row[$i]["phylum_name"])) echo $row[$i]["phylum_name"]; 
			if(!empty($row[$i]["phylum_name_mn"])) echo " - ".$row[$i]["phylum_name_mn"]; 
			if(!empty($row[$i]["phylum_name_en"])) echo " - ".$row[$i]["phylum_name_en"]; 
			if(!empty($row[$i]["phylum_name_ru"])) echo " - ".$row[$i]["phylum_name_ru"];
			?></td>
      </tr>
      <tr>
        <td><strong>Ангийн нэр:</strong></td>
        <td><?php 
			if(!empty($row[$i]["class_name"])) echo $row[$i]["class_name"]; 
			if(!empty($row[$i]["class_name_mn"])) echo " - ".$row[$i]["class_name_mn"]; 
			if(!empty($row[$i]["class_name_en"])) echo " - ".$row[$i]["class_name_en"]; 
			if(!empty($row[$i]["class_name_ru"])) echo " - ".$row[$i]["class_name_ru"];
			?></td>
      </tr>
      <tr>
        <td><strong>Багийн нэр:</strong></td>
        <td><?php 
			if(!empty($row[$i]["order_name"])) echo $row[$i]["order_name"]; 
			if(!empty($row[$i]["order_name_mn"])) echo " - ".$row[$i]["order_name_mn"]; 
			if(!empty($row[$i]["order_name_en"])) echo " - ".$row[$i]["order_name_en"]; 
			if(!empty($row[$i]["order_name_ru"])) echo " - ".$row[$i]["order_name_ru"];
			?></td>
      </tr>
      <tr>
        <td><strong>Овгийн нэр:</strong></td>
        <td><?php 
			if(!empty($row[$i]["family_name"])) echo $row[$i]["family_name"]; 
			if(!empty($row[$i]["family_name_mn"])) echo " - ".$row[$i]["family_name_mn"]; 
			if(!empty($row[$i]["family_name_en"])) echo " - ".$row[$i]["family_name_en"]; 
			if(!empty($row[$i]["family_name_ru"])) echo " - ".$row[$i]["family_name_ru"];
			?></td>
      </tr>
      <tr>
        <td><strong>Төрлийн нэр:</strong></td>
        <td><?php 
			if(!empty($row[$i]["genus_name"])) echo $row[$i]["genus_name"]; 
			if(!empty($row[$i]["genus_name_mn"])) echo " - ".$row[$i]["genus_name_mn"]; 
			if(!empty($row[$i]["genus_name_en"])) echo " - ".$row[$i]["genus_name_en"]; 
			if(!empty($row[$i]["genus_name_ru"])) echo " - ".$row[$i]["genus_name_ru"];
			?></td>
      </tr>
      <tr>
        <td><strong>Зүйлийн нэр:</strong></td>
        <td><?php 
			if(!empty($row[$i]["species_name"])) echo $row[$i]["species_name"]; 
			if(!empty($row[$i]["species_name_mn"])) echo " - ".$row[$i]["species_name_mn"]; 
			if(!empty($row[$i]["species_name_en"])) echo " - ".$row[$i]["species_name_en"]; 
			if(!empty($row[$i]["species_name_ru"])) echo " - ".$row[$i]["species_name_ru"];
			?></td>
      </tr>
      <?php if(!empty($row[$i]["description_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Таних шинж, монголоор:</strong></td>
        <td><?php echo $row[$i]["description_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["description_en"])) { ?>
      <tr>
        <td class="span4"><strong>Таних шинж, англиар:</strong></td>
        <td><?php echo $row[$i]["description_en"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["distribution_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Тархац, монголоор:</strong></td>
        <td><?php echo $row[$i]["distribution_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["distribution_en"])) { ?>
      <tr>
        <td class="span4"><strong>Тархац, англиар:</strong></td>
        <td><?php echo $row[$i]["distribution_en"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["habitat_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Амьдрах орчин, монголоор:</strong></td>
        <td><?php echo $row[$i]["habitat_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["habitat_en"])) { ?>
      <tr>
        <td class="span4"><strong>Амьдрах орчин, англиар:</strong></td>
        <td><?php echo $row[$i]["habitat_en"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["benefit_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Ач холбогдол, монголоор:</strong></td>
        <td><?php echo $row[$i]["benefit_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["benefit_en"])) { ?>
      <tr>
        <td class="span4"><strong>Ач холбогдол, англиар:</strong></td>
        <td><?php echo $row[$i]["benefit_en"]; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
