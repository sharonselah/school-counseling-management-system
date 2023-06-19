<div style='width: 650px; height: 500px; border: 1px solid black; margin: auto; position: fixed; right: 30px; bottom: 10px;'>
    <canvas id="tutorial" width="550" height="400"></canvas>
</div>


<script>
  function draw(data) {
  const canvas = document.getElementById("tutorial");
  const ctx = canvas.getContext("2d");

  const barWidth = 80;
  const barSpacing = 20;
  const chartHeight = canvas.height - 100; // Adjusted for axis and title
  const chartWidth = canvas.width - 50; // Adjusted for axis and title
  const maxValue = Math.max(...data.map((item) => item.appointment_count));

  // Calculate the x-coordinate for each bar
  let x = 60; // Adjusted for axis and title
  const yBottom = canvas.height - 30; // Adjusted for axis and title
  const yTop = yBottom - chartHeight;

  // Draw Y-axis
  ctx.beginPath();
  ctx.strokeStyle = "lightgray";
  ctx.moveTo(x, yBottom);
  ctx.lineTo(x, yTop);
  ctx.stroke();

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
  ctx.fillText("Appointment Analysis Bar Chart", canvas.width / 2, 20);
}


fetch('canvas.php')
    .then(response => response.json())
    .then(data => draw(data));
</script>
