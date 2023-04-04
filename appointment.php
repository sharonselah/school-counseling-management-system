<?php
session_start();


if (!isset($_SESSION['authenticated'])) {
    // User is not authenticated, redirect to login page
    header('Location: Login.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Sign Up Form</title>
</head>
<body>
    <div class="appointment">
        <form action="" method="post">


                <h2>Make an Appointment</h2>
                <p class="heading">Select a counselor</p>

 <div class="wrapper">

                <div class="input">
                    <input type="radio" name="select" id="counselor1"> 
                    <label for="counselor1">counselor 1</label>
                </div>


                <div class="input">
                    <input type="radio" name="select" id="counselor2">
                    <label for="counselor2">counselor 2</label>
                </div>

                <div class="input">
                    <input type="radio" name="select" id="counselor3">
                    <label for="counselor3">counselor 3</label>
                </div>

                <div class="input">
                    <input type="radio" name="select" id="counselor4">
                    <label for="counselor4">counselor 4</label>
                </div>  
</div>
<p>Select Date and Time (EAT)</p>
        

<div class="datetimewrapper">

        <div class="input-date">
            <input type="date" name="date" id="date" min="" max=""> <span><br>
            <p style="color: #800000;" id="result"></p>
            <div id="date-error"></div></span>
        </div>

   
    <div class="timewrapper">
        <div class="time">
            <input type="radio" name="select" id="time1">
            <div class="starttime">10:00 </div>
            <div class="endtime"> 11:00</div>
        </div>

        <div class="time">
            <input type="radio" name="select" id="time2">
            <div class="starttime">11:00 </div>
            <div class="endtime"> 12:00</div>
        </div>

        <div class="time">
            <input type="radio" name="select" id="time3">
            <div class="starttime">12:00 </div>
            <div class="endtime"> 13:00</div>
        </div>

        <div class="time">
            <input type="radio" name="select" id="time4">
            <div class="starttime">13:00 </div>
            <div class="endtime"> 14:00</div>
        </div>
       
    </div>


</div>

<div style="margin-left: calc((100% - 220px) / 2); margin-top: 10px;" class="button">
  <a href="">Book an Appointment</a>
</div>

              
        </form>
     </div>

     <script>

        

            var inputs = document.querySelectorAll(".input input[type='radio']");

            inputs.forEach(function(input) {
            input.addEventListener("click", function() {
                var parent = this.parentNode;
                var siblings = parent.parentNode.querySelectorAll(".input");
                siblings.forEach(function(sibling) {
                sibling.classList.remove("active");
                });
                if (this.checked) {
                parent.classList.add("active");
                }
            });
            });


 // Get all radio buttons
var radioButtons = document.querySelectorAll('.time input[type="radio"]');

// Add click event listener to each radio button
radioButtons.forEach(function(radioButton) {
  radioButton.addEventListener('click', function() {
    // Remove "selected" class from all time divs
    document.querySelectorAll('.time').forEach(function(timeDiv) {
      timeDiv.querySelector('.starttime').classList.remove('selected');
      timeDiv.querySelector('.endtime').classList.remove('selected');
    });

    // Add "selected" class to starttime and endtime divs of parent div of selected radio button
    var parentDiv = this.closest('.time');
    parentDiv.querySelector('.starttime').classList.add('selected');
    parentDiv.querySelector('.endtime').classList.add('selected');
  });
});



  // get the input element and error element
  const dateInput = document.getElementById('date');
  const dateError = document.getElementById('date-error');

  // set the minimum selectable date to today
  dateInput.min = new Date().toISOString().split('T')[0];

  // disable weekends and show error message
  const disableWeekends = function() {
    const selectedDate = new Date(dateInput.value);
    if (selectedDate.getDay() === 6) { // Saturday
      selectedDate.setDate(selectedDate.getDate() + 2);
      dateInput.value = selectedDate.toISOString().split('T')[0];
      dateError.innerHTML = 'Weekends are not selectable.';
    } else if (selectedDate.getDay() === 0) { // Sunday
      selectedDate.setDate(selectedDate.getDate() + 1);
      dateInput.value = selectedDate.toISOString().split('T')[0];
      dateError.innerHTML = 'Weekends are not selectable.';
    } else {
      dateError.innerHTML = '';
    }
  };
  dateInput.onload = disableWeekends;
  dateInput.onchange = disableWeekends;

  const result = document.getElementById('result'); 
  dateInput.addEventListener("change", function() {
  const date = new Date(this.value);
  const options = { weekday: 'long', month: 'long', day: 'numeric' };
  const formattedDate = date.toLocaleDateString('en-US', options);
  result.textContent = formattedDate;
});

     </script>
</body>
</html>

