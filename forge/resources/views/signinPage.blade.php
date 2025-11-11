<html>
    <head>
        
    <style>
        body {
            background-color: #F5F9FF;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #ABC4FF;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        h1 {
            margin: 0;
            font-size: 32px;
        }

        .container {
            max-width: 900px;
            margin: 60px auto;
            background-color: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .formSection {
            display: flex;
            justify-content: space-between;
            gap: 40px;
            flex-wrap: wrap;
        }

        form {
            flex: 1;
            min-width: 300px;
            background-color: #F5F9FF;
            padding: 20px;
            border-radius: 12px;
            border: 2px solid #ABC4FF;
        }

        form h2 {
            text-align: center;
            color: #4849E8;
        }

        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #4849E8;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 16px;
            width: 100%;
        }

        button:hover {
            background-color: #3333cc;
        }

        .highlight {
            background-color: #DDF344;
            padding: 6px 12px;
            border-radius: 6px;
            color: #333;
        }

    </style>


</head>
<body>
 
<div class='container'>
<div class='formSection'>

    <form  method="post" action="{{ route('employee.login') }}">
        @csrf
    <h2>Employee Login</h2>
    User Name: <input type="text"  name="username" required>
    

    Password: <input type="password" name="password" required>
   

    <button type="submit">Login</button>
    </form>
<!-- Employee login
 
Admin Login -->

<form  method="post">
    <h2>Admin Login </h2>
    User Name: <input type="text"  name="adminID" required>
    <br>
    Password: <input type="password" name="password" required>
    <br>
    <button type="submit">Login</button>
    </form>

</div>
</div>
</body>
</html>