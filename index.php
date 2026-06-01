<!-- Generative AI tool (e.g., ChatGPT) was used for suggestions, code improvement,adding comments and image generation.All AI-generated code was reviewed and modified by the author before use. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- =========================
         META DATA + PAGE SETUP
    ========================== -->
    <meta charset="UTF-8"><!-- Character encoding (supports all text characters) -->
    <meta name="description" content="index.html"> <!-- Page description -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="HTML, Doctype, Head, Body, Meta, Paragraph, Headings, Strong, Emphasis"><!-- SEO keywords -->
    <meta name="author" content="Vansh and Hamnah"><!-- Author of the page -->
    <title>NextGen Web Works - Home</title> <!-- Browser tab title -->
    <!-- External CSS file -->
    <link rel="stylesheet" href="styles/styles.css">
    <!-- Embedded CSS (inside HTML) -->
    <style>
        /* Hero section background image with dark overlay */
        .hero-bg {
            background-image: linear-gradient(rgba(13, 3, 160, 0.93), rgba(0, 17, 72, 0.85)),
                              url('images/Gemini_Generated_Image_o8qlqro8qlqro8ql.png');
            background-size: cover; /* Makes image cover full section */
            background-position: center; /* Centers the image */
            color: #FFFFFF; /* White text for contrast */
        }
    </style>
</head>
<body>
    <!-- =========================
         HEADER (LOGO + NAVIGATION)
    ========================== -->
    <header>
        <div class="logo">
            <!-- Company logo -->
            <img src="images/logo.png" alt="NextGen Web Works Logo" width="100"><!-- Logo generated using CHATGPT (OpenAI, Free version).-->
            <div class="logo-text">
            <!--Website name-->
                <h1>NextGen Web Works</h1>
            </div>
        </div>
        <!-- Navigation menu -->
        <nav>
            <ul>
                <li><a href="index.php" title="Home Page">Home</a></li>
                <li><a href="jobs.php" title="Browse Careers">Jobs</a></li>
                <li><a href="apply.php" title="Submit Application">Apply</a></li>
                <li><a href="about.php" title="About the Team">About Us</a></li>
            </ul>
        </nav>
    </header>
    <!-- =========================
         MAIN CONTENT
    ========================== -->
    <main>
        <!-- HERO / WELCOME SECTION -->
        <section class="welcome hero-bg">
            <h2>Welcome to NextGen Web Works</h2>
            <!-- Tagline -->
            <p class="tagline">Designing the Digital Future, Today</p>
            <!-- Short business description -->
            <p>We are a <strong>Creative Digital Media Agency</strong> specializing in web design and branding.</p>
            <!-- Job search form -->
            <form action="jobs.html" method="get" class="hero-search">
                <label for="site-search"><strong>Search Job Vacancies:</strong></label>
                <input type="text" id="site-search" name="q" placeholder="e.g. Web Designer">
                <button type="submit" class="cta">Search</button>
            </form>
        </section>
    
<!-- =========================
     PRICING PACKAGES SECTION
========================= -->
<section class="pricing-section">

    <h2>
        <span class="dark">Pricing</span>
        <span class="gold">Packages</span>
    </h2>

    <p class="pricing-subtitle">
        Transparent, all-inclusive pricing — no hidden fees
    </p>

    <div class="pricing-grid">

        <!-- STARTER -->
        <div class="pricing-card standard-card">

            <h3>Starter</h3>

            <div class="package-price">
                <span class="price">$800</span>
                <span class="per">/project</span>
            </div>

            <ul>
                <li>Up to 5 pages</li>
                <li>Mobile responsive</li>
                <li>Basic SEO</li>
                <li>Contact form</li>
                <li>3 revisions</li>
            </ul>

            <a href="apply.php" class="package-btn">
                Get Started
            </a>

        </div>

        <!-- GROWTH -->
        <div class="pricing-card featured-package">

            <div class="popular-badge">
                MOST POPULAR
            </div>

            <div class="featured-header">
                <h3>Growth</h3>
            </div>

            <div class="featured-content">

                <div class="package-price">
                    <span class="price">$1,500</span>
                    <span class="per">/project</span>
                </div>

                <ul>
                    <li>Up to 10 pages</li>
                    <li>Advanced SEO</li>
                    <li>CMS integration</li>
                    <li>Analytics setup</li>
                    <li>Google Ads setup</li>
                    <li>6 revisions + 30-day support</li>
                </ul>

                <a href="apply.php" class="package-btn">
                    Choose Plan
                </a>

            </div>

        </div>

        <!-- ENTERPRISE -->
        <div class="pricing-card standard-card">

            <h3>Enterprise</h3>

            <div class="package-price">
                <span class="price">Custom</span>
                <span class="per">/quote</span>
            </div>

            <ul>
                <li>Unlimited pages</li>
                <li>Full brand strategy</li>
                <li>Custom integrations</li>
                <li>Dedicated manager</li>
                <li>Priority support</li>
                <li>Ongoing retainer options</li>
            </ul>

            <a href="apply.php" class="package-btn">
                Contact Us
            </a>

        </div>

    </div>

</section>


        <!-- =========================
             OPERATING HOURS TABLE
        ========================== -->
        <section class="services hours-section">
            <h2>Studio Operating Hours</h2>
            <table>
                <caption>Weekly availability for client consultations</caption>
                <!-- Table headings -->
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Hours</th>
                    </tr>
                </thead>

                <!-- Table data -->
                <tbody>
                    <tr>
                        <td>Monday - Thursday</td>
                        <td>9:00 AM - 5:00 PM</td>
                    </tr>
                    <tr>
                        <td>Friday</td>
                        <td>9:00 AM - 3:00 PM</td>
                    </tr>

                    <!-- Inline CSS example -->
                    <tr>
                        <td colspan="2" style="text-align: center; font-style: italic;">
                            Closed Weekends and Public Holidays
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
        <!-- =========================
     CLIENT TESTIMONIALS SECTION
========================== -->
<section class="testimonials-section">
    <h2 class="testimonials-title">Client <span class="highlight">Testimonials</span></h2>
    <div class="testimonials-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>

    <div class="testimonials-grid">

        <div class="testimonial-card">
            <span class="testimonial-quote">&ldquo;</span>
            <p class="testimonial-text">NextGen completely transformed our online presence. Sales doubled within 3 months of the new site launching.</p>
            <div class="testimonial-divider"></div>
            <p class="testimonial-name">Sarah M.</p>
            <p class="testimonial-company">Artisan Co.</p>
        </div>

        <div class="testimonial-card">
            <span class="testimonial-quote">&ldquo;</span>
            <p class="testimonial-text">The team was professional, creative, and always available. The best investment we made for our business.</p>
            <div class="testimonial-divider"></div>
            <p class="testimonial-name">James K.</p>
            <p class="testimonial-company">TechBridge Group</p>
        </div>

        <div class="testimonial-card">
            <span class="testimonial-quote">&ldquo;</span>
            <p class="testimonial-text">Incredible attention to detail and SEO results that genuinely moved the needle for our local audience.</p>
            <div class="testimonial-divider"></div>
            <p class="testimonial-name">Priya L.</p>
            <p class="testimonial-company">Melbourne Eats</p>
        </div>

    </div>

    <p class="testimonials-average">Average 4.9/5 across 150+ projects</p>
</section>
        <!-- =========================
             ACKNOWLEDGEMENT SECTION
        ========================== -->
        <div class="acknowledgement">
            <!-- Text content -->
            <div class="ack-text">
                <h2>Acknowledgement of Country</h2>
                <p>
                    <em>
                        NextGen Web Works acknowledges the Traditional Owners and Custodians of the lands on which we work and create.
                        We pay our respects to Indigenous Elders past, present, and emerging, and celebrate the connection to Country,
                        culture, and community.
                    </em>
                </p>
            </div>
            <!-- Images (flags) -->
            <div class="ack-images">
                <img src="images/Aboriginal.webp" alt="Aboriginal flag">
                <img src="images/Torres-2.jpg" alt="Torres Strait Islander flag">
            </div>
        </div>
    </main>
    <!-- =========================
         FOOTER
    ========================== -->
    <footer class="footer">
        <!-- Copyright -->
        <p>&copy; 2026 G06 Creative Media &amp; Design</p>
        <!-- Contact email -->
        <p>
            Contact us:
            <a href="mailto:info@nextgenwebworks.com" title="Email our recruitment team">
                info@nextgenwebworks.com
            </a>
        </p>
        <!-- External links -->
        <a href="https://vsuk0001.atlassian.net/jira/software/projects/CGRW/summary" target="_blank" rel="noopener noreferrer">Jira Board</a>
        <a href="https://github.com/105533624/Assignment_1" target="_blank" rel="noopener noreferrer">GitHub Repository</a>
        <a href="https://105533624.github.io/Assignment_1/" target="_blank" rel="noopener noreferrer">Live Website</a>
    </footer>
</body>
</html>