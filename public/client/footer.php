<script src="../../assets/js/jquery.js"></script>
<script>
$(document).ready(function() {

  // ----------------------------
  // Calendar Setup
  // ----------------------------
const today = new Date();
let selectedDate = null;
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();

// Time slots
const businessDaySlots = ['09:00 AM','10:00 AM','11:00 AM','01:00 PM','02:00 PM','03:00 PM','04:00 PM'];
const weekendSlots = ['09:00 AM','10:00 AM','11:00 AM','01:00 PM','02:00 PM','03:00 PM'];

function renderCalendar(month = currentMonth, year = currentYear) {
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const firstDay = new Date(year, month, 1).getDay(); // 0=Sun

    $('#currentMonth').text(new Intl.DateTimeFormat('en-US', { month: 'long', year: 'numeric'}).format(new Date(year, month)));

    let calendarHtml = '';

    // Weekday headers
    const weekdays = ['Su','Mo','Tu','We','Th','Fr','Sa'];
    weekdays.forEach(day => calendarHtml += `<div class="font-medium">${day}</div>`);

    // Empty slots
    for (let i=0; i<firstDay; i++) calendarHtml += '<div></div>';

    for (let d=1; d<=daysInMonth; d++){
        const dateObj = new Date(year, month, d);
        const dateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        const disabled = dateObj < new Date(today.setHours(0,0,0,0)) 
            ? 'opacity-40 cursor-not-allowed' 
            : 'cursor-pointer hover:bg-sky-200';

        calendarHtml += `<div class="p-2 border rounded ${disabled}" data-date="${dateStr}" data-day="${dateObj.getDay()}">${d}</div>`;
    }

    $('#calendar_container').html(calendarHtml);
}

// Time slots
function renderTimeSlots(dateStr){
    const dateObj = new Date(dateStr);
    const day = dateObj.getDay();
    const slots = (day === 6 || day === 5) ? weekendSlots : businessDaySlots;

    let html = '';
    slots.forEach(time => html += `<button type="button" class="time-slot btn btn-outline btn-sm w-full mb-1" data-time="${time}">${time}</button>`);
    $('#time_slots').html(html);
    $('#selected_time').val('');
}

// Initialize
renderCalendar();

// -----------------
// Navigation
// -----------------
$('#prevMonth').on('click', function(e){
    e.preventDefault();
    currentMonth--;
    if(currentMonth < 0){ currentMonth = 11; currentYear--; }
    renderCalendar(currentMonth, currentYear);
});

$('#nextMonth').on('click', function(e){
    e.preventDefault();
    currentMonth++;
    if(currentMonth > 11){ currentMonth = 0; currentYear++; }
    renderCalendar(currentMonth, currentYear);
});

$('#today-btn').on('click', function(e){
    e.preventDefault();
    const todayMonth = today.getMonth();
    const todayYear = today.getFullYear();
    currentMonth = todayMonth;
    currentYear = todayYear;
    renderCalendar(todayMonth, todayYear);
});

// -----------------
// Calendar click
// -----------------
$('#calendar_container').on('click', '[data-date]', function () {
    if ($(this).hasClass('opacity-40')) return;

    $('#calendar_container [data-date]').removeClass('bg-sky-500 text-white');
    $(this).addClass('bg-sky-500 text-white');

    selectedDate = $(this).data('date');
    $('#selected_date').val(selectedDate);
    renderTimeSlots(selectedDate);
});

// -----------------
// Time slot click
// -----------------
$('#time_slots').on('click', '.time-slot', function () {
    $('#time_slots .time-slot').removeClass('btn-primary').addClass('btn-outline');
    $(this).removeClass('btn-outline').addClass('btn-primary');
    $('#selected_time').val($(this).data('time'));
});

// -----------------
// Save appointment AJAX (unchanged)
// -----------------
$('#save_appointment').on('click', function(e) {
    e.preventDefault();

    const date = $('#selected_date').val();
    const time = $('#selected_time').val();
    const app_type = $('#app_type').val();

    if(!date || !time || !app_type){
        alert('Please select a date, time, and service.');
        return;
    }

    $.ajax({
        url: '../../handlers/c_appointment.php',
        method: 'POST',
        data: { appointment: true, date, time, app_type },
        dataType: 'json',
        success: function(res) {
            if(res.error){
                alert(res.error);
            } else if(res.success){
                alert(res.success);
                app_modal.close();
                $('#appointment')[0].reset();
                $('#calendar_container [data-date]').removeClass('bg-sky-500 text-white');
                $('#time_slots').empty();
            }
        },
        error: function(xhr){
            console.log('AJAX Error: ' + xhr.responseText);
            alert('An error occurred while booking the appointment.');
        }
    });
});


  // ----------------------------
  // Profile Load & Update
  // ----------------------------
  function loadProfile() {
    $.ajax({
      url: '../../handlers/c_viewProfile.php',
      type: 'POST',
      data: { view: true, user_id: <?php echo (int)$_SESSION['id']; ?> },
      dataType: 'json',
      success: function(res) {
        if(res.success){
          let data = res.data;
          $('#view_img').attr('src','../../Uploads/Client/' + (data.img || 'default.jpg'));
          $('#first_name_view').val(data.first_name || '');
          $('#middle_name_view').val(data.middle_name || '');
          $('#last_name_view').val(data.last_name || '');
          $('#gender_view').val(data.gender || '');
          $('#contact_view').val(data.contact || '');
          $('#address_view').val(data.address || '');

          $('#first_name').val(data.first_name || '');
          $('#middle_name').val(data.middle_name || '');
          $('#last_name').val(data.last_name || '');
          $('#gender').val(data.gender || '');
          $('#contact').val(data.contact || '');
          $('#address').val(data.address || '');
          $('#profile_img_preview').attr('src','../../Uploads/Client/' + (data.img || 'default.jpg'));
          $('#profile_image').attr('src', '../../Uploads/Client/' + (data.img || 'default.jpg'));
        }
      },
      error: function(xhr){
        console.error('AJAX error (viewProfile):', xhr.responseText);
      }
    });
  }

  loadProfile();

  $('#profile_img_input').on('change', function() {
    const file = this.files[0];
    if(file){
      const reader = new FileReader();
      reader.onload = e => $('#profile_img_preview').attr('src', e.target.result);
      reader.readAsDataURL(file);
    }
  });

  $('#updateProfileForm').on('submit', function(e){
    e.preventDefault();
    let formData = new FormData(this);
    formData.append('c_update', true);

    $.ajax({
      url:'../../handlers/c_updateProfile.php',
      type:'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType:'json',
      success:function(res){
        if(res.success){
          alert(res.success);
          loadProfile();
          prof_modal.close();
        } else {
          alert(res.error);
        }
      },
      error:function(xhr){
        console.error(xhr.responseText);
        alert('Error updating profile.');
      }
    });
  });

});
</script>
