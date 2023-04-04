<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
<div class="signupform">
        <form  action="Backend/counselorsignupmodel.php" method="post" >

                <p>Add New Counselor</p>
                <label for="name">Name</label> <br>
                <input type="text" name ="name" id ="name" autocomplete="off"> <br>
                <label for="speciality">Speciality</label> <br>
                <input type="text" name ="spec" id ="spec" autocomplete="off"> <br>
                <label for="email">Email</label> <br>
                <input type="text" name ="email" id ="email" autocomplete="off"> <br>
                <label for="password">Password</label><br>
                <input type="password" name ="password" id ="password"  autocomplete="off"> <br>
                
                <br>
                <button  type="submit" name="submit" id="button_signup">Add Counselor</button>

                <br>

                <p id="error_message">HEY</p>

              
        </form>
     </div>
</body>
</html>