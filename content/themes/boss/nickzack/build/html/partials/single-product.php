<?php 
$postID = $post -> ID;
setPostViews($postID);
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



	

<?php
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

$loggedIn = is_user_logged_in();
if($loggedIn){
        ?>
        <div class = 'leave-review' id = 'leaveReview'>
                <?php comment_form( $comments_args ); ?>
        </div>
        <?php
}
else{
        ?>
        <div class = 'log-in' id = 'logInToReview'>
                <div class = 'title'>
                        <p>Please Login to leave a review</p>
                </div>
                <?php wp_login_form(array('label_username' => 'Username')); ?>
        </div>
        <?php
       
}
 ?>


</div>

