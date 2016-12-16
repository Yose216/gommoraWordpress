	<?php
    ?>
    <footer class="row">
	    <div id="contact" class="contact">
	        
	        	  <div class="titre"><h2>CONTACT</h2></div>
	       	
	       
			    <div class="row">
				<div class="iconesContact col-lg-offset-4 col-lg-4 col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6 col-xs-offset-3 col-xs-6">
				
				<img src="<?php echo get_template_directory_uri()?>/images/mailColor.png" onmouseover="javascript:this.src='<?php echo get_template_directory_uri()?>/images/mailGrey.png';" onmouseout="javascript:this.src='<?php echo get_template_directory_uri()?>/images/mailColor.png';" data-toggle="popover" title="Anne Lemeillleur" data-content="contact@ebullition.fr"/>
				
			    	<img src="<?php echo get_template_directory_uri()?>/images/phoneColor.png" onmouseover="javascript:this.src='<?php echo get_template_directory_uri()?>/images/phoneGrey.png';" onmouseout="javascript:this.src='<?php echo get_template_directory_uri()?>/images/phoneColor.png';" data-toggle="popover" title="Anne Lemeillleur" data-content="+33(0)6 12 34 56 78" />
				
			        <a href="https://plus.google.com/116290887909204122037"><img class="google" src="<?php echo get_template_directory_uri()?>/images/google.png" onmouseover="javascript:this.src='<?php echo get_template_directory_uri()?>/images/googleGrey.png';" onmouseout="javascript:this.src='<?php echo get_template_directory_uri()?>/images/google.png';" /></a>
                    		<a href="https://fr-fr.facebook.com/ebullition.fanpage/"><img class="facebook" src="<?php echo get_template_directory_uri()?>/images/f.png" onmouseover="javascript:this.src='<?php echo get_template_directory_uri()?>/images/fGrey.png';" onmouseout="javascript:this.src='<?php echo get_template_directory_uri()?>/images/f.png';" /></a>
			  </div>        
		        </div>           
            <?php echo do_shortcode('[contact-form-7 id="288" title="Contact form 1"]');?>
            <div class=" col-lg-offset-1 col-lg-10 col-md-offset-1 col-md-10 col-sm-12 col-xs-12">
            	<ul class="inlineFooterLinks col-lg-7 col-md-8 col-sm-8 col-xs-8">
            		<li><a href="vetements.html">VETEMENTS</a></li>
            		<li><a href="accessoires.html">ACCESSOIRES</a></li>
            		<li><a href="decoration.html">DECORATION</a></li>
            		<li><a href="decoration.html">LIVRE D'OR</a></li>
            		<li><a href="mentions.html">MENTIONS LEGALES</a></li>
            	</ul>
            	<ul class="inlineFooterLinks right col-lg-5 col-md-4 col-sm-4 col-xs-4">
            		<li><a href="accessoires.html">By Code Académie</a></li>
            		<li>&copy; Ebullition</li>
            	</ul>

            </div>
            <!--<div class="goToTop">
               <a href id="title"><img src="images/fleche.svg"></a>
               <p class="haut">HAUT DE PAGE</p>
            </div>-->	
	    </div>
	</footer>
  </div>

</div>
<?php wp_footer(); ?>
</body>
</html>