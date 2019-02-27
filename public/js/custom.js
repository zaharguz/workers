function ajaxLoad(filename, content) {
    content = typeof content !== 'undefined' ? content : '#workers';
    $('#loading').show();
    $.ajax({
        type: "GET",
        url: filename,
        contentType: false,
        success: function (data) {
            $(content).html(data);
            $('#loading').hide();
            $('#modalContainer').modal('show');
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}

function ajaxDelete(filename, token, content) {
    content = typeof content !== 'undefined' ? content : 'workers';
    $('#loading').show();
    $.ajax({
        type: 'POST',
        data: {_method: 'DELETE', _token: token},
        url: filename,
        success: function (data) {
            $("#" + content).html(data);
            $('#loading').hide();
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}

// $(document).on('click', '.btn-call-modal', function () {
// });

$(document).on('click', '.pagination a.page-link', function (event) {
    event.preventDefault();
    ajaxLoad($(this).attr('href'));
});

$(document).on('submit', 'form#frm', function (event) {
    event.preventDefault();
    let form = $(this);
    let data = new FormData($(this)[0]);
    let url = form.attr("action");
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $('.is-invalid').removeClass('is-invalid');
            if (data.fail) {
                for (let control in data.errors) {
                    $('#' + control).addClass('is-invalid');
                    $('#error-' + control).html(data.errors[control]);
                }
            } else {
                ajaxLoad(data.redirect_url);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
    return false;
});

// validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        let forms = document.getElementsByClassName('needs-validation');
        if (forms.length > 0) {
            // Loop over them and prevent submission
            let validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }
    }, false);
})();

// call datepicker
$('.worker-form .input-date').datepicker({
    format: "dd.mm.yyyy",
    todayBtn: "linked",
    language: "ru"
});