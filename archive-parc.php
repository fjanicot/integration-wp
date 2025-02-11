<?php
/*
 * The template for displaying park archive pages
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php
    render_hero_section([
        'background_image' => get_template_directory_uri() . '/img/hero/parc.jpg',
        'title'            => 'Les parcs d\'attractions européens',
        'paragraph'        => 'Grâce à notre encyclopédie des parcs européens, vous n\'avez pas fini de prévoir des escapades d\'un bout à l\'autre du continent !',
    ]);
    ?>

    <section>
       <div class="card-container">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <a href="<?php the_permalink(); ?>" class="card-link">
                    <article class="card">
                        <?php the_post_thumbnail(); ?>
                        <span class="name name-parc"><?php the_title(); ?></span>

                        <?php
                        // Récupérer le pays associé au parc via un champ personnalisé ou une taxonomie
                        $pays_term = get_field('pays');
                        if ($pays_term) :
                            $pays = $pays_term->name;
                            $country_code = get_field('code_pays', $pays_term);
                            $flagURL = 'https://flagsapi.com/' . strtoupper(esc_attr($country_code)) . '/flat/16.png';
                            ?>
                            <span class="country-tag">
                                <img src="<?php echo esc_url($flagURL); ?>" alt="Drapeau du pays : <?php echo esc_attr($pays); ?>">
                                <?php echo esc_html($pays); ?>
                            </span>
                        <?php endif; ?>
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
