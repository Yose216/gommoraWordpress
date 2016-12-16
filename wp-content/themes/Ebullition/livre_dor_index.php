<div class="livreDOR" id="livreDOR">
	<div class="titre"><h2>LIVRE D'OR</h2></div>
	<div class="contenu">
		<div class="row">
			<div class="col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8 col-xs-offset-2 col-xs-8">
				<p class="gris">
				<?php echo do_shortcode('[do_widget id="text-3"]');?>
				</p>

				<div class="zoneCmnt">
					<?php echo do_shortcode('[gwolle_gb]');?>
				</div>

				<?php
					$page = get_page_by_title("Livre d'Or");
				?>	
				<div class="col-lg-12 liensLivre">
					<a href="<?php echo get_permalink($page->ID);?>" class="col-lg-offset-1 col-lg-5">CONSULTER LE LIVRE D'OR</a>

				</div>
				
			</div>
		</div>
	</div>
</div>		 
</div>
</div>