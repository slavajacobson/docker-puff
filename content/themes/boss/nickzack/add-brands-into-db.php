<?php

function parse_all_brands($case){
//get product data from seperate spreadsheet api
$json_string = 'https://spreadsheets.google.com/feeds/list/1-r3kfSxUiLScFZNaddJA_HRqJPF7h5O_HOKDYAIpJEc/4/public/values?alt=json';
$jsondata = file_get_contents($json_string);
$obj = json_decode($jsondata,true);
$products = $obj['feed']['entry'];
$brandsParsed = [];
foreach($products as $product){
    $productName = $product['title']['$t'];
    $slug = strtolower($product['title']['$t']);
    $slug = str_replace(' ','-',$slug);
    $brandArray = array(
        'name' => $productName,
        'slug' => $slug,
 
    );
    array_push($brandsParsed,$brandArray);
    
}
if($case != -1){
    for($x = 0;$x != $case; $x++){
        create_wordpress_post_brands_with_code($brandsParsed[$x]);
    }
}
else{
    foreach($brandsParsed as $product){
        create_wordpress_post_brands_with_code($brandsParsed);
    }
}

}
function create_wordpress_post_brands_with_code($product) {
    $productName = $product['name'];
    $productSlug = $product['slug'];
    $counter = 0;
        // Set the post ID to -1. This sets to no action at moment
        $post_id = -1;
        // Set the Author, Slug, title and content of the new post
        $author_id = 1;
        $slug = $productSlug;
        $title = $productName;
        $content = 'Product Test content';

        //ACF FIELDS
        // Cheks if doen't exists a post with slug "wordpress-post-created-with-code".
        if( !brand_post_exists_by_slug( $slug ) ) {

            // Set the post ID
            $post_id = wp_insert_post(
                array(
                    'comment_status'    =>   'open',
                    'ping_status'       =>   'closed',
                    'post_author'       =>   $author_id,
                    'post_name'         =>   $slug,
                    'post_title'        =>   $title,
                    'post_content'      =>  $content,
                    'post_status'       =>   'publish',
                    'post_type'         =>   'brand'
                )
            );

             // update_field('image_1',$wordpressImages[0],$post_id);
             // update_field('image_2',$wordpressImages[1],$post_id);
             // update_field('image_3',$wordpressImages[2],$post_id);
        } else {
     
                // Set pos_id to -2 becouse there is a post with this slug.
                $post_id = -2;
         
        } // end if
     
    } // end oaf_create_post_with_code

 /**
 * post_exists_by_slug.
 *
 * @return mixed boolean false if no post exists; post ID otherwise.
 */
function brand_post_exists_by_slug( $post_slug ) {
    $args_posts = array(
        'post_type'      => 'brand',
        'post_status'    => 'any',
        'name'           => $post_slug,
        'posts_per_page' => 1,
    );
    $loop_posts = new WP_Query( $args_posts );
    if ( ! $loop_posts->have_posts() ) {
        return false;
    } else {
        $loop_posts->the_post();
        return $loop_posts->post->ID;
    }
}



//parse_all_brands('13');