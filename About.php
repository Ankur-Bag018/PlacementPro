<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - PlacementPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="CSS/About.css" rel="stylesheet">
    <style>
        
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top bg-white">
        <div class="container">
            <a class="navbar-brand" href="index.php">PlacementPro</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="About.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="Help.php">Help</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <header class="hero">
        <div class="container">
            <h1>About PlacementPro</h1>
            <p class="lead mb-0"> A centralized, web-based platform bridging
                students and the college placement cell with secure access
                controls and dynamic tracking.(Its a bridge between Students and Placement cell)"</p>

        </div>
    </header>

    <!-- About Us -->
    <section class="section">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <h2 class="section-title">Who We Are</h2>
                    <p class="text-secondary">
                        PlacementPro makes job searching and recruitment seamless,
                        transparent, and effective. We believe everyone deserves a
                        career they love and every company deserves the right talent.
                    </p>
                    <p class="text-secondary mb-0">
                        Our platform connects skills with opportunities through
                        resume building, skill assessments, and recruiter communication.
                    </p>
                </div>

                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="feature-card text-center">
                                <h4>Our Mission</h4>
                                <p class="text-secondary mb-0">
                                    Empowering professionals with equal career opportunities.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-card text-center">
                                <h4>Our Vision</h4>
                                <p class="text-secondary mb-0">
                                    Becoming a trusted global talent acquisition platform.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQs -->
    <section class="section" style="background:#f4f7f6">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Help &amp; FAQs</h2>
                <p class="text-secondary">Answers to common PlacementPro questions.</p>
            </div>

            <div class="accordion col-lg-8 mx-auto" id="faq">
                <div class="accordion-item mb-3">
                    <h3 class="accordion-header">
                        <button class="accordion-button" data-bs-toggle="collapse"
                            data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                            How do I apply for a job?
                        </button>
                    </h3>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faq">
                        <div class="accordion-body">
                            Create your profile, upload your resume, browse job listings,
                            and click Apply on the job you want.
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3">
                    <h3 class="accordion-header">
                        <button class="accordion-button collapsed" data-bs-toggle="collapse"
                            data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                            Is PlacementPro free for job seekers?
                        </button>
                    </h3>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faq">
                        <div class="accordion-body">
                            Yes. Creating an account, browsing jobs, and applying are free
                            for job seekers.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h3 class="accordion-header">
                        <button class="accordion-button collapsed" data-bs-toggle="collapse"
                            data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                            How can employers post a job?
                        </button>
                    </h3>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faq">
                        <div class="accordion-body">
                            Employers can register for an employer account and, after
                            verification, post jobs and manage applications.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="contact-box">
                        <h4 class="mb-4">Contact Information</h4>
                        <h6>Office Address</h6>
                        <p>Em-4, Em4/1, EM Block, Sector V<br>Bidhannagar, Kolkata, West Bengal 700091</p>

                        <h6>Email Us</h6>
                        <p>support@placementpro.com<br>careers@placementpro.com</p>

                        <h6>Call Us</h6>
                        <p class="mb-0">+91 33 1234 5678<br>Mon–Fri, 9 AM–6 PM IST</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <h4>PlacementPro</h4>
            <p class="text-secondary">Connecting talent with opportunities .</p>
            <div class="mb-4">
                <a href="index.php" class="text-white text-decoration-none mx-2">Home</a> |
                <a href="About.php" class="text-white text-decoration-none mx-2">About</a> |
                <a href="Help.php" class="text-white text-decoration-none mx-2">Help</a>
            </div>
            <hr class="border-secondary">
            <small class="text-secondary">&copy; 2026 PlacementPro. All rights reserved.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>