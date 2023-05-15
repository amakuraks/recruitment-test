function clearValidationError(modalName){
    $(modalName).find($('.is-invalid')).removeClass('is-invalid');
    $(modalName).find($('.invalid-feedback')).remove();
}

function crudAjax(tableName, routeName, method, modalName = null, modalClear = false, successCallback){
    $.ajax({
            type    :method,
            url     :routeName,
            data: $('#'+tableName).serialize(),
            beforeSend: function(){
                if(modalClear){
                    clearValidationError('#'+modalName);
                }
            },
            success :function(data){
                if($.isEmptyObject(data.error)){
                    successCallback(data);
                }else{
                    toastr.error('Submission error: '+data.error);
                }
            },
            error : function(obj, response){
                if(obj.status == 422){
                    if(modalName){
                        $.each(obj.responseJSON.errors, function(key, value) {
                            var error   = '<span class="invalid-feedback" role="alert"><strong>'+value+'</strong></span>';
                            var $modal   = $('#'+modalName).find($('[name='+key+']'))
                            $modal.addClass('is-invalid');
                            $(error).insertAfter($modal);
                        });
                    }
                }
                else{
                    toastr.error('Internal server error. Please refer to the log or contact support. Detail: '+ obj.responseJSON.message);
                }
            }
        });
}

function reloadTable(tableName, routeName, routeEdit, routeDelete){
    $.ajax({
        type        : 'GET',
        url         : routeName,
        beforeSend  : function(){
            $('#'+tableName).DataTable().clear().destroy();
            $('#'+tableName+'overlay').show();
        },
        success     : function(data){
            // Fill table
            $.each(data.data, function(i, item){
                if(routeEdit != ""){
                    var tempEdit        = routeEdit.replace(':id', item.id);
                    var $editButton     = $('<button type="button" class="btn btn-warning edit" data-action="'+tempEdit+'">').append('<i class="fas fa-edit"></i>')
                }
                var tempDelete      = routeDelete.replace(':id', item.id);
                var $deleteButton   = $('<button type="button" class="btn btn-danger destroy" data-action="'+tempDelete+'">').append('<i class="fas fa-trash"></i>')
                var $tr             = $('<tr>');

                $.each(item, function(key, value){
                    if(key == 'id'){ return; }
                    if(Array.isArray(value)){
                        var $td = $('<td>');
                        $.each(value, function(index, val){
                            $td.append(
                                $('<li>').text(val.name),
                            );
                        });
                        $tr.append(
                            $td,
                        );
                    }
                    else{
                        $tr.append(
                            $('<td>').text(value),
                        );
                    }
                });

                $tr.append(
                    $('<td>').append([$editButton, $deleteButton]),
                );

                $('#'+tableName+'body').append($tr);
            });

            $('#'+tableName).DataTable({
                "paging"        : true,
                "lengthChange"  : true,
                "searching"     : true,
                "ordering"      : true,
                "info"          : true,
                "autoWidth"     : false,
                "responsive"    : true,
            });

            // Show modal
            $('#'+tableName+'overlay').delay( 1000 ).fadeOut(300);
        },
        error : function(){
            alert('Failed fetching selected record. Please refer to the log or contact support.');
        }
    });
}

$('.modal-autoclear').on('hidden.bs.modal', function (e) {
    $(this).find($('.is-invalid')).removeClass('is-invalid');
    $(this).find($('.invalid-feedback')).remove();
});
