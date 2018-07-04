<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 14); ?> дэлгэрэнгүй харах</th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($row[$i]["photo_filename"])) {?>
      <tr>
        <td colspan="2"><div class="span2"> <a href="#" data-toggle="lightbox" data-target="#lightbox5" > <img  class="thumbnail" src="<?php echo $row[$i]["photo_pathname"].$row[$i]["photo_filename"];?>"  title="Амьтны зураг"/></a>
            <!-- Modal -->
            <div class="lightbox hide fade" id="lightbox5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class='lightbox-content'>
                <button type="button" class="close" data-dismiss="lightbox" aria-hidden="true">&times;</button>
                <img  src="<?php echo $row[$i]["photo_pathname"].$row[$i]["photo_filename"];?>" /> </div>
            </div>
            </a> </div></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["photo_date"])) { ?>
      <tr>
        <td class="span4"><strong>Зураг авсан огноо:</strong></td>
        <td><?php echo $row[$i]["photo_date"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["photo_title"])) { ?>
      <tr>
        <td class="span4"><strong>Зургийн гарчиг:</strong></td>
        <td><?php echo $row[$i]["photo_title"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["aimag_name_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Зураг авсан аймгийн нэр:</strong></td>
        <td><?php echo $row[$i]["aimag_name_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["soum_name_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Зураг авсан сумын нэр:</strong></td>
        <td><?php echo $row[$i]["soum_name_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["photo_place"])) { ?>
      <tr>
        <td class="span4"><strong>Зургийг авсан газрын нэр:</strong></td>
        <td><?php echo $row[$i]["photo_place"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["photo_auhtor"])) { ?>
      <tr>
        <td class="span4"><strong>Зургийг авсан хүний нэр:</strong></td>
        <td><?php echo $row[$i]["photo_auhtor"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["photo_description"])) { ?>
      <tr>
        <td class="span4"><strong>Зургийн тайлбар:</strong></td>
        <td><?php echo $row[$i]["photo_description"]; ?></td>
      </tr>
      <?php } ?>
      <?php if (!empty($row[$i]["geom"])) { ?>
      <tr>
        <td><strong>Газарзүйн солбицол:</strong></td>
        <td><?php
			echo "| <a  href=\"".$my_url.$my_page.$search_url.$sort_url."&action=outputanimalpicture&outputtype=2&picture_id=".$row[$i]["picture_id"]."\">Координатаар харах</a> ";
			echo "| <a href=\"".$my_url.$my_page.$search_url.$sort_url."&action=outputanimalpicture&outputtype=3&picture_id=".$row[$i]["picture_id"]."\">Google KML-аар харах</a> |";
			?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
