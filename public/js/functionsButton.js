function doRemove(id) {
    
    function removeButton() {
            $("#" + id).remove();
    }
    $.ajax({
            url : "",
            context : document.body,
            success : removeButton
    });
}

