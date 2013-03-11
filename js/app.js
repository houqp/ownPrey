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
	$('#btn_add_dev').click(function () {
		$.ajax({
			type: 'POST',
			url: OC.Router.generate('ownprey_device_add'),
			data: $('#form_add_dev').serialize(),
			success: function (data) {
				console.log('123');
			},
		});
	});


	$.ajax({
		type: 'GET',
		url: OC.Router.generate('ownprey_device_get_all'),
		success: function (json) {
			var $tr_tmpl = $('#tr_tmpl');
			$.each(json.data, function(k, dev) {
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
			});
		},
	});
});

