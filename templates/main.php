<div id="app">

	<h1 class="heading">{{ trans('Welcome to %s!', 'ownPrey') }}</h1>

	<table>
		<tr><th>Key</th><th>Value</th></tr>
		<form id="form_add_dev" class="centered">
		<tr>
			<td> Name </td>
			<td>
				<input name="name" type="text" value="untitled">
			</td>
		</tr>
		<tr>
			<td> Missing </td>
			<td>
				<input name="missing" type="text" value="false">
			</td>
		</tr>
		<tr>
			<td> Delay </td>
			<td>
				<input name="delay" type="text" value="20">
			</td>
		</tr>
		<tr>
			<td> Module List </td>
			<td>
				<input name="module_list" type="text"
					 value="geo network session webcam">
			</td>
		</tr>
		</form>
		<tr>
			<td colspan="2">
				<button id="btn_add_dev">add device</button>
			</td>
		</tr>
	</table>

	<div id="dev_list">
		<table id="dev_list_table">
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Missing</th>
				<th>Delay</th>
				<th>Module List</th>
			</tr>
			<tr id="tr_tmpl" style="display:none;">
				<td class="dev_id"></td>
				<td class="dev_name"></td>
				<td class="dev_missing"></td>
				<td class="dev_delay"></td>
				<td class="dev_module_list"></td>
			</tr>
			<tr id="tr_form_tmpl" style="display:none;">
				<td colspan="4">
					<form>
					<input name="id" type="hidden">
					<input name="name" type="text">
					<input name="missing" type="text">
					<input name="delay" type="text">
					<input name="module_list" type="text">
					<form>
				</td>
				<td>
					<button class="edit_dev">edit</button>
					<button class="del_dev">delete</button>
					<button class="cancel_dev">cancel</button>
				</td>
			</tr>
		</table>
	</div>

</div>



