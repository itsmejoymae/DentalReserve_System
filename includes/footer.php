</body>
<script src="../assets/js/jquery.js"></script>
<script>
    $(document).ready(function () {


        $('#signupForm').on('submit', function (e) {
            e.preventDefault();

            var email = $('#email').val();
            var password = $('#password').val();

            $.ajax({
                url: '../handlers/signup.php',
                type: 'POST',
                data: {
                    signup: true,
                    email: email,
                    password: password
                
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert(response.success);

                        $('#signupForm')[0].reset();

                        swapForm('login');

                    } else {
                        alert(response.error);
                    }
                },
                error: function (xhr) {
                    console.log('AJAX error:', xhr.responseText);
                    alert('Something went wrong. Please try again.');
                }
            });
        });



        $('#signinForm').on('submit', function (e) {
            e.preventDefault();

            const email = $('#login_email').val().trim();
            const password = $('#login_password').val().trim();

            $.ajax({
                url: '../handlers/login.php',
                type: "POST",
                data: {
                    login: true,
                    email: email,
                    password: password
                },
                dataType: 'json',
                success: function (response) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else {
                        alert(response.success);

                    }
                },
                error: function (xhr) {
                    console.log('AJAX error:', xhr.responseText);
                }
            });
        });


    });
</script>

<script>
    $(document).ready(function () {
        const modal = document.getElementById("modal");

        if (modal) {
            modal.showModal();
        }
    });

    function swapForm(type) {
        const login = document.getElementById("loginPanel");
        const signup = document.getElementById("signupPanel");

        if (type === "signup") {
            login.classList.add("hidden");
            signup.classList.remove("hidden");
        } else {
            signup.classList.add("hidden");
            login.classList.remove("hidden");
        }
    }
</script>


</html>