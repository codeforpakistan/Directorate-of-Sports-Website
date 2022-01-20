<div>
	<h3 class="cx-vui-subtitle"><?php esc_html_e( 'Booking Settings', 'jet-booking' ); ?></h3>
	<br>
	<div class="cx-vui-panel">
		<cx-vui-tabs
			:in-panel="false"
			:value="initialTab"
			layout="vertical"
		>
			<cx-vui-tabs-panel
				name="general"
				label="<?php esc_html_e( 'General', 'jet-booking' ); ?>"
				key="general"
			>
				<keep-alive>
					<jet-abaf-settings-general
						:settings="settings"
						@force-update="onUpdateSettings( $event, true )"
					></jet-abaf-settings-general>
				</keep-alive>
			</cx-vui-tabs-panel>
			<cx-vui-tabs-panel
				name="labels"
				label="<?php esc_html_e( 'Labels', 'jet-booking' ); ?>"
				key="labels"
			>
				<keep-alive>
					<jet-abaf-settings-labels
						:settings="settings"
						@force-update="onUpdateSettings( $event, true )"
					></jet-abaf-settings-labels>
				</keep-alive>
			</cx-vui-tabs-panel>
			<cx-vui-tabs-panel
				name="advanced"
				label="<?php esc_html_e( 'Advanced', 'jet-booking' ); ?>"
				key="advanced"
			>
				<keep-alive>
					<jet-abaf-settings-advanced
						:settings="settings"
						@force-update="onUpdateSettings( $event, true )"
					></jet-abaf-settings-advanced>
				</keep-alive>
			</cx-vui-tabs-panel>
			<cx-vui-tabs-panel
				name="db_tables"
				label="<?php esc_html_e( 'DB Tables', 'jet-booking' ); ?>"
				key="db_tables"
			>
				<p v-if="! dbTablesExists"><?php
					esc_html_e( 'Before start you need to create required DB tables', 'jet-booking' );
				?></p>
				<cx-vui-button
					:button-style="'accent'"
					:loading="processingTables"
					@click="processTables"
				>
					<span slot="label" v-if="dbTablesExists"><?php esc_html_e( 'Update Tables', 'jet-booking' ); ?></span>
					<span slot="label" v-else><?php esc_html_e( 'Create Tables', 'jet-booking' ); ?></span>
				</cx-vui-button>
			</cx-vui-tabs-panel>
		</cx-vui-tabs>
	</div>
</div>