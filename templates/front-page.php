<?php

/**
* Template Name: Home Page Template
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/

if (!defined('ABSPATH')) exit;

get_header(); 
?>

<main class="main">
    <div class="home-page bg-white dark:bg-black">
            <?php

            if (have_posts()) :
                while (have_posts()) : the_post();
                    the_content(); 
                endwhile;
            endif;
            ?>
        <?php         
            require PATH . "/components/burger-menu/component.php";
            require PATH . "/components/modal/component.php";
        ?>
    </div>
</main>

<?php get_footer(); ?>