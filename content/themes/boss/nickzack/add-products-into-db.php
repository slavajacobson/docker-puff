<?php




// todo
// find out how to update repeater fields
// fix images not uploading with the new api


//get product data from seperate spreadsheet api
function parse_all_products($case){
$productsParsed = array();
$productsAPI = 'https://spreadsheets.google.com/feeds/list/1-r3kfSxUiLScFZNaddJA_HRqJPF7h5O_HOKDYAIpJEc/3/public/values?alt=json';
$productJsonData = file_get_contents($productsAPI);
$productObject = json_decode($productJsonData,true);
$products = $productObject['feed']['entry'];

$SKUAPI = 'https://spreadsheets.google.com/feeds/list/1-r3kfSxUiLScFZNaddJA_HRqJPF7h5O_HOKDYAIpJEc/2/public/values?alt=json';
$SKUAPI = file_get_contents($SKUAPI);
$SKUObject = json_decode($SKUAPI,true);
$SKUS = $SKUObject['feed']['entry'];
$productsArray = [];

//parse informatiom in the json from the google sheet into an array with all the required fields for the new product.. then depending on what the number $case is set to, create that many products and add them into the custom post type and the database with the fields that got generated.. all products from the json file are stores in $productsParsed. if you set $case to -1 it will go through every single one and add them. If you set it to a different number, it will only go through that many and add them in (for testing)..
    foreach($products as $product){
        $image1 = $product['gsx$image1']['$t'];
        $image2 = $product['gsx$image2']['$t'];
        $image3 = $product['gsx$image3']['$t'];
        $images = [$image1,$image2,$image3];
        $productName = $product['gsx$title']['$t'];
        $vendorName = $product['gsx$vendor']['$t'];
        $plantType = $product['gsx$planttype']['$t'];
        $subCategory = $product['gsx$subcategory']['$t'];
        $CBD = $product['gsx$cbd-full']['$t'];
        $THC = $product['gsx$thc-full']['$t'];
        $brandID = $product['gsx$brandid']['$t'];
        $excerpt = $product['gsx$body']['$t'];
        $slug = strtolower($product['gsx$ignore']['$t']);
        $slug = str_replace(' ','-',$slug);
        $productID = $product['gsx$productid']['$t'];
        $brandID = $product['gsx$brandid']['$t'];
        $productArray = array(
                    'name' => $productName,
                    'vendorName' => $vendorName,
                    'plantType' => $plantType,
                    'subCategory' => $subCategory,
                    'CBD' => $CBD,
                    'THC' => $THC,
                    'excerpt' => $excerpt,
                    'slug' => $slug,
                    'productID' => $productID,
                    'images' => $images,
                    'brandID' => $brandID,
                    'variations' => array()
                );
        $variations = array();
        //go through SKU json data
        foreach($SKUS as $SKU){
        $storeID = $SKU['gsx$storeid']['$t'];
        $sku = $SKU['gsx$skuid']['$t'];
        $productSize = $SKU['gsx$productpagesize']['$t'];
        $SKUProductID = $SKU['gsx$productid']['$t'];
        $productPrice = $SKU['gsx$productpageprice']['$t'];
        $productStock = $SKU['gsx$productpagestock']['$t'];
            if($productID == $SKUProductID){
                $productVariation = array(
                    'sku' => $sku,
                    'store_id' => $storeID,
                    'product_size' => $productSize,
                    'product_price' => $productPrice,
                    'product_stock' => $productStock

                );      
                array_push($productArray['variations'],$productVariation);          
                
            }
        }
        $finalProductArray = $productArray;
        array_push($productsParsed,$finalProductArray);

    }

if($case != -1){
    for($x = 0;$x != $case; $x++){
        create_wordpress_post_with_code($productsParsed[$x]);
    }
}
else{
    foreach($productsParsed as $product){
        create_wordpress_post_with_code($product);
    }
}
}



function create_wordpress_post_with_code($product) {
    $productName = $product['name'];
    $productVendorName = $product['vendorName'];
    $productPlantType = $product['plantType'];
    $productSubCategory = $product['subCategory'];
    $productCBD = $product['CBD'];
    $productCBDMax = $product['CBDMax'];
    $productTHC = $product['THC'];
    $productTHCMax = $product['THCMax'];
    $productBrandID = $product['brandID'];
    $productSlug = $product['slug'];
    $productExcerpt = $product['excerpt'];
    $productBrandPost = get_post($productBrandID);
    $productVariations = $product['variations'];
    $images = $product['images'];
    $counter = 0;
    $wordpressImages = [];
    //bind images from json to.. download and import to uploads/products .. then upload and bind to media library
    foreach($images as $image){
        $counter++;
        //if image is empty return 0 
        if(empty($image)){
            $image = 0;
            array_push($wordpressImages,$image);

        }
        //if image is not empty
        else{
            //download image from url and place it in directory
            $urlFolder = get_template_directory() .'/nickzack/product-pics/';
            $url = $image;
            $fileName = $productSlug . '-image-'.$counter.'.png';
            @$rawImage = file_get_contents($url);
            if($rawImage)
            {

            file_put_contents($urlFolder.$fileName,$rawImage);

            //turn local folder url to wordpress media library link
            $uploadedSlug = wp_upload_dir()['path'].'/products/' . $fileName;

            $image = wp_upload_dir()['url'].'/products/' . $fileName;
           

            array_push($wordpressImages,$image);

            //if the file does not exist yet
            if (!file_exists($uploadedSlug)) {
                //upload from directory to media
                $image_url = $urlFolder.$fileName;

                $upload_dir = wp_upload_dir();

                $image_data = file_get_contents( $image_url );

                $filename = basename( $image_url );  

                if ( wp_mkdir_p( $upload_dir['path'] ) ) {
                  $file = $upload_dir['path'] . '/products/' . $filename;
                }
                else {
                  $file = $upload_dir['basedir'] . '/products/' . $filename;
                }

                file_put_contents( $file, $image_data );

                $wp_filetype = wp_check_filetype( $filename, null );

                $attachment = array(
                  'post_mime_type' => $wp_filetype['type'],
                  'post_title' => sanitize_file_name( $filename ),
                  'post_content' => '',
                  'post_status' => 'inherit'
                );
                $attach_id = wp_insert_attachment( $attachment, $file );
                require_once( ABSPATH . 'wp-admin/includes/image.php' );

            } 


            }
        }

    }
        // Set the post ID to -1. This sets to no action at moment
        $post_id = -1;
        // Set the Author, Slug, title and content of the new post
        $author_id = 1;
        $slug = $productSlug;
        $title = $productName;
        $content = $productExcerpt;

        //ACF FIELDS
        // Cheks if doen't exists a post with slug "wordpress-post-created-with-code".
        if( !post_exists_by_slug( $slug ) ) {

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
                    'post_type'         =>   'product'
                )
            );

            //insert into ACF with update_field('[field_name]','[value]',$post_id);
             update_field('brand_name',$productVendorName,$post_id);
             update_field('thc',$productTHC,$post_id);
             update_field('thc_max',$productTHCMax,$post_id);
             update_field('cbd',$productCBD,$post_id);
             update_field('cbd_max',$productCBDMax,$post_id);
             update_field('product_brand_id',$productBrandID,$post_id);
             update_field('brand_relationship',$productBrandPost,$post_id);
             update_field('plant_type',$productPlantType,$post_id);
             update_field('category',$productSubCategory,$post_id);
             foreach($productVariations as $variation){
                 // save a repeater field value
                $field_key = "variations";
                $value = array(
                        "sku"   => $variation['sku'],
                        "store_id"   => $variation['store_id'],
                        "product_size"   => $variation['product_size'],
                        "product_price"   => $variation['product_price'],
                        "product_stock"   => $variation['product_stock']
                    );
               
                add_row( $field_key, $value, $post_id );
             }
             for($counter = 1;$counter !=4;$counter++){
                $urlFile = get_template_directory_uri() .'/nickzack/product-pics/' .$productSlug . '-image-'.$counter.'.png';
                update_field('image_'.$counter,$urlFile,$post_id);
             }
             
             // update_field('image_1',$wordpressImages[0],$post_id);
             // update_field('image_2',$wordpressImages[1],$post_id);
             // update_field('image_3',$wordpressImages[2],$post_id);
        } else {

                $post_id = -2;
         
        } // end if
     
    } // end oaf_create_post_with_code


 /**
 * post_exists_by_slug.
 *
 * @return mixed boolean false if no post exists; post ID otherwise.
 */
function post_exists_by_slug( $post_slug ) {
    $args_posts = array(
        'post_type'      => 'product',
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



//parse_all_products('13');