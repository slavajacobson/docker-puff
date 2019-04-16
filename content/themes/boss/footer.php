<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */
?>
</div><!-- #main .wrapper -->

</div><!-- #page -->

</div> <!-- #inner-wrap -->

</div><!-- #main-wrap (Wrap For Mobile) -->
<footer>
	<div class = 'top'>
		<div class = 'panel'>
			<a href = '/'>
				<img src = 'http://burlingtonhoteliow.com/wp/wp-content/uploads/2017/08/image1-28leosk.png'>
			</a>
			<p>Candid Canadian Cannabis from your fellow smoker</p>
		</div>
		<div class = 'panel'>
			<h5 class = 'footer-title'>Company</h5>
			<ul>
				<li><a href = '#'>Contact</a></li>
				<li><a href = '#'>About Us</a></li>
				<li><a href = '#'>Careers</a></li>
				<li><a href = '#'>Investors</a></li>
			</ul>
		</div>
		<div class = 'panel'>
			<h5 class = 'footer-title'>Resources</h5>
			<ul>
				<li><a href = '#'>FAQ</a></li>
				<li><a href = '#'>Privacy Policy</a></li>
				<li><a href = '#'>Terms of Use</a></li>
			</ul>
		</div>
		<div class = 'panel'>
			<h5 class = 'footer-title'>Business</h5>
			<ul>
				<li><a href = '#'>Claim your business</a></li>
				<li><a href = '#'>Advertise</a></li>
			</ul>
		</div>
		<div class = 'panel'>
			<h5 class = 'footer-title'>Popular Tags</h5>
			<div class = 'popular-tags'>
				<a href = '#'>sativa</a>
				<a href = '#'>hybrid</a>
				<a href = '#'>indica</a>
				<a href = '#'>new</a>
				<a href = '#'>top 10 strains</a>
				<a href = '#'>cbd</a>
			</div>
		</div>
	</div>
	<div class = 'bottom'>
		<p>&copy; 2019 Puff Advisor</p>
	</div>
</footer>
</div><!-- #right-panel-inner -->
</div><!-- #right-panel -->

</div><!-- #panels -->
<?php
global $post;
if(is_single() != 1){
	$name = $post -> post_name;
}
else{
	$name = $post -> post_type;
}
$theme = get_template_directory_uri() . '/';
$scriptToLoad = $theme.'/nickzack/build/js/'.$name.'.js';
?>
<script src = <?php echo $scriptToLoad;?>></script>
<?php wp_footer(); ?>


</body>
</html>