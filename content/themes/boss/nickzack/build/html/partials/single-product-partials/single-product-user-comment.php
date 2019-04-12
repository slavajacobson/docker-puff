<?php
//only get user comments
function single_product_user_comment( $comment, $args, $depth ) {
		$GLOBALS[ 'comment' ] = $comment;
		switch ( $comment->comment_type ) {
			case 'pingback' :
			case 'trackback' :
				// Display trackbacks differently than normal comments.
				?>

				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<p><?php _e( 'Pingback:', 'boss' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'boss' ), '<span class="edit-link">', '</span>' ); ?></p>
					<?php
					break;
				default :
					// Proceed with normal comments.
					global $post;
					?>

				<!-- start -->
				<?php
					$commenterEmail = $comment -> comment_author_email;
					$user = get_user_by("email",$commenterEmail);
					$role = $user -> wp_capabilities;
					if($role['administrator'] == 1 || $role['contributor'] == 1){
								$role = 'Critic';
							}
							else{
								$role = 'User';
							}
					//only display if the role is user
					if($role == 'User'){
				?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment">
						<div class = 'left-side'>
							<div class = 'comment-author'>
								<h5><?php echo $comment -> comment_author;?></h5>
							</div>
							<div class="table-cell avatar-col">
								<?php echo get_avatar( $comment, 60 ); ?>
							</div><!-- .comment-left-col -->
						</div>
						<div class = 'right-side'>
							<div class = 'rating-and-date'>
								<div class = 'rating'>
									<?php
										$rating =  get_field('rating',$comment);
										//if decimal, returns 1
										$isDecimal = is_numeric( $rating ) && floor( $rating ) != $rating;
										if($isDecimal == 1){
											$numberOfWholeStarts = floor($rating);
											$starsAfter =  5 - $numberOfWholeStarts;
											$starsAfter = $starsAfter - 1;
											for($x=0;$x!=$numberOfWholeStarts;$x++){
												?>
												<i class = 'fa fa-star'></i>
												<?php
											}
											?>
											<i class = 'fa fa-star-half-o'></i>
											<?php
											for($x=0;$x!=$starsAfter;$x++){
												?>
												<i class = 'fa fa-star-o'></i>
												<?php
											}
										}
										else{
											$starsAfter = 5 - $rating;
											for($x=0;$x!=$rating;$x++){
												?>
												<i class = 'fa fa-star'></i>
												<?php
											}
											for($x=0;$x!=$starsAfter;$x++){
												?>
												<i class = 'fa fa-star-o'></i>
												<?php
											}

										}
										
									?>
								</div>
								<div clas = 'date'>
									<p>
											<?php
									printf( '<a href="%1$s"><time datetime="%2$s">%3$s ago</time></a>', esc_url( get_comment_link( $comment->comment_ID ) ), get_comment_time( 'c' ),
									/* translators: 1: date, 2: time */ human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) )
									);
									?>
									</p>
								</div>

							</div>
							<section class="comment-content comment">
								<p><?php echo $comment -> comment_content;?></p>
							</section><!-- .comment-content -->

							<footer class="comment-meta">
								<span class="entry-actions">
									<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Comment', 'boss' ), 'depth' => $depth, 'max_depth' => $args[ 'max_depth' ] ) ) ); ?>
									<div class = 'comment-text-hide'>
										<?php comment_text(); ?>
									</div>
								</span><!-- .entry-actions -->
								<?php edit_comment_link( __( 'Edit', 'boss' ), '<span class="edit-link">', '</span>' ); ?>
							</footer>
						</div>
					</article><!-- #comment-## -->
					<?php
					}
					break;

				
			}
		}

?>