<?php

add_action( 'rest_api_init', function () {
  register_rest_route( 'brand','/all-brands', array(
    'methods' => 'GET',
    'callback' => 'return_brands'
  ) );
} );





function return_brands($data){
	//master array
	$data = array();
	$brands = get_posts(array('posts_per_page' => -1, 'orderby' => 'date', 'order' => 'dsc', 'post_type' => 'brand'));
	//get all products to associate with brands
	$json_string = 'http://localhost/wp-json/product/all-products';
	$jsondata = file_get_contents($json_string);
	$obj = json_decode($jsondata,true);
	$products = $obj;

	$brandArray = [];
	//go through each brand and make a brand array
	foreach($brands as $brand){
		$currentBrandID = $brand -> ID;
		$brandInfo = [];
		//should have all matched products in the end
		$matchedProducts = [];
		//go into each product to check if its in this brand
		foreach($products as $product){
			$productCheckBrand = $product['productBrandID'];
			//if the product is in this brand
			if($productCheckBrand == $currentBrandID){
				$giveProductInfo = array(
					'product' => $product
				);
				//push the product that matches the brand
				array_push($matchedProducts,$giveProductInfo);
			}
		}
		//if the brand contains products return product array otherwise return message
		if(!empty($matchedProducts)){
			$brandInfo = array(
				'brand' => array(
					'brandInfo' => $brand,
					'products' => $matchedProducts
				)
			);

		}
		else{
			$brandInfo = array(
				'brand' => array(
					'brandInfo' => $brand,
					'products' => 'no current products'
				)
			);

		}
		array_push($brandArray,$brandInfo);
	}


	//end array
	$data = $brandArray;
	return $data;

}