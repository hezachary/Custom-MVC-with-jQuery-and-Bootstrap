
(function($){
    var strFormSelector = 'form[name="contact_us"]';
    var currentFocusName;
    
    /**
     * Trigger ajax validation via blur
     **/
    function bindBlur( node ){
        $( node ).bind('focus', function(){
            currentFocusName = $( this ).attr('name');
        });
        $( node ).bind('blur', function(){
            var input = $( this );
            var field = input.attr('name');
            var value = input.val();
            switch( input.attr('name') ){
                case 'dob-dd':
                case 'dob-mm':
                case 'dob-yyyy':
                    field = 'dob';
                    value = [ $( strFormSelector ).find('input[name="dob-yyyy"]').val(), $( strFormSelector ).find('input[name="dob-mm"]').val(), $( strFormSelector ).find('input[name="dob-dd"]').val() ];
                    break;
                default:
                    break;
            }
            
            $.post( basepath, { 'action': 'ajax', 'field': field, 'value': value }, function( data ){
                var newFormGroup = $( data.html );
                input.closest('.form-group').replaceWith( newFormGroup )
                newFormGroup.find( 'input, textarea' ).each(function(){
                    bindBlur( this );
                });
                newFormGroup.find('[name="' + currentFocusName + '"]').get(0).focus();
            }, 'json' );
        });
    }
    
    $(function(){
        //Find all input/textarea fields, and bind with blur events 
        $( strFormSelector ).find('input, textarea').each(function(){
            bindBlur( this );
        });
    });
})(jQuery);