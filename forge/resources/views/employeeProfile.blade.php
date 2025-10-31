<!DOCTYPE html> 
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/eprofile.css')}}">

        <title>Profile</title>
    </head>

    <body>
        <div class="profile-card">
            <div class="left-profile">
                <div class="profile-picture"></div>
            </div>
            <div class="right-profile">
                <h1>{{$employee->firstName}} {{$employee->lastName}}</h2>
                <h3>Company | {{$employee->company}}</h3>
                <h2>Department Position | {{$employee->department}} {{$employee->position}}</h2>
                <hr>
                <p>{{$employee->email}}</p>
                <p>{{$employee->phone}}</p>
            </div>
        </div>
        <div class="buttons">
            <button class="pushable">
            <span class="shadow"></span>
            <span class="edge"></span>
            <span class="front"> Attendence </span>
            </button>
            <button class="pushable">
            <span class="shadow"></span>
            <span class="edge"></span>
            <span class="front"> Vacation </span>
            </button><button class="pushable">
            <span class="shadow"></span>
            <span class="edge"></span>
            <span class="front"> Payroll </span>
            </button>
        </div>
    </body>
</html>