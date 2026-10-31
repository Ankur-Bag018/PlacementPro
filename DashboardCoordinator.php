<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coordinator Dashboard - PlacementPro</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Connected Common CSS -->
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
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
                    <!-- Added Back to Index Link Here -->
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            &larr; Back
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="About.php">About</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <h1>Welcome to PlacementPro</h1>
    </header>

    <!-- Job Management -->
    <main class="container py-5">
        <div class="row justify-content-center g-4">

            <div class="col-12 col-sm-6 col-md-5">
                <a href="UplodeJobs.php" class="portal">
                    <h2>Post New Job</h2>
                    <span>Post Here</span>
                </a>
            </div>

            <div class="col-12 col-sm-6 col-md-5">
                <a href="Applicantlist.php" class="portal">
                    <h2>Jobs & Applicants List</h2>
                    <span>Show Jobs & Applicants</span>
                </a>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>