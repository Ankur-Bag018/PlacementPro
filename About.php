<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - PlacementPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="About.css" rel="stylesheet">
    <style>
        
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PlacementPro</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="About.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Help.php">Help</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="about-hero">
        <div class="container">
            <h1>About PlacementPro</h1>
            <p>Bridging the gap between extraordinary talent and industry-leading companies worldwide.</p>
        </div>
    </header>

    <section class="section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="section-title">Who We Are</h2>
                    <p class="mt-4 text-muted" style="line-height: 1.8;">
                        PlacementPro was founded with a single mission: to make the job search and recruitment process seamless, transparent, and effective. We believe that everyone deserves a career they love, and every company deserves the right talent to thrive. 
                    </p>
                    <p class="text-muted" style="line-height: 1.8;">
                        Our platform leverages modern technology to match skills with opportunities, providing tools for resume building, skill assessments, and direct communication with recruiters.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="feature-card text-center">
                                <h4 class="mb-3" style="color: var(--primary-dark);">Our Mission</h4>
                                <p class="text-muted mb-0">To empower professionals by providing equal access to global career opportunities.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-card text-center">
                                <h4 class="mb-3" style="color: var(--primary-dark);">Our Vision</h4>
                                <p class="text-muted mb-0">To become the world's most trusted and reliable talent acquisition ecosystem.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="help" class="section-padding" style="background-color: var(--section-bg);">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title text-center">Help & FAQs</h2>
                <p class="text-muted mt-3">Find answers to the most common questions about PlacementPro.</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        
                        <div class="accordion-item mb-3 border-0 shadow-sm">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <strong>How do I apply for a job?</strong>
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    To apply for a job, you first need to create a profile and upload your resume. Once your profile is complete, simply browse the job listings and click the "Apply" button on any job card. Your profile details will automatically be sent to the employer.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item mb-3 border-0 shadow-sm">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <strong>Is PlacementPro free for job seekers?</strong>
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Yes! Creating an account, browsing jobs, and applying for positions is 100% free for all job seekers. We only charge employers for premium job postings and recruitment tools.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item mb-3 border-0 shadow-sm">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <strong>How can employers post a job?</strong>
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Employers can register for an 'Employer Account' from the top right corner. Once verified, you can access the dashboard to post jobs, review applications, and manage candidate interviews directly through our platform.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="section-padding">
        <div class="container">
            <div class="row g-5">
                <!-- Contact Form -->
                <div class="col-lg-7">
                    <h2 class="section-title">Get in Touch</h2>
                    <p class="mt-3 text-muted mb-4">Have specific questions or need support? Fill out the form below and our team will get back to you within 24 hours.</p>
                    
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" placeholder="John Doe" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" placeholder="john@example.com" required>
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" placeholder="How can we help you?" required>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="5" placeholder="Write your message here..." required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary rounded-pill mt-2">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Contact Info Box -->
                <div class="col-lg-5">
                    <div class="contact-info-box shadow">
                        <h4>Contact Information</h4>
                        <p class="mb-4">We're here to help! Reach out to us through any of the following channels.</p>
                        
                        <div class="mb-4">
                            <h6 class="text-uppercase mb-1" style="color: #cde0ff;">Office Address</h6>
                            <p class="mb-0">123 Tech Boulevard, Suite 400<br>San Francisco, CA 94107<br>United States</p>
                        </div>
                        
                        <div class="mb-4">
                            <h6 class="text-uppercase mb-1" style="color: #cde0ff;">Email Us</h6>
                            <p class="mb-0">support@placementpro.com<br>careers@placementpro.com</p>
                        </div>
                        
                        <div>
                            <h6 class="text-uppercase mb-1" style="color: #cde0ff;">Call Us</h6>
                            <p class="mb-0">+1 (800) 123-4567<br>Mon - Fri, 9am - 6pm (EST)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center">
        <div class="container">
            <h4 class="mb-3">PlacementPro</h4>
            <p class="mb-3 text-secondary">Connecting top talent with top companies worldwide.</p>
            <div class="mb-4">
                <a href="index.html" class="text-white text-decoration-none mx-2 hover-opacity">Home</a> |
                <a href="about.html" class="text-white text-decoration-none mx-2 hover-opacity">About Us</a> |
                <a href="help.html" class="text-white text-decoration-none mx-2 hover-opacity">Help</a> |
                <a href="contact.html" class="text-white text-decoration-none mx-2 hover-opacity">Contact</a>
            </div>
            <hr class="border-secondary">
            <p class="mb-0 mt-3 text-secondary" style="font-size: 0.9rem;">&copy; 2026 PlacementPro. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS for accordions and responsive navbar -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>