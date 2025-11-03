<!DOCTYPE html> 
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="eprofile.css">
    </head>

    <body>
   
    <p>Name: {{ $employee->firstName }} {{ $employee->lastName }}</p>
    <p>Position: {{ $employee->position}}</p>
    </body>
</html>