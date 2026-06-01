<!-- Generative AI tool (e.g., ChatGPT) was used for suggestions, code improvement,adding comments and image generation.All AI-generated code was reviewed and modified by the author before use. -->

<?php
// 1. Turning on error reporting so any PHP bugs show up clearly on your screen
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Setting the dynamic browser tab title for this specific page
$page_title = "Home";

// 3. Pulling in your clean, modular header template
require_once(__DIR__ . "/inc/header.inc"); 
?>
    <main>
        <!-- HERO / WELCOME SECTION -->
        <section class="welcome hero-bg">
            <h2>Welcome to NextGen Web Works</h2>
            <!-- Tagline -->
            <p class="tagline">Designing the Digital Future, Today</p>
            <!-- Short business description -->
            <p>We are a <strong>Creative Digital Media Agency</strong> specializing in web design and branding.</p>
            <!-- Job search form -->
            <form action="jobs.php" method="get" class="hero-search">
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
  

        <div class="acknowledgement">
            <div class="ack-text">
                <h2>Acknowledgement of Country</h2>
                <p><em> NextGen Web Works acknowledges the Traditional Owners and Custodians of the lands on which we work and create.
                        We pay our respects to Indigenous Elders past, present, and emerging, and celebrate the connection to Country,
                        culture, and community.</em></p>
            </div>
            <div class="ack-images">
                <img src="images/Aboriginal.webp" alt="Aboriginal flag">
                <img src="images/Torres-2.jpg" alt="Torres Strait Islander flag">
            </div>
        </div>
    </main>

    <?php 
    include_once(__DIR__ . "/inc/footer.inc"); 
?>
