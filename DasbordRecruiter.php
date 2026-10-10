
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coordinator Dashboard - PlacementPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root { --primary: #4880e1; }

        body {
            margin: 0;
            background: #f7f9fc;
            font-family: Arial, Helvetica, sans-serif;
        }

        .navbar {
            background: white;
            padding: 14px 20px;
            box-shadow: 0 3px 10px #00000014;
        }

        .navbar-brand {
            color: var(--primary);
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .nav-link { font-weight: 600; }
        .nav-link:hover { color: var(--primary); }

        .hero {
            min-height: 360px;
            display: grid;
            place-items: center;
            padding: 30px 20px;
            background: linear-gradient(#0007, #0007),
                url("https://media.istockphoto.com/id/2170561826/photo/modern-office-building-by-night-in-paris-france.jpg?b=1&s=612x612&w=0&k=20&c=Udc6TIgsUcIQsgAv8FLdXZIdS_hAjRqHMBvuJXcXyFI=")
                center/cover no-repeat;
        }

        .hero h1 {
            margin: 0;
            max-width: 95%;
            padding: 20px 30px;
            color: #222;
            background: #fffffff2;
            border-radius: 12px;
            text-align: center;
            font-size: clamp(1.6rem, 5vw, 3rem);
            font-weight: 700;
            box-shadow: 0 10px 30px #00000040;
        }

        .portal {
            display: block;
            height: 100%;
            padding: 35px 25px;
            color: inherit;
            text-align: center;
            text-decoration: none;
            background: white;
            border-top: 5px solid var(--primary);
            border-radius: 16px;
            box-shadow: 0 8px 25px #00000014;
            transition: .3s;
        }

        .portal:hover {
            transform: translateY(-7px);
            box-shadow: 0 15px 35px #4880e133;
        }

        .portal h2 {
            margin-bottom: 25px;
            color: #2c3e50;
            font-size: 20px;
            font-weight: 600;
        }

        .portal span {
            display: block;
            padding: 13px 20px;
            color: white;
            background: var(--primary);
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: background .3s;
        }

        .portal:hover span { background: #3566b8; }

        .portal:focus-visible {
            outline: 3px solid #244d96;
            outline-offset: 4px;
        }

        @media (max-width: 768px) {
            .navbar { padding: 12px 15px; }
            .navbar-brand { font-size: 24px; }
            .hero { min-height: 300px; }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">PlacementPro</a>

            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
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

    <!-- Header -->
    <header class="hero">
        <h1>Welcome to PlacementPro</h1>
    </header>

    <!-- Dashboard -->
    <main class="container py-5">
        <div class="row justify-content-center g-4">

            <div class="col-12 col-sm-6 col-md-5">
                <a href="PostedJobs.php" class="portal">
                    <h2>Posted Jobs List</h2>
                    <span>Show Posted Jobs</span>
                </a>
            </div>

            <div class="col-12 col-sm-6 col-md-5">
                <a href="ApplyCandidates.php" class="portal">
                    <h2>Applied Candidates List</h2>
                    <span>Show Candidates</span>
                </a>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
