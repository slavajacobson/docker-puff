<?php ?>
<div class = 'page-view products'>



<div class = 'panels'>
	<div class = 'location'>
		<p>Currenty Viewing products in Ontario</p>
	</div>
	<div class = 'left-panel'>
		<div class = 'sub-panel'>
			<h2>Categories</h2>
		</div>
		<div class = 'sub-panel'>
			<h2>Type</h2>
		</div>
		<div class = 'sub-panel'>
			<h2>Brands</h2>
		</div>

	</div>
	<div class = 'right-panel'>
	

		<?php include(locate_template('/nickzack/build/html/partials/loader.php'));?>
		<ul>

			<li v-for="product in displayedPosts" class = 'product'>
				<a :href = 'product.link'>
					<div class = 'product-image'>
						<img :src = 'product.product_images[0]'>
					</div>
					<div class = 'product-info'>
						<div class = 'product-title'>
							<h5>{{product.name}}</h5>
						</div>
						<div class = 'product-info-under-title'>
							<div class = 'panel brand-and-type'>
								<p class = 'plant-type' :class = 'product.plantType | lowercase'>{{product.plantType}}</p>
							</div>
							<div class = 'panel thc-cbd'>
								<p class = 'thc'><span class = 'mini-title'>THC</span>{{product.THC}}</p>
								<p class = 'cbd'><span class = 'mini-title'>CBD</span>{{product.CBD}}</p>

							</div>
							<div class = 'panel package'>
								<span class = 'mini-title'> Package</span>

							</div>
							<div class = 'panel score'>
								<span class = 'mini-title'> Puff Score </span>
								<div class = 'user-reviews review-box'>
									<!-- if there are user reviews -->
									<template v-if = 'product.reviewData.userReviews != undefined && product.reviewData.userReviews.length >= 1'>
										<div class = 'user'>
											<div class = 'top'>
												<!-- different image based on review percentage -->
												<template v-if = "product.reviewData.userAverage >= 0.5">
											 		<p>>= 3.5</p>
												</template>
												<template v-else>
													<p>< 3.5</p>
												</template>
												<p>{{product.reviewData.userAverage | averageToPercentage}}</p>
											</div>
											<div class = 'bottom'>
												<p>{{product.reviewData.userReviews.length}} Review(s)</p>
											</div>
										</div>
									</template>
									<template v-else>
										<p> not enough user reviews</p>
									</template>
								</div>
								<div class = 'critic-reviews review-box'>
									<!-- if there are critic reviews -->
									<template v-if = 'product.reviewData.criticReviews != undefined && product.reviewData.criticReviews.length >= 1'>
										<div class = 'critic'>
											<div class = 'top'>
												<!-- different image based on review percentage -->
												<template v-if = "product.reviewData.criticAverage.overall >= 0.5">
											 		<p>>= 3.5</p>
												</template>
												<template v-else>
													<p>< 3.5</p>
												</template>
												<p>{{product.reviewData.criticAverage.overall | averageToPercentage}}</p>
											</div>
											<div class = 'bottom'>
												<p>{{product.reviewData.criticReviews.length}} Review(s)</p>
											</div>
										</div>
									</template>
									<template v-else>
										<p> not enough critic reviews</p>
									</template>
								</div>




							</div>
							<div class = 'panel rebuy'>
								<span class = 'mini-title'>Rebuy</span>
							</div>
						</div>
					</div>
				</a>
			</li>
          <div class="clearfix btn-group col-md-2 offset-md-5">
            <button type="button" class="btn btn-sm btn-outline-secondary" v-if="page != 1" @click="page--; checkEmptyImages()"> << </button>
            <button type="button" class="btn btn-sm btn-outline-secondary" v-for="pageNumber in pages.slice(page-1, page+4)" @click="page = pageNumber; checkEmptyImages()"> {{pageNumber}} </button>
            <button type="button" @click="page++; checkEmptyImages()" v-if="page < pages.length" class="btn btn-sm btn-outline-secondary"> >> </button>
          </div>
		</ul>

	</div>



</div>

</div>