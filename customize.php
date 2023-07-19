<?php
/**
 * Plugin Name: SSA Customization - Create new Twig from The Events Calendar
 * Plugin URI:  https://simplyscheduleappointments.com
 * Description: Create a new Twig from The Events Calendar meta fields.
 * Version:     1.0.0
 * Author:      Simply Schedule Appointments
 * Author URI:  https://simplyscheduleappointments.com
 * Donate link: https://simplyscheduleappointments.com
 * License:     GPLv2
 * Text Domain: simply-schedule-appointments
 * Domain Path: /languages
 *
 * @link    https://simplyscheduleappointments.com
 *
 * @package Simply_Schedule_Appointments
 * @version 1.0.0
 *
 */

/**
 * Copyright (c) 2023 Simply Schedule Appointments (email : support@ssaplugin.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


add_filter('ssa/templates/get_template_vars', 'add_custom_tec_var', 10, 2);

function add_custom_tec_var($vars, $template)
{
	if ( empty( $vars['appointment_id'] ) ) {
			return $vars;
		}

	if ( empty( $vars['Appointment'] ) ) {
			$vars['Appointment'] = array();
		}
	
	$appointment_obj = new SSA_Appointment_Object( (int)$vars['appointment_id'] );
	$vars['Appointment'] = array_merge( $vars['Appointment'], $appointment_obj->get_data( 1 ) );

	$meta = $this->plugin->appointment_model->get_metas( (int)$vars['appointment_id'], array( 'booking_url', 'booking_post_id', 'booking_title', 'cancelation_note', 'canceled_by_user_id', 'rescheduling_note', 'rescheduled_by_user_id' ) );

	
    $vars['tec_partner_email'] = tribe_get_organizer_email($meta['booking_post_id']);
    return $vars;
}
