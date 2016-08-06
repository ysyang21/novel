<?php
include("LIB_http.php");
include("LIB_parse.php");

/*
1. 我是胤禛福晉 (1..55)
http://ck101.com/forum.php?mod=viewthread&tid=2092280&extra=&highlight=%E6%88%91%E6%98%AF%E8%83%A4%E7%A6%9B%E7%A6%8F%E6%99%89&page=1
2. 鳳還巢 (1..13)
http://ck101.com/thread-3439290-1-1.html
*/

$target = $_GET["url"];

if ($target == '')
{
	echo "no url offered! use default instead~";
	echo "\n";
	$target = "http://ck101.com/forum.php?mod=viewthread&tid=2092280&extra=&highlight=%E6%88%91%E6%98%AF%E8%83%A4%E7%A6%9B%E7%A6%8F%E6%99%89&page=1";
	//return;
}

if (($handle = fopen("novel.txt", 'w')) == FALSE)
{
	echo "failed to open file for writing!";
	echo "\n";
	return;
}

$web_page = http_get($target, "");
$a_array = parse_array($web_page['FILE'], 'class="last">... ', "</a>");

if (count($a_array)==0)
{
	echo "number of pages can't be determined!";
	echo "\n";
	return;
}

$page = $a_array[0];
$page = strip_tags(trim($page));
$page = substr($page, 17);
$page = (int)$page;

for($var=1; $var<=$page; $var++)
{
	//$target = "http://ck101.com/thread-3439290-" . $var . "-1.html";
	$target = "http://ck101.com/forum.php?mod=viewthread&tid=2092280&extra=&highlight=%E6%88%91%E6%98%AF%E8%83%A4%E7%A6%9B%E7%A6%8F%E6%99%89&page=" . $var;

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

fclose($handle);

?>
