<?php
include("LIB_http.php");
include("LIB_parse.php");

if (($handle = fopen("novel.txt", 'w')) == FALSE)
{
	echo 'failed to open file for writing';
}
else
{
	$target = "http://ck101.com/thread-3439290-1-1.html";
	$web_page = http_get($target, "");
	$strong_array = parse_array($web_page['FILE'], "<strong>", "</strong>");

	for($var=1; $var<=count($strong_array); $var++)
	{
		// Download the target file

		// for($var=1; $var<=55; $var++)
		// 我是胤禛福晉
		// http://ck101.com/forum.php?mod=viewthread&tid=2092280&extra=&highlight=%E6%88%91%E6%98%AF%E8%83%A4%E7%A6%9B%E7%A6%8F%E6%99%89&page=1
		// $target = "http://ck101.com/forum.php?mod=viewthread&tid=2092280&extra=&highlight=%E6%88%91%E6%98%AF%E8%83%A4%E7%A6%9B%E7%A6%8F%E6%99%89&page=" . $var;

		// for($var=1; $var<=13; $var++)
		// 鳳還巢
		// http://ck101.com/thread-3439290-1-1.html
		$target = "http://ck101.com/thread-3439290-" . $var . "-1.html";

		$web_page = http_get($target, "");
		// echo $web_page['FILE'];
		// fwrite ($handle, $web_page['FILE']);

		$table_array = parse_array($web_page['FILE'], "<table", "</table>");
		echo "page " . $var . " table items: ", count($table_array), " has rows: ";
		for($xx=0; $xx<count($table_array); $xx++)
		{
			$tr_array = parse_array($table_array[$xx], "<tr><td class", "</tr>");
			echo count($tr_array), " ";

			if (count($tr_array) == 1)
			{
				$text = str_replace("<br />", "\n", $tr_array[0]);
				$text = strip_tags(trim($text));
				//echo $text;
				fwrite ($handle, $text);
			}
		}
		echo "\n";
	}
}

fclose($handle);

?>
