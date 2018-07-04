
<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("SearchTitle"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-inline" role="form" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
			<label class="mr-2"><?php echo _p("ReferenceSub3Column2");?>:</label>
			<input type="text" class="form-control col-md-5 mr-2 mb-2" name="type_name_mn" id="type_name_mn" value="<?php echo $type_name_mn;?>"/>
			<button type="submit" class="btn btn-primary mb-2" name="searchtypebttn"><i class="fa fa-search"></i> <?php echo _p("SearchButton"); ?></button>
        </form></td>
      </tr>
    </tbody>
  </table>
</div>
