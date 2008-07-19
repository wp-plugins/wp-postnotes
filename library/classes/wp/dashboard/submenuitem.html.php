<?php
/*
$HeadURL$
$LastChangedDate$
$LastChangedRevision$
$LastChangedBy$
*/
?>
<?php
	$url=explode('?',$_SERVER['REQUEST_URI']);
	$url=$url[0];
?>
<li class="@@class@@">
	<a href='<?php echo $url;?>?page=<?echo $_GET['page'];?>&subpage=@@title@@'>@@title@@</a>
</li>
