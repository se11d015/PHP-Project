<?php
function page_name($nr, $my_url, $search_url="") {
	$my_url.='&page_new='.$nr;
	if ($search_url!='')
		$my_url.=$search_url;
	return $my_url;
}

function pagelink3($page_visible, $maxpage, $my_url="", $pagenum, $search_url="")
{
	if($maxpage>0) {
?>


<nav aria-label="page navigation">
  <ul class="pagination justify-content-md-center">
    <?php
		if ($pagenum > 1)
		{
			echo '<li class="page-item"><a class="page-link" href="'.page_name(1, $my_url, $search_url).'">&laquo;</a></li>';
			echo '<li class="page-item"><a class="page-link" href="'.page_name(($pagenum-1), $my_url, $search_url).'">&#8249;</a></li>';
		}else
		{
			echo '<li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>';
			echo '<li class="page-item disabled"><a class="page-link" href="#">&#8249;</a></li>';
		}

		$i=1;
		while ($i <= $page_visible)
		{								
			if ($pagenum-ceil($page_visible/2) < 0)
			{
				if ($i==$pagenum) 
					echo '<li class="page-item active"><a class="page-link" href="#">'.($pagenum).'</a></li>';
				else 
					echo '<li class="page-item"><a class="page-link" href="'.page_name($i, $my_url, $search_url).'">'.($i).'</a></li>';
			} elseif ($pagenum+floor($page_visible/2) > $maxpage)
			{
				if($maxpage > $page_visible) 
					$j = $maxpage-$page_visible+$i;
				else 
					$j = $i;
				
				if ($j==$pagenum) 
					echo '<li class="page-item active"><a class="page-link" href="#">'.($pagenum).'</a></li>';
				else 
					echo '<li class="page-item"><a class="page-link" href="'.page_name($j, $my_url, $search_url).'">'.$j.'</a></li>';
				
			} else
			{
				if ($i==ceil($page_visible/2)) 
					echo '<li class="page-item active"><a class="page-link" href="#">'.($pagenum).'</a></li>';
				else
				{
					$j = $pagenum-ceil($page_visible/2)+$i;
					echo '<li class="page-item"><a class="page-link" href="'.page_name($j, $my_url, $search_url).'">'.$j.'</a></li>';
				}
			}
			if ($i==$maxpage) break;
			$i++;
		}
	
		if ($pagenum < $maxpage)
		{
			echo '<li class="page-item"><a class="page-link" href="'.page_name(($pagenum+1), $my_url, $search_url).'">&#8250;</a></li>';
			echo '<li class="page-item"><a class="page-link" href="'.page_name($maxpage, $my_url, $search_url).'">&raquo;</a></li>';
		} else {
			echo '<li class="page-item disabled"><a class="page-link" href="#">&#8250;</a></li>';
			echo '<li class="page-item disabled"><a class="page-link" href="#">&raquo;</a></li>';
		}
			?>
  </ul></nav>
<?php
	}
}
?>
