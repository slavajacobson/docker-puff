<?php
function single_product_comment( $comment, $args, $depth ) {
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
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment">
						<?php echo var_dump($comment);?>
						<div class="table-cell avatar-col">
							<?php echo get_avatar( $comment, 60 ); ?>
						</div><!-- .comment-left-col -->

						<div class="table-cell">
							<header class="comment-meta comment-author vcard">
								<?php
								printf( '<cite class="fn">%1$s %2$s</cite>', get_comment_author_link(),
								// If current post author is also comment author, make it known visually.
				( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'boss' ) . '</span>' : ''
								);
								?>
							</header><!-- .comment-meta -->


							<section class="comment-content comment">
								<?php comment_text(); ?>
							</section><!-- .comment-content -->

							<footer class="comment-meta">
								<?php
								printf( '<a href="%1$s"><time datetime="%2$s">%3$s ago</time></a>', esc_url( get_comment_link( $comment->comment_ID ) ), get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */ human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) )
								);
								?>
								<span class="entry-actions">
									<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( '<i class="fa fa-reply"></i>', 'boss' ), 'depth' => $depth, 'max_depth' => $args[ 'max_depth' ] ) ) ); ?>
								</span><!-- .entry-actions -->
								<?php edit_comment_link( __( 'Edit', 'boss' ), '<span class="edit-link">', '</span>' ); ?>
							</footer>
						</div>
					</article><!-- #comment-## -->
					<?php
					break;
			}
		}

?>