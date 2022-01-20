<div
	:class="{ 'jet-abaf-loading': isLoading }"
>
	<cx-vui-list-table
		:is-empty="! itemsList.length"
		empty-message="<?php esc_html_e( 'No bookings found', 'jet-booking' ); ?>"
	>
		<cx-vui-list-table-heading
			:slots="[ 'booking_id', 'apartment_id', 'apartment_unit', 'check_in_date', 'check_out_date', 'order_id', 'status' ]"
			slot="heading"
		>
			<span slot="booking_id"><?php esc_html_e( 'ID', 'jet-booking' ); ?></span>
			<span slot="apartment_id"><?php esc_html_e( 'Booked Instance', 'jet-booking' ); ?></span>
			<span slot="apartment_unit"><?php esc_html_e( 'Booked Unit ID', 'jet-booking' ); ?></span>
			<span slot="check_in_date"><?php esc_html_e( 'Check In', 'jet-booking' ); ?></span>
			<span slot="check_out_date"><?php esc_html_e( 'Check Out', 'jet-booking' ); ?></span>
			<span slot="order_id"><?php esc_html_e( 'Related Order', 'jet-booking' ); ?></span>
			<span slot="status"><?php esc_html_e( 'Status', 'jet-booking' ); ?></span>
		</cx-vui-list-table-heading>
		<cx-vui-list-table-item
			:slots="[ 'booking_id', 'apartment_id', 'apartment_unit', 'check_in_date', 'check_out_date', 'order_id', 'status' ]"
			slot="items"
			v-for="( item, index ) in itemsList"
			:key="item.booking_id + item.apartment_id"
		>
			<span slot="booking_id">{{ item.booking_id }}</span>
			<span slot="apartment_id">{{ getBookingLabel( item.apartment_id ) }}</span>
			<span slot="apartment_unit">{{ item.apartment_unit }}</span>
			<span slot="check_in_date">{{ item.check_in_date }}</span>
			<span slot="check_out_date">{{ item.check_out_date }}</span>
			<span slot="order_id">
				<a v-if="item.order_id" :href="getOrderLink( item.order_id )" target="_blank">#{{ item.order_id }}</a>
			</span>
			<span
				slot="status"
				:class="{
					'notice': true,
					'notice-alt': true,
					'notice-success': isFinished( item.status ),
					'notice-warning': isInProgress( item.status ),
					'notice-error': isInvalid( item.status ),
				}"
			>{{ item.status }}</span>
			<div
				class="jet-abaf-actions"
				slot="status"
			>
				<cx-vui-button
					button-style="accent"
					size="mini"
					@click="showEditDialog( item, index )"
				><span slot="label"><?php esc_html_e( 'Edit', 'jet-appoinments-booking' ); ?></span></cx-vui-button>
				<cx-vui-button
					button-style="link-accent"
					size="link"
					@click="showDetailsDialog( item )"
				><span slot="label"><?php esc_html_e( 'Details', 'jet-appoinments-booking' ); ?></span></cx-vui-button>
				<cx-vui-button
					button-style="link-error"
					size="link"
					@click="showDeleteDialog( item.booking_id )"
				><span slot="label"><?php esc_html_e( 'Delete', 'jet-appoinments-booking' ); ?></span></cx-vui-button>
			</div>
		</cx-vui-list-table-item>
	</cx-vui-list-table>
	<cx-vui-pagination
		v-if="perPage < totalItems"
		:total="totalItems"
		:page-size="perPage"
		@on-change="changePage"
	></cx-vui-pagination>
	<cx-vui-popup
		v-model="deleteDialog"
		body-width="460px"
		ok-label="<?php esc_html_e( 'Delete', 'jet-booking' ) ?>"
		cancel-label="<?php esc_html_e( 'Cancel', 'jet-booking' ) ?>"
		@on-cancel="deleteDialog = false"
		@on-ok="handleDelete"
	>
		<div class="cx-vui-subtitle" slot="title"><?php
			esc_html_e( 'Are you sure? Deleted booking can\'t be restored.', 'jet-booking' );
		?></div>
	</cx-vui-popup>
	<cx-vui-popup
		v-model="detailsDialog"
		body-width="400px"
		:show-cancel="false"
		ok-label="<?php esc_html_e( 'Close', 'jet-booking' ) ?>"
		@on-ok="detailsDialog = false"
	>
		<div class="cx-vui-subtitle" slot="title"><?php
			esc_html_e( 'Booking Details:', 'jet-booking' );
		?></div>
		<div class="jet-abaf-details" slot="content">
			<br>
			<p v-for="( itemValue, itemKey ) in currentItem" :key="itemKey">
				<b>{{ itemKey }}:</b>
				<a
					v-if="'order_id' === itemKey && itemValue"
					:href="getOrderLink( itemValue )"
					target="_blank"
				>
					#{{ itemValue }}
				</a>
				<span
					v-else-if="'status' === itemKey && itemValue"
					:class="{
						'notice': true,
						'notice-alt': true,
						'notice-success': isFinished( itemValue ),
						'notice-warning': isInProgress( itemValue ),
						'notice-error': isInvalid( itemValue ),
					}"
				>{{ itemValue }}</span>
				<span v-else-if="'apartment_id' === itemKey && itemValue">{{ getBookingLabel( itemValue ) }}</span>
				<span v-else>{{ itemValue }}</span>
			</p>
		</div>
	</cx-vui-popup>
	<cx-vui-popup
		v-model="editDialog"
		body-width="400px"
		ok-label="<?php esc_html_e( 'Save', 'jet-booking' ) ?>"
		@on-cancel="editDialog = false"
		@on-ok="handleEdit"
	>
		<div class="cx-vui-subtitle" slot="title"><?php
			esc_html_e( 'Edit Booking:', 'jet-booking' );
		?></div>
		<div
			class="jet-abaf-bookings-error"
			slot="content"
			v-if="overlappingBookings"
			v-html="overlappingBookings"
		></div>
		<div class="jet-abaf-details" slot="content">
			<br>
			<p v-for="( itemValue, itemKey ) in currentItem" :key="itemKey">
				<b>{{ itemKey }}:</b>
				<a
					v-if="'order_id' === itemKey && itemValue"
					:href="getOrderLink( itemValue )"
					target="_blank"
				>
					#{{ itemValue }}
				</a>
				<select
					v-else-if="'status' === itemKey && itemValue"
					v-model="currentItem.status"
				>
					<option
						v-for="( statusLabel, statusId ) in statuses"
						:value="statusId"
					>{{ statusLabel }}</option>
				</select>
				<select
					v-else-if="'apartment_id' === itemKey && itemValue"
					v-model="currentItem.apartment_id"
				>
					<option
						v-for="( instanceLabel, instanceId ) in bookingInstances"
						:value="instanceId"
					>{{ instanceLabel }}</option>
				</select>
				<span v-else-if="'booking_id' === itemKey">{{ itemValue }}</span>
				<input type="text" v-else v-model="currentItem[ itemKey ]">
			</p>
		</div>
	</cx-vui-popup>
</div>