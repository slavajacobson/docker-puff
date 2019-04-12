<?php
	$reviews = get_comments(array('post_id' => $postID));
	$criticReviews = [];
	$userReviews = [];
	//average is the percentage of reviews 3.5 or greater
	$basicUserCount = 0;
	$basicUserGreaterThan = 0;
	$criticUserCount = 0;
	$criticUserGreaterThan = 0;
	$criticAverageSmell = 0;
	$criticAveragePotency = 0;
	$criticAverageLooks = 0;
	foreach($reviews as $review){
		$commentAuthorEmail = $review -> comment_author_email;
		$commentUser = get_user_by('email',$commentAuthorEmail);
		$role = $commentUser -> wp_capabilities;
		 if($role['administrator'] == 1 || $role['contributor'] == 1){
			$rating = get_field('rating',$review);
			if($rating != 0){
				$criticUserCount++;
				$smell = get_field('smell',$review);
				$potency = get_field('potency',$review);
				$looks = get_field('looks',$review);
				if($rating >= 3.5){
				    $criticUserGreaterThan++;
				}
				if($smell >= 3.5){
				    $criticAverageSmell++;
				}
				if($potency >= 3.5){
				    $criticAveragePotency++;
				}
				if($looks >= 3.5){
				    $criticAverageLooks++;
				}
			}
		}
		else{
			
			$rating = get_field('rating',$review);
				if($rating != 0){
				$basicUserCount++;

				//rating average
				if($rating >= 3.5){
				    //add another greater than review
				    $basicUserGreaterThan++;
				}
			}
		}
	}

	//get to decimal point
	$decimalPoint = 2;
	$userAverageReview = number_format($basicUserGreaterThan / $basicUserCount,$decimalPoint);
	$criticAverageReview = number_format($criticUserGreaterThan / $criticUserCount,$decimalPoint);
	$criticAveragePotencyReview = number_format($criticAveragePotency /$criticUserCount,$decimalPoint);
	$criticAverageSmellReview = number_format($criticAverageSmell /$criticUserCount,$decimalPoint);
	$criticAverageLooksReview = number_format($criticAverageLooks /$criticUserCount,$decimalPoint);

	//final array
	$averageArray = array(
		'user' => array(
			'reviews' => $basicUserCount,
			'average' => $userAverageReview
		),
		'critic' => array(
			'reviews' => $criticUserCount,
			'average' => $criticAverageReview,
			'potency' => $criticAveragePotency,
			'smell' => $criticAverageSmell,
			'looks' => $criticAverageLooks
		)
	);
	
	?>