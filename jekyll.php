<?php

global $path, $files, $strs;

$path = "../_posts"; //生成路径
$ext = ".md"; //后缀
$layout = "post"; //模板


function createdir($path)
{
   if(file_exists($path) && is_dir($path)){
   }
   else{
    mkdir ($path,0777);
   }
}
function createfile($path, $file, $str)
{
  $fp = fopen($path . "/" . $file, "w+");
  fputs($fp,$str);
  fclose($fp);
}

function wxr_post_taxonomy() {
    $post = get_post();
    $s = "";
    $taxonomies = get_object_taxonomies( $post->post_type );
    if ( empty( $taxonomies ) )
      return $s;
    $terms = wp_get_object_terms( $post->ID, $taxonomies );

    foreach ( (array) $terms as $term ) {
      $s .= str_replace("post_","", "{$term->taxonomy}") . ": " . $term->name . "\n";
    }
    return $s;
}

require('../wp-blog-header.php');
global $wpdb;

$posts = $wpdb->get_results( "SELECT * FROM {$wpdb->posts} WHERE post_status ='publish' " );

createdir($path);

foreach ( $posts as $post ) {

$files = date('Y-n-j-', strtotime($post->post_date)) . $post->post_name . $ext;
$strs = "---\n";
$strs .= "layout: ". $layout ."\n";
$strs .= "title: ".$post->post_title ."\n";
$strs .= wxr_post_taxonomy();
$strs .= "---\n";
$strs .= $post->post_content;

createfile($path, $files, $strs);
?>
<p><?php echo date('Y-n-j-', strtotime($post->post_date)) . $post->post_name ; ?> success</p>
<?php
}
?>
all done!