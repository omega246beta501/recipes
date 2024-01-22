<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>

    html {
        scroll-snap-type: x mandatory;
    }

    body {
      /* margin: 0; */
      overflow-x: auto;
      white-space: nowrap;
    }

    .section {
      width: 100vw; 
      height: 100vh; 
      display: inline-block; 
      box-sizing: border-box;
      vertical-align: top; 
      scroll-snap-align: start;
    }

    /* Add styling for each section if needed */
    .section:nth-child(1) {
      background-color: #f0f0f0;
    }

    .section:nth-child(2) {
      background-color: #e0e0e0;
    }
  </style>
</head>
<body>
  <div class="section">
    <!-- Content for the first section -->
    <h1>Section 1</h1>
    <p>Your content here.</p>
  </div>
  <div class="section">
    <!-- Content for the second section -->
    <h1>Section 2</h1>
    <p>Your content here.</p>
  </div>
</body>
</html>
