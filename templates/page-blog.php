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

<main class="main">
    <div class="blog-page">
        <div class="lg:pt-[46px] pt-[92px]">
            <?php render_media_menu(); ?>
            <div class="pt-6">
                <?php 
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
    
                require PATH . "/components/burger-menu/component.php";
                require PATH . "/components/modal/component.php"; 
                ?> 
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>