jQuery(document).ready(function($) {

    $('#ywr-submit').on('click', function(event) {
        event.preventDefault();
        
        $.ajax({
            url: ywrApiData.root + 'ywr-api/v1/email',
            method: 'POST',
            data: {
                post_id: $('#post_ID').val()
            },
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-WP-Nonce', ywrApiData.nonce);
            },
            success: function(response) {
                console.log(JSON.stringify(response, null, 2));
                // $('#post').submit();
            },
            error: function(error) {
                $('#ywr-api-response').html('<p>Error: ' + error.responseText + '</p>');
            }
        });

    });

});