<?php
/*
 Template name : Single park page
*/

get_header();
?>

    <main id="primary" class="site-main">
        <?php get_template_part( 'template-parts/content', get_post_type() ); ?>
    </main><!-- #main -->

<?php
get_footer();
