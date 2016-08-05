<?php
include("..\LIB_http.php");
include("..\LIB_parse.php");

if (($handle = fopen("novel.txt", 'w')) == FALSE)
{
	echo 'failed to open file for writing';
}
else
{
	$domain = "http://www.zuiyq.com/big5/zuiyq/9/9026/";
	echo $domain, "\n";
	$domain_page = http_get($domain, "");
	#echo $domain_page['FILE'];
	#fwrite ($handle, $domain_page['FILE']);

	$href_array = parse_array($domain_page['FILE'], "href", "html");
	echo "ITEMS: ", count($href_array), "\n";

	$index=0;
	$toget=0;
	for($xx=4; $xx<=196; $xx++) // 4 to 196 is the magic number
	{
		switch ($index%8)
		{
			case 0:
				$toget  =  $xx;
				break;
			case 1:
				$toget = $xx+1;
				break;
			case 2:
				$toget = $xx+2;
				break;
			case 3:
				$toget = $xx+3;
				break;
			case 4:
				$toget = $xx-3;
				break;
			case 5:
				$toget = $xx-2;
				break;
			case 6:
				$toget = $xx-1;
				break;
			case 7:
				$toget = $xx;
				break;
		}
		
		$aa = strpos($href_array[$toget], "html");
		$target = $domain . substr($href_array[$toget], 6, $aa-2);
		echo $target, "\n";

		// Download the target file
		$web_page = http_get($target, "");
		#echo $web_page['FILE'];
		#fwrite ($handle, $web_page['FILE']);

		$contentmiddle_array = parse_array($web_page['FILE'], "</div>", "</div>");
		echo "ITEMS-contentmiddle: ", count($contentmiddle_array), "\n";

		//for($yy=0; $yy<count($contentmiddle_array); $yy++)
		//{
			#echo $div_array[$yy];
			$text = str_replace("<br>", "\n", $contentmiddle_array[9]); // <-- 9 is the magic number
			$text = str_replace("&nbsp;", " ", $text);
			#echo $text;
			$text = strip_tags(trim($text));
			#echo $text;
			fwrite ($handle, $text);
			fwrite ($handle, "\n------------------------------------------------------\n");
		//}
		
		$index++;
		#sleep(1);
	}
}

fclose($handle);

?>