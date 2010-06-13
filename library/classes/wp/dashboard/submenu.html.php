<?php
/*
$HeadURL$
$LastChangedDate$
$LastChangedRevision$
$LastChangedBy$
*/
?>
<?php
	global $wp_version;
	if($wp_version<2.7)
	{
?>
<style>
#dashmenu .wp-submenu, #adminmenu .wp-submenu {
	display: none;
	list-style: none;
	margin: 0;
	padding: 0;
}

#dashmenu li.wp-menu-open .wp-submenu, #adminmenu li.wp-menu-open .wp-submenu {
	display: block;
}

#dashmenu {
	margin: 0 0 0 10px;
	background: url(images/logo-ghost.png) no-repeat top left;
	list-style: none;
	position: absolute;
	top: 0;
	left: 0;
	height: 31px;
	font-size: 11px;
	padding: 0 0 0 30px;
}

#dashmenu li {
	display: block;
	float: left;
	list-style: none;
	white-space: nowrap;
	margin: 0 5px 0 0;
	padding: 0;
	position: relative;
}

#adminmenu li.current {
	border-width: 1px;
	border-style: solid;
	margin-right: -1px;
}

#adminmenu li .wp-submenu li {
	padding: 0 0 0 15px;
}

#adminmenu li.wp-has-submenu > a {
	background-image: url(images/menu-closed.png);
	background-repeat: no-repeat;
	background-position: left center;
}

#adminmenu li.wp-menu-open > a {
	background-image: url(images/menu-open.png);
}


#wpbody ul.wp-menu {
	list-style: none;
	margin: 10px 0;
	padding: 0;
	font-size: 16px;
}

#wpbody ul.wp-menu li {
	display: inline;
}

#wpbody ul.wp-menu li:before {
	content: " | ";
}

#wpbody ul.wp-menu li.wp-first-item:before {
	content: "";
}

#wpbody ul.wp-menu li.current a {
	text-decoration: none;
	color: #666;
}
<?php } ?>
</style>
<ul class="wp-menu">
@@submenu@@
</ul>
