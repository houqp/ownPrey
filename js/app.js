/*
# ownCloud
#
# @author Qingping Hou
# Copyright (c) 2013 - Qingping Hou <qingping.hou@gmail.com>
#
# This file is licensed under the Affero General Public License version 3 or later.
# See the COPYING-README file
#
*/

OC.Router.registerLoadedCallback(function () {
	function add_dev_to_table(dev) {
		var $tr_tmpl = $('#tr_tmpl');
		var new_tr = $tr_tmpl.clone();
		new_tr.attr('id', '');

		$('.dev_id', new_tr).html(
			'<a href="' +
			OC.Router.generate(
				'ownprey_device_check', {id: dev.id}) +
			'">' + dev.id +
			'</a>'
		);
		$('.dev_name', new_tr).text(dev.name);
		$('.dev_missing', new_tr).text(dev.missing);
		$('.dev_delay', new_tr).text(dev.delay);
		$('.dev_module_list', new_tr).text(dev.module_list);
		$('#dev_list_table').append(new_tr);
		new_tr.show();
	}

	/* register add device button listener */
	$('#btn_add_dev').click(function () {
		$.ajax({
			type: 'POST',
			url: OC.Router.generate('ownprey_device_add'),
			data: $('#form_add_dev').serialize(),
			success: function (json) {
				if (json.data['status'] == 'success') {
					add_dev_to_table({
						'id': json.data['id'],
						'name': $('input[name="name"]').val(),
						'missing': $('input[name="missing"]').val(),
						'delay': $('input[name="delay"]').val(),
						'module_list': $('input[name="module_list"]').val(),
					});
				} else {
					//@TODO notify user of failure    (houqp)
				}
			},
		});
	});

	function dev_list_tr_click_cb() {
		var cur_tr = $(this);
		var orig_tr = cur_tr.clone();
		cur_tr.unbind('click');
		var tr_tmpl = $('#tr_form_tmpl').clone();
		tr_tmpl.attr('id', '');
		var f = $('from', tr_tmpl);
		var dev_id = $('.dev_id', cur_tr).text();

		$('input[name="id"]', tr_tmpl).val(dev_id);
		$('input[name="name"]', tr_tmpl).val(
				$('.dev_name', cur_tr).text());
		$('input[name="missing"]', tr_tmpl).val(
				$('.dev_missing', cur_tr).text());
		$('input[name="delay"]', tr_tmpl).val(
				$('.dev_delay', cur_tr).text());
		$('input[name="module_list"]', tr_tmpl).val(
				$('.dev_module_list', cur_tr).text());

		cur_tr.html($(tr_tmpl).find('td'));
		tr_tmpl.show();

		$('.cancel_dev', cur_tr).click(function(){
			cur_tr.replaceWith($(orig_tr));
			$(orig_tr).click(dev_list_tr_click_cb);
		});

		$('.del_dev', cur_tr).click(function(){
			$.ajax({
				type: 'DELETE',
				url: OC.Router.generate('ownprey_device_remove',
					{id: dev_id}),
				success: function () {
					cur_tr.remove();
				},
			});
		});

		$('.edit_dev', cur_tr).click(function(){
			$.ajax({
				type: 'POST',
				url: OC.Router.generate('ownprey_device_update',
					{id: dev_id}),
				data: $('form', cur_tr).serialize(),
				success: function (json) {
					if (json['status'] == 'success') {
						$('.dev_name', orig_tr).text(
							$('input[name="name"]', cur_tr).val());
						$('.dev_missing', orig_tr).text(
							$('input[name="missing"]', cur_tr).val());
						$('.dev_delay', orig_tr).text(
							$('input[name="delay"]', cur_tr).val());
						$('.dev_module_list', orig_tr).text(
							$('input[name="module_list"]', cur_tr).val());
						cur_tr.replaceWith($(orig_tr));
					} else {
						alert('failed to update device info!');
					}
				},
			});
		});
	}

	/* pull down devices list */
	$.ajax({
		type: 'GET',
		url: OC.Router.generate('ownprey_device_get_all'),
		success: function (json) {
			$.each(json.data, function(k, dev) {
				add_dev_to_table(dev);
			});

			$('#dev_list_table tr').click(dev_list_tr_click_cb);
		},
	});
});

