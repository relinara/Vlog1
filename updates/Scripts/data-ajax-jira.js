var DataTableJiraSearch = function() {

	window.jiralist_table;
	// var jiralist_table;

	$.fn.dataTable.Api.register('column().title()', function() {
		return $(this.header()).text().trim();
	});

	// Jira List DataTable
	var initJiraList = function() {

		jiralist_table = $('#m_table_jiralist').DataTable({
			// responsive: true,
			//== Pagination settings
			dom: `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
			// read more: https://datatables.net/examples/basic_init/dom.html
    		lengthMenu: [5, 10, 25, 50],
			pageLength: 5,
			scrollX: true,
			language: {
				'lengthMenu': 'Display _MENU_',
			},
			searchDelay: 500,
			processing: true,
			ajax: {
				url: '/jiras',
				type: 'POST',
				// success:function(data){
			 //        console.log(data);
		  //     	},
				error: function (xhr, error, code) {
	                console.log(xhr, error, code);
	            }
			},
			columns: [
				{data: 'projectname'},
				{data: 'type'},
				{data: 'typename'},
				{data: 'compname'},
				{data: 'jiranum'},
				{data: 'status'},
				{data: 'created'},
				{data: 'l_resolutiondate'},
				{data: 'diff_time'},
				{data: 'maxtime'},
				{data: 'assignee'},
				{data: 'assigneename'},
				{data: 'error'},
				{data: 'projectid'},
			],
			columnDefs: [
				{
					targets: 12,
					render: function(data, type, full, meta) {
						var status = {
							0: {'title': 'Тийм', 'class': ' m-badge--success'},
							1: {'title': 'Үгүй', 'class': ' m-badge--danger'},
						};
						if (typeof status[data] === 'undefined') {
							return data;
						}
						return '<span class="m-badge ' + status[data].class + ' m-badge--wide">' + status[data].title + '</span>';
					},
				},
				{ "targets": [ 2 ], "visible": false, "searchable": true }, // type name
				{ "targets": [ 9 ], "visible": false, "searchable": true }, // max time
				{ "targets": [ 10 ], "visible": false, "searchable": true }, // assigee
				{ "targets": [ 13 ], "visible": false, "searchable": true }, // projectid
			],
			initComplete: function(settings, json) {
			    calcJiraStatistic();
			    // console.log( "Drawing Finished" );
		  	}
		});

		var filter = function() {
			var val = $.fn.dataTable.util.escapeRegex($(this).val());
			jiralist_table.column($(this).data('col-index')).search(val ? val : '', false, false).draw();
		};

		var asdasd = function(value, index) {
			var val = $.fn.dataTable.util.escapeRegex(value);
			jiralist_table.column(index).search(val ? val : '', false, true);
		};

		$('#m_search').on('click', function(e) {
			e.preventDefault();
			var params = {};
			$('.m-input').each(function() {
				var i = $(this).data('col-index');
				if (params[i]) {
					
					params[i] += '|' + $(this).val();
				}
				else {
					params[i] = $(this).val();
				}
			});
			
			$.each(params, function(i, val) {
				// apply search params to datatable
				// console.log( i, val ? val : '', false, false );
				jiralist_table.column(i).search(val ? val : '', true, true);
			});

			jiralist_table.table().draw();

			calcJiraStatistic();
		});

		$('#m_reset').on('click', function(e) {
			e.preventDefault();
			$('.m-input').each(function() {
				$(this).val('');
				jiralist_table.column($(this).data('col-index')).search('', false, false);
			});
			jiralist_table.table().draw();
		});

		$('#m_datepicker').datepicker({
			todayHighlight: true,
			templates: {
				leftArrow: '<i class="la la-angle-left"></i>',
				rightArrow: '<i class="la la-angle-right"></i>',
			},
		});
	};

	// Jira Statistics DataTable
	var initJiraStatistic = function() {
		
		var table = $('#m_table_jirareport').DataTable({ "bSort" : false });

		calcJiraStatistic();
	};

	var calcJiraStatistic = function() {
		
		var resolved_easy = 0;
		var all_easy = 0;
		var solved_hard = 0;
		var all_hard = 0;
		var normal_easy = 0;
		var normal_hard = 0;

		jiralist_table.rows({ filter : 'applied'}).eq(0).each( function ( index ) {
		    
		    var row = jiralist_table.row( index );
		    var data = row.data();
			
			// MaxTime нь Null ирэх боломжтой байна. Пизда
			if (data.maxtime <= 8)
		 	{
			 	if (data.status == "10001-Шийдвэрлэсэн" || data.status == "10219-Хаагдсан")
			 	{
			 		// Хугацаа шаардагдахгүй шийдвэрлэсэн JIRA -ны тоо
			 		resolved_easy++;

			 		if( data.diff_time <= data.maxtime )
			 		{
			 			// Стандарт хугацаандаа шийдвэрлэсэн JIRA (Хугацаа шаардагдахгүй)
			 			normal_easy++;
			 		}
			 	}

			 	// Хугацаа шаардагдахгүй бүх JIRA -ны тоо
		 		all_easy++;
		 	}
		 	else if (data.maxtime > 8)
		 	{
		 		if (data.status == "10001-Шийдвэрлэсэн" || data.status == "10219-Хаагдсан")
		 		{
		 			// Хугацаа шаардагдах шийдвэрлэсэн JIRA -ны тоо
		 			solved_hard++;

		 			if( data.diff_time <= data.maxtime )
		 			{
		 				// Стандарт хугацаандаа шийдвэрлэсэн JIRA (Хугацаа шаардагдах)
		 				normal_hard++;
		 			}
		 		}

		 		// Хугацаа шаардагдах бүх JIRA -ны тоо
		 		all_hard++;
		 	}
		});

		// console.log( resolved_easy,all_easy,solved_hard,all_hard,normal_easy,normal_hard );
		
		$("#st1_kpi").text( $( "#_department option:selected" ).text() );
		$("#st2_kpi").text( $( "#_department option:selected" ).text() );
		$("#st3_kpi").text( $( "#_department option:selected" ).text() );
		$("#st4_kpi").text( $( "#_department option:selected" ).text() );

		$("#st1_total_count").text(all_easy);
		$("#st1_solived_count").text(resolved_easy);
		$("#st1_procent").text( parseFloat(resolved_easy*100/all_easy).toFixed(2) + "%" );

		$("#st2_total_count").text(all_hard);
		$("#st2_solived_count").text(solved_hard);
		$("#st2_procent").text( parseFloat(solved_hard*100/all_hard).toFixed(2) + "%" );

		$("#st3_total_count").text(all_easy);
		$("#st3_solived_count").text(normal_easy);
		$("#st3_procent").text( parseFloat(normal_easy*100/all_easy).toFixed(2) + "%" );

		$("#st4_total_count").text(all_hard);
		$("#st4_solived_count").text(normal_hard);
		$("#st4_procent").text( parseFloat(normal_hard*100/all_hard).toFixed(2) + "%" );
	};

	return {
		init: function() {
			initJiraList();
		},
	};

}();

jQuery(document).ready(function() {
	
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	
	DataTableJiraSearch.init();
});