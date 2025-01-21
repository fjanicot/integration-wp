</p>
<section class="presentation">
    <?php the_post_thumbnail(); ?>
    <div class="informations">
        <div>
            <h1>
                <?php the_title(); ?>
            </h1>
            <span class="dashicons dashicons-admin-links"></span><a href="<?php echo get_field('site'); ?>" target="_blank">Site officiel</a>
        </div>
        <div><h2>Adresse du parc d'attractions</h2>
            <p class="address">
                <?php echo get_field('adresse'); ?>
                <?php
                $term = get_field('pays');
                $pays = $term->name;
                $country_code = get_field('code_pays', $term);
                $flagURL = 'https://flagsapi.com/' . strtoupper(esc_attr($country_code)) . '/flat/32.png';
                ?>
                <span>
                    <img
                        src="<?php echo $flagURL?>"
                        alt="Drapeau du pays suivant : <?php echo $pays?>"
                    >
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
            <img src="<?php echo get_template_directory_uri(); ?>/img/coaster.svg" alt="Icône de coasters">
            <span class="text">
                <span class="number">
                    00
                </span>
                <span>Coaster</span>
            </span>
        </li>
        <li>
            <img src="<?php echo get_template_directory_uri(); ?>/img/calendar.svg" alt="Icône de calendrier">
            <span class="text">
                <span>Ouvert depuis </span>
                <span class="number"><?php echo get_field('date_douverture'); ?></span>
            </span>
        </li>
    </ul>
</section>

<section class="coasters">
    <h2 class="center">Coasters du parc</h2>

</section>
