<!-- // Evin Camacho -->
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Create Employee - SmartHR</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <style>
            :root {
                --primary-blue: #4849E8;
                --light-blue: #ABC4FF;
                --accent-yellow: #DDF344;
                --bg-white: #F5F9FF;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, var(--bg-white) 0%, var(--light-blue) 100%);
                min-height: 100vh;
                overflow-x: hidden;
                position: relative;
                padding: 40px 16px;
            }

            /* Animated Background Shapes */
            .shape {
                position: fixed;
                border-radius: 50%;
                filter: blur(60px);
                opacity: 0.4;
                z-index: 0;
                animation: float 22s infinite ease-in-out;
            }

            .shape1 {
                width: 450px;
                height: 450px;
                background: var(--primary-blue);
                top: -100px;
                left: -100px;
                animation-delay: 0s;
            }

            .shape2 {
                width: 350px;
                height: 350px;
                background: var(--accent-yellow);
                bottom: -100px;
                right: -100px;
                animation-delay: 7s;
            }

            .shape3 {
                width: 400px;
                height: 400px;
                background: var(--light-blue);
                top: 50%;
                right: -150px;
                animation-delay: 14s;
            }

            @keyframes float {
                0%, 100% { transform: translate(0, 0) rotate(0deg); }
                25% { transform: translate(30px, -30px) rotate(90deg); }
                50% { transform: translate(-20px, 20px) rotate(180deg); }
                75% { transform: translate(40px, 10px) rotate(270deg); }
            }

            /* Particles */
            .particle {
                position: fixed;
                width: 4px;
                height: 4px;
                background: var(--primary-blue);
                border-radius: 50%;
                opacity: 0.3;
                z-index: 0;
                animation: floatParticle 15s infinite ease-in-out;
            }

            @keyframes floatParticle {
                0%, 100% { transform: translateY(0) translateX(0); }
                50% { transform: translateY(-100px) translateX(50px); }
            }

            .container {
                max-width: 900px;
                margin: 0 auto;
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(20px);
                border-radius: 30px;
                box-shadow: 0 20px 60px rgba(72, 73, 232, 0.2);
                overflow: hidden;
                position: relative;
                z-index: 1;
                border: 1px solid rgba(255, 255, 255, 0.5);
                animation: slideUp 0.6s ease-out;
            }

            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .container::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(221, 227, 68, 0.1), transparent);
                animation: shimmer 3s infinite;
                z-index: 0;
            }

            @keyframes shimmer {
                0% { left: -100%; }
                100% { left: 100%; }
            }

            .header {
                background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
                color: white;
                padding: 30px;
                text-align: center;
                position: relative;
                z-index: 1;
            }

            .header h1 {
                margin: 0;
                font-size: 1.8rem;
                font-weight: 700;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 12px;
            }

            .header i {
                font-size: 2rem;
            }

            form {
                padding: 40px;
                position: relative;
                z-index: 1;
            }

            .form-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 25px;
                margin-bottom: 30px;
            }

            .form-field {
                display: flex;
                flex-direction: column;
                gap: 8px;
                animation: fieldFadeIn 0.5s ease-out backwards;
            }

            .form-field:nth-child(1) { animation-delay: 0.1s; }
            .form-field:nth-child(2) { animation-delay: 0.15s; }
            .form-field:nth-child(3) { animation-delay: 0.2s; }
            .form-field:nth-child(4) { animation-delay: 0.25s; }
            .form-field:nth-child(5) { animation-delay: 0.3s; }
            .form-field:nth-child(6) { animation-delay: 0.35s; }
            .form-field:nth-child(7) { animation-delay: 0.4s; }
            .form-field:nth-child(8) { animation-delay: 0.45s; }
            .form-field:nth-child(9) { animation-delay: 0.5s; }
            .form-field:nth-child(10) { animation-delay: 0.55s; }
            .form-field:nth-child(11) { animation-delay: 0.6s; }
            .form-field:nth-child(12) { animation-delay: 0.65s; }

            @keyframes fieldFadeIn {
                from {
                    opacity: 0;
                    transform: translateX(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            .form-field label {
                color: var(--primary-blue);
                font-weight: 700;
                font-size: 0.95rem;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .form-field label i {
                font-size: 1.1rem;
            }

            .form-field input {
                padding: 14px 18px;
                border-radius: 15px;
                border: 2px solid rgba(72, 73, 232, 0.2);
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(5px);
                outline: none;
                font-size: 1rem;
                transition: all 0.3s ease;
                font-family: inherit;
            }

            .form-field input:focus {
                border-color: var(--primary-blue);
                box-shadow: 0 0 0 4px rgba(72, 73, 232, 0.1);
                transform: translateY(-2px);
                background: rgba(255, 255, 255, 0.95);
            }

            .form-field input[readonly] {
                background: rgba(171, 196, 255, 0.2);
                cursor: not-allowed;
                border-color: rgba(72, 73, 232, 0.15);
            }

            .actions {
                padding: 0 40px 40px 40px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 20px;
                position: relative;
                z-index: 1;
                flex-wrap: wrap;
            }

            .back-btn {
                background: rgba(72, 73, 232, 0.1);
                border: 2px solid var(--primary-blue);
                color: var(--primary-blue);
                text-decoration: none;
                padding: 15px 30px;
                border-radius: 15px;
                font-weight: 700;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                transition: all 0.3s ease;
            }

            .back-btn:hover {
                background: var(--primary-blue);
                color: white;
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(72, 73, 232, 0.3);
            }

            button[type="submit"] {
                background: linear-gradient(135deg, var(--accent-yellow), rgba(221, 227, 68, 0.8));
                color: var(--primary-blue);
                border: none;
                padding: 15px 40px;
                border-radius: 15px;
                font-weight: 700;
                font-size: 1.1rem;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 8px 20px rgba(221, 227, 68, 0.3);
                display: inline-flex;
                align-items: center;
                gap: 10px;
                position: relative;
                overflow: hidden;
            }

            button[type="submit"]::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 0;
                height: 0;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.4);
                transform: translate(-50%, -50%);
                transition: width 0.6s, height 0.6s;
            }

            button[type="submit"]:hover::before {
                width: 300px;
                height: 300px;
            }

            button[type="submit"]:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 30px rgba(221, 227, 68, 0.4);
            }

            button[type="submit"]:active {
                transform: translateY(-2px);
            }

            .note {
                color: var(--light-blue);
                font-size: 0.85rem;
                font-weight: 600;
                background: rgba(171, 196, 255, 0.2);
                padding: 10px 15px;
                border-radius: 10px;
                border: 1px solid rgba(72, 73, 232, 0.1);
            }

            @media (max-width: 768px) {
                .form-grid {
                    grid-template-columns: 1fr;
                }

                .actions {
                    flex-direction: column;
                    align-items: stretch;
                }

                .back-btn, button[type="submit"] {
                    width: 100%;
                    justify-content: center;
                }

                .note {
                    text-align: center;
                }
            }
        </style>
    </head>
    <body>
        <!-- Animated Background Shapes -->
        <div class="shape shape1"></div>
        <div class="shape shape2"></div>
        <div class="shape shape3"></div>

        <!-- Particles -->
        <script>
            for (let i = 0; i < 15; i++) {
                let particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 15 + 's';
                particle.style.animationDuration = (15 + Math.random() * 10) + 's';
                document.body.appendChild(particle);
            }
        </script>
        <div class="container">
            <div class="header">
                <h1><i class="bi bi-person-plus-fill"></i> Create Employee</h1>
            </div>

            <form name="EvinCamacho" method="post" action="/test">
                @csrf

                <div class="form-grid">
                    <div class="form-field">
                        <label for="employeeID"><i class="bi bi-hash"></i> Employee ID</label>
                        <input id="employeeID" type="text" name="employeeID" value="{{ $nextEmployeeID }}" readonly />
                    </div>

                    <div class="form-field">
                        <label for="companyID"><i class="bi bi-building"></i> Company ID</label>
                        <input id="companyID" type="text" name="companyID" />
                    </div>

                    <div class="form-field">
                        <label for="position"><i class="bi bi-briefcase"></i> Position</label>
                        <input id="position" type="text" name="position" />
                    </div>

                    <div class="form-field">
                        <label for="departmentID"><i class="bi bi-diagram-3"></i> Department ID</label>
                        <input id="departmentID" type="text" name="departmentID" />
                    </div>

                    <div class="form-field">
                        <label for="firstName"><i class="bi bi-person"></i> First Name</label>
                        <input id="firstName" type="text" name="firstName" />
                    </div>

                    <div class="form-field">
                        <label for="lastName"><i class="bi bi-person"></i> Last Name</label>
                        <input id="lastName" type="text" name="lastName" />
                    </div>

                    <div class="form-field">
                        <label for="phone"><i class="bi bi-telephone"></i> Phone</label>
                        <input id="phone" type="text" name="phone" />
                    </div>

                    <div class="form-field">
                        <label for="email"><i class="bi bi-envelope"></i> Email</label>
                        <input id="email" type="email" name="email" />
                    </div>

                    <div class="form-field">
                        <label for="username"><i class="bi bi-person-badge"></i> User Name</label>
                        <input id="username" type="text" name="username" />
                    </div>

                    <div class="form-field">
                        <label for="password"><i class="bi bi-lock"></i> Password</label>
                        <input id="password" type="password" name="password" />
                    </div>

                    <div class="form-field">
                        <label for="baseSalary"><i class="bi bi-cash"></i> Base Salary</label>
                        <input id="baseSalary" type="text" name="baseSalary" />
                    </div>

                    <div class="form-field">
                        <label for="rate"><i class="bi bi-percent"></i> Rate</label>
                        <input id="rate" type="text" name="rate" />
                    </div>
                </div>
            </form>

            <div class="actions">
                <a href="{{ route('admin.employeeList') }}" class="back-btn">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
                <button type="submit" form="EvinCamacho">
                    <i class="bi bi-check-circle"></i> Create Employee
                </button>
            </div>
        </div>
    </body>
</html>