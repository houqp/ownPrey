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


	$.ajax({
		type: 'GET',
		url: OC.Router.generate('ownprey_device_get_all'),
		success: function (json) {
			$.each(json.data, function(k, dev) {
				add_dev_to_table(dev);
			});
		},
	});
});

