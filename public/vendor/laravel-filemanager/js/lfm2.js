(function ($) {
    
    $.fn.filemanager2 = function (type, options) {
        type = type || 'file';
        var parent = this;            
        this.on('click', function (e) {
            if( $(parent).attr('data-choice') === 'files'){
                type = 'file';
                $("#isIcon").val(1);
            }
            if( $(parent).attr('data-choice') === 'icon'){
                $("#isIcon").val(2);
            }
            var route_prefix = (options && options.prefix) ? options.prefix : '/admin/laravel-filemanager';
            localStorage.setItem('target_input', $(this).data('input'));
            localStorage.setItem('target_preview', $(this).data('preview'));
            window.open(route_prefix + '?type=' + type , 'FileManager', 'width=900,height=600');            
            if ($("#mutil").val() === 'remove' && $(parent).attr('data-choice') === 'files') {               
               return true;
            } else {                                     
                    window.SetUrl = function (url, file_path) {
                        //set the value of the desired input to image url
                        var target_input = $('#' + localStorage.getItem('target_input'));
                        target_input.val(file_path).trigger('change');
    
                        //set or change the preview image src
                        var target_preview = $('#' + localStorage.getItem('target_preview'));
                        target_preview.attr('src', url).trigger('change');
                    };
                    return false;
                
            }
        });
    }

})(jQuery);
