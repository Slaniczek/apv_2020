$(function(){
   $.nette.init();

   $('input[name^="smazat_"]').on('click', function(){
      $(this).parentsUntil('fieldset').parent().hide();
   });
});
