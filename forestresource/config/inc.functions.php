<?php
function generateSessionString($length)
{
	$arr = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789');
    shuffle($arr);
    $arr = array_slice($arr, 0, $length);
    $str = implode('', $arr);
	return $str;
}

function pg_prep($value) 
{ 
  return pg_escape_string($value); 
}

function _p($string)
{
    global $_sl;
    if (isset($_sl[$string])) {
        return $_sl[$string];
    } else {
        return $string;
    }
}

function seldata($name, $style, $values, $selected, $fname="", $inivalue="")
{
	if ($fname=="")
		$sell = '<select name="'.$name.'" id="'.$name.'" class="'.$style.'">';
	else 
		$sell = '<select name="'.$name.'" id="'.$name.'" onchange="'.$fname.'(this)" class="'.$style.'">';

	if ($inivalue!="")
	{
		if ($selected==0)
		{
			$sell  .= '<option value = "0" selected = "selected">-- '.$inivalue.' --</option>';
		} else
		{ 
			$sell  .= '<option value = "0">-- '.$inivalue.' --</option>';
			$inivalue = "";
		}
	}
			
	if($values)
	{
		foreach ($values as $key => $value)
		{
			$v1		= (isset($key)	? htmlentities($key, ENT_QUOTES,  'UTF-8')	: "");
			$v2		= (isset($value)	? htmlentities($value, ENT_QUOTES,  'UTF-8')	: $v1);

			if ($v1!="")
			{
				if ($inivalue=="")
				{
					if($v1==$selected)
					{
						$check = ' selected = "selected"';
					}else 
					{
						$check = '';
					}
				}else
				{
					$check = '';
				}
				$sell  .= '<option value = "'.$v1.'" '.$check.'>'.$v2.'</option>';
			}
		}
	}else 
	{
		$sell .= "";
	}
	
	$sell .= "</select>";
	return $sell;
}

function seldatadb($name, $style, $arrays, $key, $value, $selected, $fname="", $inivalue="")
{
	if ($fname=="")
		$sell = '<select name="'.$name.'" id="'.$name.'" class="'.$style.'">';
	else 
		$sell = '<select name="'.$name.'" id="'.$name.'" onchange="'.$fname.'(this)" class="'.$style.'">';

	if ($inivalue!="")
	{
		if ($selected==0)
		{
			$sell  .= '<option value = "0" selected = "selected">-- '.$inivalue.' --</option>';
		} else
		{ 
			$sell  .= '<option value = "0">-- '.$inivalue.' --</option>';
			$inivalue = "";
		}
	}
	
	if($arrays)
	{
		for ($i=0; $i<sizeof($arrays); $i++)
		{
			$v1		= (isset($arrays[$i][$key])	? htmlentities($arrays[$i][$key], ENT_QUOTES,  'UTF-8')	: "");
			$v2		= (isset($arrays[$i][$value])	? htmlentities($arrays[$i][$value], ENT_QUOTES,  'UTF-8')	: $v1);
			if ($v1!="")
			{
				if ($inivalue=="")
				{
					if($v1==$selected)
					{
						$check = ' selected = "selected"';
					}else 
					{
						$check = '';
					}
				}else
				{
					$check = '';
				}
				$sell  .= '<option value = "'.$v1.'" '.$check.'>'.$v2.'</option>';
			}
		}
	}else 
	{
		$sell .= "";
	}
	
	$sell .= "</select>";
	return $sell;
}

function getdata($values, $selected)
{
	foreach ($values as $key => $value)
	{
		$v1		= (isset($key)	? htmlentities($key, ENT_QUOTES,  'UTF-8')	: "");
		$v2		= (isset($value)	? htmlentities($value, ENT_QUOTES,  'UTF-8')	: $v1);
		if ($v1!="")
		{
			if($v1==$selected)
			{
				return $v2;
			}
		}
	}	
	
	return null;
}
function getdatadb($arrays, $key, $value, $selected)
{
	for ($i=0; $i<sizeof($arrays); $i++)
	{
		$v1		= (isset($arrays[$i][$key])	? htmlentities($arrays[$i][$key], ENT_QUOTES,  'UTF-8')	: "");
		$v2		= (isset($arrays[$i][$value]) ? htmlentities($arrays[$i][$value], ENT_QUOTES,  'UTF-8')	: $v1);

		if ($v1!="")
		{
			if($v1==$selected)
			{
				return $v2;
			}
		}
	}	
	
	return null;
}

?>
