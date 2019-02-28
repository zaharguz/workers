window.ajaxLoad = function (filename, content) {
    content = typeof content !== 'undefined' ? content : '#workers';
    $('#loading').show();
    $.ajax({
        type: "GET",
        url: filename,
        contentType: false,
        success: function (data) {
            $(content).html(data);
            $('#loading').hide();
        },
        error: function (xhr) {
            alert(xhr.responseText);
        }
    });
};

window.ajaxLoadModal = function (filename, content) {
    ajaxLoad(filename, content);
    setTimeout(function () {
        // render select field
        $('.selectpicker').selectpicker('render');
        // call datepicker
        $('.worker-form .input-date').datepicker({
            format: "dd.mm.yyyy",
            todayBtn: "linked",
            language: "ru"
        });
        $('#modalContainer').modal('show');
    }, 300);
};

window.ajaxDelete = function(filename, token) {
    $('#loading').show();
    $.ajax({
        type: 'POST',
        data: {_method: 'DELETE', _token: token},
        url: filename,
        success: function (data) {
            $('#loading').hide();
            ajaxLoad(data.redirect_url);
        },
        error: function (xhr) {
            alert(xhr.responseText);
        }
    });
};

$(document).on('click', '.collapser', function () {
    $(this).toggleClass('collapsed').parent().next('.collapse').collapse('toggle');
});

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
                form.html('<div class="alert alert-success" role="alert">Сохранено</div>');
                setTimeout(function () {
                    if ($('#modalContainer').length > 0) {
                        ajaxLoad(window.location);
                        $('#modalContainer').modal('hide');
                    } else {
                        ajaxLoad(data.redirect_url);
                        window.location = data.redirect_url;
                    }
                }, 2000);
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

$(document).on('keyup', '.selectpicker-container .bs-searchbox input', function () {
    let search = $(this).val();
    let token = $('meta[name="csrf-token"]').attr('content');
    let route = $('.selectpicker-container #find_worker').val();
    if (search.length > 1) {
        $.ajax({
            type: "POST",
            url: route,
            data: {_token: token, search: search},
            dataType: 'JSON',
            success: function (data) {
                let options = '<option value="0">- Отсутствует -</option>';
                $.each(JSON.parse(data), function(key, value) {
                   options += '<option value=' + key + '>' + value + '</option>';
                });
                $('.selectpicker').html(options).selectpicker('refresh');
            },
            error: function (xhr) {
                alert(xhr.responseText);
            }
        });
    }
});

$(document).ready(function () {
    // call datepicker
    $('.worker-form .input-date').datepicker({
        format: "dd.mm.yyyy",
        todayBtn: "linked",
        language: "ru"
    });
});