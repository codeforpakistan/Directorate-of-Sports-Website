<div
	:class="{ 'jet-abaf-loading': isLoading }"
>
	<cx-vui-list-table
		:is-empty="! itemsList.length"
		empty-message="<?php esc_html_e( 'No calendars found', 'jet-booking' ); ?>"
	>
		<cx-vui-list-table-heading
			:slots="[ 'post_title', 'unit_title', 'export_url', 'import_url' ]"
			slot="heading"
		>
			<span slot="post_title"><?php esc_html_e( 'Post Title', 'jet-booking' ); ?></span>
			<span slot="unit_title"><?php esc_html_e( 'Unit Title', 'jet-booking' ); ?></span>
			<span slot="export_url"><?php esc_html_e( 'Export URL', 'jet-booking' ); ?></span>
			<span slot="import_url"><?php esc_html_e( 'External Calendars', 'jet-booking' ); ?></span>
		</cx-vui-list-table-heading>
		<cx-vui-list-table-item
			:slots="[ 'post_title', 'unit_title', 'export_url', 'import_url' ]"
			slot="items"
			v-for="( item, index ) in itemsList"
			:key="item.post_id + item.unit_id"
		>
			<span slot="post_title">{{ item.title }}</span>
			<span slot="unit_title">{{ item.unit_title }}</span>
			<code slot="export_url">{{ item.export_url }}</code>
			<div slot="import_url">
				<ul v-if="item.import_url">
					<li v-for="url in item.import_url" :key="url"><a :href="url">{{ url }}</a></li>
				</ul>
				<div v-else>--</div>
			</div>
			<div
				class="jet-abaf-actions"
				slot="import_url"
			>
				<cx-vui-button
					button-style="accent-border"
					size="mini"
					v-if="item.import_url && item.import_url.length"
					@click="showSynchDialog( item )"
				>
					<span slot="label"><?php
						esc_html_e( 'Synch', 'jet-appoinments-booking' );
					?></span>
				</cx-vui-button>
				<cx-vui-button
					button-style="accent"
					size="mini"
					@click="showEditDialog( item, index )"
				>
					<span slot="label"><?php
						esc_html_e( 'Edit Calendars', 'jet-appoinments-booking' );
					?></span>
				</cx-vui-button>
			</div>
		</cx-vui-list-table-item>
	</cx-vui-list-table>
	<cx-vui-popup
		v-model="editDialog"
		body-width="400px"
		ok-label="<?php esc_html_e( 'Save', 'jet-booking' ) ?>"
		@on-cancel="editDialog = false"
		@on-ok="handleEdit"
	>
		<div class="cx-vui-subtitle" slot="title"><?php
			esc_html_e( 'Edit Calendars:', 'jet-booking' );
		?></div>
		<div class="jet-abaf-calendars" slot="content">
			<br>
			<p v-for="( url, index ) in currentItem.import_url">
				<input
					type="url"
					placeholder="https://calendar-link.com"
					v-model="currentItem.import_url[ index ]"
					:style="{width: '100%'}"
				>
			</p>
			<a href="#" @click.prevent="addURL" :style="{ textDecoration: 'none' }"><b>
				+ <?php esc_html_e( 'New URL', 'jet-booking' ); ?>
			</b></a>
		</div>
	</cx-vui-popup>
	<cx-vui-popup
		v-model="synchDialog"
		body-width="600px"
		cancel-label="<?php esc_html_e( 'Close', 'jet-booking' ) ?>"
		@on-cancel="synchDialog = false"
		:show-ok="false"
	>
		<div class="cx-vui-subtitle" slot="title"><?php
			esc_html_e( 'Synchronizing Calendars:', 'jet-booking' );
		?></div>
		<div class="jet-abaf-calendars" slot="content">
			<div v-if="!synchLog"><?php esc_html_e( 'Processing...', 'jet-booking' ); ?></div>
			<div v-else v-html="synchLog" class="jet-abaf-synch-log"></div>
		</div>
	</cx-vui-popup>
</div>