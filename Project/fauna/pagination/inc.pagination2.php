<?php
function page_name($nr, $my_url, $search_url="") {
	$my_url.='?page='.$nr;
	if ($search_url!='')
		$my_url.=$search_url;
	return $my_url;
}

function pagelink2($page_visible, $maxpage, $my_url="", $pagenum, $search_url="")
{
	if($maxpage>0) {
?>

<div class="pagenumber" align="center">
  <div class="pagination">
    <ul>
      <?php
		if ($pagenum > 1)
		{
			echo '<li><a href="'.page_name(1, $my_url, $search_url).'">&laquo;</a></li>';
			echo '<li><a href="'.page_name(($pagenum-1), $my_url, $search_url).'">&#8249;</a></li>';
		}else
		{
			echo '<li class="disabled"><a href="#">&laquo;</a></li>';
			echo '<li class="disabled"><a href="#">&#8249;</a></li>';
		}

		$i=1;
		while ($i <= $page_visible)
		{								
			if ($pagenum-ceil($page_visible/2) < 0)
			{
				if ($i==$pagenum) 
					echo '<li class="active"><a href="#">'.($pagenum).'</a></li>';
				else 
					echo '<li><a href="'.page_name($i, $my_url, $search_url).'">'.($i).'</a></li>';		
			} elseif ($pagenum+floor($page_visible/2) > $maxpage)
			{
				if($maxpage > $page_visible) 
					$j = $maxpage-$page_visible+$i;
				else 
					$j = $i;
				
				if ($j==$pagenum) 
					echo '<li class="active"><a href="#">'.($pagenum).'</a></li>';
				else 
					echo '<li><a href="'.page_name($j, $my_url, $search_url).'">'.$j.'</a></li>';
				
			} else
			{
				if ($i==ceil($page_visible/2)) 
					echo '<li class="active"><a href="#">'.($pagenum).'</a></li>';
				else
				{
					$j = $pagenum-ceil($page_visible/2)+$i;
					echo '<li><a href="'.page_name($j, $my_url, $search_url).'">'.$j.'</a></li>';
				}
			}
			if ($i==$maxpage) break;
			$i++;
		}
	
		if ($pagenum < $maxpage)
		{
			echo '<li><a href="'.page_name(($pagenum+1), $my_url, $search_url).'">&#8250;</a></li>';
			echo '<li><a href="'.page_name($maxpage, $my_url, $search_url).'">&raquo;</a></li>';
		} else {
			echo '<li class="disabled"><a href="#">&#8250;</a></li>';
			echo '<li class="disabled"><a href="#">&raquo;</a></li>';
		}
			?>
    </ul>
  </div>
</div>
<?php
	}
}
?>
