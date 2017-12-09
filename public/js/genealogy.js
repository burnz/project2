$(function () {
	$("#genealogy-container").jstree({
		plugins: ["table", "search", "json_data", "addFunctions"],
		core: {
			data: function(node, cb) {
				$.ajax({
					url: node.id=="#"?"?action=getUser":"?action=getChildren",
					data: {
						id: node.id,
						username: $('#search-input').val(),
					},
					timeout : 15000
				}).done(function(data) {
					if (data instanceof Array) {
						var children = [];
						for (var i = 0; i < data.length; i++) {
							var user = data[i];
							children.push({
								//text: user.id +' '+ user.u + ' (' + user.dmc + ')',
								text: user.uid +' '+ user.u,
								data: {
									username: user.id +' '+ user.u,
                                    packageId: '<b class="psi  psi1">'+ user.packageId +'</b>',
                                    totalMembers: user.totalMembers,
                                    leg: user.leg,
                                    rankId: getRank(user.rankId),
								},
								id: user.id,
								children: user.dmc?true:false,
								icon: "/img/jstree/user.png",
								state: {opened: parseInt(user.totalMembers) > 0 ? false : true}
							});
						}
						cb(children);
					} else {
						var user = data;
						cb([{
							text: user.uid +' '+ user.u,
							data: {
								username: user.id +' '+ user.u,
                                packageId: '<b class="psi  psi1">'+ user.packageId +'</b>',
                                totalMembers: user.totalMembers,
                                leg: user.leg,
                                rankId: getRank(user.rankId),
							},
							id: user.id,
							children: user.dmc?true:false,
							icon: "/img/jstree/user.png",
                            state: {opened: parseInt(user.totalMembers) > 0 ? false : true}
						}]);
					}
				});
			},
			load_open : true
		},
		// configure tree table
		table: {
			columns: [
				{width: '50%', header: "ID/Username"},
				{width: '5%', value: "totalMembers", header: "Total member"},
				{width: '5%', value: "packageId", header: "Lending Package"},
				{width: '5%', value: "leg", header: "Left/Right"},
				{width: '5%', value: "loyaltyId", header: "Rank"}
			],
			width: "100%",
			fixedHeader: false,
			resizable: true,
		}
	});

	

	function getRank(rankId) {

		var rankName = ''
		if(rankId == 0) {
			rankName = '';
		}
		else if(rankId == 1) {
			rankName = 'SAPPHIRE';
		}
		else if(rankId == 2) {
			rankName = 'EMERALD';
		}
		else if(rankId == 3) {
			rankName = 'DIAMOND';
		}
		else if(rankId == 4) {
			rankName = 'BLUE DIAMOND';
		}
		else if(rankId == 5) {
			rankName = 'BLACK DIAMOND';
		}

		return rankName;
	}

	var to = false;
	$('#search-button').on('click', function (e) {
		$.ajax({
			url: "?action=getUser",
			data: {
				username: $('#search-input').val(),
			},
			timeout : 15000
		}).done(function(data) {
			if (!data.err) {
				$('#genealogy-container').jstree(true).refresh();
			} else {
				swal({
					title: "There's something wrong",
					text: ErrorCodes[data.err],
					type: "error"
				});
			}
		});
	});
	$('#search-input').keypress(function (e) {
		var key = e.which;
		if(key == 13) {
			$('#search-button').click();
			return false;
		}
	});
});