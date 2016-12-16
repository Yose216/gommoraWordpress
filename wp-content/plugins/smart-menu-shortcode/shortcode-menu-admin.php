<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="wrap">
<?php
if(current_user_can('manage_options')):
$riscmenu = '';
if(isset($_POST['_rismnonce']) && wp_verify_nonce( $_POST['_rismnonce'], 'rism-nonce' )){
	if($_POST['menuid']!=''){ $riscmenu = absint($_POST['menuid']); }else{ $riscmenu = ''; }
}else{  }


?><form action="" method="post">
	<input type="hidden" name="_rismnonce" value="<?php echo wp_create_nonce( 'rism-nonce' ); ?>" />
	<table class="manage-social wp-list-table widefat fixed striped pages">
    <thead>
    	
    </thead>
    <tbody>
    	<tr>
        	<td class="column-title"> <strong>Select Menu :</strong> </td> 
            <td> <select name="menuid" >
                	<option value="">Select Menu</option>
                    <?php
						$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
						foreach ( $menus as $k => $menu ) {
							$sel = '';
							if($menu->term_id==$mid){ $sel = 'selected="selected"'; }
							echo '<option '.$sel.' value="'.$menu->term_id.'">'.$menu->name.'</option>';
						}
					?>
                </select></td>
        </tr>
    <tr> <td><input class="button" type="submit" name="ssn" value="View Shortcode" /></td>
    <td>
    	<?php
			if($riscmenu!=''){
				echo '[menu_shortcode id='.$riscmenu.']';
			}
		?>
    </td>
    </tr>   
    </tbody>
    
    </table>
    </form>
    <div class="ri_sticky_menu_op">
        
    </div>
<?php endif; ?>
</div>