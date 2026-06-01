-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2026 at 10:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nextgenwebworks`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `job_reference` varchar(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `salary` varchar(50) DEFAULT NULL,
  `reports_to` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `responsibilities` text DEFAULT NULL,
  `essential_requirements` text DEFAULT NULL,
  `preferred_requirements` text DEFAULT NULL,
  `closing_date` date DEFAULT NULL,
  `min_salary` int(11) DEFAULT NULL,
  `max_salary` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `job_reference`, `title`, `salary`, `reports_to`, `description`, `responsibilities`, `essential_requirements`, `preferred_requirements`, `closing_date`, `min_salary`, `max_salary`) VALUES
(1, 'ANM04', 'Motion Designer', '$80,000 - $90,000', 'Senior UX/UI Designer', 'We are looking for a creative motion designer to bring digital experiences to life through engaging animations, micro-interactions, and visual storytelling.', 'Design and produce animations for web and mobile interfaces.\nCollaborate with UX/UI designers to enhance user experience.\nCreate motion graphics for branding, marketing, and product demos.', 'Strong portfolio showcasing motion design and animation work.\nProficiency in After Effects, Figma, and relevant animation tools.\nSolid understanding of timing, spacing, and visual storytelling.', 'Experience with Lottie and interactive web animations.\nKnowledge of 3D tools such as Blender or Cinema 4D.\nFamiliarity with front-end implementation of animations.', '2026-06-05', NULL, NULL),
(2, 'MKT03', 'Digital Marketing Strategist', '$100,000 - $110,000', 'Head of Marketing', 'We are seeking a data-driven storyteller to develop and execute innovative digital marketing campaigns that grow brand presence and engagement across multiple platforms.', 'Develop and manage multi-channel digital marketing strategies.\nAnalyse campaign performance and optimise based on insights.\nOversee SEO, SEM, email marketing, and paid social campaigns.', 'Minimum 3–5 years experience in digital marketing or growth roles.\nStrong understanding of Google Analytics, Meta Ads, and SEO tools.\nExcellent copywriting and analytical skills.', 'Experience with marketing automation tools (HubSpot, Mailchimp).\nKnowledge of A/B testing and conversion rate optimisation.\nBackground in creative or agency environments.', '2026-06-20', NULL, NULL),
(3, 'UXD01', 'Senior UX/UI Designer', '$150,000 - $140,000', 'Creative Director', 'We are looking for a visionary designer to lead our user experience strategies and craft beautiful highly functional interfaces for our digital clients.', 'Lead the design process from wireframing to high-fidelity prototypes.\r\nConduct user research and usability testing.\r\nCollaborate closely with the development team.', 'Minimum 5 years of experience in UI/UX design.\r\nExpertise in Figma Adobe Creative Suite and prototyping tools.\r\nStrong portfolio.', 'Experience with motion design or micro-interactions.\r\nBackground in branding or visual identity systems.\r\nFamiliarity with front-end frameworks.', '2026-06-10', NULL, NULL),
(4, 'DEV02', 'Junior Front-End Developer', '$130,000 - $120,000', 'Lead Developer', 'Join our coding team to bring stunning creative designs to life using standard web technologies with a focus on accessibility.', 'Translate UI/UX wireframes into code.\r\nEnsure technical feasibility.\r\nOptimize applications for speed and scalability.', 'Proficiency in HTML5 and CSS3.\r\nUnderstanding of cross-browser compatibility.\r\nStrong communication skills.', 'Experience deploying static sites.\r\nAccessibility testing knowledge.\r\nFamiliarity with Git.', '2026-06-15', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
