 <!-- // Evin Camacho -->
  <html>
    <body>
        <h1> Test </h1>
  <form name='EvinCamacho' method='post' action='/test'>
    @csrf
            employeeID:<input type='text' name='employeeID'> </input>
                <br>
            companyID:<input type='text' name='companyID'> </input>
                <br>  
            position:<input type='text' name='position'> </input>
                <br>
             departmentID:<input type='text' name='departmentID'> </input>
                <br>
            First Name:<input type='text' name='firstName'> </input>
                <br>  
            Last Name:<input type='text' name='lastName'> </input>
                <br> 
             phone:<input type='text' name='phone'> </input>
                <br>
            email:<input type='text' name='email'> </input>
                <br>  
            User Name:<input type='text' name='username'> </input>
                <br>
            password:<input type='text' name='password'> </input>
                <br>  
            Base Salary:<input type='text' name='baseSalary'> </input>
            <br>
            Rate:<input type='text' name='rate' step="0.01"> </input>

        <button type='submit'>Create Employee</button>
<!-- employeeID, companyID, position, departmentID, firstName, lastName, phone, email, username, password, baseSalary, rate -->
</form>
</body>
</html>
