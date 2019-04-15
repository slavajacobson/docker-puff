<?php
//only get user comments
function single_product_critic_comment( $comment, $args, $depth ) {
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
					if($role == 'Critic'){
						$rating = get_field('rating',$comment);
						$smell = get_field('smell',$comment);
						$potency = get_field('potency',$comment);
						$looks = get_field('looks',$comment);
						$ratingsArray = [$rating,$smell,$potency,$looks];
						$ratingsArrayNames = ['Rating','Smell','Potency','Looks'];
						$recommend = get_field('recommend',$comment);
						$title = get_field('title',$comment);
						$excerpt = $comment -> comment_content;
				?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment">
						<div class = 'comment-wrapper'>
							<div class = 'top-side'>
								<div class = 'image-and-title'>
									<div class = 'image'>
										<?php if($rating >= 3.5){
											//display different image depending on the rating
											?>
											<img src = 'https://www.rottentomatoes.com/assets/pizza-pie/images/icons/global/new-fresh-lg.12e316e31d2.png'>
											<?php
										}
										else{
											?>
											<img src = 'https://www.rottentomatoes.com/assets/pizza-pie/images/icons/global/new-rotten-lg.ecdfcf9596f.png'>
											
											<?php
										}
										?>
									</div>
									<div class = 'title'>
										<h5><?php echo $title;?></h5>
									</div>
								</div>
								<div class = 'excerpt'>
									<p><?php echo $excerpt;?></p>
								</div>
							
							</div>
							<div class = 'bottom-side'>
								<div class = 'title'><h5>Ratings</h5></div>
								<div class = 'left-side'>
									<div class = 'average-rating'>
										<p> 86%</p>
									</div>
									<div class = 'recommend'>
										<p>Would you smoke this with your friends</p>
									</div>
									<div class = 'yes-or-no'>
										<p><?php echo $recommend;?></p>
									</div>
								</div>
								<div class = 'right-side'>
									<div class = 'rating-and-date'>
										<div class = 'ratings'>
											<?php
												//make star ratings for each critic row (rating, potency, looks, smell )
												$counter = 0;
												foreach($ratingsArray as $row){
												?>
												<div class = 'rating'>
													<div class = 'rating-starts'>
													<?php
													//if decimal, returns 1
													$isDecimal = is_numeric( $row ) && floor( $row ) != $row;
													if($isDecimal == 1){
														$numberOfWholeStarts = floor($row);
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
														$starsAfter = 5 - $row;
														for($x=0;$x!=$row;$x++){
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
													<div class = 'rating-name'>
														<p><?php echo $ratingsArrayNames[$counter];?></p>
													</div>
												</div>
												<?php
												$counter++;
												}
											?>
										</div>
									</div>
							</div>
						
							</div>
						</div>


					<footer class="comment-meta">
						<span class="entry-actions">
							<div class = 'author'>
								<div class = 'comment-author'>
									<h5><?php echo $comment -> comment_author;?></h5>
								</div>
								<div class="table-cell avatar-col">
									<?php echo get_avatar( $comment, 60 ); ?>
								</div><!-- .comment-left-col -->
							</div>
							<div class = 'comment-text-hide'>
								<?php comment_text(); ?>
							</div>
						</span><!-- .entry-actions -->
					
					</footer>
					</article><!-- #comment-## -->
					<?php
					}
					break;

				
			}
		}

?>