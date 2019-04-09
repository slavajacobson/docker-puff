<?php ?>
<div class = 'page-view homepage'>
	<div class = 'first-row'>
		<div class = 'background'>
			<div class = 'image'></div>
		</div>
		<div class = 'content'>
			<h1>Everything about Canadian Cannabis</h1>
			<p> Discover Cannabis with confindence with reviews from fellow PuffAdvisors. Find out from social media what others have shared about brands and products</p>
			<div class = 'socials'>
				<i class="fa fa-instagram"></i>
				<i class="fa fa-instagram"></i>
				<i class="fa fa-instagram"></i>
				<i class="fa fa-instagram"></i>
			</div>
		</div>

	</div>
	<div class = 'second-row links'>
		<ul>
			<li>
				<a href = '#'>
					<i class = 'fa fa-home'></i>
					<p>Products</p>
				</a>

			</li>
			<li>
				<a href = '#'>
					<i class = 'fa fa-home'></i>
					<p>Brands</p>
				</a>

			</li>
			<li>
				<a href = '#'>
					<i class = 'fa fa-home'></i>
					<p>Stores</p>
				</a>

			</li>
			<li>
				<a href = '#'>
					<i class = 'fa fa-home'></i>
					<p>Map</p>
				</a>

			</li>
		</ul>
	</div>
</div>
<div class = 'third-row categories'>

<?php
$products = get_posts(array('posts_per_page' => -1, 'orderby' => 'date', 'order' => 'dsc', 'post_type' => 'product'));
var_dump($products);
?>
</div>