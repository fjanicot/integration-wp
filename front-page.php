<?php
get_header();
?>

    <main id="primary" class="site-main">
        <p>Contenu page d'accueil</p>
        <?php the_content();?>

        <?php $lastParkArgs = [
	        'post_type' => 'parc',
	        'posts_per_page' => 1,
	        'orderby' => 'date',
	        'order' => 'DESC',
        ];
        $lastParkQuery = new WP_Query($lastParkArgs);

        if ($lastParkQuery->have_posts()) :
            $lastParkQuery->the_post();
            ?>
            <p>Nom du dernier parc ajouté : <?php the_title(); ?></p>
        <?php
        endif;

        wp_reset_postdata();
        ?>
    </main>

<?php
get_footer();
