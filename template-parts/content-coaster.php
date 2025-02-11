



<?php the_title();?>
<?php the_post_thumbnail(); ?>
<?php echo get_field('hauteur'); ?>
<?php echo get_field('longueur'); ?>
<?php echo get_field('vitesse'); ?>
<?php echo get_field('inversions'); ?>
<?php echo get_field('statut'); ?>
<?php echo get_field('date_douverture'); ?>
<?php echo get_field('constructeur'); ?>


<?php echo get_field('type')->name; ?>

<?php
// Récupère le parc associé
$parcLinked = get_field('parc');
// Parcours le tableau pour récupérer la valeur du parc
foreach ($parcLinked as $parc) {
    echo '<span class="dashicons dashicons-admin-links"></span><a href="'. get_permalink($parc) .'">' . get_the_title($parc) . '</a>';
};
?>
