<?php
//product api
add_action( 'rest_api_init', function () {
  register_rest_route( 'carousel','/all-carousels', array(
    'methods' => 'GET',
    'callback' => 'return_carousels'
    
  ) );
} );
//get required fields and dump them into the json file

function return_carousels($data){
     $data = array();

     //newest carousel
     $newArray = array();
     $product = get_posts(array('posts_per_page' => 10, 'orderby' => 'date', 'order' => 'dsc', 'post_type' => 'product'));
     foreach($product as $post) {
     	//generate general ACF fields for each post.
     	//product image
          $postID = $post -> ID;
          $link = get_the_permalink($post);
     	
          $image1 = get_field('image_1',$post);
          $image2 = get_field('image_2',$post);
          $image3 = get_field("image_3",$post);
          $imageArray =[$image1,$image2,$image3];

     	//brand name
     	$brandName = get_field('brand_name',$post);
          $plantType = get_field('plant_type',$post);
          $plantCategory = get_field('category',$post);
          $productBrandID = get_field("product_brand_id",$post);
          $productBrandRelationship = get_field('brand_relationship',$post);
          $brandPost = get_post($productBrandID);
          $brandURL = get_permalink($brandPost);
     	//THC
     	$THC = get_field('thc',$post);
     	//CBD
     	$CBD = get_field('cbd',$post);
     	//generate array for each category (type,category,brand) to be used for filters.

     	$ID = $post -> ID;



     $reviews = get_comments(array('post_id' => $postID));

     $criticReviews = [];
     $userReviews = [];
     //average is the percentage of reviews 3.5 or greater
     $basicUserCount = 0;
     $basicUserGreaterThan = 0;

     $criticUserCount = 0;
     $criticUserGreaterThan = 0;
     $criticAverageSmell = 0;
     $criticAveragePotency = 0;
     $criticAverageLooks = 0;

     //if there are reviews.. start review loop
     if(count($reviews) != 0){
     foreach($reviews as $review){
          //get basic review fields
          $commentID = $review -> comment_ID;
          $commentAuthor = $review -> comment_author;
          $commentAuthorEmail = $review -> comment_author_email;
          $commentIP = $review -> comment_author_IP;
          $commentDate = $review -> comment_date;
          $commentContent = $review -> comment_content;
          $commenterEmail = $review -> comment_author_email;
          $commentParent = $review -> comment_parent;

          //figure out if user is a critic or basic user
          $commentUser = get_user_by('email',$commentAuthorEmail);
          $role = $commentUser -> wp_capabilities;
          //find out if the comment is a reply
          $reply = false;
          if($commentParent != 0){
               $reply = true;
               $replyID = $commentParent;
          }
          else{
               $replyID = false;
          }
          //critic review array
          if($role['administrator'] == 1 || $role['contributor'] == 1){
               
               $role = 'Critic';
               $rating = get_field('rating',$review);
               $smell = get_field('smell',$review);
               $potency = get_field('potency',$review);
               $looks = get_field('looks',$review);
               //if its not a reply and has a valid rating
               if($rating !=0){
                    $criticUserCount++;
                    if($rating >= 3.5){
                         $criticUserGreaterThan++;
                    }
                    if($smell >= 3.5){
                         $criticAverageSmell++;
                    }
                    if($potency >= 3.5){
                         $criticAveragePotency++;
                    }
                    if($looks >= 3.5){
                         $criticAverageLooks++;
                    }
               }
               $criticArray = array(
                    'role' => $role,
                    'rating' => $rating,
                    'smell' => $smell,
                    'potency' => $potency,
                    'looks' => $looks,
                    'commentID' => $commentID,
                    'commentAuthor' => $commentAuthor,
                    'commentIP' => $commentIP,
                    'commentDate' => $commentDate,
                    'commentContent' => $commentContent,
                    'commenterEmail' => $commenterEmail,
                    'reply' => $reply,
                    'replyID' => $replyID
               );
               array_push($criticReviews,$criticArray);
          }
          //basic user review array
          else{
              
               $role = 'User';
               $rating = get_field('rating',$review);

               //if its not a reply and has a valid rating
               if($rating !=0){
                    //rating average
                    $basicUserCount++;
                    if($rating >= 3.5){
                         //add another greater than review
                         $basicUserGreaterThan++;
                    }
               }
               $userArray = array(
                    'role' => $role,
                    'rating' => $rating,
                    'commentID' => $commentID,
                    'commentAuthor' => $commentAuthor,
                    'commentIP' => $commentIP,
                    'commentDate' => $commentDate,
                    'commentContent' => $commentContent,
                    'commenterEmail' => $commenterEmail,
                    'reply' => $reply,
                    'replyID' => $replyID
               );
               array_push($userReviews,$userArray);
          }
     }//end foreach review
     
     //average out all reviews for users and critics
     $userAverageReview = number_format($basicUserGreaterThan / $basicUserCount,2);
     $criticAverageReview = number_format($criticUserGreaterThan / $criticUserCount,2);
     $criticAveragePotencyReview = number_format($criticAveragePotency /$criticUserCount,2);
     $criticAverageSmellReview = number_format($criticAverageSmell /$criticUserCount,2);
     $criticAverageLooksReview = number_format($criticAverageLooks /$criticUserCount,2);

     $reviewData = array(
          'userReviews' => $userReviews,
          'criticReviews' => $criticReviews,
          'userAverage' => $userAverageReview,
          'criticAverage' => array(
               'overall' => $criticAverageReview,
               'potency' => $criticAveragePotencyReview,
               'smell' => $criticAverageSmellReview,
               'looks' => $criticAverageLooksReview
          )
     );
     //final array for product
     $newestArray=array(
          'link' => $link,
     	'name' => $post -> post_title,
     	'product_images' => $imageArray,
     	'brand_name' => $brandName,
          'plantType' => $plantType,
          'plantCategory' => $plantCategory,
          'productBrandID' => $productBrandID,
          'productBrandRelationship' => $productBrandRelationship,
          'brandLink' => $brandURL,
     	'THC' => $THC,
     	'CBD' => $CBD,
     	'package' => $package,
          'post_id' => $postID,
          'reviewData' => $reviewData
     );
     }

     //if there arent any reviews
     else{
     $newestArray=array(
          'link' => $link,
          'name' => $post -> post_title,
          'product_images' => $imageArray,
          'brand_name' => $brandName,
          'plantType' => $plantType,
          'plantCategory' => $plantCategory,
          'productBrandID' => $productBrandID,
          'productBrandRelationship' => $productBrandRelationship,
          'brandLink' => $brandURL,
          'THC' => $THC,
          'CBD' => $CBD,
          'post_id' => $postID,
          'reviewData' => 0
     );
     }
     array_push($newArray,$newestArray);
     }
    $finalArray = array(
     'newest' => $newArray
    );
    array_push($data,$finalArray);
    return $data;
}


