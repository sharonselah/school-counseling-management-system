<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Document</title>
</head>
<body>
        <div class="header-dashboard">

        <div class="logo">
            CUEA Counseling
        </div>

        <div class="search">
            <input type="text" placeholder="Search...">
            <button>Search</button>
        </div>

        <div class="personal-info">
            <h2>Welcome, <?php  echo $_SESSION["name"]; ?></h2>
        </div>
        </div>
</body>
</html>

