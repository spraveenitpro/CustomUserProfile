<?php

/*
Plugin Name: Custom User Fields
Plugin URL: http://Google.com
Description: Allows to add custom fields to User Profile for Registration
Version:1.0
Author:Praveen
Author URI: http://google.com
*/


		$extra_fields = array (
						array('facebook',__('Facebook Username', 'rc_cucm'), true),
						array('twitter',__('Twitter Username', 'rc_cucm'), true),
						array('phone',__('Phone Number', 'rc_cucm'), true) 
						);

		//Using user_contactmethods to add new fields
		add_filter('user_contactmethods','rc_add_user_contact_methods' );

		//Add New fields to registration process
		add_action('register_form', 'rc_register_form_display_extra_fields');
		add_action('user_register', 'rc_user_register_save_extra_fields', 100);



		/**
		* Add Custom Users Custom Contact Methods
		*@access public
		*@since 1.0
		*@return void
		*/


		function rc_add_user_contact_methods( $user_contactmethods ) {

			//Get the Fields
			global $extra_fields;
			//Display each Field
			foreach ($extra_fields as $field) {
				
				if (!isset ($contactmethods[$field[0]]))
					$user_contactmethods[$field[0]] = $field[1];
			}
			//Return Contact Methods
			return $user_contactmethods;
		}



		/**
		* Show custom Fields on registration page
		* Show custom Fields on registration page if the third parameter is set to true
		* @access public
		* @since  1.0
		* @return void
		*/

		function rc_register_form_display_extra_fields() {

			//Get fields
			global $extra_fields;

			//Display the Fields if the 3rd parameter is set to true
			foreach ( $extra_fields as $field ){
				 if($field[2] == true) {

				 	if ( isset($_POST[ $field[0] ] ) ) { $field_value = $_POST[ $field[0] ]; } else { $field_value = ''; }

				 	?>
				 	<p>
				 		<label for="<?php echo $field[0];  ?>"><?php echo $field[1];   ?><br>
				 			<input type="text" name="<?php echo $field[0]; ?>" id="<?php echo $field[0];  ?>" class="input" value="<?php echo $field_value; ?>" size="20"></label>
				 		</label>
				 	</p>
				 	<?php 

				 } // End endif
			} // End Foreach
		} // End Function


		/**
		*Save Field Values
		* @access public
		* @since  1.0
		* @return void
		*/

		function rc_user_register_save_extra_fields($user_id,$password='',$meta= array() ) {

		//Get Fields
			global $extra_fields;
			$userdata 		= array();
			$userdata['ID'] = $user_id;

		//Save each field
			foreach($extra_fields as $field) {

				if ($field[2] == true) {

					$userdata[$field[0] ] = $_POST[ $field[0] ];
				} //Endif

			} // End Foreach

		$new_user_id = wp_update_user($userdata);

		}
















?>