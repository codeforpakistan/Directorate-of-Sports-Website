<div class="jet-abaf-units-manager">
	<cx-vui-button
		button-style="accent"
		:loading="loading"
		@click="loadUnits"
		v-if="!loaded"
	>
		<span slot="label">Manage Units</span>
	</cx-vui-button>
	<div v-else>
		<div class="cx-vui-subtitle">Available Units</div>
		<cx-vui-list-table
			:is-empty="! unitsList.length"
			empty-message="No units was found for this apartment"
		>
			<cx-vui-list-table-heading
				:slots="[ 'unit_id', 'name', 'actions' ]"
				slot="heading"
			>
				<div slot="unit_id" style="width: 50px;">Unit ID</div>
				<div slot="name">Name</div>
				<div slot="actions">Actions</div>
			</cx-vui-list-table-heading>
			<cx-vui-list-table-item
				:slots="[ 'unit_id', 'name', 'actions' ]"
				slot="items"
				v-for="unit in unitsList"
				:key="unit.unit_id"
			>
				<div slot="unit_id" style="width: 50px;">{{ unit.unit_id }}</div>
				<div slot="name">
					<cx-vui-input
						v-if="unitToEdit && unit.unit_id === unitToEdit.unit_id"
						:wrapper-css="[ 'equalwidth' ]"
						size="fullwidth"
						:prevent-wrap="true"
						:autofocus="true"
						v-model="unitToEdit.unit_title"
						@on-keyup.stop.enter="saveUnit"
					></cx-vui-input>
					<div v-else>
						{{ unit.unit_title }}
					</div>
				</div>
				<div class="jet-abaf-unit-actions" slot="actions">
					<cx-vui-button
						button-style="link-accent"
						size="link"
						@click="saveUnit"
						v-if="unitToEdit && unit.unit_id === unitToEdit.unit_id"
					>
						<span slot="label">Save</span>
					</cx-vui-button>
					<cx-vui-button
						v-else
						button-style="link-accent"
						size="link"
						@click="unitToEdit = unit"
					>
						<span slot="label">Edit</span>
					</cx-vui-button><div class="jet-abaf-delete-unit">
						<cx-vui-button
							button-style="link-error"
							size="link"
							@click="unitToEdit = null"
							v-if="unitToEdit && unit.unit_id === unitToEdit.unit_id"
						>
							<span slot="label">Cancel</span>
						</cx-vui-button>
						<cx-vui-button
							button-style="link-error"
							size="link"
							@click="unitToDelete = unit.unit_id"
							v-else
						>
							<span slot="label">Delete</span>
						</cx-vui-button>
						<div
							class="cx-vui-tooltip"
							v-if="unit.unit_id === unitToDelete"
						>
							Are you sure?
							<br><span
								class="cx-vui-repeater-item__confrim-del"
								@click="deleteUnit"
							>Yes</span>
							/
							<span
								class="cx-vui-repeater-item__cancel-del"
								@click="unitToDelete = null"
							>No</span>
						</div>
					</div>
				</div>
			</cx-vui-list-table-item>
		</cx-vui-list-table>
		<br>
		<div class="cx-vui-subtitle">Add Units</div>
		<div class="cx-vui-panel">
			<cx-vui-input
				label="Number"
				description="Enter number of created units"
				:wrapper-css="[ 'equalwidth' ]"
				size="fullwidth"
				type="number"
				v-model="newUnitsNum"
			></cx-vui-input>
			<cx-vui-input
				label="Title"
				description="Enter title of created units. If empty - apartment title will be used"
				:wrapper-css="[ 'equalwidth' ]"
				size="fullwidth"
				v-model="newUnitsTitle"
			></cx-vui-input>
		</div>
		<cx-vui-button
			button-style="accent"
			@click="insertUnits"
		>
			<span slot="label">Add Units</span>
		</cx-vui-button>
	</div>
</div>