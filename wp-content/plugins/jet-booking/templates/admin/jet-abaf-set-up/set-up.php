<div class="wrap jet-abaf-setup">
	<div v-if="!isSet || isReset">
		<div v-if="1 === currentStep">
			<h3 class="cx-vui-subtitle"><?php
				esc_html_e( 'Step 1 of 4. Set up booking instance CPT', 'jet-booking' )
			?></h3>
			<div class="cx-vui-panel">
				<div class="cx-vui-component"><p class="jet-abaf-setup-descr"><?php
					printf( __( 'To start you need to create post type for booking instances. If you already created required post types, please select it in the list below. For example this can be `Apartments` post type for apartments bookings. If no - please go <a href="%1$s">Post Types</a> page and create it.', 'jet-booking' ), add_query_arg( array( 'page' => 'jet-engine-cpt' ), admin_url( 'admin.php' ) ) );
				?></p></div>
				<cx-vui-select
					label="<?php esc_html_e( 'Booking instances post type', 'jet-booking' ); ?>"
					description="<?php esc_html_e( 'Select post type to get booking instances from.', 'jet-booking' ); ?>"
					:options-list="postTypes"
					:wrapper-css="[ 'equalwidth' ]"
					size="fullwidth"
					v-model="setupData.apartment_post_type"
				></cx-vui-select>
			</div>
		</div>
		<div v-if="2 === currentStep">
			<h3 class="cx-vui-subtitle"><?php
				esc_html_e( 'Step 2 of 4. Set up orders', 'jet-booking' )
			?></h3>
			<div class="cx-vui-panel">
				<cx-vui-switcher
					label="<?php esc_html_e( 'WooCommerce Integration', 'jet-booking' ); ?>"
					description="<?php esc_html_e( 'Check this if you want to integrate booking orders with WooCommerce', 'jet-booking' ); ?>"
					:wrapper-css="[ 'equalwidth' ]"
					v-model="setupData.wc_integration"
				></cx-vui-switcher>
				<cx-vui-select
					label="<?php esc_html_e( 'Orders post type', 'jet-booking' ); ?>"
					description="<?php esc_html_e( 'Select post type to get booking instances from.', 'jet-booking' ); ?>"
					:options-list="postTypes"
					:wrapper-css="[ 'equalwidth' ]"
					size="fullwidth"
					v-model="setupData.related_post_type"
					:conditions="[
						{
							input: this.setupData.wc_integration,
							compare: 'not_equal',
							value: true,
						}
					]"
				></cx-vui-select>
			</div>
		</div>
		<div v-if="3 === currentStep">
			<h3 class="cx-vui-subtitle"><?php
				esc_html_e( 'Step 3 of 4. Setup DB tables', 'jet-booking' );
			?></h3>
			<div class="cx-vui-panel">
				<div class="cx-vui-component">
					<div class="cx-vui-component__meta">
						<label class="cx-vui-component__label"><?php
							esc_html_e( 'Required columns', 'jet-booking' );
						?></label>
						<div class="cx-vui-component__desc"><?php
							esc_html_e( 'Minimum set of required DB columns', 'jet-booking' );
						?></div>
					</div>
					<div class="cx-vui-component__control">
						<ul class="jet-abaf-setup__db-columns">
							<li v-for="field in getDBFields()">{{ field }}</li>
						</ul>
					</div>
				</div>
				<cx-vui-component-wrapper
					:wrapper-css="[ 'fullwidth-control' ]"
				>
					<div class="cx-vui-inner-panel">
						<cx-vui-repeater
							:button-label="'<?php esc_html_e( 'New DB Column', 'jet-booking' ); ?>'"
							:button-style="'accent'"
							:button-size="'mini'"
							v-model="additionalDBColumns"
							@add-new-item="addNewColumn"
						>
							<cx-vui-repeater-item
								v-for="( column, columnIndex ) in additionalDBColumns"
								:title="additionalDBColumns[ columnIndex ].column"
								:collapsed="isCollapsed( column )"
								:index="columnIndex"
								@clone-item="cloneColumn( $event, columnIndex )"
								@delete-item="deleteColumn( $event, columnIndex )"
								:key="'column' + columnIndex"
							>
								<cx-vui-input
									label="<?php esc_html_e( 'Column name', 'jet-booking' ); ?>"
									description="<?php esc_html_e( 'Name for additional DB column', 'jet-booking' ); ?>"
									:wrapper-css="[ 'equalwidth' ]"
									size="fullwidth"
									:value="additionalDBColumns[ columnIndex ].column"
									@input="setColumnProp( columnIndex, 'column', $event )"
								></cx-vui-input>
							</cx-vui-repeater-item>
						</cx-vui-repeater>
					</div>
				</cx-vui-component-wrapper>
			</div>
		</div>
		<div v-if="4 === currentStep">
			<h3 class="cx-vui-subtitle"><?php
				esc_html_e( 'Step 4 of 4. Setup additional settings', 'jet-booking' )
			?></h3>
			<div class="cx-vui-panel">
                <cx-vui-switcher
                        v-if="active_jet_form_builder"
                        label="<?php esc_html_e( 'Create JetFormBuilder Form', 'jet-booking' ); ?>"
                        description="<?php esc_html_e( 'Create JetForm for single booking page.', 'jet-booking' ); ?>"
                        :wrapper-css="[ 'equalwidth' ]"
                        v-model="setupData.create_single_form"
                ></cx-vui-switcher>
                <cx-vui-radio
                            v-if="!active_jet_form_builder"
                            label="<?php esc_html_e( 'Create Booking Form', 'jet-booking' ); ?>"
                            description="<?php esc_html_e( 'Create Form for single booking page.', 'jet-booking' ); ?>"
                            :options-list="form_options"
                            :wrapper-css="[ 'equalwidth' ]"
                            v-model="setupData.create_single_form"
                ></cx-vui-radio>
			</div>
		</div>
		<div v-if="4 < currentStep">
			<h3 class="cx-vui-subtitle"><?php
				esc_html_e( 'Congratulations! You\'re all set!', 'jet-booking' );
			?></h3>
			<div class="cx-vui-panel jet-abaf-panel">
				<div class="jet-abaf-panel-block">
					<h3 class="cx-vui-subtitle"><?php
						esc_html_e( 'Post Types', 'jet-booking' );
					?></h3>
					<p><span class="dashicons dashicons-admin-post"></span><a :href="log.bookings_page" target="_blank"><?php
						esc_html_e( 'Manage Booking Instances', 'jet-booking' );
					?></a></p>
					<p v-if="log.orders_page"><span class="dashicons dashicons-admin-post"></span><a :href="log.orders_page" target="_blank"><?php
						esc_html_e( 'Manage Orders', 'jet-booking' );
					?></a></p>
				</div>
				<div class="jet-abaf-panel-block">
					<h3 class="cx-vui-subtitle"><?php
						esc_html_e( 'WooCommerce Integration', 'jet-booking' );
					?></h3>
					<p v-if="log.wc.enabled" class="jet-abaf-wc-active" style="color: #46B450;"><span class="dashicons dashicons-yes"></span><b><?php
						esc_html_e( 'Enabled', 'jet-booking' );
					?></b></p>
					<p v-else class="jet-abaf-wc-inactive" style="color: #C92C2C;"><span class="dashicons dashicons-no"></span><b><?php
						esc_html_e( 'Disabled', 'jet-booking' );
					?></b></p>
					<p v-if="log.wc.enabled && log.wc.link"><span class="dashicons dashicons-cart"></span><a :href="log.wc.link" target="_blank"><?php
						esc_html_e( 'Related product', 'jet-booking' )
					?></a></p>
				</div>
				<div v-if="log.forms.length" class="jet-abaf-panel-block">
					<h3 class="cx-vui-subtitle"><?php
						esc_html_e( 'Created Forms', 'jet-booking' );
					?></h3>
					<p v-for="form in log.forms" :key="form.id">
						<span class="dashicons dashicons-clipboard"></span>
						<a :href="form.link" target="_blank">{{ form.title }}</a>
					</p>
					<p>
						<b>*</b> <?php _e( '<b>Note:</b> If you added additional DB columns you need add to appropriate fields to form fields and notification settings.', 'jet-booking' ); ?>
					</p>
				</div>
				<div class="jet-abaf-panel-block">
					<p><?php
						_e( 'You can disable Set Up wizard in plugin settings (<b>Advanced</b> tab)', 'jet-booking' );
					?></p>
					<cx-vui-button
						button-style="accent"
						tag-name="a"
						target="_blank"
						:url="log.settings_url"
					>
						<span slot="label">
							<?php esc_html_e( 'Go to plugin settings', 'jet-booking' ); ?>
						</span>
					</cx-vui-button>
				</div>
			</div>
		</div>
		<div v-else class="jet-abaf-setup__actions">
			<cx-vui-button
				button-style="link-accent"
				@click="prevStep"
				v-if="1 < currentStep"
			>
				<span slot="label">
					<span class="dashicons dashicons-arrow-left-alt2"></span>
					<?php esc_html_e( 'Prev', 'jet-booking' ); ?>
				</span>
			</cx-vui-button>
			<cx-vui-button
				button-style="accent"
				:loading="loading"
				@click="nextStep"
			>
				<span slot="label" v-if="currentStep === lastStep">
					<?php esc_html_e( 'Finish', 'jet-booking' ); ?>
				</span>
				<span slot="label" v-else>
					<?php esc_html_e( 'Next', 'jet-booking' ); ?>
				</span>
			</cx-vui-button>
		</div>
	</div>
	<div class="cx-vui-panel" v-else>
		<div class="jet-abaf-reset">
			<p>
				<b><?php esc_html_e( 'Plugin is already set up.', 'jet-booking' ) ?></b>
				<?php esc_html_e( 'If you want to reset current plugin data and set it again press the button below', 'jet-booking' ); ?>
			</p>
			<cx-vui-button
				:button-style="'default'"
				@click="goToReset"
			>
				<span slot="label"><?php esc_html_e( 'Reset', 'jet-booking' ); ?></span>
			</cx-vui-button>
		</div>
	</div>
</div>