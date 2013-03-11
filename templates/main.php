<div id="app">

	<h1 class="heading">{{ trans('Welcome to %s!', 'ownPrey') }}</h1>

	<table>
		<tr><th>Key</th><th>Value</th></tr>
		<form id="form_add_dev" class="centered">
		<tr>
			<td> Name </td>
			<td>
				<input name="name" type="text" value="untitled">
				</br>
			</td>
		</tr>
		<tr>
			<td> Missing </td>
			<td>
				<input name="missing" type="text" value="false">
				</br>
			</td>
		</tr>
		<tr>
			<td> Delay </td>
			<td>
				<input name="delay" type="text" value="20">
				</br>
			</td>
		</tr>
		<tr>
			<td> Module List </td>
			<td>
				<input name="module_list" type="text"
					 value="geo network session webcam">
				</br>
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
		<table>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Missing</th>
				<th>Delay</th>
				<th>Module List</th>
			</tr>
			{% for dev in devices %}
			<tr>
				<td>
					<a href="{{ abs_url('ownprey_device_check', {id: dev.id}) }}">
						{{ dev.id }}
					</a>
				</td>
				<td> {{ dev.name }} </td>
				<td> {{ dev.missing }} </td>
				<td> {{ dev.delay }} </td>
				<td> {{ dev.module_list }} </td>
			</tr>
			{% endfor %}
		</table>
	</div>
</div>



