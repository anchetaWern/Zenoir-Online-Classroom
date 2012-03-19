<!--create quiz items-->
<style>
table{
	border:0px;
}

th, td{
	padding:0px;
}
</style>
<script>
$(function(){
$('#item_count').blur(function(){
	var quiz_items = $.trim($('#item_count').val());
	$('#items').html('');
		var tbl = $('<table>').appendTo('#items');
		var tbody_root = $('<tbody>').appendTo(tbl);
	
	for(var index=0; index < quiz_items; index++){
		var tr1 = $('<tr>').appendTo(tbody_root);
		var tr2 = $('<tr>').appendTo(tbody_root);
		var tr3 = $('<tr>').appendTo(tbody_root);
		var tr4 = $('<tr>').appendTo(tbody_root);
		var tr5 = $('<tr>').appendTo(tbody_root);
		var tr6 = $('<tr>').appendTo(tbody_root);
		
		var td_question = $('<td>').appendTo(tr1);
		
		var td_a = $('<td>').appendTo(tr2);
		var td_b = $('<td>').appendTo(tr3);
		var td_c = $('<td>').appendTo(tr4);
		var td_d = $('<td>').appendTo(tr5);
		
		var td_answer = $('<td>').appendTo(tr6);
		
		var txt_quiz = $('<input>').attr({'type' : 'text', 'name' : 'question[]', 'class' : 'qt', 'placeholder' : 'Question'}).appendTo(td_question);
		
		var txt_a = $('<input>').attr({'type' : 'text', 'name' : 'choice_a[]', 'class' : 'ca', 'placeholder' : 'Choice A', 'required' : 'required'}).appendTo(td_a);
		var txt_b = $('<input>').attr({'type' : 'text', 'name' : 'choice_b[]', 'class' : 'cb', 'placeholder' : 'Choice B', 'required' : 'required'}).appendTo(td_b);
		var txt_c = $('<input>').attr({'type' : 'text', 'name' : 'choice_c[]', 'class' : 'cc', 'placeholder' : 'Choice C', 'required' : 'required'}).appendTo(td_c);
		var txt_d = $('<input>').attr({'type' : 'text', 'name' : 'choice_d[]', 'class' : 'cd', 'placeholder' : 'Choice D', 'required' : 'required'}).appendTo(td_d);
		
		var sel_answer = $('<select>').attr({'name' : 'answer[]', 'class' : 'an'}).appendTo(td_answer);
		$('<option>').attr({'value' : 'A'}).appendTo(sel_answer).text('A');
		$('<option>').attr({'value' : 'B'}).appendTo(sel_answer).text('B');
		$('<option>').attr({'value' : 'C'}).appendTo(sel_answer).text('C');
		$('<option>').attr({'value' : 'D'}).appendTo(sel_answer).text('D');
	}//end for loop
	
	$(tbl).after("<button id='create_quiz' name='create_quiz' class='medium green'>Create Quiz</button>");
});
});
</script>
<div id="modal_header">
<h4>Create New Quiz</h4>

</div>
<div class="container">
<?php echo form_label('Number of Items', 'item_count'); ?>
<input type="number" id="item_count" name="item_count" min="1" class="col_2"/>
<div id="items">
</div>
</div><!--end of container-->