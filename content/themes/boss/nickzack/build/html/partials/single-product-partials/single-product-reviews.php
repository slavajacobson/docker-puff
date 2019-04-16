<?php


?>

<div class = 'critic-reviews' id = 'criticReviews'>
	<div class = 'review-wrapper'>
	<?php
		$numOfUserReviews = $averageArray['critic']['reviews'];
	?>
	<div class = 'header'>
		<h5>Critic Reviews <?php echo '('.$numOfUserReviews.')';?></h5>
	</div>
	<?php
	$comments = wp_list_comments(
	  array(
	  	'callback'	  => 'single_product_critic_comment',
	    'per_page' => -1, //Allow comment pagination
	    'reverse_top_level' => false //Show the latest comments at the top of the list
	  ), 
	  $reviews
	);

	?>
	</div>
</div>
<div class = 'user-reviews' id = "userReviews">
	<div class = 'review-wrapper'>
	<?php
		$numOfUserReviews = $averageArray['user']['reviews'];
	?>
	<div class = 'header'>
		<h5>Audience Reviews <?php echo '('.$numOfUserReviews.')';?></h5>
	</div>
	<?php
	$comments = wp_list_comments(
	  array(
	  	'callback'	  => 'single_product_user_comment',
	    'per_page' => -1, //Allow comment pagination
	    'reverse_top_level' => false //Show the latest comments at the top of the list
	  ), 
	  $reviews
	);

	?>
	</div>
</div>

