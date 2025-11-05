<html>
    <body>
<h1>
    Edit an employee
</h1>
<form method="post" action='/editEmployee'>
    @csrf
            employeeID: <input type="text" name="employeeID" required><br>

            position:<input type='text' name='position'> </input>
                <br>
            First Name:<input type='text' name='firstName'> </input>
                <br>  
            Last Name:<input type='text' name='lastName'> </input>
                <br> 
            email:<input type='text' name='email'> </input>
                <br>  
                <button type='submit'>Zombie </button>
</form >
</body>
</html>