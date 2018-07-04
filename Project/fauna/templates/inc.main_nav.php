
<div class="navbar navbar-static">
  <div class="navbar-inner">
    <div class="container">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <li><a href="index.php">Нүүр хуудас</a></li>
          <li class="divider-vertical"></li>
          <li><a href="index.php?id=20">Амьтны мэдээлэл</a></li>
          <li class="divider-vertical"></li>
          <li><a href="index.php?id=30"><?php echo getdata($GROUP_ITEM_TYPE, 3); ?></a></li>
          <li class="divider-vertical"></li>
          <li><a href="index.php?id=31"><?php echo getdata($GROUP_ITEM_TYPE, 4); ?></a></li>
          <li class="divider-vertical"></li>
          <li><a href="gis.php">Газарзүйн мэдээлэл</a></li>
          <li class="divider-vertical"></li>
          <li><a href="login.php">Мэдээ оруулах</a></li>
          <li class="divider-vertical"></li>
        </ul>
      </div>
    </div>
  </div>
</div>
