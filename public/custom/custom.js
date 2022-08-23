$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function deleteData(message, route) {
    if (confirm(message)) {
        window.location = route;
    }

}
