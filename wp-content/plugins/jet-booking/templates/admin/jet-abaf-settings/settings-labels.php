<div>
	<cx-vui-switcher
		label="<?php esc_html_e( 'Use custom labels', 'jet-booking' ); ?>"
		description="<?php esc_html_e( 'Rewrite check-in/check-out calendar field labels', 'jet-booking' ); ?>"
		:wrapper-css="[ 'equalwidth' ]"
		:value="advancedSettings.use_custom_labels"
		@input="updateSetting( $event, 'use_custom_labels' )"
	></cx-vui-switcher>
	<cx-vui-input
		label="<?php esc_html_e( 'Excluded dates', 'jet-booking' ); ?>"
		description="<?php esc_html_e( 'Tooltip text for already booked dates. Default: Sold out', 'jet-booking' ); ?>"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="advancedSettings.labels_booked"
		@on-input-change="updateSetting( $event.target.value, 'labels_booked' )"
	></cx-vui-input>
	<cx-vui-input
		label="<?php esc_html_e( 'Before selected dates', 'jet-booking' ); ?>"
		description="<?php esc_html_e( 'Text before selected dates range. Default: Choosed', 'jet-booking' ); ?>"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="advancedSettings.labels_selected"
		@on-input-change="updateSetting( $event.target.value, 'labels_selected' )"
	></cx-vui-input>
	<cx-vui-input
		label="<?php esc_html_e( '`Nights` text', 'jet-booking' ); ?>"
		description="<?php esc_html_e( 'Text after nights number. Default: Nights', 'jet-booking' ); ?>"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="advancedSettings.labels_nights"
		@on-input-change="updateSetting( $event.target.value, 'labels_nights' )"
	></cx-vui-input>
	<cx-vui-input
		label="<?php esc_html_e( '`Days` text', 'jet-booking' ); ?>"
		description="<?php esc_html_e( 'Text after days number. Default: Days', 'jet-booking' ); ?>"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="advancedSettings.labels_days"
		@on-input-change="updateSetting( $event.target.value, 'labels_days' )"
	></cx-vui-input>
	<cx-vui-input
		label="<?php esc_html_e( 'Monday', 'jet-booking' ); ?>"
		description="<?php esc_html_e( 'Label/translation of Monday', 'jet-booking' ); ?>"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="advancedSettings.labels_week_1"
		@on-input-change="updateSetting( $event.target.value, 'labels_week_1' )"
	></cx-vui-input>
	<cx-vui-input
		label="<?php esc_html_e( 'Tuesday', 'jet-booking' ); ?>"
		description="<?php esc_html_e( 'Label/translation of Tuesday', 'jet-booking' ); ?>"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="advancedSettings.labels_week_2"
		@on-input-change="updateSetting( $event.target.value, 'labels_week_2' )"
	></cx-vui-input>
	<cx-vui-input
		label="<?php esc_html_e( 'Wednesday', 'jet-booking' ); ?>"
		description="<?php esc_html_e( 'Label/translation of Wednesday', 'jet-booking' ); ?>"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="advancedSettings.labels_week_3"
		@on-input-change="updateSetting( $event.target.value, 'labels_week_3' )"
	></cx-vui-input>
	<cx-vui-input
		label="<?php esc_html_e( 'Thursday', 'jet-booking' ); ?>"
		description="<?php esc_html_e( 'Label/translation of Thursday', 'jet-booking' ); ?>"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="advancedSettings.labels_week_4"
		@on-input-change="updateSetting( $event.target.value, 'labels_week_4' )"
	></cx-vui-input>
	<cx-vui-input
		label="<?php esc_html_e( 'Friday', 'jet-booking' ); ?>"
		description="<?php esc_html_e( 'Label/translation of Friday', 'jet-booking' ); ?>"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="advancedSettings.labels_week_5"
		@on-input-change="updateSetting( $event.target.value, 'labels_week_5' )"
	></cx-vui-input>
	<cx-vui-input
		label="<?php esc_html_e( 'Saturday', 'jet-booking' ); ?>"
		description="<?php esc_html_e( 'Label/translation of Saturday', 'jet-booking' ); ?>"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="advancedSettings.labels_week_6"
		@on-input-change="updateSetting( $event.target.value, 'labels_week_6' )"
	></cx-vui-input>
	<cx-vui-input
		label="<?php esc_html_e( 'Sunday', 'jet-booking' ); ?>"
		description="<?php esc_html_e( 'Label/translation of Sunday', 'jet-booking' ); ?>"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="advancedSettings.labels_week_7"
		@on-input-change="updateSetting( $event.target.value, 'labels_week_7' )"
	></cx-vui-input>
	<cx-vui-textarea
		label="<?php esc_html_e( 'Month names', 'jet-booking' ); ?>"
		description="<?php esc_html_e( 'Comma-separated list of month names. E.g. January, February, March, ...', 'jet-booking' ); ?>"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="advancedSettings.labels_month_name"
		@on-input-change="updateSetting( $event.target.value, 'labels_month_name' )"
	></cx-vui-textarea>
	<cx-vui-input
		label="<?php esc_html_e( 'Past text', 'jet-booking' ); ?>"
		description="<?php esc_html_e( 'Label for past dates. Default: Past', 'jet-booking' ); ?>"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="advancedSettings.labels_past"
		@on-input-change="updateSetting( $event.target.value, 'labels_past' )"
	></cx-vui-input>
	<cx-vui-input
		label="<?php esc_html_e( 'Previous text', 'jet-booking' ); ?>"
		description="<?php esc_html_e( 'Label for previous dates. Default: Past', 'jet-booking' ); ?>"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="advancedSettings.labels_previous"
		@on-input-change="updateSetting( $event.target.value, 'labels_previous' )"
	></cx-vui-input>
	<cx-vui-input
		label="<?php esc_html_e( 'Previous week', 'jet-booking' ); ?>"
		description="<?php esc_html_e( 'Previous week text', 'jet-booking' ); ?>"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="advancedSettings.labels_prev_week"
		@on-input-change="updateSetting( $event.target.value, 'labels_prev_week' )"
	></cx-vui-input>
	<cx-vui-input
		label="<?php esc_html_e( 'Previous month', 'jet-booking' ); ?>"
		description="<?php esc_html_e( 'Previous month text', 'jet-booking' ); ?>"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="advancedSettings.labels_prev_month"
		@on-input-change="updateSetting( $event.target.value, 'labels_prev_month' )"
	></cx-vui-input>
</div>