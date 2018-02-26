var $selected;
var selectAttribute = function(x, y){
	var $topY = $('#matrix_table').find('tr[data-id='+y+']').addClass('colSel');
	var $topX = $('#matrix_table').find('th[data-id='+x+']').addClass('colSel');
	var x = $topX.index();
	$selected = $topY.find('td').eq(x).find('a');
	$selected.addClass('selected');
}
var assignCombinations = function(){
	dropTableMatrix();
	var matrixX = $.map($('#matrix_table th'), function(element){return $(element).data('id')});
	var matrixY = $.map($('#matrix_table tr'), function(element){return $(element).data('id')});
	var selectedComb = $.map($('[name^=group_]'), function(item){return parseInt($(item).val())});
	$.each(combinations, function(k, v){
		var x = null;
		var y = null;
		var showed = true;
		$.each(v['idsAttributes'], function(key, val){
			if($.inArray(val, matrixX) > -1){
				x = val;
			}
			if($.inArray(val, matrixY) > -1){
				y = val;
			}
			if(val != x && val != y && $.inArray(val, selectedComb) < 0){
				showed = false;
			}
		});
		if(x && y && showed){
			var $topY = $('#matrix_table').find('tr[data-id='+y+']');
			var $topX = $('#matrix_table').find('th[data-id='+x+']');
			var x = $topX.index();
			var $td = $topY.find('td').eq(x).find('a');
			$td.removeClass('hidden');
			if(v['quantity'] > 0){
				$td.removeClass('notsel').addClass('sel');
			}else{
				$td.addClass('notsel').removeClass('sel');
			}
		}
	});
}
function dropTableMatrix()
{
	$('#matrix_table tr td:not(.leftCol) a').removeClass('sel').addClass('hidden');
}
$(document).ready(function(){
	var selX = $('#group_1').val();
	var selY = $('#group_2').val();
	assignCombinations();
	selectAttribute(selX, selY);
	$('#matrix_table td a')
		.click(function(e){
			e.preventDefault();
			$selected.removeClass('selected');
			$(this).addClass('selected');
			$selected = $(this);
			var x = $(this).closest('td').index();
			var y = $(this).closest('tr').index() + 1;
			$('#matrix_table th').removeClass('colSel');
			$('#matrix_table tr').removeClass('colSel');
			var attr1 = $('#matrix_table th').eq(x).addClass('colSel').data('id');
			var attr2 = $('#matrix_table tr').eq(y).addClass('colSel').data('id');
			$('#group_1').val(attr1).change();
			$('#group_2').val(attr2).change();
			assignCombinations();
			return false;
		})
		.mouseover(function(){
			var x = $(this).closest('td').index();
			var y = $(this).closest('tr').index() + 1;
			$('#matrix_table th').eq(x).addClass('over');
			$('#matrix_table tr').eq(y).find('.leftCol').addClass('over');
		})
		.mouseout(function(){
			var x = $(this).closest('td').index();
			var y = $(this).closest('tr').index() + 1;
			$('#matrix_table th').eq(x).removeClass('over');
			$('#matrix_table tr').eq(y).find('.leftCol').removeClass('over');
		});
	$('[id^=group_]').change(assignCombinations);
	$('a.color_pick').click(function(){
		setTimeout(assignCombinations, 1000);
	});
});
