</body>
<script src="../../assets/js/jquery.js"></script>
<script>
    $(document).ready(function() {

        $('#appointment').on('click', function(e) {
            const userId = $(this).data['user-id'];
            const app_type = $(this).data['app-id'];
            const date = $('#date').val();
            const time = $('#time').val();

            console.log(date, time, app_type)

            $.ajax({
                url: '../../../handlers/appointment.php',
                method: 'POST',
                data: {
                    appointment: true,
                    date: date,
                    time: time,
                    app_type: app_type
                },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        alert(response.success);
                    }

                },
                error: function(xhr, response) {
                    console.log(xhr + response);

                }
            });
        });

    });
</script>


</html>