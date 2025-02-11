<?php
get_header();
?>

    <main id="primary" class="site-main">
        <?php
        render_hero_section([
            'background_image' => get_template_directory_uri() . '/img/hero/home.webp',
            'title'            => 'Découvre les coasters des parcs d\'attractions européens !',
            'paragraph'        => 'Et planifie ton prochain voyage sensationnel...',
            'cta_1_link'       => home_url() . '/coasters',
            'cta_1_title'       => 'Coasters',
            'cta_2_link'       => home_url() . '/parcs',
            'cta_2_title'       => 'Parcs',
        ]);
        ?>


        <!-- Section pour afficher les derniers ajouts -->
        <section class="last-elements">
            <!-- Dernier parc ajouté -->
            <div class="last-park">
                <h2>Dernier parc ajouté</h2>
                <?php
                // Préparer une requête pour récupérer le dernier parc
                $lastParkArgs = [
                    'post_type'      => 'parc',
                    'posts_per_page' => 1,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ];
                $lastParkQuery = new WP_Query($lastParkArgs);
                // Si un parc est trouvé, afficher ses détails
                if ($lastParkQuery->have_posts()) {
                    $lastParkQuery->the_post();
                    ?>
                    <a href="<?php the_permalink(); ?>" class="card-link">
                        <article class="card">
                            <?php the_post_thumbnail(); // Affiche l'image à la une ?>
                            <span class="name name-parc"><?php the_title(); // Affiche le titre du parc ?></span>
                            <?php
                            // Récupérer le pays associé au parc
                            $countryTerm = get_field('pays');
                            if ($countryTerm) :
                                $country = $countryTerm->name;
                                $countryCode = get_field('code_pays', $countryTerm); // Code du pays pour le drapeau
                                $flagURL = 'https://flagsapi.com/' . strtoupper(esc_attr($countryCode)) . '/flat/16.png';
                                ?>
                                <span class="country-tag">
                                <img src="<?php echo esc_url($flagURL); ?>" alt="Drapeau du pays : <?php echo esc_attr($country); ?>">
                                <?php echo esc_html($country); ?>
                            </span>
                            <?php endif; ?>
                        </article>
                    </a>
                    <?php
                } else {
                    echo '<p>Aucun parc trouvé.</p>';
                }
                wp_reset_postdata();
                ?>
            </div>
            <!-- Dernier coaster ajouté -->
            <div class="last-coaster">
                <h2>Dernier coaster ajouté</h2>
                <?php
                // Préparer une requête pour récupérer le dernier coaster
                $lastCoasterArgs = [
                    'post_type'      => 'coaster',
                    'posts_per_page' => 1,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ];
                $lastCoasterQuery = new WP_Query($lastCoasterArgs);
                // Si un coaster est trouvé, afficher ses détails
                if ($lastCoasterQuery->have_posts()) {
                    $lastCoasterQuery->the_post();
                    ?>
                    <a href="<?php the_permalink(); ?>" class="card-link">
                        <article class="card">
                            <?php the_post_thumbnail(); ?>
                            <span class="name name-coaster"><?php the_title(); ?></span>
                            <?php
                            // Récupérer le parc associé au coaster
                            $park = get_field('parc');
                            if ($park) {
                                $parkName = get_the_title($park[0]->ID);
                                ?>
                                <p class="park"><?php echo esc_html($parkName); ?></p>
                            <?php } ?>
                        </article>
                    </a>
                    <?php
                } else {
                    echo '<p>Aucun coaster trouvé.</p>';
                }
                wp_reset_postdata();
                ?>
            </div>
        </section>
        <!-- Section pour les coasters d'un pays mis en avant -->
        <section class="featured-country">
            <?php
            // Récupérer le pays mis à l'honneur depuis la page d'options
            $featuredCountry = get_field('pays', 'option'); // Renvoie un objet WP_Term

            if ($featuredCountry instanceof WP_Term) {
                $countryId = $featuredCountry->term_id;

                // Récupérer les parcs associés à ce pays
                $parcsQuery = new WP_Query([
                    'post_type'      => 'parc',
                    'posts_per_page' => -1,
                    'meta_query'     => [
                        [
                            'key'     => 'pays',
                            'value'   => $countryId,
                            'compare' => 'LIKE',
                        ],
                    ],
                ]);

                if ($parcsQuery->have_posts()) {
                    $parcIds = [];
                    while ($parcsQuery->have_posts()) {
                        $parcsQuery->the_post();
                        $parcIds[] = get_the_ID(); // Collecter les IDs des parcs
                    }
                    wp_reset_postdata();
                } else {
                    echo '<p class="center">Aucun parc trouvé pour ce pays.</p>';
                    return;
                }

                // Construire une meta_query pour récupérer les coasters associés aux parcs
                $metaQuery = ['relation' => 'OR'];
                foreach ($parcIds as $parcId) {
                    $metaQuery[] = [
                        'key'     => 'parc', // Champ relation
                        'value'   => '"' . $parcId . '"',
                        'compare' => 'LIKE',
                    ];
                }

                // Récupérer 3 coasters aléatoires liés à ces parcs
                $queryCoasters = new WP_Query([
                    'post_type'      => 'coaster',
                    'posts_per_page' => 3,
                    'orderby'        => 'rand',
                    'meta_query'     => $metaQuery,
                ]);

                if ($queryCoasters->have_posts()) {
                    ?>
                    <h2>Les coasters de <?php echo esc_html($featuredCountry->name); ?> à l'honneur !</h2>
                    <div class="card-container">
                        <?php
                        while ($queryCoasters->have_posts()) {
                            $queryCoasters->the_post();
                            ?>
                            <a href="<?php the_permalink(); ?>" class="card-link">
                                <article class="card">
                                    <?php the_post_thumbnail(); ?>
                                    <span class="name name-coaster"><?php the_title(); ?></span>
                                    <?php
                                    $park = get_field('parc');
                                    if ($park) {
                                        $parkName = get_the_title($park[0]->ID);
                                        ?>
                                        <p class="park"><?php echo esc_html($parkName); ?></p>
                                    <?php } ?>
                                </article>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                    wp_reset_postdata();
                } else {
                    echo '<p class="center">Aucun coaster trouvé pour ce pays.</p>';
                }
            } else {
                echo '<p class="center">Aucun pays sélectionné dans les options.</p>';
            }
            ?>
        </section>
    </main>

<?php
get_footer();
