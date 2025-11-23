</body>
<script src="../assets/js/jquery.js"></script>
<script>
    $(document).ready(function() {


        $('#signupForm').on('submit', function(e) {
            e.preventDefault();

            let email = $('#email').val().trim();
            let password = $('#password').val().trim();

            $.ajax({
                url: '../handlers/signup.php',
                type: 'POST',
                data: {
                    signup: true,
                    email: email,
                    password: password
                },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        alert(response.success);
                        $('#email').val('');
                        $('#password').val('');
                        $('#my_modal_1')[0].close();
                    }
                },
                error: function(xhr) {
                    console.log('AJAX error:', xhr.responseText);
                    alert('Something went wrong. Please try again.');
                }
            });
        });



        $('#signinForm').on('submit', function(e) {
            e.preventDefault();

            let email = $('#login_email').val().trim();
            let password = $('#login_password').val().trim();

            $.ajax({
                url: '../handlers/signin.php',
                type: "POST",
                data: {
                    signin: true,
                    email: email,
                    password: password
                },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        alert(response.success);
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        }
                    }
                },
                error: function(xhr) {
                    console.log('AJAX error:', xhr.responseText);
                }
            });
        });


    });
</script>

<script>
    function swapForm(type) {
        const signin = document.getElementById("signin_section");
        const signup = document.getElementById("signup_section");

        if (type === "signup") {
            signin.classList.add("hidden");
            signup.classList.remove("hidden");
        } else {
            signup.classList.add("hidden");
            signin.classList.remove("hidden");
        }
    }
</script>


</html>