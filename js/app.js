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

$(document).ready(function() {
	$('#btn_add_dev').click(function() {
		console.log(OC.Router.generate('ownprey_device_add'));
		$.ajax({
			type: 'POST',
			url: OC.Router.generate('ownprey_device_add'),
			data: $('#form_add_dev').serialize(),
			success: function(data) {
				console.log('123');
			},
		});
	});
});

