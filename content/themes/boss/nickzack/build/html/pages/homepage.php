<?php ?>
<div class = 'page-view homepage'>
	<div class = 'first-row'>
		<div class = 'background'>
			<div class = 'image'></div>
		</div>
		<div class = 'content'>
			<h1>Everything about Canadian Cannabis</h1>
			<p> Discover Cannabis with confindence with reviews from fellow PuffAdvisors. Find out from social media what others have shared about brands and products</p>
		</div>

	</div>
	<div class = 'second-row links'>
		<ul>
			<li>
				<a href = '/products'>
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
	<div class = 'third-row categories'>
		<div class = 'title-and-view-all'>
			<h5>Popular Categories</h5>
			<a href = '/products'>View All</a>
		</div>
		<div class = 'categories-wrapper'>
			<a href = '#'>
				Highest THC
			</a>
			<a href = '#'>
				Flowers
			</a>
			<a href = '#'>
				Oils and Capsules
			</a>
			<a href = '#'>
				PreRolls
			</a>
			<a href = '#'>
				Sativas
			</a>
			<a href = '#'>
				Indicas
			</a>
			<a href = '#'>
				Hybrids
			</a>
			<a href = '#'>
				CBD
			</a>
		</div>
	</div>

	<div class = 'carousels'>
		<div class = 'title-and-view-all'>
			<h5>New</h5>
			<a href = '/products'>View All</a>
		</div>
		<div class = 'swiper-container newest-carousel'>
			<div class = 'swiper-wrapper'>
				<div v-for="product in newestPosts" class = 'product swiper-slide' :data-type = 'product.plantType | lowercase'>
					<?php include(locate_template('nickzack/build/html/pages/homepage-partials/homepage-carousel-content.php'));?>
				</div>
			</div>
		</div>
		<div class = 'newest-navigation carousel-navigation'>
			<div class = 'previous'>
				<i class = 'fa fa-chevron-left'></i>
			</div>
			<div class = 'next'>
				<i class = 'fa fa-chevron-right'></i>
			</div>
		</div>

	</div>
</div>
