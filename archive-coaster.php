<?php
/*
 * The template for displaying coaster archive pages
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php
    render_hero_section([
        'background_image' => get_template_directory_uri() . '/img/hero/coasters.png',
        'title'            => 'Les coasters européens',
        'paragraph'        => 'Que vous aimiez les sensations fortes ou juste rider des montagnes russes plus calmes en famille, parcourez notre liste de coaster d\'Europe pour peut-être trouver votre prochain top 1 !',
    ]);
    ?>
    <section>
        <div class="card-container">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="card-link">
                        <article class="card">
                            <?php the_post_thumbnail(); ?>
                            <span class="name name-coaster"><?php the_title(); ?></span>

                            <?php
                            // Récupérer le parc associé au coaster
                            $parc = get_field('parc');
                            $parcName = get_the_title($parc[0]->ID); // Récupérer le titre du parc?>
                            <p class="park"> <?php echo $parcName; ?></p>

                        </article>
                    </a>
                <?php endwhile; ?>
            <?php else : ?>
                <p>Aucun coaster trouvé</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
