</body>
<script src="../../assets/js/jquery.js"></script>
<script>
    $(document).ready(function() {

        $('#appointment').on('submit', function(e) {
            e.preventDefault();
            
            const date = $('#date').val();
            const time = $('#time').val();
            const app_type = $('select[name="app_type"]').val();

            $.ajax({
                url: '../../handlers/appointment.php',
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
                        alert(response.succes);
                        // Update the count on the page
                        let currentCount = parseInt($('.stat-value').text());
                        $('.stat-value').text(currentCount + 1);
                        my_modal_2.close();
                    }

                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error: ' + xhr.responseText);
                    alert('An error occurred while booking the appointment. Please try again.');
                }
            });
        });

        $('#profile_form').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '../../handlers/update_profile.php',
                method: 'POST',
                data: $(this).serialize() + "&update_profile=true",
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        alert(response.success);
                        profile_modal.close();
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error: ' + xhr.responseText);
                    alert('An error occurred while updating your profile. Please try again.');
                }
            });
        });

    });
</script>


</html>