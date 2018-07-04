// JavaScript Document
	$(document).ready(function(){          
		$("select#aimag_code").change(function(){
			var aimag_code = $("select#aimag_code option:selected").attr('value');
			$.post("get_soumname.php", {aimagcode:aimag_code}, function(data){
				$("select#soum_code").html(data);
			});			
		});		
	});
	
	$(document).ready(function(){          
		$("form#changeform").change(function(){
			document.changeform.submit();
		});
	});	

	$(document).ready(function(){  
	    $( ".datepicker" ).datepicker({
		  	showOn: "button",
			showButtonPanel: true,
			buttonImage: "images/calendar.gif",
			buttonImageOnly: true,
			buttonText: "Огноо сонгох",
			dateFormat: "yy-mm-dd",
			closeText: 'Хаах',
			currentText: 'Өнөөдөр',
			prevText: 'Өмнөх',
			nextText: 'Дараах',
			monthNames: ['1-р сар', '2-р сар', '3-р сар', '4-р сар', '5-р сар', '6-р сар', '7-р сар', '8-р сар', '9-р сар', '10-р сар', '11-р сар', '12-р сар'],
			dayNamesMin: ['Ня','Да','Мя','Лх','Пү','Ба','Бя'],
			dayNames: ['Ням','Даваа','Мягмар','Лхагва','Перэв','Баасан','Бямба'],
			weekHeader: 'Бям.',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
		});
	});
