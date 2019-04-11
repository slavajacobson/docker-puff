<?php
	$postTitle = strtoupper($post -> post_title);
	$image1 = get_field('image_1');
	$image2 = get_field('image_2');
	$image3 = get_field('image_3');
	$imageArray = [$image1,$image2,$image3];
	$THC = get_field('thc');
	$CBD = get_field('cbd');
	$brand = get_field('brand_relationship')[0];
	$brandLink = get_permalink($brand);
	$brandTitle = $brand -> post_title;
	$type = get_field('plant_type');
?>

<div class = 'product-top-info'>
<div class = 'left-box'>
	<div class = 'main-image'>
		<img src = <?php echo $image1;?>>

	</div>
	<div class = 'sub-images'>
		<?php
			foreach($imageArray as $image){
				//check if there is a url in the field
				if(!empty($image)){
					$file_headers = get_headers($image);
					//check if there is an actual image in the url
					if(strpos($file_headers[0], '404') !== false){
						//no image
					} else {
					?>
					<img src = <?php echo $image;?>>
					<?php
					}
				}
			}
		?>

	</div>
</div>
<div class = 'right-box'>
	<div class = 'title'>
		<h1><?php echo $postTitle;?></h1>
	</div>
	<div class = 'info'>
		<div class = 'type'>
			<span class = <?php echo strtolower($type);?>>
				<?php echo $type;?>
			</span>

		</div>
		<div class = 'brand'>
			<span class = 'bold'>
				Brand:
				<a href = <?php echo $brandLink;?>>
					<?php echo $brandTitle;?>
				</a>
			</span>
			

			
		</div>
		<div class = 'thc-cbd'>
			<p><span class = 'bold'>THC</span><span class = 'content'><?php echo $THC;?></span></p>
			<p><span class = 'bold'>CBD</span><span class = 'content'><?php echo $CBD;?></span></p>
		</div>
	</div>
	<div class = 'review-averages'>
		<div class = 'critics'>
			<h5>Critic Reviews</h5>
			<div class = 'icon-and-percent'>
				<div class = 'icon'>
					<img src = 'https://www.rottentomatoes.com/assets/pizza-pie/images/icons/global/new-fresh-lg.12e316e31d2.png'>
				</div>
				<div class = 'percent'>
					<p>
					<?php
					echo $averageArray['critic']['average'] * 100 .'%';
					?>
					</p>
				</div>
			</div>
			<div class = 'review-count'>
				<p>
					<?php echo $averageArray['critic']['reviews']?>
					reviews
				</p>

			</div>
		</div>
		<div class = 'users'>
			<h5>User Reviews</h5>
			<div class = 'icon-and-percent'>
				<div class = 'icon'>
					<img src = 'https://www.rottentomatoes.com/assets/pizza-pie/images/icons/global/new-upright.ac91cc241ac.png'>
				</div>
				<div class = 'percent'>
					<p>
					<?php
					echo $averageArray['user']['average'] * 100 .'%';
					?>
					</p>
				</div>
			</div>
			<div class = 'review-count'>
				<p>
					<?php echo $averageArray['user']['reviews']?>
					reviews
				</p>

			</div>
		</div>
	</div>
</div>

</div>




