function base_url(uri)
{
    var baseUrl = $('input[name="base_url"]').val();
    return baseUrl + uri;
}

function removeFeedback()
{
    setTimeout(
        function(){
            $('#feedback').fadeOut(
                1000,
                function(){
                    $('#feedback').html('');
                    $('#feedback').removeClass('alert-success').removeClass('alert-danger');
                    $('#feedback').css('display', 'block');
                }
            );
        },
        3000
    );
}

function insertFeedback(message, type)
{
    $('#feedback').hide();
    if (type === "success") {
        $('#feedback').addClass('alert-success');
    } else if (type === "danger") {
        $('#feedback').addClass('alert-danger');
    }
    $('#feedback').html(message);
    $('#feedback').fadeIn(500);
}

function clearForm()
{
    $('#form-month-dateTime').trigger('reset');
}

function loadPointTable()
{
    $.ajax({
        url: base_url('point/loadMonthPointTable'),
        async: true,
        dataType: 'html',
        type: 'post'
    }).done(
        function(data)
        {
            console.log(data);
            
            $('#points-month').fadeIn(
                500,
                function()
                {
                    $(this).html(data);
                }
            );
        }
    ).fail(
        function()
        {
        }
    ).always(
        function()
        {
        }
    );
}

$(document).ready(
    function(){
        $('#form-month-dateTime').submit(
            function(event)
            {
                event.preventDefault();
                $('#points-month').fadeOut();
                var status = -1;
                var dataResponse;
                loadPointTable();
                $.ajax({
                    url: base_url('point/register'),
                    async: true,
                    dataType: 'json',
                    type: 'post',
                    data: $(this).serialize()
                }).done(
                    function(data)
                    {
                        console.log(data);
                        dataResponse = data;
                        if (data.response === false) {
                            status = 1;
                        } else {
                            status = 2;
                        }
                    }
                ).fail(
                    function()
                    {
                        status = 0;
                    }
                ).always(
                    function()
                    {
                        switch (status) {
                            case 0:
                                insertFeedback('Nossos servidores estão fora do ar. Por favor, tente mais tarde.', 'danger');
                                break;
                            case 1:
                                insertFeedback(dataResponse.message, 'danger');
                                break;
                            case 2:
                                insertFeedback(dataResponse.message, 'success');
                                clearForm();
                                break;
                        }
                        removeFeedback();
                        loadPointTable();
                    }
                );
            }
        );
    }
);