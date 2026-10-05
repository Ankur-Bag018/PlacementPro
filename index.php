<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlacementPro</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="index.css" rel="stylesheet">
    <style>
        /* Logo and Navbar Brand Adjustments */
        
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