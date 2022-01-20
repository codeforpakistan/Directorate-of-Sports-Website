<div
	:class="{ 'jet-abaf-popup': true, 'jet-abaf-popup--active': isActive }"
>
	<div class="jet-abaf-popup__overlay" @click="isActive = ! isActive"></div>
	<div class="jet-abaf-popup__body">
		<div class="jet-abaf-popup__header">
			<h3><?php esc_html_e( 'Set up advanced pricing rates', 'jet-booking' ); ?></h3>
		</div>
		<div class="jet-abaf-popup__content">
			<div class="jet-abaf-rates-list">
				<div class="jet-abaf-rates-list__item default">
					<div class="jet-abaf-rates-list__col col-title">
						<?php esc_html_e( 'From', 'jet-booking' ); ?>&nbsp;&nbsp;
						<input type="number" value="1" disabled>&nbsp;&nbsp;
						<?php esc_html_e( 'days/nights', 'jet-booking' ); ?>
					</div>
					<div class="jet-abaf-rates-list__col col-price">
						<?php esc_html_e( 'Price:', 'jet-booking' ); ?>&nbsp;&nbsp;
						<input type="number" min="0" :value="defaultPrice" disabled>&nbsp;&nbsp;
						<?php esc_html_e( 'per day/night', 'jet-booking' ); ?>
					</div>
					<div class="jet-abaf-rates-list__col col-delete">&nbsp;</div>
				</div>
				<div class="jet-abaf-rates-list__item" v-for="( rate, index ) in rates" :key="'rate-' + index">
					<div class="jet-abaf-rates-list__col col-title">
						<?php esc_html_e( 'From', 'jet-booking' ); ?>&nbsp;&nbsp;
						<input type="number" min="2" step="1" v-model="rates[ index ].duration">&nbsp;&nbsp;
						<?php esc_html_e( 'days/nights', 'jet-booking' ); ?>
					</div>
					<div class="jet-abaf-rates-list__col col-price">
						<?php esc_html_e( 'Price:', 'jet-booking' ); ?>&nbsp;&nbsp;
						<input type="number" min="0" step="1" v-model="rates[ index ].value">&nbsp;&nbsp;
						<?php esc_html_e( 'per day/night', 'jet-booking' ); ?>
					</div>
					<div class="jet-abaf-rates-list__col col-delete"><span @click="deleteRate( index )" class="dashicons dashicons-trash"></span></div>
				</div>
			</div>
			<a href="#" class="jet-abaf-add-rate" @click.prevent="newRate">+&nbsp;<?php esc_html_e( 'Add new rate', 'jet-booking' ); ?></a>
		</div>
		<div class="jet-abaf-popup-actions">
			<button class="button button-primary" type="button" aria-expanded="true" @click="saveRates">
				<span v-if="!saving"><?php esc_html_e( 'Save', 'jet-booking' ); ?></span>
				<span v-else><?php esc_html_e( 'Saving...', 'jet-booking' ); ?></span>
			</button>
			<button class="button-link" type="button" aria-expanded="true" @click="isActive = false"><?php esc_html_e( 'Cancel', 'jet-booking' ); ?></button>
		</div>
	</div>
</div>