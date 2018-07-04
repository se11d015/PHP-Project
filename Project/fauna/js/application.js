// JavaScript Document
	$(document).ready(function(){          
		$("select#aimag_name").change(function(){
			var aimagcode = $("select#aimag_name option:selected").attr('value');
			$.post("get_aimagsoum.php", {aimagcode:aimagcode}, function(data){
				$("select#soum_name").html(data);
			});			
		});		
	});
	
	$(document).ready(function(){          
		$("select#phylum_code").change(function(){
			var phylumcode = $("select#phylum_code option:selected").attr('value');
			$.post("get_phylumclass.php", {phylumcode:phylumcode}, function(data){
				$("select#class_code").html(data);
			});			
		});		
	});	
	
	$(document).ready(function(){          
		$("select#phylum_code").change(function(){
			var phylumcode = $("select#phylum_code option:selected").attr('value');
			$.post("get_phylumorder.php", {phylumcode:phylumcode}, function(data){
				$("select#order_code").html(data);
			});			
		});		
	});
	
	$(document).ready(function(){          
		$("select#order_code").change(function(){
			var ordercode = $("select#order_code option:selected").attr('value');
			$.post("get_orderfamily.php", {ordercode:ordercode}, function(data){
				$("select#family_code").html(data);
			});			
		});		
	});

	$(document).ready(function(){          
		$("select#family_code").change(function(){
			var familycode = $("select#family_code option:selected").attr('value');
			$.post("get_familygenus.php", {familycode:familycode}, function(data){
				$("select#genus_code").html(data);
			});			
		});		
	});

	$(document).ready(function(){          
		$("select#genus_code").change(function(){
			var genuscode = $("select#genus_code option:selected").attr('value');
			$.post("get_genusspecies.php", {genuscode:genuscode}, function(data){
				$("select#species_code").html(data);
			});			
		});		
	});	
	
	$(document).ready(function(){          
		$("select#phylum_code_family").change(function(){
			var phylumcode = $("select#phylum_code_family option:selected").attr('value');
			$.post("get_phylumorder.php", {phylumcode:phylumcode}, function(data){
				$("select#order_code").html(data);
			});
			$.post("get_phylumfamily.php", {phylumcode:phylumcode}, function(data){
				$("select#family_code").html(data);	
			});
		});
	}); 
	
	$(document).ready(function(){          
		$("select#phylum_code_genus").change(function(){
			var phylumcode = $("select#phylum_code_genus option:selected").attr('value');
			$.post("get_phylumorder.php", {phylumcode:phylumcode}, function(data){
				$("select#order_code_genus").html(data);
			});
			$.post("get_phylumfamily.php", {phylumcode:phylumcode}, function(data){
				$("select#family_code").html(data);	
			});
			$.post("get_phylumgenus.php", {phylumcode:phylumcode}, function(data){
				$("select#genus_code").html(data);	
			});			
		});
	});	
	$(document).ready(function(){          
		$("select#order_code_genus").change(function(){
			var ordercode = $("select#order_code_genus option:selected").attr('value');
			$.post("get_orderfamily.php", {ordercode:ordercode}, function(data){
				$("select#family_code").html(data);
			});
			$.post("get_ordergenus.php", {ordercode:ordercode}, function(data){
				$("select#genus_code").html(data);	
			});
		});
	}); 

	
	$(document).ready(function(){          
		$("select#phylum_code_species").change(function(){
			var phylumcode = $("select#phylum_code_species option:selected").attr('value');
			$.post("get_phylumorder.php", {phylumcode:phylumcode}, function(data){
				$("select#order_code_species").html(data);
			});
			$.post("get_phylumfamily.php", {phylumcode:phylumcode}, function(data){
				$("select#family_code_species").html(data);	
			});
			$.post("get_phylumgenus.php", {phylumcode:phylumcode}, function(data){
				$("select#genus_code").html(data);	
			});			
			$.post("get_phylumspecies.php", {phylumcode:phylumcode}, function(data){
				$("select#species_code").html(data);
			});
		});
	});	
	$(document).ready(function(){          
		$("select#order_code_species").change(function(){
			var ordercode = $("select#order_code_species option:selected").attr('value');
			$.post("get_orderfamily.php", {ordercode:ordercode}, function(data){
				$("select#family_code_species").html(data);
			});
			$.post("get_ordergenus.php", {ordercode:ordercode}, function(data){
				$("select#genus_code").html(data);	
			});
			$.post("get_orderspecies.php", {ordercode:ordercode}, function(data){
				$("select#species_code").html(data);	
			});
		});
	}); 
	$(document).ready(function(){          
		$("select#family_code_species").change(function(){
			var familycode = $("select#family_code_species option:selected").attr('value');
			$.post("get_familygenus.php", {familycode:familycode}, function(data){
				$("select#genus_code").html(data);
			});
			$.post("get_familyspecies.php", {familycode:familycode}, function(data){
				$("select#species_code").html(data);	
			});
		});
	}); 

