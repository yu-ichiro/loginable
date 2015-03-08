<?php
/*
Plugin Name: Loginable
Description: Determines if the user is Loginable using cookie with php
Version: 0.2
Author: yu-ichiro
License: GPL2

  Copyright 2014 yu-ichiro

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Add Settings Menu */
add_action( 'admin_menu', 'loginable_menu' );

function loginable_menu() {
	add_options_page( 'Loginable', 'Loginable', 'manage_options', 'loginable-options', 'loginable_options' );
	add_action('admin_init', 'loginable_settings');
}

function loginable_settings() {
	register_setting( 'loginable_settings', 'loginable_cookie' );
}


function loginable_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
?>
<div class="wrap">
<h2>Loginable</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'loginable_settings' ); ?>
    <?php do_settings_sections( 'loginable-options' ); ?>
    <label for="loginable_cookie">Cookie Name (Should be hidden and unique) :</label>
    <input type="text" id="loginable_cookie" name="loginable_cookie" value="<?php echo esc_attr( get_option('loginable_cookie'))?esc_attr( get_option('loginable_cookie')):"user"; ?>">
    <?php submit_button(); ?>
</form>
</div>
<?php 
}



/* Add a hook that creates a authorized cookie */
add_action('admin_init', 'loginable_auth_cookie');



function loginable_auth_cookie() {
	setcookie(esc_attr( get_option('loginable_cookie'))? esc_attr( get_option('loginable_cookie')) : 'user' , 1, time()+60*60*24*365,"/");
}

function loginable() {
	return isset($_COOKIE[esc_attr( get_option('loginable_cookie'))?esc_attr( get_option('loginable_cookie')):'user']);
}
?>
