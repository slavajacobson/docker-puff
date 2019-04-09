<?php


// Product Post Type & Taxonomy
function create_product_category_hierarchical_taxonomy() {
  $labels = array(
    'name' => _x( 'Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Categories' ),
    'all_items' => __( 'All Categories' ),
    'parent_item' => __( 'Parent Category' ),
    'parent_item_colon' => __( 'Parent Category:' ),
    'edit_item' => __( 'Edit Category' ),
    'update_item' => __( 'Update Category' ),
    'add_new_item' => __( 'Add New Category' ),
    'new_item_name' => __( 'New Category Name' ),
    'menu_name' => __( 'Categories' ),
  );
  register_taxonomy('product_category',null, array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'products'),
  ));
}
function product_post_type() {
  $labels = array(
    'name'               => _x( 'Products', 'post type general name' ),
    'singular_name'      => _x( 'Product', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'book' ),
    'add_new_item'       => __( 'Add New Product' ),
    'edit_item'          => __( 'Edit Product' ),
    'new_item'           => __( 'New Product' ),
    'all_items'          => __( 'All Products' ),
    'view_item'          => __( 'View Products' ),
    'search_items'       => __( 'Search Products' ),
    'not_found'          => __( 'No Product found' ),
    'not_found_in_trash' => __( 'No Products found in the Trash' ),
    'parent_item_colon'  => '',
    'menu_name'          => 'Products'
  );

  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds PuffAdvisors Products',
    'public'        => true,
    'menu_position' => 99999,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes','comments' ),
    'taxonomies'    => array('product_category'),
    'has_archive'   => true,
    'has_parent'    => true,
    'menu_icon'     => 'dashicons-admin-site',
    'hierarchical'  => true,
    'rewrite' => array('slug' => 'product'),
  );
  register_post_type( 'product', $args );
  flush_rewrite_rules();
}
add_action( 'init', 'create_product_category_hierarchical_taxonomy', 0 );
add_action( 'init', 'product_post_type' );



//brands
function create_brand_category_hierarchical_taxonomy() {
  $labels = array(
    'name' => _x( 'Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Categories' ),
    'all_items' => __( 'All Categories' ),
    'parent_item' => __( 'Parent Category' ),
    'parent_item_colon' => __( 'Parent Category:' ),
    'edit_item' => __( 'Edit Category' ),
    'update_item' => __( 'Update Category' ),
    'add_new_item' => __( 'Add New Category' ),
    'new_item_name' => __( 'New Category Name' ),
    'menu_name' => __( 'Categories' ),
  );
  register_taxonomy('brand_category',null, array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'brands'),
  ));
}
function brand_post_type() {
  $labels = array(
    'name'               => _x( 'Brands', 'post type general name' ),
    'singular_name'      => _x( 'Brand', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'book' ),
    'add_new_item'       => __( 'Add New Brand' ),
    'edit_item'          => __( 'Edit Brand' ),
    'new_item'           => __( 'New Brand' ),
    'all_items'          => __( 'All Brands' ),
    'view_item'          => __( 'View Brands' ),
    'search_items'       => __( 'Search Brands' ),
    'not_found'          => __( 'No Brand found' ),
    'not_found_in_trash' => __( 'No Brands found in the Trash' ),
    'parent_item_colon'  => '',
    'menu_name'          => 'Brands'
  );

  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds PuffAdvisors Brands',
    'public'        => true,
    'menu_position' => 99999,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes','comments' ),
    'taxonomies'    => array('brand_category'),
    'has_archive'   => true,
    'has_parent'    => true,
    'menu_icon'     => 'dashicons-admin-site',
    'hierarchical'  => true,
    'rewrite' => array('slug' => 'brand'),
  );
  register_post_type( 'brand', $args );
  flush_rewrite_rules();
}
add_action( 'init', 'create_brand_category_hierarchical_taxonomy', 0 );
add_action( 'init', 'brand_post_type' );

//stores
function create_store_category_hierarchical_taxonomy() {
  $labels = array(
    'name' => _x( 'Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Categories' ),
    'all_items' => __( 'All Categories' ),
    'parent_item' => __( 'Parent Category' ),
    'parent_item_colon' => __( 'Parent Category:' ),
    'edit_item' => __( 'Edit Category' ),
    'update_item' => __( 'Update Category' ),
    'add_new_item' => __( 'Add New Category' ),
    'new_item_name' => __( 'New Category Name' ),
    'menu_name' => __( 'Categories' ),
  );
  register_taxonomy('store_category',null, array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'brands'),
  ));
}
function store_post_type() {
  $labels = array(
    'name'               => _x( 'Stores', 'post type general name' ),
    'singular_name'      => _x( 'Store', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'book' ),
    'add_new_item'       => __( 'Add New Store' ),
    'edit_item'          => __( 'Edit Store' ),
    'new_item'           => __( 'New Store' ),
    'all_items'          => __( 'All Stores' ),
    'view_item'          => __( 'View Stores' ),
    'search_items'       => __( 'Search Stores' ),
    'not_found'          => __( 'No Store found' ),
    'not_found_in_trash' => __( 'No Stores found in the Trash' ),
    'parent_item_colon'  => '',
    'menu_name'          => 'Stores'
  );

  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds PuffAdvisors Stores',
    'public'        => true,
    'menu_position' => 99999,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes','comments' ),
    'taxonomies'    => array('store_category'),
    'has_archive'   => true,
    'has_parent'    => true,
    'menu_icon'     => 'dashicons-admin-site',
    'hierarchical'  => true,
    'rewrite' => array('slug' => 'store'),
  );
  register_post_type( 'store', $args );
  flush_rewrite_rules();
}
add_action( 'init', 'create_store_category_hierarchical_taxonomy', 0 );
add_action( 'init', 'store_post_type' );