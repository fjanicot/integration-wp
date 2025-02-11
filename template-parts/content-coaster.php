<section class="presentation">
    <?php the_post_thumbnail(); ?>
    <div class="informations">
        <div>
            <h1>
                <?php the_title(); ?>
            </h1>

            <?php
            // Récupère le parc associé
            $parcLinked = get_field('parc');

            // Parcours le tableau pour récupérer la valeur du parc
            foreach ($parcLinked as $parc) {
                echo '<span class="dashicons dashicons-admin-links"></span><a href="'. get_permalink($parc) .'">' . get_the_title($parc) . '</a>';
            };
            ?>

        </div>
        <div><h2>Localisation</h2>
            <?php
            // Récupère la relation (parc lié)
            $parcLinked = get_field('parc');
            $parcId = $parcLinked[0]->ID; // ID du parc lié

            // Récupère les champs personnalisés du parc
            $adresse = get_field('adresse', $parcId) ?: 'Adresse non disponible';
            $pays_term = get_field('pays', $parcId);
            $pays = $pays_term->name ?? 'Pays inconnu';
            $country_code = get_field('code_pays', $pays_term) ?: 'XX';
            $flagURL = 'https://flagsapi.com/' . strtoupper($country_code) . '/flat/32.png';
            ?>

            <p class="address">
                <?php echo $adresse; ?>
                <span>
                    <img src="<?php echo $flagURL; ?>" alt="Drapeau du pays suivant : <?php echo $pays; ?>">
                    <?php echo $pays; ?>
                </span>
            </p>
        </div>
    </div>
</section>

<section class="stats">
    <h2 class="center">
        Statistiques
    </h2>
    <ul>

        <li>
            <img src="<?php echo get_template_directory_uri(); ?>/img/height.svg" alt="Icône de flèche pour la hauteur">
            <span class="text">
                <span class="container">
                    <span class="number"><?php echo get_field('hauteur'); ?></span>
                    <span class="unit">mètres</span>
                </span>
                <span>de hauteur</span>
            </span>
        </li>
        <li>
            <img src="<?php echo get_template_directory_uri(); ?>/img/length.svg" alt="Icône de mètre">
            <span class="text">
                <span class="container">
                    <span class="number"><?php echo get_field('longueur'); ?></span>
                    <span class="unit">mètres</span>
                </span>
                <span>de longueur</span>
            </span>
        </li>
        <li>
            <img src="<?php echo get_template_directory_uri(); ?>/img/speed.svg" alt="Icône de chronomètre">
            <span class="text">
                <span class="container">
                    <span class="number"><?php echo get_field('vitesse'); ?></span>
                    <span class="unit">km/h</span>
                </span>
                <span>de vitesse max</span>
            </span>
        </li>
        <li>
            <img src="<?php echo get_template_directory_uri(); ?>/img/loop.svg" alt="Icône de flèche pour représenter un looping">
            <span class="text">
                <span class="container">
                    <span class="number"><?php echo get_field('inversions'); ?></span>
                </span>
                <?php if (get_field('inversions') < 1) {
                    echo '<span>inversion</span>';
                } else {
                    echo '<span>inversions</span>';
                }?>
            </span>
        </li>
    </ul>

    <div class="technical-datas">
        <h3>Détails techniques</h3>
        <ul>
            <li>
                Statut : <?php echo ucfirst(get_field('statut')); ?>
            </li>
            <li>
                Inauguration : <?php echo get_field('date_douverture'); ?>
            </li>
            <li>
                Constructeur : <?php echo get_field('constructeur')->name; ?>
            </li>
            <li>
                Type : <?php echo get_field('type')->name; ?>
            </li>
        </ul>
    </div>
</section>

<section class="coasters">
    <h2 class="center">D'autres coasters du même parc</h2>
    <?php
    $parcLinked = get_field('parc');
    $parcId = $parcLinked[0]->ID;
    $args = [
        'post_type'      => 'coaster',
        'posts_per_page' => 3,
        'post__not_in'   => [get_the_ID()],
        'meta_query'     => [
            [
                'key'     => 'parc',
                'value'   => '"' . $parcId . '"',
                'compare' => 'LIKE',
            ],
        ],
        'orderby' => 'rand',
    ];
    $related_coasters = new WP_Query($args);

    if ($related_coasters->have_posts()) : ?>
        <ul class="card-container">
            <?php while ($related_coasters->have_posts()) : $related_coasters->the_post(); ?>
                <li class="card coaster-card">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail() ?>
                        <span class="name"><?php the_title(); ?></span>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php
    else :?>
        <p class="center">Aucun autre coaster de ce parc n'est renseigné</p>
    <?php endif;
    wp_reset_postdata();
    ?>
</section>
