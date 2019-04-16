<?php ?>


<div class = 'product-info'>
	<div class = 'product-title'>
		<div class = 'product-name'>
			<a :href = "product.link"><h5>{{product.name}}</h5></a>
		</div>
		<div class = 'product-brand'>
			<h5>By <a :href ="product.brandLink">{{product.productBrandRelationship[0]['post_title']}}</a></h5>
		</div>
		<div class = 'category'>
			<span> {{product.plantCategory}}</span>
		</div>
		<div class = 'type'>
			<span :class = 'product.plantType | lowercase'>{{product.plantType}}</span>
		</div>
		<div class = 'product-image'>
			<a :href = "product.link">
				<img :src = 'product.product_images[0]'>
			</a>
		</div>
	</div>
	<div class = 'product-info-under-title'>
		<div class = 'panel brand-and-type'>
			<p class = 'thc'><span class = 'mini-title'>THC</span>{{product.THC}}</p>
			<p class = 'cbd'><span class = 'mini-title'>CBD</span>{{product.CBD}}</p>
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