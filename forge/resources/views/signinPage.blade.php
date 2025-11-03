<html>
<body>
    <h1>
        Welcome to Smart HR
</h1>

    <form  method="post" action="{{ route('employee.login') }}">
        @csrf
    User Name: <input type="text"  name="username" required>
    <br>
    Password: <input type="password" name="password" required>
    <br>
    <button type="submit">Login</button>
    </form>
<!-- Employee login
 
Admin Login -->

<form  method="post">
    User Name: <input type="text"  name="adminID" required>
    <br>
    Password: <input type="password" name="password" required>
    <br>
    <button type="submit">Login</button>
    </form>

</body>
</html>