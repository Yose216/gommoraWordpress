<?php
/*
* Template Name: Livre d'or
*/
?>

<?php get_header();?>
<?php include "slide.php";?>

<div class="pagelivreDOR container-fluid" id="livreDOR">
  <div class="titre"><h2>LIVRE D'OR</h2></div>
    <div class="contenu row">


        <p class="gris col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8 col-xs-offset-2 col-xs-8">
            <?php echo do_shortcode('[do_widget id="text-3"]');?>
          </p>

        <div class="col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8 col-xs-offset-2 col-xs-8">
          <?php echo do_shortcode('[gwolle_gb]');?>
        </div>

        <ul class="pagination col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <ul class="pager">
            <li><a href="#">Previous</a></li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">Next</a></li>
          </ul>
        </ul>

      </div>
  </div>
</div>
<?php get_footer();?>