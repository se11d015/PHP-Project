<?php
if ($error!="")
{
	show_notification("error", "Алдаа: ", $error);
}
?>

<div class="login-table">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Нэвтрэх хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><span class="text-error">Мэдээллийн санд мэдээ оруулах эрх бүхий хэрэглэгч нэвтэрнэ.</span></td>
      </tr>
      <tr>
        <td><form class="form-inline" method="post" action="<?php echo $my_url; ?>">
            <input type="text" class="input-small" placeholder="Нэвтрэх нэр" name="username">
            <input type="password" class="input-small" placeholder="Нууц үг" name="password">
            <button type="submit" class="btn btn-danger" name="loginbttn">Нэвтрэх</button>
            <button type="reset" class="btn btn-danger">Болих</button>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
