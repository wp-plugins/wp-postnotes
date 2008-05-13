<?php
$_dc_class_name = 'dc_wp_post_1_0_0';
if (!class_exists($_dc_class_name)) {
	require_once(dirname(dirname(__FILE__)).'/base.php');
	class dc_wp_post_1_0_0 extends dc_base_1_0_1 {

		function add_category($name) {
			$result=wp_insert_term($name, 'category', array('cat_name' => $name));
			return $result['term_id'];
		}
		function ids($category_name) {
			$cids = get_posts(array('type'=>'category','category_name'=>$category));
			$ids = array();
			foreach($cids as $id) {
				$ids[]=$post->post_id;
			}
			return $ids;
		}
		function category_name($category_id)
		{
			return get_cat_name($category_id);
		}
	}
}
?>