<?php
/**
 * Contact Form 7 Style Options
 */

require 'plugin-options.php';
$options = json_decode($options_string, true);

/**
 * Generate property fields
 */

function generate_property_fields( $key, $std, $name, $type, $saved_values, $selector_type ) {
	$temp = '';
	/*Had to remove numbers which adds the  UNIQUE keys!*/
	$title_addon = ($selector_type != "") ? str_replace('_', ' ', $selector_type): "";
	$hidden_element = ($selector_type != "") ? "class='hidden".$title_addon."-element'": "";
	$current_key = preg_replace('/[0-9]+/', '', strtolower( $key ) );
	switch ( $current_key ) {
		case 'color-picker':
		case 'input':
			$field_class = ($current_key == "input") ? "cf7-style-upload-field" : "cf7-style-color-field";
			$saved_one = (array_key_exists( $name . "_". $std["style"].$selector_type, $saved_values)) ? $saved_values[ $name . "_". $std["style"].$selector_type] : "";
			return "<li ".$hidden_element."><label for='". $name . "_". $std["style"] .$selector_type."'><strong>".$std["title"].$title_addon.":</strong></label>".(($current_key == "color-picker") ? "<span class='icon smaller'><i class='fa fa-eyedropper' aria-hidden='true'></i></span>" : "")."<input type='text' id='". $name . "_". $std["style"] .$selector_type."' name='cf7stylecustom[". $name . "_". $std["style"] .$selector_type."]' value='". $saved_one ."' class='".$field_class."' /></li>";
			break;
		case 'comming-soon': 
			return "<li></li>";
		break;
		case 'numeric':
			$val = explode( " ", $std["property"] );
			$temp .= "<li ".$hidden_element.">";
			if( $std["property"] == "0 0 0 0"){
			 	if( $std["style"] == "border-radius"){
			 		$element= array( "top-left", "top-right-radius", "bottom-left-radius", "bottom-right-radius" );
			 		$temp .=  "<label for='".$name . "_border-top-left-radius".$selector_type."'><strong>".$std["title"].":</strong>";
				} else {
					$element= array( "top", "right", "bottom", "left" );
					 $labelos = explode( "-",$std["style"]);
					 if( $std["style"] == "border-radius"){
					 	$ending =  "-top-".$labelos[1].$selector_type;
					 } else {
					 	$ending =  "-top".$selector_type;
					 }
					$temp .=  "<label for='".$name . "_". $labelos[0].$ending."'><strong>".$std["title"].$title_addon.":</strong>";
				}
			}else {
				$temp .=  "<label for='".$name . "_". $std["style"].$selector_type."'><strong>".$std["title"].$title_addon.":</strong>";
			}
			$incrementor = 0;
			$indexer = 0;
			$arrows = array('up', 'right', 'down' , 'left');
			$fonts = array( 'font-size' => 'text-height', 'line-height' => 'font', 'text-indent' => 'indent');
			foreach( $val as $elem_key => $elem_value ) {
				if( $std["property"] == "0 0 0 0"){
					/*Add new style properties if 4 value property inserted*/
					$newproperty = explode("-", $std["style"]);
				 	$endstyling = $element[ $incrementor];
				 	if( $std["style"] == "border-radius"){
				 		$endstyling = $element[ $incrementor ]."-".end($newproperty);
				 	}
					$std["style"] = $newproperty[0] ."-".$endstyling;
					$incrementor++;
				}
				$test = ( $std["style"] == "border-top" || $std["style"] == "border-right" || $std["style"] == "border-bottom" || $std["style"] == "border-left") ? '-width' : '' ;
				$saved_one = ( array_key_exists( $name . "_". $std["style"].$test.$selector_type, $saved_values)) ? $saved_values [ $name . "_". $std["style"].$test.$selector_type ] : "";
				switch ($type){
					case "width" : $temp .= '<span class="icon"><i class="fa fa-arrows-h" aria-hidden="true"></i></span>'; break;
					case "height" : $temp .= '<span class="icon"><i class="fa fa-arrows-v" aria-hidden="true"></i></span>'; break;
					case "border" :
					case "margin" :
					case "padding": $temp .= '<span class="icon"><i class="fa fa-long-arrow-'.$arrows[$indexer++].'" aria-hidden="true"></i></span>'; break;
					case "font" : $temp .= '<span class="icon"><i class="fa fa-'.$fonts[$std["style"]].'" aria-hidden="true"></i></span>';break;
				}
				$temp .= "<input type='number' min='0' max='1000' id='". $name . "_". $std["style"].$test.$selector_type."' name='cf7stylecustom[". $name . "_". $std["style"].$test.$selector_type."]' value='". $saved_one ."' />";
				
				$temp .= "<select id='". $name . "_". $std["style"] .$test . "_unit".$selector_type."' name='cf7stylecustom[". $name . "_". $std["style"] .$test ."_unit".$selector_type."]'>";
				foreach( $std["unit"] as $unit_val ) {
					$saved_one_unit =  ( array_key_exists( $name . "_". $std["style"]. "_unit".$selector_type, $saved_values) ) ? $saved_values[ $name . "_". $std["style"]. "_unit".$selector_type ] : "";
					$temp .= "<option ". selected( $saved_one_unit , $unit_val, false ) . ">". $unit_val ."</option>";
				}
				$temp .= "</select>";
				
			}
			$temp .= "</label></li>";
			return $temp;
			break;

		case 'select':
			$fonts = array( 'font-style' => 'italic', 'font-weight' => 'bold', 'text-align' => 'align-center', 'text-decoration' => 'underline', 'text-transform' => 'header'  );
			$temp .= "<li ".$hidden_element."><label for='".$name . "_" . $std["style"].$selector_type."'><strong>".$std["title"].$title_addon.":</strong>";
			switch ($type){
				case "font" : $temp .= '<span class="icon"><i class="fa fa-'.$fonts[$std["style"]].'" aria-hidden="true"></i></span>';break;
			}
			$temp .= "<select id='". $name . "_" . $std["style"].$selector_type. "' name='cf7stylecustom[". $name . "_" . $std["style"] .$selector_type."]'>";
			$temp .= '<option value="">'.__( "Choose value", 'contact-form-7-style' ).'</option>';
			foreach( $std["property"] as $key => $value ) {
				$saved_one = ( array_key_exists($name . "_". $std["style"].$selector_type, $saved_values) ) ? $saved_values[ $name . "_". $std["style"].$selector_type] : "";
				$temp .= "<option ". selected( $saved_one , $value, false ) . ">". $value ."</option>";
			}
			$temp .= "</select></label></li>";
			return $temp;

			break;

		default:
			
			break;
	}

}


/**
 * Elements
 */
$sameElements = array( "width", "height", "background", "margin", "padding", "font", "border",  "float", "display", "box-sizing" );
$containerElements = array( "width", "height",  "margin", "padding", "font", "border",   "float", "box-sizing" );
$elements = array(
	'form' 	=> array(
		'name' => 'form',
		'description' => 'The Contact Form 7 form element\'s design can be modified below:',
		'settings' => array("width", "height", "background", "margin", "padding", "border",  "float", "box-sizing" )
	),
	'input' => array(
		'name' => 'input',
		'description' => 'This section allows styling of text, email, URL and contact numbers fields.', 
		'settings' => $sameElements
	),
	'textarea' => array(
		'name' => 'text area',
		'description' => 'This section allows styling the textarea fields.', 
		'settings' => $sameElements
	),
	"p" => array(
		'name' => 'text',
		'description' => '', 
		'settings' => $containerElements
	),
	'label' => array(
		'name' => 'input label',
		'description' => 'This section allows styling the input label.', 
		'settings' => $containerElements
	),
	'fieldset' => array(
		'name' => 'fieldset',
		'description' => '', 
		'settings' => $containerElements
	),
	'submit' => array(
		'name' => 'submit button',
		'description' => 'This section allows styling the submit button.', 
		'settings' => $sameElements
	),
	'select' => array(
		'name' => 'dropdown menu',
		'description' => 'This section allows styling the dropdown menus.', 
		'settings' => $sameElements
	),
	'acceptance' => array(
		'name' => 'acceptance',
		'description' => '', 
		'settings' => array("comming-soon")
	),
	'checkbox' => array(
		'name' => 'checkboxes',
		'description' => '', 
		'settings' => array( "width", "height" )
	),
	'radio' => array(
		'name' => 'radio buttons',
		'description' => '', 
		'settings' => array( "width", "height" )
	),
	'file' => array(
		'name' => 'file',
		'description' => '', 
		'settings' => array("comming-soon")
	),
	'quiz' => array(
		'name' => 'quiz',
		'description' => '', 
		'settings' => array("comming-soon")
	),
);


/**
 * Get saved values
 */ 

wp_nonce_field( 'cf_7_style_style_customizer_inner_custom_box', 'cf_7_style_customizer_custom_box_nonce' );
$saved_values = maybe_unserialize(get_post_meta( $post->ID, 'cf7_style_custom_styler', true ));
$saved_values = (empty($saved_values)) ? array() : $saved_values;
$active_panel = get_post_meta( $post->ID, 'cf7_style_active_panel', 'form' );
$active_panel = ( $active_panel=="" ) ? "form" : $active_panel; 

$form_tags = '<div id="form-tag">';
$form_tags .= '<h4>'. __( "Choose element", 'contact-form-7-style' ).'</h4>';
$form_panel = '';
$form_index = 0;
foreach( $elements as $property => $property_value ) {
	$selected_class = ( $active_panel == $property) ? ' button-primary' : '';
	$hidden_class = ( $active_panel != $property || ( $active_panel =="" && $form_index++ > 0)) ? ' hidden' : ''; 
	$form_tags .= "<a href='#' class='button".$selected_class."' data-property='".$property."'>" . $property_value['name'] . "</a>";
	$form_panel .= "<div class='". $property ."-panel panel".$hidden_class." clearfix'>";
		if( $property_value['description'] != ""){
			$form_panel .= '<h4 class="description-title">'.$property_value['description'].'</h4>';
		}
		foreach( $property_value['settings'] as $sub_property_key => $sub_property_value ) {
			$property = strtolower( $property );
			$sub_property_slug = strtolower( $options[$sub_property_value]['slug'] );
			$style_element_name 	= strtolower($options[$sub_property_value]['name']);
			$half_width_class = ( $style_element_name == "box sizing" || $style_element_name == "display" || $style_element_name == "position" ||  $style_element_name == "width" || $style_element_name == "height") ? "half-size" : "";
			$form_panel .= '<div class="element-styling '.$half_width_class.' '.$style_element_name.'"><h3><span>&lt;'.$property.'&gt;</span> '.$style_element_name . '</h3>';
			if( $options[$sub_property_value]['type'] ) {
				$form_panel .= "<ul>";
				foreach( $options[$sub_property_value]['type'] as $key => $value ) {
					if( $key != "comming-soon" ){
						$form_panel .= generate_property_fields( $key, $value, $property, $sub_property_slug, $saved_values, '');
						$form_panel .= generate_property_fields( $key, $value, $property, $sub_property_slug, $saved_values, '_hover');
					} else {
						$form_panel .= "<li></li>";
					}
				}
				$form_panel .= "</ul>";
				$form_panel .= "</div>";
			}
		}
	$form_panel .= "</div>";	
}
?>

<div class="generate-preview">		
	<?php
		$form_args = array(
			'post_type'		=> 'wpcf7_contact_form',
			'posts_per_page'	=> -1,
			'meta_key' 		=> 'cf7_style_id',
			'meta_value' 		=> $post->ID
		);
		$indexter = 0;
		$form_el = array();
		$form_query = new WP_Query( $form_args );
		while ( $form_query->have_posts() ) : $form_query->the_post(); 
			$cur_title = get_the_title();
			$form_el[$indexter]['form'] = do_shortcode( '[contact-form-7 id="'.get_the_ID().'" title="'.$cur_title.'"]' );
			$form_el[$indexter++]['form_title'] = $cur_title;
		endwhile; 
		wp_reset_postdata();
		$form_choose ="";
		if($indexter > 1){
			$form_choose 	= '<div class="choose-preview"><h4>'.__( "Choose form to preview:", 'contact-form-7-style' ).'</h4>';
			$form_choose 	.= '<select name="form-preview" id="form-preview">';
			foreach ($form_el as $key => $cur_form) {   
				$form_choose .= '<option value="'.$key.'" '.selected($key,0,false).'>'.$cur_form['form_title'].'</option>';
			} 
			$form_choose .= "</select></div>";
		}
		$form_tags 	.= '</div>';?>
	<div class="panel-options">
		<h3><?php echo __( "Customize form", 'contact-form-7-style' );?></h3>
		<?php echo $form_tags; ?>
		<div class="element-selector clearfix">
			<h4><?php echo __( "Choose element state", 'contact-form-7-style' ); ?></h4>
			<label><input type="radio" name="element-type" checked = "checked" value="normal" /> <?php echo __( "normal state", 'contact-form-7-style' ); ?></label>
			<label><input type="radio" name="element-type" value="hover" /> <?php echo __( ":hover state", 'contact-form-7-style' ); ?></label>
			<div class="hidden"><input type="text" name="cf7styleactivepane" value="<?php echo $active_panel;  ?>"></div>
		</div>
		<?php echo $form_panel; ?>
	</div>
	<div class='panel-header'>

		<h3><?php echo __( "Preview Area", 'contact-form-7-style' ); ?></h3>
		<?php echo $form_choose;   ?>
		<div class='preview-form-tag' id="preview">
			<?php 
			$indexter = 0;

			// Show default form when on first custom style edit
			if( empty( $form_el ) ) {
				echo "<p class='cf7style-no-forms-added'>" . __( 'Please check one of the forms above to activate the preview mode.', 'cf7style' ) . "</p>";
			}

			foreach ( $form_el as $key => $cur_form ) { 
				$extra_class= ($indexter++ != 0) ? 'hidden' : ''; ?>
				<div class="preview-form-container <?php echo $extra_class; ?>">
					<h4><?php echo $cur_form['form_title']; ?></h4>
					<?php echo $cur_form['form'];  ?>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php $check_screen = get_current_screen(); ?>
<div class="fixed-save-style">
	<?php if( $check_screen->action == "add" && $check_screen->post_type == "cf7_style" ){ ?>
		<input type="submit" name="publish" class="button button-primary button-large" value="Publish Style">
	<?php } else { ?>
		<input name="save" type="submit" class="button button-primary button-large" value="Update Style">
	<?php } ?>
</div>