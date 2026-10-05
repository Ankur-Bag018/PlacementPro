<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CooradinatorDasbord</title>
</head>
<style>
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
    }

    .navbar-brand {
        color: #4880e1 !important;
        font-size: 28px;
        font-weight: 800;
        letter-spacing: 1px;
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

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="About.php">PlacementPro</a>
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
            <a href="JOB_JobPost.php" class="portal-link">
                <div class="member" id="student">
                    <label>Post New job</label>
                    <div class="form-btn">Post Here</div>
                </div>
            </a>
           
            <a href="JOB_PostedJobs.php" class="portal-link">
                <div class="member" id="coordinator">
                    <label>Posted Jobs List</label>
                    <div class="form-btn">Show</div>
                </div>
            </a>
            
        </div>
    </main>



    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>