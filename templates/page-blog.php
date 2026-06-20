<?php 

/**
* Template Name: Blog Page Template
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/

if (!defined('ABSPATH')) exit;

$categories = get_categories();

get_header();

?>  

<div class="blog-page">
    <div class="lg:pt-[46px] pt-[92px]">
<?php render_media_menu(); ?>
    <?php 
        while (have_posts()) : the_post();
            the_content();
        endwhile;

        require PATH . "/components/burger-menu/component.php";
    ?> 
    </div>
</div>

<?php get_footer(); ?>