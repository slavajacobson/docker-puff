<?php

$comments = wp_list_comments(
	  array(
	  	'callback'	  => 'single_product_comment',
	    'per_page' => -1, //Allow comment pagination
	    'reverse_top_level' => false //Show the latest comments at the top of the list
	  ), 
	  $reviews
	);

?>