<?php
if ($error!="")
{
	show_notification("error", _p("LoginError"), $error);
}
?>

<table class="table table-bordered">
  <thead>
    <tr>
      <th><?php echo _p("LoginTitle"); ?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><span class="text-danger"><?php echo _p("LoginText"); ?></span></td>
    </tr>
    <tr>
      <td><form class="form" role="form" method="post" action="<?php echo $my_url; ?>">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail"><?php echo _p("LoginName"); ?>:</label>
              <input name="username" type="text" class="form-control">
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword"><?php echo _p("LoginPassword"); ?>:</label>
              <input name="password" type="password" class="form-control" size="25">
            </div>
          </div>
          <button type="submit" class="btn btn-success" name="loginbttn"><i class="fa fa-sign-in"></i> <?php echo _p("LoginButton"); ?></button>
          <button type="reset" class="btn btn-success"><i class="fa fa-refresh"></i> <?php echo _p("CancelButton"); ?></button>
        </form></td>
    </tr>
  </tbody>
</table>
