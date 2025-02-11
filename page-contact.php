<?php
/**
 * The template for displaying contact page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EuCoasters
 */

get_header();
?>

    <main id="primary" class="site-main">
        <?php
        render_hero_section([
            'background_image' => get_template_directory_uri() . '/img/hero/contact.jpg',
            'title'            => 'Contacte-nous ou rejoins-nous !',
            'paragraph'        => 'Envie de discuter avec d\'autres fans de coasters ? N\'hésite pas à nous rejoindre sur les réseaux sociaux ou sur Discord. Une question sur le site ? Utilise le formulaire de contact ci-dessous !',
        ]);
        ?>

        <?php echo do_shortcode('[contact-form-7 id="5be9913" title="Contact form 1"]'); ?>

    </main><!-- #main -->

<?php
get_footer();
