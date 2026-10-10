
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PlacementPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root { --primary: #4880e1; }

        body {
            margin: 0;
            background: #fbfdff;
            font-family: "Segoe UI", sans-serif;
        }

        .navbar {
            background: white;
            box-shadow: 0 4px 6px #0000000d;
        }

        .navbar-brand {
            color: var(--primary);
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .nav-link:hover { color: var(--primary); }

        .hero {
            min-height: 400px;
            display: grid;
            place-items: center;
            padding: 40px 15px;
            background: linear-gradient(#0006, #0006),
                url("https://media.istockphoto.com/id/2170561826/photo/modern-office-building-by-night-in-paris-france.jpg?b=1&s=612x612&w=0&k=20&c=Udc6TIgsUcIQsgAv8FLdXZIdS_hAjRqHMBvuJXcXyFI=")
                center/cover no-repeat;
        }

        .hero h1 {
            padding: 20px 30px;
            background: #fffffff2;
            color: #333;
            border-radius: 12px;
            text-align: center;
            font-size: clamp(1.8rem, 5vw, 3rem);
            font-weight: 700;
            box-shadow: 0 10px 30px #0003;
        }

        .portal {
            display: block;
            height: 100%;
            padding: 30px 20px;
            color: inherit;
            text-align: center;
            text-decoration: none;
            background: white;
            border-top: 5px solid var(--primary);
            border-radius: 16px;
            box-shadow: 0 8px 20px #00000014;
            transition: .3s;
        }

        .portal:hover {
            transform: translateY(-7px);
            box-shadow: 0 15px 30px #4880e126;
        }

        .portal h2 {
            font-size: 21px;
            font-weight: 600;
            margin-bottom: 22px;
        }

        .portal span {
            display: block;
            padding: 12px;
            color: white;
            background: var(--primary);
            border-radius: 8px;
            font-weight: 600;
        }

        .portal:hover span { background: #3566b8; }

        .portal:focus-visible {
            outline: 3px solid #244d96;
            outline-offset: 4px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">PlacementPro</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
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

    <!-- Hero -->
    <header class="hero">
        <h1>Welcome to PlacementPro</h1>
    </header>

    <!-- Data Entry Portals -->
    <main class="container py-5">
        <div class="row g-4 justify-content-center">

            <div class="col-12 col-sm-6 col-lg-3">
                <a class="portal" href="DB_DataEntryStudent.php">
                    <h2>Student Data Entry</h2>
                    <span>Enter Student Data</span>
                </a>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <a class="portal" href="DB_DataEntryRecruter.php">
                    <h2>Recruiter Data Entry</h2>
                    <span>Enter Recruiter Data</span>
                </a>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <a class="portal" href="DB_DataEntryCoordinator.php">
                    <h2>Coordinator Data Entry</h2>
                    <span>Enter Coordinator Data</span>
                </a>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <a class="portal" href="DB_DataEntryCollegeAdmin.php">
                    <h2>College Admin Data Entry</h2>
                    <span>Enter College Admin Data</span>
                </a>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
