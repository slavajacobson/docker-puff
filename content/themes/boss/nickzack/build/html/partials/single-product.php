<?php 
$postID = $post -> ID;
?>
<div class = 'page-view single-product'>
	<h1> Single Product </h1>
	
	<!-- REVIEW AVERAGE -->
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
		 	$criticUserCount++;
		 
		$rating = get_field('rating',$review);
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
		else{
			$basicUserCount++;
			$rating = get_field('rating',$review);

			//rating average
			if($rating >= 3.5){
			    //add another greater than review
			    $basicUserGreaterThan++;
			}
		}
	}
	$userAverageReview = number_format($basicUserGreaterThan / $basicUserCount,2);
	$criticAverageReview = number_format($criticUserGreaterThan / $criticUserCount,2);
	$criticAveragePotencyReview = number_format($criticAveragePotency /$criticUserCount,2);
	$criticAverageSmellReview = number_format($criticAverageSmell /$criticUserCount,2);
	$criticAverageLooksReview = number_format($criticAverageLooks /$criticUserCount,2);

	
	?>

	<h5>User Overall Rating: <?php echo $userAverageReview;?></h5>
	<h5>Critic Overall Rating: <?php echo $criticAverageReview;?></h5>
	<p> Critic Reviews</p>
	<ul>
		<li>Potency: <?php echo $criticAveragePotencyReview;?></li>
		<li>Smell: <?php echo $criticAverageSmellReview;?></li>
		<li>Looks: <?php echo $criticAverageLooksReview;?></li>
	</ul>

	<!-- END REVIEW AVERAGE -->


	<!-- COMMENTS -->
	<?php
		$user =  wp_get_current_user();
		$com = get_comments(array('post_id' => $postID));
		$counter = 0;
	foreach($com as $co){
		$commenterEmail = $co -> comment_author_email;
		$commentUserProfile = get_user_by('email',$commenterEmail);
		$role = $commentUserProfile -> wp_capabilities;
		if($role['administrator'] == 1 || $role['contributor'] == 1){
			$role = 'Critic';
		}
		else{
			$role = 'User';
		}
		$rating = get_field('rating',$co);
		$smell = get_field('smell',$co);
		$potency = get_field('potency',$co);
		$looks = get_field('looks',$co);
		$comment = $co -> comment_content;
		$commentAuthor = $co -> comment_author;
		$commentID = $co -> comment_ID;

		$userProfileLink = '/members/'.$commentUserProfile -> user_nicename.'/profile/';


		?>
		<div style = 'padding-top:10px;padding-bottom:10px;'>
			<a href = <?php echo $userProfileLink;?>
				<p>User: <?php echo $commentAuthor;?></p>
			</a>
			<p>Comment: <?php echo $comment;?></p>
			<p>Role: <?php echo $role;?></p>
			<p>Overall Rating: <?php echo $rating;?></p>
			<?php if(!empty($smell)){ ?>
			<p>Smell: <?php echo $smell;?></p>
			<p>potency: <?php echo $potency;?></p>
			<p>looks: <?php echo $looks;?></p>

			<?php } ?>
		</div>

		<?php

		//get IP
		//echo get_comment_author_IP($co);

	}
	


$comments_args = array(
        // Change the title of send button 
        'label_submit' => __( 'Send', 'textdomain' ),
        // Change the title of the reply section
        'title_reply' => __( 'Write a Reply or Comment', 'textdomain' ),
        // Remove "Text or HTML to be displayed after the set of comment fields".
        'comment_notes_after' => '',
        // Redefine your own textarea (the comment body).
        'comment_field' => '
        <p class="comment-form-comment">
        <label for="comment">'
         . _x( 'Comment', 'noun' ) . 
         '</label>
         <br />
         <textarea id="comment" name="comment" aria-required="true">
         </textarea>
         </p>',
);
comment_form( $comments_args );
	?>
</div>

