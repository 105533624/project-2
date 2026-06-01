<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$page_title = "Apply";

$jobref_value = "";
if (isset($_GET["jobref"])) {
    $jobref_value = htmlspecialchars(trim($_GET["jobref"]));
}

require_once(__DIR__ . "/inc/header.inc"); 
?>

    <main>
        <section class="form-section">
            <h2 style="text-align: center;">Apply for a Position</h2>
            <p class="form-intro" style="text-align: center; color: #084887; font-weight: bold; font-style: italic;">
                Please fill in your details below to apply. All fields are required.
            </p>
            
            <form class="form-container" method="post" action="process_eoi.php" novalidate aria-label="Job Application Form">    
                
                <fieldset>
                    <legend><b>Job Application Details</b></legend>

                    <label for="jobref">Job reference number</label>
                    <input 
                        type="text" 
                        id="jobref" 
                        name="jobref"
                        aria-label="Job reference number"
                        aria-required="true"
                        value="<?php echo $jobref_value; ?>" 
                        <?php echo !empty($jobref_value) ? 'readonly style="background-color: #e9ecef;"' : ''; ?> 
                    >

                    <label for="firstname">First name</label>
                    <input type="text" id="firstname" name="firstname" aria-label="First name" aria-required="true">

                    <label for="lastname">Last name</label>
                    <input type="text" id="lastname" name="lastname" aria-label="Last name" aria-required="true">

                    <label for="date">Date of birth</label>
                    <input type="text" id="date" name="date" placeholder="DD/MM/YYYY" aria-label="Date of birth in DD/MM/YYYY format" aria-required="true">
                </fieldset>

                <fieldset role="group" aria-labelledby="gender-legend">
                    <legend id="gender-legend"><b>Gender</b></legend>

                    <input type="radio" id="male" name="gender" value="male" aria-required="true">
                    <label for="male">Male</label>

                    <input type="radio" id="female" name="gender" value="female">
                    <label for="female">Female</label>

                    <input type="radio" id="other" name="gender" value="other">
                    <label for="other">Other</label>
                </fieldset>

                <fieldset>
                    <legend><b>Address</b></legend>

                    <label for="street">Street Address</label>
                    <input type="text" id="street" name="street" aria-label="Street address" aria-required="true">

                    <label for="suburb">Suburb/Town</label>
                    <input type="text" id="suburb" name="suburb" aria-label="Suburb or town" aria-required="true">

                    <label for="state">State</label>
                    <select id="state" name="state" aria-label="State" aria-required="true">
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
                    <input type="text" id="postcode" name="postcode" aria-label="4 digit postcode" aria-required="true">
                </fieldset>

                <fieldset>
                    <legend><b>Contact Information</b></legend>

                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="example@gmail.com" aria-label="Email address" aria-required="true">

                    <label for="phone">Phone number</label>
                    <input type="text" id="phone" name="phone" aria-label="Phone number between 8 and 12 digits" aria-required="true">
                </fieldset>

                <fieldset role="group" aria-labelledby="skills-legend">
                    <legend id="skills-legend"><b>Skills Needed</b></legend>

                    <input type="checkbox" id="skill-html" name="skills[]" value="HTML" aria-label="HTML skill">
                    <label for="skill-html">HTML</label>

                    <input type="checkbox" id="skill-css" name="skills[]" value="CSS" aria-label="CSS skill">
                    <label for="skill-css">CSS</label>

                    <input type="checkbox" id="skill-js" name="skills[]" value="JavaScript" aria-label="JavaScript skill">
                    <label for="skill-js">JavaScript</label>
                </fieldset>

                <fieldset>
                    <legend><b>Other Skills</b></legend>

                    <label for="otherskills">List any additional skills you have:</label>
                    <textarea id="otherskills" name="otherskills" rows="4" cols="50" 
                        placeholder="e.g. Figma, Adobe Illustrator, team leadership..."
                        aria-label="Other skills"></textarea>
                </fieldset>
                 <fieldset>
                    <legend><b>Resume / CV Upload</b></legend>
                    <label for="resume">Upload your resume (optional):</label>
                    <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" aria-label="Upload your resume"><!-- Accepts PDF, DOC, DOCX as required by process_eoi.php -->
                    <p style="color: #555; font-size: 0.9em; margin-top: 0.5em;">Accepted formats: PDF, DOC, DOCX &nbsp;|&nbsp; Maximum size: 2MB</p>
                 </fieldset>

                <div class="form-buttons">
                    <button type="submit" aria-label="Submit application">Submit Application</button>
                    <button type="reset" aria-label="Reset form">Reset Form</button>
                </div>

            </form>
        </section>
    </main>

<?php 
require_once(__DIR__ . "/inc/footer.inc"); 
?>
