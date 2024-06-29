<?php
function trimwidth($str,$start,$length,$m='...')
{
	if(strlen($str)>($length+$start))
	{
		$str = substr($str,$start,$length);
		
		$pos = strrpos($str,' ');
		$str = substr($str,$start,$pos) . $m;
	}
	return $str;
}
?>