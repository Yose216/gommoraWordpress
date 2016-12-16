<?php
/*
Template Name: Homepage
*/
?>
<?php
?>
<?php get_header();?>
<?php include "slide.php";?>
<?php echo do_shortcode('[neo_carousel_shortcode id="462"]');?>
<?php include "marque_index.php";?>
<?php include "livre_dor_index.php";?>
<?php get_footer();?>


<script type="text/javascript">
    $('.carousel-caption > h3').lettering('words');
</script>
