<?php

add_action( 'rest_api_init', function () {
  register_rest_route( 'store','/all-stores', array(
    'methods' => 'GET',
    'callback' => 'return_stores'
  ) );
} );





function return_stores($data){
	//master array
	$data = array();
	$stores = get_posts(array('posts_per_page' => -1, 'orderby' => 'date', 'order' => 'dsc', 'post_type' => 'store'));
	foreach($stores as $store){
		$storeTitle = $store -> post_title;
		$storeID = get_field('store_id',$store);
		$storeArray = array(
			'title' => $storeTitle,
			'ID' => $storeID
		);
		array_push($data,$storeArray);
	}

	return $data;

}