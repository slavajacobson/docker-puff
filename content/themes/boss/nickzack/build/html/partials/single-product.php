<?php 
$postID = $post -> ID;
?>
<div class = 'page-view single-product'>
	<!-- REVIEW AVERAGE -->
	<?php
	//script to calculate averages
	include(locate_template('nickzack/build/html/partials/single-product-partials/single-product-get-averages.php'));
	//first panel.. product info
	include(locate_template('nickzack/build/html/partials/single-product-partials/single-product-top-info.php'));
	//reviews
	include(locate_template('nickzack/build/html/partials/single-product-partials/single-product-reviews.php'));
	?>

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
			<?php //echo do_shortcode('[thumbs-rating-buttons]'); ?>

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

