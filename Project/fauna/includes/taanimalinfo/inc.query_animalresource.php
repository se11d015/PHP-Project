
<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 11); ?> дэлгэрэнгүй харах</th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($row[$i]["evaluated_date"])) { ?>
      <tr>
        <td class="span4"><strong>Судалгаа хийсэн огноо:</strong></td>
        <td><?php echo $row[$i]["evaluated_date"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["evaluated_org"])) { ?>
      <tr>
        <td class="span4"><strong>Судалгаа хийсэн байгууллагын нэр:</strong></td>
        <td><?php echo $row[$i]["evaluated_org"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["dist_place"])) { ?>
      <tr>
        <td class="span4"><strong>Тархсан газрын нэр:</strong></td>
        <td><?php echo $row[$i]["dist_place"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["dist_area"])) { ?>
      <tr>
        <td class="span4"><strong>Талбайн хэмжээ, га:</strong></td>
        <td><?php echo $row[$i]["dist_area"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["dist_density"])) { ?>
      <tr>
        <td class="span4"><strong>1км2 дах амьтны нягтшил:</strong></td>
        <td><?php echo $row[$i]["dist_density"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["total_head"])) { ?>
      <tr>
        <td class="span4"><strong>Амьтны тоо толгой:</strong></td>
        <td><?php echo $row[$i]["total_head"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["male_head"])) { ?>
      <tr>
        <td class="span4"><strong>Сүргийн бүтэц, Бие гүйцсэн эр:</strong></td>
        <td><?php echo $row[$i]["male_head"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["female_head"])) { ?>
      <tr>
        <td class="span4"><strong>Сүргийн бүтэц, Бие гүйцсэн эм:</strong></td>
        <td><?php echo $row[$i]["female_head"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["yearling_head"])) { ?>
      <tr>
        <td class="span4"><strong>Сүргийн бүтэц, Залуу:</strong></td>
        <td><?php echo $row[$i]["yearling_head"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["young_head"])) { ?>
      <tr>
        <td class="span4"><strong>Сүргийн бүтэц, Төл:</strong></td>
        <td><?php echo $row[$i]["young_head"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["head_density"])) { ?>
      <tr>
        <td class="span4"><strong>Сүргийн нөхөн төлжилт, хувиар:</strong></td>
        <td><?php echo $row[$i]["head_density"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["additional_info"])) { ?>
      <tr>
        <td class="span4"><strong>Нэмэлт мэдээлэл:</strong></td>
        <td><?php echo $row[$i]["additional_info"]; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
