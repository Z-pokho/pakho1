(function($){
	$.fn.extend({
		'Form':function(){

			var Input = $(this).find('input,textarea').not('input[type="reset"],input[type="submit"],input[type="image"]');
			var defaultColor = Input.css('color');
			var enterColor = 'black';
//			defaultColor是默认颜色
//			enterColor是输入文本颜色
			/////////////////////////
			Input.each(function(){
				var value = $(this).attr('value');
				$(this).val(value);	
				$(this).focus(function(){
					if($(this).val()===value){
						$(this).val('').css('color',enterColor)
					}
				})
			
				$(this).blur(function(){
					if($(this).val()===''){
						$(this).val(value).css('color',defaultColor)
					}
				})
		
			})	
			
			var reset = $(this).find('input[type="reset"]');

			reset.click(function(event){
				event.preventDefault()
				Input.each(function(){
					var value = $(this).attr('value')
					$(this).val(value).css('color',defaultColor)
				})
			})
			////////////////////////
			
		}
	})
})(jQuery)

