<script language="JavaScript" type="text/javascript">
    function addsubmitform()
    {
        if (document.getElementById("status_code").value == "") {
            alert("Ангиллын кодыг оруулна уу");
        }
        else {
            document.getElementById("insertredliststatusbttn").value = "1";
            document.mainform.submit();
        }
    }
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 22); ?> бүртгэх хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <div class="control-group">
              <label class="control-label">Ангиллын код:</label>
              <div class="controls">
                <input type="text" name="status_code" id="status_code"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ангиллын монгол нэр:</label>
              <div class="controls">
                <input type="text" name="name_mn" id="name_mn" class="span4"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ангиллын англи нэр:</label>
              <div class="controls">
                <input type="text" name="name_en" id="name_en" class="span4"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ангиллын монгол тайлбар:</label>
              <div class="controls">
                <textarea name="desc_mn" id="desc_mn" class="span4" rows=5></textarea>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ангиллын англи тайлбар:</label>
              <div class="controls">
                <textarea name="desc_en" id="desc_en"  class="span4" rows=5></textarea>
              </div>
            </div>
            <input type="hidden" id="insertredliststatusbttn" name="insertredliststatusbttn" value="0"/>
            <div class="form-actions">
              <button type="button" class="btn btn-danger" onclick="addsubmitform()"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
              <a class="btn btn-danger" href="<?php echo $my_url.$my_page; ?>"><i class="icon-share-alt icon-white"></i>&nbsp;Болих</a> </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
