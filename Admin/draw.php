<div style='width: 650px; height: 450px; border: 1px solid black; margin: auto; position: fixed; right: 30px; bottom: 10px;'>
    <!-- Canvas - element used to draw graphics using JS -->
    <canvas id="chart_container" width="550" height="380"></canvas>
</div>


<script>
  function draw(data) {
    const canvas = document.getElementById("chart_container");

    //create a 2D rendering context
    const ctx = canvas.getContext("2d");

    const barWidth = 80;
    const barSpacing = 20;
    const chartHeight = canvas.height - 100; // Adjusted for axis and title (280)
    const chartWidth = canvas.width - 50; // Adjusted for axis and title (500)

    /*
    Get the maximum value of the appointment_count 
    Math.max () - in-built JS function
    ... - spread operator - expands an array into its elements
    map - creates a new array
    => arrow function takes the item and return its value of its 
    appointment_count

    */
    const maxValue = Math.max(...data.map((item) => item.appointment_count));

    // Calculate the x-coordinate for each bar
    let x = 60; // Adjusted for axis and title
    const yBottom = canvas.height - 30; // Adjusted for axis and title
    const yTop = yBottom - chartHeight;

  /* 
  
  Draw Y-axis
  beginPath - create a new path (method)
  strokeStyle - set color of the stroke (property)

  */
  ctx.beginPath();
  ctx.strokeStyle = "lightgray";
  ctx.moveTo(x, yBottom); //line starts here
  ctx.lineTo(x, yTop); //line goes here
  ctx.stroke(); //outline the current path

  // Draw X-axis
  ctx.beginPath();
  ctx.strokeStyle = "lightgray";
  ctx.moveTo(x, yBottom);
  ctx.lineTo(x + chartWidth, yBottom);
  ctx.stroke();

  // Draw Y-axis label
  ctx.fillStyle = "black";
  ctx.font = "bold 12px Arial";
  ctx.fillText("Count", 10, yTop + 200);

  // Draw X-axis labels
  ctx.font = "12px Arial";
  data.forEach((item) => {
    const barHeight = (item.appointment_count / maxValue) * chartHeight;
    const y = yBottom - barHeight;

    // Draw the bar
    ctx.fillStyle = "rgb(229,218,247)";
    ctx.fillRect(x, y, barWidth, barHeight);

    // Draw the label
    ctx.fillStyle = "black";
    ctx.fillText(item.status, x, yBottom + 15);

    x += barWidth + barSpacing;
  });

  // Draw the chart title
  ctx.fillStyle = "black";
  ctx.font = "bold 16px Arial";
  //text, x, y
  ctx.fillText("Appointment Analysis Bar Chart", canvas.width / 2, 20); 
}

/*

  The Fetch API is a modern interface that allows you to make 
  HTTP requests to servers from web browsers
  initiates an HTTP request to canvas.php. 
  fetch method returns a Promise so you use then to handle it
  You are sending a request - You need a response 
  read the response in json format 
  then pass the data as an argument in the draw function



*/

fetch('canvas.php')
    .then(response => response.json())
    .then(data => draw(data));
</script>
