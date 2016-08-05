<?php
include("..\LIB_http.php");
include("..\LIB_parse.php");

if (($handle = fopen("novel.txt", 'w')) == FALSE)
{
	echo 'failed to open file for writing';
}
else
{
	for($var=1; $var<=25; $var++)
	{
		$page_code = "{$var}";
		// Download the target file
		$target = "http://tieba.baidu.com/p/1601074814?pn=" . $page_code;
		$web_page = http_get($target, "");
		#echo $web_page['FILE'];
		#fwrite ($handle, $web_page['FILE']);

		$cc_array = parse_array($web_page['FILE'], "<cc", "</cc>");
		echo "ITEMS: ", count($cc_array), "\n";
		for($xx=0; $xx<count($cc_array); $xx++)
		{
			$div_array = parse_array($cc_array[$xx], "<div", "</div>");
			#echo "ITEMS: ", count($div_array), "\n";
			for($yy=0; $yy<count($div_array); $yy++)
			{
				#echo $div_array[$yy];
				$text = str_replace("<br>", "\n", $div_array[$yy]);
				#echo $text;
				$text = strip_tags(trim($text));
				#echo $text;
				fwrite ($handle, $text);
			}
		}

		#sleep(1);
	}
}

fclose($handle);

?>