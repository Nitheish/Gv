<?
	//For Post and Get Values
	foreach($_POST as $key=>$val)
	{
		${$key} = $val;
	}
	
	foreach($_GET as $key=>$val)
	{
		${$key} = $val;
	}
	
	if(!function_exists('GVGETSERVER'))
	{
		function GVGETSERVER($getServer)
		{
			return $_SERVER[$getServer];
		}
	}
?>