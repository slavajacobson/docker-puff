<?php ?>
<div class = 'page-view products'>



<div class = 'panels'>
	<div class = 'location'>
		<p>Currenty Viewing products in Ontario</p>
	</div>
	<div class = 'left-panel'>
		<h5 class = 'title'>FILTERS</h5>
		<h5 class = 'filter-title'>TYPE</h5>
		<div class = 'type-filters'>
			<span id = 'all' class = 'filter-button hover-button button-filter-type' data-type = 'all' @click="filter('type','all',$event,'button')">All</span>
			<span id = 'indica' class = 'indica hover-button button-filter-type' data-type = 'indica' @click ="filter('type','indica',$event,'button')">Indica</span>
			<span id ='hybrid' class = 'hybrid hover-button button-filter-type' data-type = 'hybrid' @click ="filter('type','hybrid',$event,'button')" >Hybrid</span>
			<span id='sativa' class = 'sativa hover-button button-filter-type' data-type = 'sativa' @click ="filter('type','sativa',$event,'button')" >Sativa</span>
		</div>
		<h5 class = 'filter-title'>CATEGORIES</h5>
		<div class = 'category-filters'>
			<span id='all' class = 'filter-button hover-button button-filter-type' data-category = 'all' @click ="filter('category','all',$event,'button')" >All</span>
			<span id='flower' class = 'filter-button hover-button button-filter-type' data-category = 'flower' @click ="filter('category','flower',$event,'button')" >Flower</span>
			<span id='pre-roll'class = 'filter-button hover-button button-filter-type' data-category = 'pre-roll' @click ="filter('category','pre-roll',$event,'button')" >Pre-Roll</span>
			<span id = 'oil-and-capsules' class = 'filter-button hover-button button-filter-type' data-category = 'oil-and-capsules' @click ="filter('category','oil-and-capsules',$event,'button')">Oil and Capsules</span>
			<span id ='seeds' class = 'filter-button hover-button button-filter-type' data-category = 'seeds' @click ="filter('category','seeds',$event,'button')" >Seeds</span>

		</div>
		<div class = 'filter-search'>
			<span class = 'filter-button' data-type = 'sativa' @click ="filterResults()" >Filter</span>
		</div>
	</div>
	<div class = 'right-panel'>
	

		<?php include(locate_template('/nickzack/build/html/partials/loader.php'));?>
		<ul>

			<li v-for="product in displayedPosts" class = 'product' :data-type = 'product.plantType | lowercase'>
				<div class = 'product-image'>
					<a :href = "product.link">
						<img :src = 'product.product_images[0]'>
					</a>
				</div>
				<div class = 'product-info'>
					<div class = 'product-title'>
						<div class = 'product-name'>
							<a :href = "product.link"><h5>{{product.name}}</h5></a>
						</div>
						<div class = 'product-brand'>
							<h5>By <a :href ="product.brandLink">{{product.productBrandRelationship[0]['post_title']}}</a></h5>
						</div>
					</div>
					<div class = 'product-info-under-title'>
						<div class = 'panel brand-and-type'>
							<p class = 'plant-type' :class = 'product.plantType | lowercase'>{{product.plantType}}</p>
							<p class = 'thc'><span class = 'mini-title'>THC</span>{{product.THC}}</p>
							<p class = 'cbd'><span class = 'mini-title'>CBD</span>{{product.CBD}}</p>
						</div>
						<div class = 'panel package'>
							<span class = 'mini-title'>Available Sizes and Prices</span>
							<h5>Coming Soon!</h5>

						</div>
						<div class = 'panel score'>
							<span class = 'mini-title'> Puff Score </span>
							<div class = 'user-reviews review-box'>
								<!-- if there are user reviews -->
								<h5>User Reviews</h5>
								<template v-if = 'product.reviewData.userReviews != undefined && product.reviewData.userReviews.length >= 1'>
									<div class = 'user'>
										<div class = 'top'>
											<!-- different image based on review percentage -->
											<template v-if = "product.reviewData.userAverage >= 0.5">
												<div class = 'image'>
										 		<img src = 'https://www.rottentomatoes.com/assets/pizza-pie/images/icons/global/new-upright.ac91cc241ac.png' class = '	user-review-image review-image'>
										 		</div>
											</template>
											<template v-else>
												<div class = 'image'>
													<img src = 'https://www.rottentomatoes.com/assets/pizza-pie/images/icons/global/new-spilled.844ba7ac3d0.png' class = 'user-review-image review-image'>
												</div>
											</template>
											<p>{{product.reviewData.userAverage | averageToPercentage}}</p>
										</div>
										<div class = 'bottom'>
											<p>{{product.reviewData.userReviews | findLength}} Reviews</p>
										</div>
									</div>
								</template>
								<template v-else>
									<p> not enough user reviews</p>
								</template>
							</div>
							<div class = 'critic-reviews review-box'>
								<!-- if there are critic reviews -->
								<h5>Critic Reviews</h5>
								<template v-if = 'product.reviewData.criticReviews != undefined && product.reviewData.criticReviews.length >= 1'>
									<div class = 'critic'>
										<div class = 'top'>
											<!-- different image based on review percentage -->
											<template v-if = "product.reviewData.criticAverage.overall >= 0.5">
												<div class = 'image'>
										 			<img src = 'https://www.rottentomatoes.com/assets/pizza-pie/images/icons/global/new-fresh-lg.12e316e31d2.png' class = 'critic-review-image review-image'>
										 		</div>
											</template>
											<template v-else>
												<div class = 'image'>
													<img src = 'https://www.rottentomatoes.com/assets/pizza-pie/images/icons/global/new-rotten-lg.ecdfcf9596f.png' class = 'critic-review-image review-image'>
												</div>
											</template>
											<p>{{product.reviewData.criticAverage.overall | averageToPercentage}}</p>
										</div>
										<div class = 'bottom'>
											<p>{{product.reviewData.criticReviews | findLength}} Reviews</p>
										</div>
									</div>
								</template>
								<template v-else>
									<p> not enough critic reviews</p>
								</template>
							</div>
						</div>
					</div>
				</div>
			</li>
          <div class="clearfix btn-group col-md-2 offset-md-5">
            <button type="button" class="btn btn-sm btn-outline-secondary" v-if="page != 1" @click="page--"> << </button>
            <button type="button" class="btn btn-sm btn-outline-secondary" v-for="pageNumber in pages.slice(page-1, page+4)" @click="page = pageNumber"> {{pageNumber}} </button>
            <button type="button" @click="page++" v-if="page < pages.length" class="btn btn-sm btn-outline-secondary"> >> </button>
          </div>
		</ul>

	</div>



</div>

</div>