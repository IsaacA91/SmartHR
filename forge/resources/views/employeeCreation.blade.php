<!-- // Evin Camacho -->
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Create Employee</title>
        <style>
            :root {
                --bg: #F5F9FF; /* very light */
                --light-blue: #ABC4FF;
                --lime: #DDF344;
                --deep-blue: #4849E8;
                --muted: #6b6b6b;
                --card: #ffffff;
            }

            body {
                font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
                background: linear-gradient(180deg, var(--bg), #ffffff);
                color: #111827;
                margin: 0;
                padding: 40px 16px;
            }

            .container {
                max-width: 760px;
                margin: 0 auto;
                background: var(--card);
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(72,73,232,0.08);
                overflow: hidden;
            }

            .header {
                background: var(--deep-blue);
                color: white;
                padding: 18px 20px;
                text-align: center;
            }

            h1 { margin: 0; font-size: 1.25rem; letter-spacing: 0.6px; }

            form { padding: 20px; }

            .form-row { display: flex; gap: 12px; align-items: center; margin-bottom: 12px; }
            .form-row label { min-width: 140px; color: var(--muted); font-weight: 600; }
            .form-row input[type="text"], .form-row input[type="email"], .form-row input[type="password"] {
                flex: 1;
                padding: 10px 12px;
                border-radius: 8px;
                border: 1px solid rgba(72,73,232,0.08);
                background: var(--bg);
                outline: none;
                font-size: 0.95rem;
            }

            .actions { padding: 0 20px 24px 20px; display:flex; justify-content: space-between; align-items: center; gap:12px; }
            .note { color: var(--muted); font-size: 0.9rem; }
            button { background: var(--lime); color: var(--deep-blue); border: none; padding: 10px 16px; border-radius: 8px; font-weight: 700; cursor: pointer; }
            button:hover { filter: brightness(.98); transform: translateY(-1px); }

            @media (max-width:640px){ .form-row { flex-direction: column; align-items: stretch; } .form-row label { min-width: unset; } }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Create Employee</h1>
            </div>

            <form name="EvinCamacho" method="post" action="/test">
                @csrf

                <div class="form-row">
                    <label for="employeeID">Employee ID</label>
                    <input id="employeeID" type="text" name="employeeID" />
                </div>

                <div class="form-row">
                    <label for="companyID">Company ID</label>
                    <input id="companyID" type="text" name="companyID" />
                </div>

                <div class="form-row">
                    <label for="position">Position</label>
                    <input id="position" type="text" name="position" />
                </div>

                <div class="form-row">
                    <label for="departmentID">Department ID</label>
                    <input id="departmentID" type="text" name="departmentID" />
                </div>

                <div class="form-row">
                    <label for="firstName">First Name</label>
                    <input id="firstName" type="text" name="firstName" />
                </div>

                <div class="form-row">
                    <label for="lastName">Last Name</label>
                    <input id="lastName" type="text" name="lastName" />
                </div>

                <div class="form-row">
                    <label for="phone">Phone</label>
                    <input id="phone" type="text" name="phone" />
                </div>

                <div class="form-row">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" />
                </div>

                <div class="form-row">
                    <label for="username">User Name</label>
                    <input id="username" type="text" name="username" />
                </div>

                <div class="form-row">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" />
                </div>

                <div class="form-row">
                    <label for="baseSalary">Base Salary</label>
                    <input id="baseSalary" type="text" name="baseSalary" />
                </div>

                <div class="form-row">
                    <label for="rate">Rate</label>
                    <input id="rate" type="text" name="rate" />
                </div>

                <div class="actions">
                    <div class="note">Fields: employeeID, companyID, position, departmentID, firstName, lastName, phone, email, username, password, baseSalary, rate</div>
                    <button type="submit">Create Employee</button>
                </div>
            </form>
        </div>
    </body>
</html>