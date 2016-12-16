<div class="row marque" id="marque">
		
		<div class="titre">
		<h2>LA MARQUE</h2>
		</div>

		<div class="contenu">
			<div class="row ">
				<div class="texte col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8 col-xs-offset-2 col-xs-8">
					<p class="gris"><?php echo do_shortcode('[do_widget id="text-2"]');?></p>
				</div>
			</div>

			<div class="row">
		
				<div class="col-lg-offset-1 col-lg-10 col-md-offset-1 col-md-10 col-xs-offset-2 col-xs-8">

					<div class="vetm col-lg-3 col-md-3 no-gutters">
						<div class="titre-vetm">
							<?php echo do_shortcode('[menu_shortcode id="32"]');?>
						</div>
					</div>

					<div class="acces col-lg-3 col-md-3 no-gutters">
						<div class="titre-acces">
						<?php echo do_shortcode('[menu_shortcode id="29"]');?>
						
						</div>
					</div>
					
					<div class="deco col-lg-3 col-md-3 no-gutters">
						<div class="titre-deco">
						<?php echo do_shortcode('[menu_shortcode id="30"]');?>
						
						</div>
					</div>
					<div class="deco col-lg-3 col-md-3 no-gutters">
						<div class="titre-deco">
						<?php echo do_shortcode('[menu_shortcode id="31"]');?>
						
						</div>
					</div>
				</div>
			</div>
				
		<div class="zoneTelechargement">
			<div class="icone" id="telechCatalogue"></div>
			<a id="telechCatalogue" class="text" ><br><br><br>TELECHARGER NOTRE CATALOGUE</a>
			<div class="row">
				<div class="mailCatalogue col-lg-offset-4 col-lg-4 col-md-offset-3 col-md-6 col-sm-offset-1 col-sm-10 col-xs-offset-1 col-xs-10" id="">
					<p>Veuillez saisir votre mail pour télécharger notre catalogue.</p>
					<form class="form" role="form">
						<div class="form-group">
							<input type="email" class="form-control adresse" placeholder=" Votre email" name="mail" id="emailCtlg" onchange="displayDownloadBox()">
						</div>
						<div class="checkbox">
							<label><input type="checkbox" id='newsletter_checkbox' >   Je m'abonne à la Newsletter.</label>
						</div>

						<div id="download_link">
							<?php echo do_shortcode ('[sdm_download id="467" fancy="0"]') ;?>	
						</div>
						
						<?php echo do_shortcode ('[sdm_download_counter id="467"]') ; ?>
						<!--<a name="send" href="<?php echo get_template_directory_uri()?>/download/catalogue.pdf">Envoyer</a>-->
									
					</form>
								<!--<a href="Mentions.html">NOTRE POLITIQUE DE CONFIDENTIALITÉ</a>-->
				</div>
			</div>
		</div>
		
	</div>

	<script>
	function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
	function displayDownloadBox(){
		var checkbox = document.getElementById('newsletter_checkbox').checked;
		var email = document.getElementById('emailCtlg').value;
		if(checkbox && validateEmail(email)){
			document.getElementById('download_link').style.display='block';
		}
		else{
			document.getElementById('download_link').style.display='none';
		}
	}
	</script>