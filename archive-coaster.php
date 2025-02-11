<?php
/*
 * The template for displaying coaster archive pages
 */

get_header();
?>

    <main id="primary" class="site-main">
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
