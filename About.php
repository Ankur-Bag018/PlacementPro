
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - PlacementPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #689ae6;
            --dark: #4a7abf;
            --light: #fbfdff;
        }

        body {
            margin: 0;
            background: var(--light);
            font-family: "Segoe UI", Tahoma, sans-serif;
        }

        .navbar { box-shadow: 0 2px 10px #0000000d; }
        .navbar-brand, .nav-link.active { color: var(--primary) !important; }
        .navbar-brand { font-size: 28px; font-weight: bold; }

        .hero {
            padding: 90px 20px;
            color: white;
            text-align: center;
            background: linear-gradient(#689ae6d9, #4a7abfe6),
                url("https://images.pexels.com/photos/3184291/pexels-photo-3184291.jpeg")
                center/cover no-repeat;
        }

        .hero h1 { font-size: clamp(2rem, 5vw, 3rem); font-weight: bold; }
        .section { padding: 65px 0; }
        .section-title { color: var(--dark); font-weight: bold; margin-bottom: 25px; }

        .feature-card {
            height: 100%;
            padding: 25px;
            background: white;
            border-top: 4px solid var(--primary);
            border-radius: 10px;
            box-shadow: 0 5px 15px #0000000d;
            transition: .3s;
        }

        .feature-card:hover { transform: translateY(-5px); }
        .feature-card h4 { color: var(--dark); }

        .accordion-button:not(.collapsed) {
            color: var(--dark);
            background: #e9f2ff;
        }

        .accordion-button:focus, .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 .2rem #689ae640;
        }

        .btn-primary { background: var(--primary); border: 0; }
        .btn-primary:hover { background: var(--dark); }

        .contact-box {
            height: 100%;
            padding: 30px;
            color: white;
            background: var(--primary);
            border-radius: 10px;
        }

        footer { padding: 35px 0 20px; background: #212529; color: white; }
        footer a:hover { opacity: .7; }

        @media (max-width: 576px) {
            .section { padding: 45px 0; }
            .hero { padding: 65px 15px; }
        }
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
            <p class="lead mb-0">Bridging the gap between talented people and leading companies worldwide.</p>
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
                <div class="col-lg-7">
                    <h2 class="section-title">Get in Touch</h2>
                    <p class="text-secondary">Have questions? Send us a message.</p>

                    <form method="post" action="">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input class="form-control" id="name" name="name"
                                    type="text" placeholder="Your name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input class="form-control" id="email" name="email"
                                    type="email" placeholder="you@example.com" required>
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label">Subject</label>
                                <input class="form-control" id="subject" name="subject"
                                    type="text" placeholder="Message subject" required>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message"
                                    rows="4" placeholder="Write your message..." required></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary rounded-pill px-4" type="submit">
                                    Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-5">
                    <div class="contact-box">
                        <h4 class="mb-4">Contact Information</h4>
                        <h6>Office Address</h6>
                        <p>123 Tech Boulevard, Suite 400<br>San Francisco, CA 94107</p>

                        <h6>Email Us</h6>
                        <p>support@placementpro.com<br>careers@placementpro.com</p>

                        <h6>Call Us</h6>
                        <p class="mb-0">+1 (800) 123-4567<br>Mon–Fri, 9 AM–6 PM EST</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <h4>PlacementPro</h4>
            <p class="text-secondary">Connecting talent with opportunities worldwide.</p>
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
