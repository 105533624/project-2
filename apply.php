<!-- Generative AI tool (e.g., ChatGPT) was used for suggestions, code improvement,adding comments and image generation.All AI-generated code was reviewed and modified by the author before use. -->
 <!DOCTYPE html>
<html lang="en">
<head> 
     <!-- META DATA SECTION: Defines page info, SEO, and links CSS -->
    <meta charset="UTF-8"><!-- Character encoding (supports all text characters) -->
    <meta name="description" content="Apply.html"> <!-- Page description -->
    <meta name="keywords" content="HTML, Doctype, Head, Body, Meta, Paragraph, Headings, Strong, Emphasis"><!-- SEO keywords -->
    <meta name="author" content="Hamnah"><!-- Author of the page -->
    <link rel="stylesheet" href="styles.css"><!-- Links external CSS file -->
    <style>
        fieldset {
            border: 2px solid #084887;
            border-radius: 8px;
            padding: 1.5em;
            margin-bottom: 1.5em;
            background-color: #f9fafc;
        }
        fieldset legend {
            color: #084887;
            padding: 0 0.5em;
        }
    </style>
    <title>Apply.html</title><!-- Browser tab title -->
</head>
<body><!-- Visible content starts here -->
    <header>
    <!-- HEADER SECTION: Contains logo and navigation menu -->
        <div class="logo">
        <img src="images/logo.png" alt="NextGen Web Works Logo" width="100"><!-- Company logo -->
        <div class="logo-text">
            <h1>NextGen Web Works</h1><!-- Website title -->
        </div>
    </div>
    <nav><!-- Navigation bar -->
        <ul>
            <li><a href="index.php" title="Home Page">Home</a></li><!-- Link to home -->
            <li><a href="jobs.php" title="Browse Careers">Jobs</a></li><!-- Link to jobs -->
            <li><a href="apply.php" title="Submit Application">Apply</a></li><!-- Current page -->
            <li><a href="about.php" title="About the Team">About Us</a></li><!-- About page -->
        </ul>
    </nav>
</header>
    <!-- PAGE TITLE + INTRO -->
     <main>
     <section class="form-section">
    <h2 style="text-align: center;">Apply for a Position</h2>
    <p class="form-intro" style="text-align: center; color: #084887; font-weight: bold; font-style: italic;">Please fill in your details below to apply. All fields are required.</p>
    <form class="form-container" method="post" action="https://mercury.swin.edu.au/it000000/formtest.php" enctype="multipart/form-data">    <!-- FORM: Sends data to server using POST method. enctype required for file upload -->
        <!-- FIELDSET 1: JOB DETAILS -->
        <fieldset>
            <legend><b>Job Application Details</b></legend>
            <label for="jobref">Job reference number</label>
            <input type="text" id="jobref" name="jobref" pattern="[a-zA-Z0-9]{5}" required title="Must be exactly 5 alphanumeric characters">
            <label for="firstname">First name</label>
            <input type="text" id="firstname" name="firstname" pattern="[a-zA-Z]{1,20}" required>
            <label for="lastname">Last name</label>
            <input type="text" id="lastname" name="lastname" pattern="[a-zA-Z]{1,20}" required>
            <label for="date">Date of birth</label>
            <input type="date" id="date" name="date" required>
        </fieldset>
        <!-- FIELDSET 2: GENDER (RADIO BUTTONS - ONLY ONE CAN BE SELECTED) -->
          <fieldset>
            <legend><b>Gender</b></legend>
            <input type="radio" id="male" name="gender" required value="male">
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" required value="female">
            <label for="female">Female</label>
            <input type="radio" id="other" name="gender" required value="other">
            <label for="other">Other</label>
        </fieldset>
        <!-- FIELDSET 3: ADDRESS -->
        <fieldset>
            <legend><b>Address</b></legend>
            <label for="street">Street Address</label>
            <input type="text" id="street" name="street" pattern="[a-zA-Z0-9 ]{1,40}" required>
            <label for="suburb">Suburb/Town</label>
            <input type="text" id="suburb" name="suburb" pattern="[a-zA-Z ]{1,40}" required>
            <label for="state">State</label>
            <select id="state" name="state" required><!-- Dropdown menu -->
             <option value="" disabled selected>Please Select</option> 
             <option value="VIC">VIC</option>
             <option value="NSW">NSW</option> 
             <option value="QLD">QLD</option> 
             <option value="NT">NT</option> 
             <option value="WA">WA</option> 
             <option value="SA">SA</option> 
             <option value="TAS">TAS</option> 
             <option value="ACT">ACT</option>
            </select>
            <label for="postcode">Postcode</label>
            <input type="text" id="postcode" name="postcode" pattern="[0-9]{4}" required><!-- 4 digit postcode -->
        </fieldset>
        <!-- FIELDSET 4: CONTACT DETAILS -->
        <fieldset>
            <legend><b>Contact Information</b></legend>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="example@gmail.com" required title="Please enter an appropriate email address">
            <label for="phone">Phone number</label>
            <input type="tel" id="phone" name="phone" pattern="[0-9]{8,12}" required>
        </fieldset>
        <!-- FIELDSET 5: SKILLS (CHECKBOXES - MULTIPLE CAN BE SELECTED) -->
        <fieldset>
            <legend><b>Skills Needed</b></legend>
            <ul>
    <li>
        <input type="checkbox" id="skill-html" name="skills[]" value="HTML">
        <label for="skill-html">HTML</label>
    </li>
    <li>
        <input type="checkbox" id="skill-css" name="skills[]" value="CSS">
        <label for="skill-css">CSS</label>
    </li>
    <li>
        <input type="checkbox" id="skill-js" name="skills[]" value="JavaScript">
        <label for="skill-js">JavaScript</label>
    </li>
</ul>   
        </fieldset>
        <fieldset>
            <legend><b>Other Skills</b></legend>
            <label for="otherskills">List any additional skills you have:</label><br>
            <textarea id="otherskills" name="otherskills" rows="4" cols="50" placeholder="e.g. Figma, Adobe Illustrator, team leadership..."></textarea>
        </fieldset>
        <!-- FIELDSET 6: RESUME UPLOAD -->
        <fieldset>
            <legend><b>Resume / CV Upload</b></legend>
            <label for="resume">Upload your resume (optional):</label>
            <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx"><!-- Accepts PDF, DOC, DOCX as required by process_eoi.php -->
            <p style="color: #555; font-size: 0.9em; margin-top: 0.5em;">Accepted formats: PDF, DOC, DOCX &nbsp;|&nbsp; Maximum size: 2MB</p>
        </fieldset>
        <!-- FORM BUTTONS -->
        <div class="form-buttons">
            <button type="submit">Submit Application</button><!-- Sends form -->
            <button type="reset">Reset Form</button><!-- Clears form -->
        </div>
    </form>
    </section>
     </main>
    <!-- FOOTER -->
    <footer class="footer">
        <p>&copy; 2026 G06 Creative Media &amp; Design</p>
        <p>
            Contact us:
            <a href="mailto:info@nextgenwebworks.com" title="Email our recruitment team">
                info@nextgenwebworks.com
            </a>
        </p>
         
             <a href="https://vsuk0001.atlassian.net/jira/software/projects/CGRW/summary" target="_blank" rel="noopener noreferrer">Jira Board</a>
             <a href="https://github.com/105533624/Assignment_1" target="_blank" rel="noopener noreferrer">GitHub Repository</a>
        
    </footer>
</body>
</html>