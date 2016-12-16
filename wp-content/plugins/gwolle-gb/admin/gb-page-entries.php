<?php
/*
 * entries.php
 * Displays the guestbook entries in a list.
 */

// No direct calls to this script
if ( strpos($_SERVER['PHP_SELF'], basename(__FILE__) )) {
	die('No direct calls allowed!');
}


function gwolle_gb_page_entries() {

	if ( function_exists('current_user_can') && !current_user_can('moderate_comments') ) {
		die(__('Cheatin&#8217; uh?', 'gwolle-gb'));
	}

	gwolle_gb_admin_enqueue();

	$gwolle_gb_errors = '';
	$gwolle_gb_messages = '';

	if ( isset($_POST['gwolle_gb_page']) && $_POST['gwolle_gb_page'] == 'entries' ) {
		$action = '';
		if ( ( isset($_POST['massEditAction1']) && $_POST['massEditAction1'] == 'check' ) || ( isset($_POST['massEditAction2']) && $_POST['massEditAction2'] == 'check' ) ) {
			$action = 'check';
		} else if ( ( isset($_POST['massEditAction1']) && $_POST['massEditAction1'] == 'uncheck' ) || ( isset($_POST['massEditAction2']) && $_POST['massEditAction2'] == 'uncheck' ) ) {
			$action = 'uncheck';
		} else if ( ( isset($_POST['massEditAction1']) && $_POST['massEditAction1'] == 'spam' ) || ( isset($_POST['massEditAction2']) && $_POST['massEditAction2'] == 'spam' ) ) {
			$action = 'spam';
		} else if ( ( isset($_POST['massEditAction1']) && $_POST['massEditAction1'] == 'no-spam' ) || ( isset($_POST['massEditAction2']) && $_POST['massEditAction2'] == 'no-spam' ) ) {
			$action = 'no-spam';
		} else if ( ( isset($_POST['massEditAction1']) && $_POST['massEditAction1'] == 'akismet' ) || ( isset($_POST['massEditAction2']) && $_POST['massEditAction2'] == 'akismet' ) ) {
			$action = 'akismet';
		} else if ( ( isset($_POST['massEditAction1']) && $_POST['massEditAction1'] == 'trash' ) || ( isset($_POST['massEditAction2']) && $_POST['massEditAction2'] == 'trash' ) ) {
			$action = 'trash';
		} else if ( ( isset($_POST['massEditAction1']) && $_POST['massEditAction1'] == 'untrash' ) || ( isset($_POST['massEditAction2']) && $_POST['massEditAction2'] == 'untrash' ) ) {
			$action = 'untrash';
		} else if ( ( isset($_POST['massEditAction1']) && $_POST['massEditAction1'] == 'remove' ) || ( isset($_POST['massEditAction2']) && $_POST['massEditAction2'] == 'remove' ) ) {
			$action = 'remove';
		}


		/* Check if we are not sending in more entries than were even listed... */
		$continue_on_entries_checked = false;
		$entries_checked = 0;
		$num_entries = get_option('gwolle_gb-entries_per_page', 20);
		foreach( array_keys($_POST) as $postElementName ) {
			if (strpos($postElementName, 'check') > -1 && !strpos($postElementName, '-all-') && $_POST[$postElementName] == 'on') {
				$entries_checked++;
			}
		}
		if ( $entries_checked < ( $num_entries + 1 ) ) {
			$continue_on_entries_checked = true;
		} else {
			$gwolle_gb_messages .= '<p>' . __('It seems you checked more entries then were even listed on the page.', 'gwolle-gb') . '</p>';
			$gwolle_gb_errors = 'error';
		}

		/* Check Nonce */
		$continue_on_nonce_checked = false;
		if ( isset($_POST['gwolle_gb_wpnonce']) ) {
			$verified = wp_verify_nonce( $_POST['gwolle_gb_wpnonce'], 'gwolle_gb_page_entries' );
			if ( $verified == true ) {
				$continue_on_nonce_checked = true;
			} else {
				// Nonce is invalid, so considered spam
				$gwolle_gb_messages .= '<p>' . __('Nonce check failed. Please try again.', 'gwolle-gb') . '</p>';
				$gwolle_gb_errors = 'error';
			}
		}
		/* End of security checks. */


		if ( $action != '' && $continue_on_entries_checked && $continue_on_nonce_checked ) {
			// Initialize variables to generate messages with
			$entries_handled = 0;
			$entries_not_handled = 0;
			$akismet_spam = 0;
			$akismet_not_spam = 0;
			$akismet_already_spam = 0;
			$akismet_already_not_spam = 0;

			/* Handle the $_POST entries */
			foreach( array_keys($_POST) as $postElementName ) {
				if (strpos($postElementName, 'check') > -1 && !strpos($postElementName, '-all-') && $_POST[$postElementName] == 'on') {
					$entry_id = str_replace('check-','',$postElementName);
					$entry_id = intval($entry_id);
					if ( isset($entry_id) && $entry_id > 0 ) {
						$entry = new gwolle_gb_entry();
						$result = $entry->load( $entry_id );
						if ( $result ) {

							if ( $action == 'check' ) {
								if ( $entry->get_ischecked() == 0 ) {
									$entry->set_ischecked( true );
									$user_id = get_current_user_id(); // returns 0 if no current user
									$entry->set_checkedby( $user_id );
									gwolle_gb_add_log_entry( $entry->get_id(), 'entry-checked' );
									$result = $entry->save();
									if ( $result ) {
										$entries_handled++;
										do_action( 'gwolle_gb_save_entry_admin', $entry );
									} else {
										$entries_not_handled++;
									}
								} else {
									$entries_not_handled++;
								}
							} else if ( $action == 'uncheck' ) {
								if ( $entry->get_ischecked() == 1 ) {
									$entry->set_ischecked( false );
									$user_id = get_current_user_id(); // returns 0 if no current user
									$entry->set_checkedby( $user_id );
									gwolle_gb_add_log_entry( $entry->get_id(), 'entry-unchecked' );
									$result = $entry->save();
									if ( $result ) {
										$entries_handled++;
										do_action( 'gwolle_gb_save_entry_admin', $entry );
									} else {
										$entries_not_handled++;
									}
								} else {
									$entries_not_handled++;
								}
							} else if ( $action == 'spam' ) {

								if ( $entry->get_isspam() == 0 ) {
									$entry->set_isspam( true );
									if ( get_option('gwolle_gb-akismet-active', 'false') == 'true' ) {
										gwolle_gb_akismet( $entry, 'submit-spam' );
									}
									gwolle_gb_add_log_entry( $entry->get_id(), 'marked-as-spam' );
									$result = $entry->save();
									if ( $result ) {
										$entries_handled++;
										do_action( 'gwolle_gb_save_entry_admin', $entry );
									} else {
										$entries_not_handled++;
									}
								} else {
									$entries_not_handled++;
								}
							} else if ( $action == 'no-spam' ) {
								if ( $entry->get_isspam() == 1 ) {
									$entry->set_isspam( false );
									if ( get_option('gwolle_gb-akismet-active', 'false') == 'true' ) {
										gwolle_gb_akismet( $entry, 'submit-ham' );
									}
									gwolle_gb_add_log_entry( $entry->get_id(), 'marked-as-not-spam' );
									$result = $entry->save();
									if ( $result ) {
										$entries_handled++;
										do_action( 'gwolle_gb_save_entry_admin', $entry );
									} else {
										$entries_not_handled++;
									}
								} else {
									$entries_not_handled++;
								}
							} else if ( $action == 'akismet' ) {
								/* Check for spam and set accordingly */
								if ( get_option('gwolle_gb-akismet-active', 'false') == 'true' ) {
									$isspam = gwolle_gb_akismet( $entry, 'comment-check' );
									if ( $isspam ) {
										// Returned true, so considered spam
										if ( $entry->get_isspam() == 0 ) {
											$entry->set_isspam( true );
											gwolle_gb_add_log_entry( $entry->get_id(), 'marked-as-spam' );
											$result = $entry->save();
											if ( $result ) {
												$akismet_spam++;
												do_action( 'gwolle_gb_save_entry_admin', $entry );
											} else {
												$akismet_not_spam++;
											}
										} else {
											$akismet_already_spam++;
										}
									} else {
										if ( $entry->get_isspam() == 1 ) {
											$entry->set_isspam( false );
											gwolle_gb_add_log_entry( $entry->get_id(), 'marked-as-not-spam' );
											$result = $entry->save();
											if ( $result ) {
												$akismet_not_spam++;
												do_action( 'gwolle_gb_save_entry_admin', $entry );
											} else {
												$akismet_spam++;
											}
										} else {
											$akismet_already_not_spam++;
										}
									}
								}
							} else if ( $action == 'trash' ) {
								if ( $entry->get_istrash() == 0 ) {
									$entry->set_istrash( true );
									gwolle_gb_add_log_entry( $entry->get_id(), 'entry-trashed' );
									$result = $entry->save();
									if ( $result ) {
										$entries_handled++;
										do_action( 'gwolle_gb_save_entry_admin', $entry );
									} else {
										$entries_not_handled++;
									}
								} else {
									$entries_not_handled++;
								}
							} else if ( $action == 'untrash' ) {
								if ( $entry->get_istrash() == 1 ) {
									$entry->set_istrash( false );
									gwolle_gb_add_log_entry( $entry->get_id(), 'entry-untrashed' );
									$result = $entry->save();
									if ( $result ) {
										$entries_handled++;
										do_action( 'gwolle_gb_save_entry_admin', $entry );
									} else {
										$entries_not_handled++;
									}
								} else {
									$entries_not_handled++;
								}
							} else if ( $action == 'remove' ) {
								$result = $entry->delete();
								if ( $result ) {
									$entries_handled++;
									do_action( 'gwolle_gb_save_entry_admin', $entry );
								} else {
									$entries_not_handled++;
								}
							}
						} else { // no result on load()
							$entries_not_handled++;
						}
					} else { // entry_id is not set or not > 0
						$entries_not_handled++;
					}
				} // no entry with the check-'entry_id' input, continue
			} // foreach


			/* Construct Message */
			if ( $action == 'check' ) {
				$gwolle_gb_messages .= '<p>' . sprintf( _n('%s entry checked.','%s entries checked.', $entries_handled, 'gwolle-gb'), $entries_handled ). '</p>';
			} else if ( $action == 'uncheck' ) {
				$gwolle_gb_messages .= '<p>' . sprintf( _n('%s entry unchecked.','%s entries unchecked.', $entries_handled, 'gwolle-gb'), $entries_handled ). '</p>';
			} else if ( $action == 'spam' ) {
				$gwolle_gb_messages .= '<p>' . sprintf( _n('%s entry marked as spam and submitted to Akismet as spam (if Akismet was enabled).','%s entries marked as spam and submitted to Akismet as spam (if Akismet was enabled).', $entries_handled, 'gwolle-gb'), $entries_handled ). '</p>';
			} else if ( $action == 'no-spam' ) {
				$gwolle_gb_messages .= '<p>' . sprintf( _n('%s entry marked as not spam and submitted to Akismet as ham (if Akismet was enabled).','%s entries marked as not spam and submitted to Akismet as ham (if Akismet was enabled).', $entries_handled, 'gwolle-gb'), $entries_handled ). '</p>';
			} else if ( $action == 'akismet' ) {
				if ( $akismet_spam > 0 ) {
					$gwolle_gb_messages .= '<p>' . sprintf( _n('%s entry considered spam and marked as such.','%s entries considered spam and marked as such.', $akismet_spam, 'gwolle-gb'), $akismet_spam ). '</p>';
				}
				if ( $akismet_not_spam > 0 ) {
					$gwolle_gb_messages .= '<p>' . sprintf( _n('%s entry considered not spam and marked as such.','%s entries considered not spam and marked as such.', $akismet_not_spam, 'gwolle-gb'), $akismet_not_spam ). '</p>';
				}
				if ( $akismet_already_spam > 0 ) {
					$gwolle_gb_messages .= '<p>' . sprintf( _n('%s entry already considered spam and not changed.','%s entries already considered spam and not changed.', $akismet_already_spam, 'gwolle-gb'), $akismet_already_spam ). '</p>';
				}
				if ( $akismet_already_not_spam > 0 ) {
					$gwolle_gb_messages .= '<p>' . sprintf( _n('%s entry already considered not spam and not changed.','%s entries already considered not spam and not changed.', $akismet_already_not_spam, 'gwolle-gb'), $akismet_already_not_spam ). '</p>';
				}
			} else if ( $action == 'trash' ) {
				$gwolle_gb_messages .= '<p>' . sprintf( _n('%s entry moved to trash.','%s entries moved to trash.', $entries_handled, 'gwolle-gb'), $entries_handled ). '</p>';
			} else if ( $action == 'untrash' ) {
				$gwolle_gb_messages .= '<p>' . sprintf( _n('%s entry recovered from trash.','%s entries recovered from trash.', $entries_handled, 'gwolle-gb'), $entries_handled ). '</p>';
			} else if ( $action == 'remove' ) {
				$gwolle_gb_messages .= '<p>' . sprintf( _n('%s entry removed permanently.','%s entries removed permanently.', $entries_handled, 'gwolle-gb'), $entries_handled ). '</p>';
			}
		}

		if ( isset( $_POST['delete_all'] ) || isset( $_POST['delete_all2'] ) ) {
			if ( $continue_on_nonce_checked ) {
				// Delete all entries in spam or trash
				if ( isset($_POST['show']) && in_array($_POST['show'], array('spam', 'trash')) ) {
					$delstatus = $_POST['show'];
					$deleted = gwolle_gb_del_entries( $delstatus );
					$gwolle_gb_messages .= '<p>' . sprintf( _n('%s entry removed permanently.','%s entries removed permanently.', $deleted, 'gwolle-gb'), $deleted ). '</p>';
				}
			}
		}
	}


	// Get entry counts
	$count = Array();
	$count['checked'] = gwolle_gb_get_entry_count(array(
		'checked' => 'checked',
		'trash'   => 'notrash',
		'spam'    => 'nospam'
	));
	$count['unchecked'] = gwolle_gb_get_entry_count(array(
		'checked' => 'unchecked',
		'trash'   => 'notrash',
		'spam'    => 'nospam'
	));
	$count['spam']  = gwolle_gb_get_entry_count(array( 'spam' => 'spam'  ));
	$count['trash'] = gwolle_gb_get_entry_count(array( 'trash'=> 'trash' ));
	$count['all']   = gwolle_gb_get_entry_count(array( 'all'  => 'all'   ));


	$show = (isset($_REQUEST['show']) && in_array($_REQUEST['show'], array('checked', 'unchecked', 'spam', 'trash'))) ? $_REQUEST['show'] : 'all';

	$num_entries = get_option('gwolle_gb-entries_per_page', 20);

	// Check if the requested page number is an integer > 0
	$pageNum = (isset($_REQUEST['pageNum']) && $_REQUEST['pageNum'] && (int) $_REQUEST['pageNum'] > 0) ? (int) $_REQUEST['pageNum'] : 1;

	$pages_total = ceil( $count[$show] / $num_entries );
	if ($pageNum > $pages_total) {
		$pageNum = 1; // page doesnot exist, return to first page
	}

	// Calculate Query
	if ($pageNum == 1 && $count[$show] > 0) {
		$offset = 0;
	} elseif ($count[$show] == 0) {
		$offset = 0;
	} else {
		$offset = ($pageNum - 1) * $num_entries;
	}

	$book_id = 0;
	if ( isset( $_GET['book_id'] ) ) {
		$book_id = (int) $_GET['book_id'];
	}

	// Get the entries
	if ( $show == 'checked' ) {
		$entries = gwolle_gb_get_entries(array(
			'num_entries' => $num_entries,
			'offset'  => $offset,
			'checked' => 'checked',
			'trash'   => 'notrash',
			'spam'    => 'nospam',
			'book_id' => $book_id
		));
		$count_entries = gwolle_gb_get_entry_count(array(
			'checked' => 'checked',
			'trash'   => 'notrash',
			'spam'    => 'nospam',
			'book_id' => $book_id
		));
	} else if ( $show == 'unchecked' ) {
		$entries = gwolle_gb_get_entries(array(
			'num_entries' => $num_entries,
			'offset'  => $offset,
			'checked' => 'unchecked',
			'trash'   => 'notrash',
			'spam'    => 'nospam',
			'book_id' => $book_id
		));
		$count_entries = gwolle_gb_get_entry_count(array(
			'checked' => 'unchecked',
			'trash'   => 'notrash',
			'spam'    => 'nospam',
			'book_id' => $book_id
		));
	} else if ( $show == 'spam' ) {
		$entries = gwolle_gb_get_entries(array(
			'num_entries' => $num_entries,
			'offset'  => $offset,
			'spam'    => 'spam',
			'book_id' => $book_id
		));
		$count_entries = gwolle_gb_get_entry_count(array(
			'spam'    => 'spam',
			'book_id' => $book_id
		));
	} else if ( $show == 'trash' ) {
		$entries = gwolle_gb_get_entries(array(
			'num_entries' => $num_entries,
			'offset'  => $offset,
			'trash'   => 'trash',
			'book_id' => $book_id
		));
		$count_entries = gwolle_gb_get_entry_count(array(
			'trash'   => 'trash',
			'book_id' => $book_id
		));
	} else {
		$entries = gwolle_gb_get_entries(array(
			'num_entries' => $num_entries,
			'offset'  => $offset,
			'all'     => 'all',
			'book_id' => $book_id
		));
		$count_entries = gwolle_gb_get_entry_count(array(
			'all'     => 'all',
			'book_id' => $book_id
		));
	}
	$count_entrypages = ceil( $count_entries / $num_entries );
	?>

	<div class="wrap gwolle_gb">
		<div id="icon-gwolle-gb"><br /></div>
		<h1><?php _e('Guestbook entries', 'gwolle-gb'); ?></h1>

		<?php
		if ( $gwolle_gb_messages ) {
			echo '
				<div id="message" class="updated fade notice is-dismissible ' . $gwolle_gb_errors . ' ">' .
					$gwolle_gb_messages .
				'</div>';
		} ?>

		<form name="gwolle_gb_entries" id="gwolle_gb_entries" action="" method="POST" accept-charset="UTF-8">

			<input type="hidden" name="gwolle_gb_page" value="entries" />
			<!-- the following fields give us some information used for processing the mass edit -->
			<input type="hidden" name="pageNum" value="<?php echo $pageNum; ?>">
			<input type="hidden" name="entriesOnThisPage" value="<?php echo count($entries); ?>">
			<input type="hidden" name="show" value="<?php echo $show; ?>">

			<?php
			/* Nonce */
			$nonce = wp_create_nonce( 'gwolle_gb_page_entries' );
			echo '<input type="hidden" id="gwolle_gb_wpnonce" name="gwolle_gb_wpnonce" value="' . $nonce . '" />';
			?>

			<ul class="subsubsub">
				<li><a href='admin.php?page=<?php echo GWOLLE_GB_FOLDER; ?>/entries.php' <?php
					if ($show == 'all') { echo 'class="current"'; }
					?>>
					<?php _e('All', 'gwolle-gb'); ?> <span class="count">(<?php echo $count['all']; ?>)</span></a> |
				</li>
				<li><a href='admin.php?page=<?php echo GWOLLE_GB_FOLDER; ?>/entries.php&amp;show=checked' <?php
					if ($show == 'checked') { echo 'class="current"'; }
					?>>
					<?php _e('Unlocked', 'gwolle-gb'); ?> <span class="count">(<?php echo $count['checked']; ?>)</span></a> |
				</li>
				<li><a href='admin.php?page=<?php echo GWOLLE_GB_FOLDER; ?>/entries.php&amp;show=unchecked' <?php
					if ($show == 'unchecked') { echo 'class="current"'; }
					?>><?php _e('New', 'gwolle-gb'); ?> <span class="count">(<?php echo $count['unchecked']; ?>)</span></a> |
				</li>
				<li><a href='admin.php?page=<?php echo GWOLLE_GB_FOLDER; ?>/entries.php&amp;show=spam' <?php
					if ($show == 'spam') { echo 'class="current"'; }
					?>><?php _e('Spam', 'gwolle-gb'); ?> <span class="count">(<?php echo $count['spam']; ?>)</span></a> |
				</li>
				<li><a href='admin.php?page=<?php echo GWOLLE_GB_FOLDER; ?>/entries.php&amp;show=trash' <?php
					if ($show == 'trash') { echo 'class="current"'; }
					?>><?php _e('Trash', 'gwolle-gb'); ?> <span class="count">(<?php echo $count['trash']; ?>)</span></a>
				</li>
			</ul>

			<div class="tablenav">
				<div class="alignleft actions">
					<?php
					$massEditControls_select = '<select name="massEditAction1">';
					$massEditControls = '<option value="-1" selected="selected">' . __('Mass edit actions', 'gwolle-gb') . '</option>';
					if ($show == 'trash') {
						$massEditControls .= '
							<option value="untrash">' . __('Recover from trash', 'gwolle-gb') . '</option>
							<option value="remove">' . __('Remove permanently', 'gwolle-gb') . '</option>';
					} else {
						if ($show != 'checked') {
							$massEditControls .= '<option value="check">' . __('Mark as checked', 'gwolle-gb') . '</option>';
						}
						if ($show != 'unchecked') {
							$massEditControls .= '<option value="uncheck">' . __('Mark as not checked', 'gwolle-gb') . '</option>';
						}
						if ($show != 'spam') {
							$massEditControls .= '<option value="spam">' . __('Mark as spam', 'gwolle-gb') . '</option>';
						}
						$massEditControls .= '<option value="no-spam">' . __('Mark as not spam', 'gwolle-gb') . '</option>';
						if ( get_option('gwolle_gb-akismet-active', 'false') == 'true' ) {
							$massEditControls .= '<option value="akismet">' . __('Check with Akismet', 'gwolle-gb') . '</option>';
						}
						$massEditControls .= '<option value="trash">' . __('Move to trash', 'gwolle-gb') . '</option>';
						if ( $show == 'spam' ) {
							$massEditControls .= '<option value="remove">' . __('Remove permanently', 'gwolle-gb') . '</option>';
						}

					}
					$massEditControls .= '</select>';
					$massEditControls .= '<input type="submit" value="' . esc_attr__('Apply', 'gwolle-gb') . '" name="doaction" id="doaction" class="button-secondary action" />';
					$empty_button = '';
					if ( $show == 'spam' ) {
						$empty_button = '<input type="submit" name="delete_all" id="delete_all" class="button apply" value="' . esc_attr__('Empty Spam', 'gwolle-gb') . '"  />';
					} else if ( $show == 'trash' ) {
						$empty_button = '<input type="submit" name="delete_all" id="delete_all" class="button apply" value="' . esc_attr__('Empty Trash', 'gwolle-gb') . '"  />';
					}

					// Only show controls when there are entries
					if ( is_array($entries) && ! empty($entries) ) {
						echo $massEditControls_select . $massEditControls . $empty_button;
					} ?>
				</div>

				<?php
				$pagination = gwolle_gb_pagination_admin( $pageNum, $count_entrypages, $count_entries, $show );
				echo $pagination;
				?>
			</div>

			<div>
				<table class="widefat">
					<thead>
						<tr>
							<th scope="col" class="manage-column column-cb check-column"><input name="check-all-top" id="check-all-top" type="checkbox"></th>
							<th scope="col"><?php _e('Book', 'gwolle-gb'); if ($book_id > 0) { echo ' ' . $book_id; } ?></th>
							<th scope="col"><?php _e('ID', 'gwolle-gb'); ?></th>
							<?php
							if (get_option('gwolle_gb-showEntryIcons', 'true') === 'true') { ?>
								<th scope="col">&nbsp;</th><!-- this is the icon-column -->
							<?php
							} ?>
							<th scope="col"><?php _e('Date', 'gwolle-gb'); ?></th>
							<th scope="col"><?php _e('Author', 'gwolle-gb'); ?></th>
							<th scope="col"><?php _e('Entry (excerpt)', 'gwolle-gb'); ?></th>
							<th scope="col"><?php _e('Action', 'gwolle-gb'); ?></th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<th scope="col" class="manage-column column-cb check-column"><input name="check-all-bottom" id="check-all-bottom" type="checkbox"></th>
							<th scope="col"><?php _e('Book', 'gwolle-gb'); if ($book_id > 0) { echo ' ' . $book_id; } ?></th>
							<th scope="col"><?php _e('ID', 'gwolle-gb'); ?></th>
							<?php
							if (get_option('gwolle_gb-showEntryIcons', 'true') === 'true') { ?>
								<th scope="col">&nbsp;</th><!-- this is the icon-column -->
							<?php
							} ?>
							<th scope="col"><?php _e('Date', 'gwolle-gb'); ?></th>
							<th scope="col"><?php _e('Author', 'gwolle-gb'); ?></th>
							<th scope="col"><?php _e('Entry (excerpt)', 'gwolle-gb'); ?></th>
							<th scope="col"><?php _e('Action', 'gwolle-gb'); ?></th>
						</tr>
					</tfoot>


					<tbody>
						<?php
						$request_uri = $_SERVER['REQUEST_URI'];
						$rowOdd = true;
						$html_output = '';
						if ( !is_array($entries) || empty($entries) ) {
							$colspan = (get_option('gwolle_gb-showEntryIcons', 'true') === 'true') ? 8 : 7;
							$html_output .= '
								<tr>
									<td colspan="' . $colspan . '" align="center">
										<strong>' . __('No entries found.', 'gwolle-gb') . '</strong>
									</td>
								</tr>';
						} else {
							foreach ($entries as $entry) {

								// rows have a different color.
								if ($rowOdd) {
									$rowOdd = false;
									$class = ' alternate';
								} else {
									$rowOdd = true;
									$class = '';
								}

								// Attach 'spam' to class if the entry is spam
								if ( $entry->get_isspam() === 1 ) {
									$class .= ' spam';
								} else {
									$class .= ' nospam';
								}

								// Attach 'trash' to class if the entry is in trash
								if ( $entry->get_istrash() === 1 ) {
									$class .= ' trash';
								} else {
									$class .= ' notrash';
								}

								// Attach 'checked/unchecked' to class
								if ( $entry->get_ischecked() === 1 ) {
									$class .= ' checked';
								} else {
									$class .= ' unchecked';
								}

								// Attach 'visible/invisible' to class
								if ( $entry->get_isspam() === 1 || $entry->get_istrash() === 1 || $entry->get_ischecked() === 0 ) {
									$class .= ' invisible';
								} else {
									$class .= ' visible';
								}

								// Add admin-entry class to an entry from an admin
								$author_id = $entry->get_author_id();
								$is_moderator = gwolle_gb_is_moderator( $author_id );
								if ( $is_moderator ) {
									$class .= ' admin-entry';
								}

								// Checkbox and ID columns
								$html_output .= '
									<tr id="entry_' . $entry->get_id() . '" class="entry ' . $class . '">
										<td class="check">
											<input name="check-' . $entry->get_id() . '" id="check-' . $entry->get_id() . '" type="checkbox">
										</td>
										<td class="book">
											<span class="book-icon" title="' . __('Book ID', 'gwolle-gb') . ' ' . $entry->get_book_id()  . '">
												<a href="' . add_query_arg( 'book_id', $entry->get_book_id(), $request_uri ) . '"
													title="' . __('Book ID', 'gwolle-gb') . ' ' . $entry->get_book_id()  . '">
													' . $entry->get_book_id()  . '
												</a>
											</span>
										</td>
										<td class="id">' . $entry->get_id() . '</td>';

								// Optional Icon column where CSS is being used to show them or not
								if ( get_option('gwolle_gb-showEntryIcons', 'true') === 'true' ) {
									$html_output .= '
										<td class="entry-icons">
											<span class="visible-icon" title="' . __('Visible', 'gwolle-gb') . '"></span>
											<span class="invisible-icon" title="' . __('Invisible', 'gwolle-gb') . '"></span>
											<span class="spam-icon" title="' . __('Spam', 'gwolle-gb') . '"></span>
											<span class="trash-icon" title="' . __('Trash', 'gwolle-gb') . '""></span>';
									$admin_reply = gwolle_gb_sanitize_output( $entry->get_admin_reply() );
									if ( strlen( trim($admin_reply) ) > 0 ) {
										$html_output .= '
											<span class="admin_reply-icon" title="' . __('Admin Replied', 'gwolle-gb') . '"></span>';
									}
									$html_output .= '
											<span class="gwolle_gb_ajax" title="' . __('Wait...', 'gwolle-gb') . '"></span>
										</td>';
								}

								// Date column
								$html_output .= '
									<td class="entry-date">' . date_i18n( get_option('date_format'), $entry->get_datetime() ) . ', ' .
										date_i18n( get_option('time_format'), $entry->get_datetime() ) .
									'</td>';

								// Author column
								$author_name_html = gwolle_gb_get_author_name_html($entry);
								$html_output .= '
									<td class="entry-author-name"><span class="author-name">' . $author_name_html . '</span><br />' .
										'<span class="author-email">' . $entry->get_author_email() . '</span>' .
									'</td>';

								// Excerpt column
								$html_output .= '
									<td class="entry-content">
										<label for="check-' . $entry->get_id() . '">';
								$entry_content = gwolle_gb_get_excerpt( $entry->get_content(), 17 );
								if ( get_option('gwolle_gb-showSmilies', 'true') === 'true' ) {
									$entry_content = convert_smilies($entry_content);
								}
								$html_output .= $entry_content . '</label>
									</td>';

								// Actions column
								$html_output .= '
									<td class="gwolle_gb_actions">
										<span class="gwolle_gb_edit">
											<a href="admin.php?page=' . GWOLLE_GB_FOLDER . '/editor.php&entry_id=' . $entry->get_id() . '" title="' . __('Edit entry', 'gwolle-gb') . '">' . __('Edit', 'gwolle-gb') . '</a>
										</span>
										<span class="gwolle_gb_check">&nbsp;|&nbsp;
											<a id="check_' . $entry->get_id() . '" href="#" class="vim-a" title="' . __('Check entry', 'gwolle-gb') . '">' . __('Check', 'gwolle-gb') . '</a>
										</span>
										<span class="gwolle_gb_uncheck">&nbsp;|&nbsp;
											<a id="uncheck_' . $entry->get_id() . '" href="#" class="vim-u" title="' . __('Uncheck entry', 'gwolle-gb') . '">' . __('Uncheck', 'gwolle-gb') . '</a>
										</span>
										<span class="gwolle_gb_spam">&nbsp;|&nbsp;
											<a id="spam_' . $entry->get_id() . '" href="#" class="vim-s vim-destructive" title="' . __('Mark entry as spam.', 'gwolle-gb') . '">' . __('Spam', 'gwolle-gb') . '</a>
										</span>
										<span class="gwolle_gb_unspam">&nbsp;|&nbsp;
											<a id="unspam_' . $entry->get_id() . '" href="#" class="vim-a" title="' . __('Mark entry as not-spam.', 'gwolle-gb') . '">' . __('Not spam', 'gwolle-gb') . '</a>
										</span>
										<span class="gwolle_gb_trash">&nbsp;|&nbsp;
											<a id="trash_' . $entry->get_id() . '" href="#" class="vim-d vim-destructive" title="' . __('Move entry to trash.', 'gwolle-gb') . '">' . __('Trash', 'gwolle-gb') . '</a>
										</span>
										<span class="gwolle_gb_untrash">&nbsp;|&nbsp;
											<a id="untrash_' . $entry->get_id() . '" href="#" class="vim-d" title="' . __('Recover entry from trash.', 'gwolle-gb') . '">' . __('Untrash', 'gwolle-gb') . '</a>
										</span>
										<span class="gwolle_gb_ajax">&nbsp;|&nbsp;
											<a id="ajax_' . $entry->get_id() . '" href="#" class="ajax vim-d vim-destructive" title="' . __('Please wait...', 'gwolle-gb') . '">' . __('Wait...', 'gwolle-gb') . '</a>
										</span>
									</td>
								</tr>';
							}
						}
						echo $html_output;
						?>
					</tbody>
				</table>
			</div>

			<div class="tablenav">
				<div class="alignleft actions">
					<?php
					$massEditControls_select = '<select name="massEditAction2">';
					$empty_button = '';
					if ( $show == 'spam' ) {
						$empty_button = '<input type="submit" name="delete_all2" id="delete_all2" class="button apply" value="' . esc_attr__('Empty Spam', 'gwolle-gb') . '"  />';
					} else if ( $show == 'trash' ) {
						$empty_button = '<input type="submit" name="delete_all2" id="delete_all2" class="button apply" value="' . esc_attr__('Empty Trash', 'gwolle-gb') . '"  />';
					}

					// Only show controls when there are entries
					if ( is_array($entries) && !empty($entries) ) {
						echo $massEditControls_select . $massEditControls . $empty_button;
					} ?>
				</div>
				<?php echo $pagination; ?>
			</div>

		</form>

	</div>
	<?php
}
