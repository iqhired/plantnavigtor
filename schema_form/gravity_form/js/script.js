//initialize Form Builder
$(function(){	
	var options = {
      controlOrder: [
        'text',
        'textarea'
      ],
       disableFields: ['autocomplete','date'],
       controlOrder: [
        'header',
        'text',
        'textarea',
        'number',
        'select',
        'checkbox-group',
        'radio-group',
        'file',
        'paragraph',
        'starRating',
        'button',
        'hidden',
      ]
    };
$('.build-wrap').formBuilder(options);
	//$('.build-wrap').formBuilder();
});
