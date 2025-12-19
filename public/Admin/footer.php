<script src="../../assets/js/jquery.js"></script>
<script>
$(document).ready(function() {

    // Function to load dashboard counts
    function loadDashboardCounts() {
        $.ajax({
            url: '../../handlers/dashboard_count.php',
            method: 'GET',
            dataType: 'json',
            success: function(res) {
                // Update counts
                $('#approvedCount').text(res.approved || 0);
                $('#pendingCount').text(res.pending || 0);
                $('#doctorCount').text(res.doctors || 0);
                $('#totalAppointments').text(res.total || 0);
            },
            error: function(err) {
                console.error('Failed to fetch dashboard counts', err);
            }
        });
    }

    loadDashboardCounts();
});

    //logout confirmation
document.getElementById('logoutLink').addEventListener('click', function(e) {
    e.preventDefault();
    const proceed = confirm("Are you sure you want to log out?");
    if (proceed) {
       
        window.location.href = "../../handlers/logout.php";
    } else {
        
        alert("You chose to stay logged in.");
    }
});

function animateValue(obj, start, end, duration) {
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        obj.innerHTML = Math.floor(progress * (end - start) + start);
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}
</script>
