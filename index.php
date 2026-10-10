<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlacementPro</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   
    <style>
        /* Logo and Navbar Brand Adjustments */
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #fbfdff;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar Enhancements */
        .navbar {
            background-color: #ffffff !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 15px 20px;
            margin: 0px;
        }

        .navbar-brand {
            color: #4880e1 !important;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            font-size: 1.5rem; 
            font-weight: bold;
            margin-left: -70px;
        }

        .navbar-brand img {
            height: 70px; 
            width: 200px;  
            object-fit: contain;
            margin-left: 0px; 
            margin-top: 0px; 
            margin-bottom: 0px; 
        }

        .nav-link {
            font-weight: 500;
            color: #333 !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #4880e1 !important;
        }

        /* Hero / Introduction Section */
        .introduction {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 50vh;
            min-height: 400px;
            width: 100%;
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url("https://media.istockphoto.com/id/2170561826/photo/modern-office-building-by-night-in-paris-france.jpg?b=1&s=612x612&w=0&k=20&c=Udc6TIgsUcIQsgAv8FLdXZIdS_hAjRqHMBvuJXcXyFI=");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .introduction h1 {
            font-size: 3rem;
            color: #333;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 20px 40px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            font-weight: 700;
        }

        /* Main Content Layout (Role Cards) */
        main {
            flex-grow: 1;
            padding: 60px 20px 20px;
        }

        .main {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Reset Anchor Tag Styles for Cards */
        .portal-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        /* Individual Role Cards */
        .member {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            padding: 40px 30px;
            width: 100%;
            min-width: 280px;
            max-width: 320px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-top: 5px solid #4880e1;
            box-sizing: border-box;
        }

        .portal-link:hover .member {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(72, 128, 225, 0.15);
        }

        .member label {
            font-size: 22px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 25px;
            display: block;
            cursor: pointer;
        }

        /* Button Styling (Now configured for a DIV) */
        .form-btn {
            background-color: #4880e1;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
            transition: background-color 0.3s ease, transform 0.1s ease;
            display: inline-block;
            box-sizing: border-box;
        }

        .portal-link:hover .form-btn {
            background-color: #3566b8;
        }

        .portal-link:active .form-btn {
            transform: scale(0.98);
        }

        /* -------------------------------------
           Recruiter Companies Section with Logos
           ------------------------------------- */
        .companies-section {
            padding: 40px 20px 60px;
            text-align: center;
        }

        .companies-section h2 {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .companies-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .recruitercompany {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #ffffff;
            color: #5a6a7c;
            border: 1px solid #dcdfe3;
            padding: 10px 20px;
            border-radius: 50px; 
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
            cursor: default;
            user-select: none;
        }

        .recruitercompany img {
            width: 24px;
            height: 24px;
            object-fit: contain;
            border-radius: 4px;
        }

        .recruitercompany:hover {
            background-color: #f0f5fc;
            color: #4880e1;
            border-color: #4880e1;
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(72, 128, 225, 0.15);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .introduction h1 {
                font-size: 2rem;
                padding: 15px 25px;
            }
            .member {
                padding: 30px 20px;
            }
            .recruitercompany {
                font-size: 13px;
                padding: 8px 16px;
            }
            .recruitercompany img {
                width: 20px;
                height: 20px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="About.php">
                <!-- inline height="35" সরিয়ে CSS দিয়ে কন্ট্রোল করা হয়েছে -->
                <img src="Logo.jpeg" alt="PlacementPro Logo" class="d-inline-block align-text-center me-2">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="About.php">About</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Header Image -->
    <header>
        <div class="introduction">
            <h1>Welcome to PlacementPro</h1>
        </div>
    </header>

    <!-- Main Content for Job Sections -->
    <main>
        <div class="main">
            <!-- Student Card -->
            <a href="LoginStudent.php" class="portal-link">
                <div class="member" id="student">
                    <label>Student Portal</label>
                    <div class="form-btn">Login as Student</div>
                </div>
            </a>
            
            <!-- Placement Coordinator Card -->
            <a href="LoginCoordinator.php" class="portal-link">
                <div class="member" id="coordinator">
                    <label>Coordinator Portal</label>
                    <div class="form-btn">Login as Coordinator</div>
                </div>
            </a>
            
            <!-- Recruiter Card -->
            <a href="LoginRecruiter.php" class="portal-link">
                <div class="member" id="recruiter">
                    <label>Recruiter Portal</label>
                    <div class="form-btn">Login as Recruiter</div>
                </div>
            </a>
             <a href="LoginCollegeAdmin.php" class="portal-link">
                <div class="member" id="college-admin">
                    <label>College Management</label>
                    <div class="form-btn">Login as College Admin</div>
                </div>
            </a>
        </div>
    </main>

    <!-- Top Recruiters Section -->
    <section class="companies-section">
        <h2>Top Recruiting Companies</h2>
        <div class="companies-container">
            <div class="recruitercompany">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTFfrlAlMtOaBaRzkCLdfRX3D9aJ8b6lZDjmBBKTalLrw&s" alt="Google Logo">
                Google
            </div>
            <div class="recruitercompany">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQEJANb0XItp3xw1MB-dF4ccHxxCtgDc7auj-nAXlk-vw&s=10" alt="Microsoft Logo">
                Microsoft
            </div>
            <div class="recruitercompany">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQCPjeZ-FjJ-FHOMlVO9c1ZtEPo8ypuNnRN1uCMugVyyA&s=10" alt="Amazon Logo">
                Amazon
            </div>
            <div class="recruitercompany">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ8sK2gHxaFm7vD5xwy7Q1RtLRIvSbjXOvbXOvOgHgIyA&s=10" alt="Apple Logo">
                EY
            </div>
            <div class="recruitercompany">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS4lyiDe9X395obsB7Z3X89mtkBpOLX8izIWtcdyqmHZg&s=10" alt="Facebook Logo">
                Facebook
            </div>
            <div class="recruitercompany">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQkRw04I43_oNpC4HaklqpM7BbCRbTNgEZym5DEWANyrA&s=10" alt="Netflix Logo">
                Wipro
            </div>
            <div class="recruitercompany">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT3x-Xihii0MqNDSL0ASS7ZUp36dmpawKSZJHryuYQT6Q&s=10" alt="Twitter/X Logo">
                TCS
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <h4 class="mb-3">PlacementPro</h4>
            <p class="mb-2">Connecting top talent with top companies.</p>
            <div class="mb-3">
                <a href="#" class="text-white text-decoration-none mx-2">About Us</a> |
                <a href="#" class="text-white text-decoration-none mx-2">Privacy Policy</a> |
                <a href="#" class="text-white text-decoration-none mx-2">Contact</a>
            </div>
            <p class="mb-0 text-secondary">&copy; 2026 PlacementPro. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>