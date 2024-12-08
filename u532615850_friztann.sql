-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 08, 2024 at 02:19 PM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u532615850_friztann`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'fritzann', '8dfd53490791d70caedc54e4ddd614e6', '2024-12-06 08:08:54'),
(5, 'dasasdasda', '0b130fd6d46d7b7e3448a04550d5fe23', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `friztann_booking`
--

CREATE TABLE `friztann_booking` (
  `booking_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `userEmail` varchar(100) DEFAULT NULL,
  `FromDate` varchar(50) NOT NULL,
  `ToDate` varchar(50) NOT NULL,
  `pickuptime` varchar(11) NOT NULL,
  `BookingHours` float NOT NULL,
  `returntime` varchar(11) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 0,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `bookingprice` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `friztann_booking`
--

INSERT INTO `friztann_booking` (`booking_id`, `vehicle_id`, `userEmail`, `FromDate`, `ToDate`, `pickuptime`, `BookingHours`, `returntime`, `Status`, `PostingDate`, `bookingprice`) VALUES
(56, 160, 'alexg@gmail.com', '2024-12-10', '2024-12-11', '3:43 am', 1, '3:43 am', 0, '2024-12-08 07:43:28', 800),
(57, 159, 'abygascal@gmail.com', '2024-12-13', '2024-12-14', '3:54 am', 1, '3:54 am', 0, '2024-12-08 07:55:00', 800),
(58, 162, 'abygascal@gmail.com', '2024-12-16', '2024-12-17', '4:06 pm', 1, '4:06 pm', 0, '2024-12-08 08:04:28', 800),
(59, 167, 'abygascal@gmail.com', '2024-12-08', '2025-01-07', '4:05 am', 30, '4:05 am', 1, '2024-12-08 08:06:04', 119500),
(60, 161, 'zanee2r@gmail.com', '2024-12-08', '2024-12-09', '9:34 pm', 1, '9:34 pm', 0, '2024-12-08 11:35:00', 800);

-- --------------------------------------------------------

--
-- Table structure for table `friztann_bookinginfo`
--

CREATE TABLE `friztann_bookinginfo` (
  `booking_info_id` int(11) NOT NULL,
  `useremail` varchar(255) NOT NULL,
  `NeedDriver` varchar(255) NOT NULL,
  `paymentproof` varchar(255) NOT NULL,
  `DriverId` int(11) DEFAULT NULL,
  `selectedLocation` varchar(100) NOT NULL,
  `locationprice` decimal(10,2) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `bookingprice` decimal(10,2) DEFAULT NULL,
  `totalprice` decimal(10,2) NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friztann_bookinginfo`
--

INSERT INTO `friztann_bookinginfo` (`booking_info_id`, `useremail`, `NeedDriver`, `paymentproof`, `DriverId`, `selectedLocation`, `locationprice`, `booking_id`, `bookingprice`, `totalprice`, `location_id`) VALUES
(40, 'alexg@gmail.com', 'Yes', 'admin/img/payments/432519021_741439871408292_1840721872582665286_n.jpg', NULL, 'Davao City|3000.00', 3000.00, 56, 800.00, 3800.00, 35),
(41, 'abygascal@gmail.com', 'Yes', 'admin/img/payments/resort-hotel-in-lake-sebu-punta-isla-lake-resort-south-cotabato (9).jpg', NULL, 'Davao City|3000.00', 3000.00, 57, 800.00, 3800.00, 35),
(42, 'abygascal@gmail.com', 'Yes', 'admin/img/payments/images (2).jpg', 7, 'Davao City|3000.00', 3000.00, 59, 119500.00, 122500.00, 35),
(43, 'zanee2r@gmail.com', 'Yes', 'admin/img/payments/462571044_933853008686927_343753320866355519_n.jpg', NULL, 'General Santos City|1300.00', 1300.00, 60, 800.00, 2100.00, 34);

-- --------------------------------------------------------

--
-- Table structure for table `friztann_brands`
--

CREATE TABLE `friztann_brands` (
  `brand_id` int(11) NOT NULL,
  `BrandName` varchar(120) NOT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `BrandLogo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `friztann_brands`
--

INSERT INTO `friztann_brands` (`brand_id`, `BrandName`, `CreationDate`, `UpdationDate`, `BrandLogo`) VALUES
(69, 'TOYOTA', '2024-12-03 17:57:44', NULL, 'pngwing.com (2).png'),
(70, 'HONDA', '2024-12-03 17:57:52', NULL, 'pngwing.com (1).png'),
(73, 'MITSUBISHI', '2024-12-07 13:35:25', NULL, 'pngwing.com.png');

-- --------------------------------------------------------

--
-- Table structure for table `friztann_contactinfo`
--

CREATE TABLE `friztann_contactinfo` (
  `contactusinfo_id` int(11) NOT NULL,
  `Address` tinytext DEFAULT NULL,
  `EmailId` varchar(255) DEFAULT NULL,
  `ContactNo` char(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `friztann_contactinfo`
--

INSERT INTO `friztann_contactinfo` (`contactusinfo_id`, `Address`, `EmailId`, `ContactNo`) VALUES
(1, 'Blk 2, Baldostamon Subd, Poblacion, Koronadal City', 'fritzannshuttleservices@gmail.com', '9360386693');

-- --------------------------------------------------------

--
-- Table structure for table `friztann_contactus`
--

CREATE TABLE `friztann_contactus` (
  `contactuquery_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `EmailId` varchar(255) DEFAULT NULL,
  `ContactNumber` varchar(20) DEFAULT NULL,
  `Message` varchar(255) DEFAULT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `friztann_contactus`
--

INSERT INTO `friztann_contactus` (`contactuquery_id`, `name`, `EmailId`, `ContactNumber`, `Message`, `PostingDate`, `status`) VALUES
(2, 'Joshua FREDRICK L carillo', 'zaneercarillo@gmail.com', '09796797', 'daaadsadsadsdas', '2024-10-01 04:00:48', NULL),
(4, 'joshua carillo ', 'zaneer@gmail.com', '09323254534', 'adsadsadsadsadadsadsadsadsadsadsdsdsadasda', '2024-12-06 18:21:52', NULL),
(5, 'joshua carillo ', 'zaneer@gmail.com', '09323254534', 'adsadsadsadsadadsadsadsadsadsadsdsdsadasda', '2024-12-06 18:22:52', NULL),
(6, 'joshua carillo ', 'zaneer@gmail.com', '09323254534', 'adsadsadsadsadadsadsadsadsadsadsdsdsadasda', '2024-12-06 18:23:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `friztann_drivers`
--

CREATE TABLE `friztann_drivers` (
  `driver_id` int(11) NOT NULL,
  `DriverName` varchar(120) NOT NULL,
  `Gender` varchar(255) NOT NULL,
  `EmailId` varchar(100) DEFAULT NULL,
  `ContactNo` int(11) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `friztann_drivers`
--

INSERT INTO `friztann_drivers` (`driver_id`, `DriverName`, `Gender`, `EmailId`, `ContactNo`, `RegDate`) VALUES
(7, 'AMBOT AMBOT AMBOT', 'MALE', 'AMBOT@GMAIL.COM', 2147483647, '2024-12-06 17:46:05');

-- --------------------------------------------------------

--
-- Table structure for table `friztann_feedback`
--

CREATE TABLE `friztann_feedback` (
  `testimonial_id` int(11) NOT NULL,
  `UserEmail` varchar(100) NOT NULL,
  `Testimonial` mediumtext NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL,
  `FeedbackImage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `friztann_feedback`
--

INSERT INTO `friztann_feedback` (`testimonial_id`, `UserEmail`, `Testimonial`, `PostingDate`, `status`, `FeedbackImage`) VALUES
(68, 'ASDASD!@GMAIL.COM', 'HELLO HAVE A NICE DAY GODBLESS', '2024-12-08 00:48:13', 1, 'assets/feedback/download (3).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `friztann_gender`
--

CREATE TABLE `friztann_gender` (
  `GenderId` int(11) NOT NULL,
  `Gender` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friztann_gender`
--

INSERT INTO `friztann_gender` (`GenderId`, `Gender`) VALUES
(1, 'MALE'),
(2, 'FEMALE'),
(3, 'OTHERS');

-- --------------------------------------------------------

--
-- Table structure for table `friztann_location`
--

CREATE TABLE `friztann_location` (
  `location_id` int(11) NOT NULL,
  `LocationName` varchar(150) DEFAULT NULL,
  `LocationPrice` decimal(10,2) NOT NULL,
  `LocationsOverview` longtext DEFAULT NULL,
  `image1` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friztann_location`
--

INSERT INTO `friztann_location` (`location_id`, `LocationName`, `LocationPrice`, `LocationsOverview`, `image1`) VALUES
(34, 'General Santos City', 1300.00, 'General Santos City or \"GenSan\" is in the province of South Cotabato in the Philippines. It is a highly urbanized city located at the southern portion of South Cotabato, but perhaps its biggest claim to fame is that boxer Manny Pacquiao is a native. It is known as \"The Tuna Capital of the Philippines\".', 'General Santos City.jpg'),
(35, 'Davao City', 3000.00, 'The capital of the Davao Region, Davao City is the most populated city in Mindanao and the third most populated in the Philippines. It\'s a major tourist destination, known for its natural beauty, urban charm, and cultural landmarks. Davao City is also a center of commerce and administration, and home to the Francisco Bangoy International Airport, the largest and most developed airport in Mindanao.', 'Davao, Philippines - Day 4.jpg'),
(36, 'Tacurong City', 1300.00, 'Tacurong is located at the center of Central Mindanao. It is 92 kilometers from General Santos City, 96 kilometers from Cotabato City, and 178 kilometers from Davao City. It is situated at the crossroads of the Davao-Gensan-Cotabato highways, and is the financial, commercial and education center of the area.', 'City of TACURONG.jpg'),
(37, 'Glan sarangani', 1500.00, 'Glan is the most populous municipality in Sarangani and it is located east of Sarangani Bay, west of Davao Occidental, and north of the Celebes Sea. Barangay Sufatubo as the largest barangay in Glan, It is largely based on agriculture with a high level production of copra.', 'download (4).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `friztann_noaccbooking`
--

CREATE TABLE `friztann_noaccbooking` (
  `noaccbooking_ID` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `FromDate` date NOT NULL,
  `PickupTime` varchar(110) NOT NULL,
  `ToDate` date NOT NULL,
  `ReturnTime` varchar(120) NOT NULL,
  `BookingDuration` int(11) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `bookingprice` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friztann_noaccbooking`
--

INSERT INTO `friztann_noaccbooking` (`noaccbooking_ID`, `vehicle_id`, `FromDate`, `PickupTime`, `ToDate`, `ReturnTime`, `BookingDuration`, `CreatedAt`, `bookingprice`) VALUES
(53, 162, '2024-12-08', '13:56:00', '2024-12-09', '13:56:00', 1, '2024-12-08 05:56:42', 1300.00),
(55, 161, '2024-12-17', '16:32:00', '2024-12-18', '16:32:00', 1, '2024-12-08 08:32:46', 1300.00),
(56, 166, '2024-12-08', '19:37:00', '2024-12-09', '19:37:00', 1, '2024-12-08 11:35:58', 1500.00);

-- --------------------------------------------------------

--
-- Table structure for table `friztann_noaccbookinginfo`
--

CREATE TABLE `friztann_noaccbookinginfo` (
  `noaccbookinginfo_ID` int(11) NOT NULL,
  `noaccbooking_ID` int(11) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `selectedLocation` varchar(255) NOT NULL,
  `locationPrice` decimal(10,2) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `bookingprice` varchar(266) DEFAULT NULL,
  `totalprice` varchar(255) NOT NULL,
  `bookingCode` varchar(11) NOT NULL,
  `hours` varchar(250) NOT NULL,
  `Status` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `needDriver` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friztann_noaccbookinginfo`
--

INSERT INTO `friztann_noaccbookinginfo` (`noaccbookinginfo_ID`, `noaccbooking_ID`, `firstname`, `middlename`, `lastname`, `selectedLocation`, `locationPrice`, `address`, `gender`, `age`, `phone`, `bookingprice`, `totalprice`, `bookingCode`, `hours`, `Status`, `location_id`, `needDriver`) VALUES
(45, 53, 'Crystal', 'L', 'Laroza', 'Davao City', 3000.00, 'Crystallaroza@gmail.com', 'female', 25, '9187449373', '1300.00', '4300', 'p2CNkO1', '1Hour', 0, 35, 'No'),
(47, 55, 'aby bernadeth', 'ugyhjok', 'xdtfyguhijnomk', 'General Santos City', 1300.00, 'koronadal city, south cotabato', 'female', 21, '6789876543', '1300.00', '2600', 'TZMdSCc', '2Hours', 0, 34, 'No'),
(48, 56, 'sdv sfdfs', 'dfsfds', 'dfdffsdfsd', 'General Santos City', 1300.00, 'dasdadsasdadsadsadsasdasdadsasdasdasdasdadsadsads', 'female', 22, '9898998988', '1500.00', '2800', 'puhHUDi', '30Mins', 0, 34, 'No');

-- --------------------------------------------------------

--
-- Table structure for table `friztann_pages`
--

CREATE TABLE `friztann_pages` (
  `page_id` int(11) NOT NULL,
  `PageName` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT '',
  `detail` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `friztann_pages`
--

INSERT INTO `friztann_pages` (`page_id`, `PageName`, `type`, `detail`) VALUES
(1, 'Terms and Conditions', 'terms', '                                                    To comply with our requirements, please ensure you have your Driving License, 1 Gov\'t ID, and utility bills as proof of your address and a 500 pesos reservation fee to be deducted in your total rent.                                                '),
(2, 'Privacy Policy', 'privacy', 'At FritzAnn Shuttle Services, Inc., we value your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, store, and protect your data when you use our services, both online and in person. By accessing or using our services, you agree to the practices outlined in this Privacy Policy. If you have any questions or concerns, please feel free to contact us using the details provided below.\r\n\r\n1. Information We Collect\r\nWe collect personal information when you interact with our services, including your name, contact details, booking information (such as travel dates and locations), payment data (e.g., GCash receipts), and any feedback or survey responses you provide.\r\n\r\n2. How We Use Your Information\r\nWe use the personal information we collect to process and confirm your bookings, verify the details of your reservations, enhance your customer experience, securely process payments, and comply with legal obligations. We may also use your data to improve our services and communication.\r\n\r\n3. Data Security\r\nWe take the security of your personal information seriously and implement measures to protect it from unauthorized access, alteration, or disclosure. We use industry-standard encryption protocols to protect sensitive data during transmission and secure storage methods.\r\n\r\n4. Sharing Your Information\r\nWe do not share your personal information for marketing purposes. However, we may share data with trusted third-party service providers who assist us with operations, such as payment processors or customer support platforms. We may also disclose your information if required by law or in response to legal requests to protect our rights.\r\n\r\n\r\n\r\n5. Your Rights\r\nYou have the right to access, correct, and request deletion of your personal data. You can also opt out of receiving marketing communications at any time. To exercise these rights, please contact us using the details provided below.\r\n\r\n6. No-Account Booking and Limited Features\r\nFor customers who choose the No-Account Booking option, we offer a simplified reservation process without requiring account creation. However, this option does not provide feedback functionality or notifications for updates. We collect and store the necessary details for verification to secure your booking and prevent fraudulent activities.\r\n\r\n7. Changes to This Privacy Policy\r\nWe may update this Privacy Policy to reflect changes in our practices or legal obligations. Any updates will be posted on our website with an updated effective date. We encourage you to review this policy periodically to stay informed about how we are protecting your privacy.'),
(3, 'About Us', 'aboutus', '                                                    Announcement: \r\nFritzAnn Shuttle Services is now\r\nFritzAnn Shuttle Services, Inc.\r\n\r\nWe are thrilled to announce that FritzAnn Shuttle Services has officially transitioned from a sole proprietorship to a corporation, now operating as FritzAnn Shuttle Services, Inc.\r\n\r\nThis change marks a significant milestone in our company\'s history, as we continue to grow and expand our services to better serve our valued customers. As a corporation, we are committed to maintaining the same high standards of quality and customer satisfaction that have defined our business since its inception.\r\n\r\nOur mission remains unchanged: to provide safe, reliable, and efficient shuttle services to individuals, gov\'t, & private organizations in need of transportation solutions. With this new corporate structure, we are poised to take on larger projects, offer more comprehensive services, and solidify our position as a leader in the Shuttle Service industry in South Cotabato.\r\n\r\nWe would like to take this opportunity to express our heartfelt gratitude to all our customers for their continued support and trust in our services. Your loyalty has been instrumental in our success, and we look forward to many more years of working together.\r\n\r\nThank you for your support.\r\n\r\nSincerely,\r\nFritzAnn Shuttle Services, Inc.                                                               '),
(4, 'FAQs', 'faqs', '                                                    1. What does this transition mean for customers?\r\nThe transition from FritzAnn Shuttle Services to FritzAnn Shuttle Services, Inc. means that we have moved from operating as a sole proprietorship to becoming a corporation. This allows us to expand our services, take on larger projects, and enhance the quality and reliability of our offerings while maintaining our commitment to customer satisfaction. \r\nHere’s the updated FAQ reflecting the removal of feedback for No-Account Booking:\r\n\r\nFrequently Asked Questions (FAQs)\r\n1. What does this transition mean for customers?\r\nThe transition from FritzAnn Shuttle Services to FritzAnn Shuttle Services, Inc. means that we have moved from operating as a sole proprietorship to becoming a corporation. This allows us to expand our services, take on larger projects, and enhance the quality and reliability of our offerings while maintaining our commitment to customer satisfaction.\r\n\r\n2. Will there be changes in the services provided?\r\nNo, our services will remain the same. However, we are introducing enhanced booking options to provide more convenience to our customers.\r\n\r\n3. What are the types of bookings available in the new system?\r\na. No-Account Booking\r\n\r\nFeatures:\r\nAvailable for customers who prefer not to create an account.\r\nCustomers can pick a time to get the car, with options of 30 minutes, 1 hour, or 2 hours.\r\nIf the time expires without claiming the car, the booking will be automatically deleted to make the slot available for other customers.\r\nRequires verification to secure the booking and ensure the accuracy of details.\r\nLimited features, including no notifications and no feedback options for updates or follow-ups.\r\nHere’s the updated FAQ reflecting the removal of feedback for No-Account Booking:\r\n\r\nFrequently Asked Questions (FAQs)\r\n1. What does this transition mean for customers?\r\nThe transition from FritzAnn Shuttle Services to FritzAnn Shuttle Services, Inc. means that we have moved from operating as a sole proprietorship to becoming a corporation. This allows us to expand our services, take on larger projects, and enhance the quality and reliability of our offerings while maintaining our commitment to customer satisfaction.\r\n\r\n2. Will there be changes in the services provided?\r\nNo, our services will remain the same. However, we are introducing enhanced booking options to provide more convenience to our customers.\r\n\r\n3. What are the types of bookings available in the new system?\r\na. No-Account Booking\r\n\r\nFeatures:\r\nAvailable for customers who prefer not to create an account.\r\nCustomers can pick a time to get the car, with options of 30 minutes, 1 hour, or 2 hours.\r\nIf the time expires without claiming the car, the booking will be automatically deleted to make the slot available for other customers.\r\nRequires verification to secure the booking and ensure the accuracy of details.\r\nLimited features, including no notifications and no feedback options for updates or follow-ups.\r\n\r\n\r\nb. User Booking (Online Payment)\r\n\r\nFeatures:\r\nRequires an account to book.\r\nPayment is made securely using GCash.\r\nCustomers can choose specific time slots and have access to all system features, including booking history, feedback, and priority services.\r\nRequires verification during booking to confirm customer details and ensure security.\r\nComprehensive feedback options allow you to share your experience and suggestions.\r\n\r\n                             c. Walk-in Booking\r\n\r\nFeatures:\r\nDesigned for customers who prefer in-person transactions.\r\nRequires customers to visit our location to book and board a shuttle.\r\nRequires verification of details on-site before completing the booking.\r\nFeedback can be provided directly at the booking location.\r\n4. What happens if I don’t claim the car within the selected time?\r\nIf you do not claim the car within the selected time (30 minutes, 1 hour, or 2 hours), the booking will be automatically deleted. This ensures that the slot becomes available for other customers who need it. 5. Why are booking details required for verification?\r\nBooking details are required for verification to ensure that the information provided is accurate. This step helps secure your reservation and prevents unauthorized or fraudulent bookings. By verifying your details, we ensure that we can provide the best service and protect both your reservation and our system from misuse. 6. Why does No-Account Booking have no feedback options?\r\nNo-Account Booking is designed for quick, one-time reservations with limited features. Feedback options are intentionally excluded to keep the process simple and straightforward.\r\n\r\n7. How can I provide feedback on your services?\r\nUser Booking: Submit feedback directly through your account dashboard.\r\nWalk-in Booking: Provide feedback directly at the booking location. \r\n\r\n8. How does payment work with GCash?\r\nFor users who choose the User Booking option, payment is made through GCash. Once you\'ve completed the payment through GCash, you will need to attach the receipt of your payment during the booking process to confirm the transaction. This ensures a quick and secure verification of your reservation.\r\n\r\n9. How does this benefit me as a customer?\r\nThe transition to FritzAnn Shuttle Services, Inc. improves our ability to offer reliable, secure, and efficient services. With new flexible booking options, a smoother verification process, and better security for reservations, we aim to make your experience more convenient and seamless. Our corporate structure helps us better meet your needs and ensure that every booking is managed with the highest level of care and efficiency.');

-- --------------------------------------------------------

--
-- Table structure for table `friztann_payments`
--

CREATE TABLE `friztann_payments` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `proof_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friztann_payments`
--

INSERT INTO `friztann_payments` (`payment_id`, `booking_id`, `proof_path`) VALUES
(28, 56, 'admin/img/payments/ahxcel.jpg'),
(29, 57, 'admin/img/payments/testimonial-img-4.jpg'),
(30, 59, 'admin/img/payments/support_faq_bg.jpg'),
(31, 59, 'admin/img/payments/support_faq_bg.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `friztann_promo`
--

CREATE TABLE `friztann_promo` (
  `promo_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `imageP` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friztann_promo`
--

INSERT INTO `friztann_promo` (`promo_id`, `title`, `description`, `imageP`) VALUES
(28, 'dsdas', 'adsdassadasdasdasd', 'adminlogin.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `friztann_users`
--

CREATE TABLE `friztann_users` (
  `user_id` int(11) NOT NULL,
  `ProfileImg` varchar(255) NOT NULL,
  `FirstName` varchar(120) DEFAULT NULL,
  `MiddleName` varchar(120) DEFAULT NULL,
  `LastName` varchar(120) DEFAULT NULL,
  `EmailId` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `ContactNo` char(11) DEFAULT NULL,
  `dob` varchar(100) DEFAULT NULL,
  `Barangay` varchar(100) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `Province` varchar(100) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `Gender` int(11) NOT NULL,
  `DriversLicenseFront` varchar(255) NOT NULL,
  `DriversLicenseBack` varchar(255) NOT NULL,
  `GovernmentIDFront` varchar(255) NOT NULL,
  `GovernmentIDBack` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `friztann_users`
--

INSERT INTO `friztann_users` (`user_id`, `ProfileImg`, `FirstName`, `MiddleName`, `LastName`, `EmailId`, `Password`, `ContactNo`, `dob`, `Barangay`, `City`, `Province`, `RegDate`, `UpdationDate`, `Gender`, `DriversLicenseFront`, `DriversLicenseBack`, `GovernmentIDFront`, `GovernmentIDBack`, `status`) VALUES
(39, 'avatar7.jfif', 'Jisha', 'L', 'Laroza', 'hdiejwjb@gmail.com', 'eff370704dcd80caa620e8c0b2392297', '9736264432', '2001-01-02', 'GPS', 'Koronadal', 'South Cotabato', '2024-12-04 12:08:40', '2024-12-04 12:52:41', 2, '17333155899737132786023102481313.jpg', '17333156083086673608288483335050.jpg', '17333156217316792088493681622748.jpg', '17333156299094556546792381550127.jpg', '1'),
(51, 'avatar3.jfif', 'JOSHUA FREDRICK', 'LEGO', 'CARILLO', 'ASDASD!@GMAIL.COM', '25d55ad283aa400af464c76d713c07ad', '9323232323', '2024-12-06', 'AMBOT', 'TACURONG', 'SULTAN KUDARAT', '2024-12-05 18:43:26', '2024-12-08 00:42:39', 1, 'Card free icons designed by Freepik.jpg', 'download.jpg', 'Id Card free icons designed by NT Sookruay.jpg', 'Icono De Línea Llenado De Tarjeta De Identificación PNG ,dibujos  Tarjeta, Id, Tarjeta De Identificacion PNG y Vector para Descargar Gratis _ Pngtree.jpg', '1'),
(68, '', 'Crystal Gail', 'L', 'Mendoza', 'crystalgailmendoza@gmail.com', '7b9b15b4c32c0fd55f8518522c0ae27a', '9375221642', '2000-12-19', 'GPS', 'Koronadal', 'South Cotabato', '2024-12-08 01:08:39', '2024-12-08 01:33:00', 2, '1733620663586747209780604209093.jpg', '17336206716387673974091146483817.jpg', '17336206800117088781464907560487.jpg', '17336206492354834451932109025127.jpg', '1'),
(69, 'avatar3.jfif', 'Jan', 'Leorito', 'Lorilla', 'desjan.580@gmail.com', '23330495a37a6e026c6671e4027ebc1e', '9755789016', '', 'Caloocan', 'Koronadal', 'South cotabato', '2024-12-08 01:26:52', '2024-12-08 01:32:58', 1, 'inbound3155083584096186382.jpg', 'inbound6660001482458265605.jpg', 'inbound3400187957972027467.jpg', 'inbound1475620075318028157.jpg', '1'),
(70, '', 'aby bernadeth', 'sierra', 'gascal', 'abygascal@gmail.com', '0e974daa377486c6367ed6f75f044448', '9150489566', NULL, NULL, NULL, NULL, '2024-12-08 05:36:01', '2024-12-08 05:53:20', 0, '', '', '', '', '1'),
(71, '', 'alex', 'rejas', 'gascal', 'alexg@gmail.com', 'f1fd19501019329931ad0af50e9c2f5c', '9759723328', NULL, NULL, NULL, NULL, '2024-12-08 07:41:55', '2024-12-08 07:42:26', 0, '', '', '', '', '1'),
(72, '', 'Zaneks dke', 'Skeiejsjej', 'Ksiekensns', 'zaneercarillo2@gmail.com', '8b86d3ce894710e93ebbc9dde2d5f04b', '9610432778', NULL, NULL, NULL, NULL, '2024-12-08 10:39:06', '2024-12-08 11:34:39', 0, '', '', '', '', '1'),
(73, '', 'zaneer', 's', 'carillo', 'zanee2r@gmail.com', '56dfc7cbe1d7773a556708d62407d1ff', '9843343434', NULL, NULL, NULL, NULL, '2024-12-08 11:31:53', '2024-12-08 11:34:36', 0, '', '', '', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `friztann_vehicles`
--

CREATE TABLE `friztann_vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `VehiclesTitle` varchar(150) DEFAULT NULL,
  `VehiclesBrand` int(11) DEFAULT NULL,
  `BrandLogo` varchar(255) NOT NULL,
  `vimage0` varchar(255) DEFAULT NULL,
  `PricePerDay` float DEFAULT NULL,
  `FuelType` varchar(100) DEFAULT NULL,
  `TransmissionType` varchar(22) DEFAULT NULL,
  `SeatingCapacity` int(11) DEFAULT NULL,
  `Vimage1` varchar(120) DEFAULT NULL,
  `Vimage2` varchar(120) DEFAULT NULL,
  `Vimage3` varchar(120) DEFAULT NULL,
  `AirConditioner` int(11) DEFAULT NULL,
  `PowerDoorLocks` int(11) DEFAULT NULL,
  `PowerWindows` int(11) DEFAULT NULL,
  `CDPlayer` int(11) DEFAULT NULL,
  `CentralLocking` int(11) DEFAULT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `STATUS` varchar(255) NOT NULL,
  `bodytype` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `friztann_vehicles`
--

INSERT INTO `friztann_vehicles` (`vehicle_id`, `VehiclesTitle`, `VehiclesBrand`, `BrandLogo`, `vimage0`, `PricePerDay`, `FuelType`, `TransmissionType`, `SeatingCapacity`, `Vimage1`, `Vimage2`, `Vimage3`, `AirConditioner`, `PowerDoorLocks`, `PowerWindows`, `CDPlayer`, `CentralLocking`, `RegDate`, `STATUS`, `bodytype`) VALUES
(156, 'Mirage', 73, '', 'Untitled design_20240703_091122_0000.png', 1000, 'Gasoline', 'CVT', 5, 'Premium Photo _ Front view new car interior view.jpg', 'download (2).jpg', 'TikTok · Elyse Janes.jpg', 1, 1, NULL, NULL, 1, '2024-12-07 13:41:26', 'AVAILABLE', 'HATCHBACK'),
(157, 'Mirage', 73, '', 'Untitled design_20240703_091122_0000.png', 1000, 'Gasoline', 'CVT', 5, 'Premium Photo _ Front view new car interior view.jpg', 'download (2).jpg', 'TikTok · Elyse Janes.jpg', 1, 1, NULL, NULL, 1, '2024-12-07 13:41:33', 'AVAILABLE', 'HATCHBACK'),
(158, 'MIRAGE', 73, '', 'Untitled design_20240703_090830_0000.png', 1000, 'Gasoline', 'CVT', 5, '_Groovy Rides_ Exploring the Iconic Hippie Cars of the 60s and 70s_.jpg', 'TikTok · Elyse Janes.jpg', 'download.jpg', 1, 1, NULL, NULL, 1, '2024-12-07 13:48:07', 'AVAILABLE', 'HATCHBACK'),
(159, 'VIOS', 69, '', 'Untitled design_20240703_090726_0000.png', 1300, 'Gasoline', 'CVT', 5, '_Groovy Rides_ Exploring the Iconic Hippie Cars of the 60s and 70s_.jpg', 'TikTok · Elyse Janes.jpg', 'download.jpg', 1, 1, NULL, NULL, 1, '2024-12-07 13:52:45', 'MAINTENANCE', 'SEDAN'),
(160, 'VIOS ', 69, '', 'Untitled design_20240703_090924_0000.png', 1300, 'Gasoline', 'CVT', 5, 'download23.jpg', 'download.jpg', 'TikTok · Elyse Janes.jpg', 1, 1, 1, NULL, 1, '2024-12-07 13:53:40', 'MAINTENANCE', 'SEDAN'),
(161, 'WIGO ', 69, '', 'Untitled design_20240703_092140_0000.png', 1300, 'Gasoline', 'CVT', 5, '_Groovy Rides_ Exploring the Iconic Hippie Cars of the 60s and 70s_.jpg', 'TikTok · Elyse Janes.jpg', 'download23.jpg', 1, 1, 1, 1, 1, '2024-12-07 13:56:34', 'MAINTENANCE', 'HATCHBACK'),
(162, 'WIGO ', 69, '', 'Untitled design_20240703_092111_0000.png', 1300, 'Gasoline', 'CVT', 5, '_Groovy Rides_ Exploring the Iconic Hippie Cars of the 60s and 70s_.jpg', 'TikTok · Elyse Janes.jpg', 'download.jpg', 1, 1, 1, 1, 1, '2024-12-07 13:57:46', 'MAINTENANCE', 'HATCHBACK'),
(163, 'XPANDER CROSS', 73, '', 'Untitled design_20240703_091931_0000.png', 1400, 'Gasoline', 'Automatic', 7, 'BAM SHIFTS Handcrafted Shift Knobs and Accessories.jpg', 'download23.jpg', 'download.jpg', 1, 1, 1, NULL, 1, '2024-12-07 14:02:29', 'AVAILABLE', 'MPV'),
(164, 'STRADA ATHLETE 4x4', 73, '', 'Untitled design_20240703_090621_0000.png', 1500, 'Diesel', 'Manual', 5, '_Groovy Rides_ Exploring the Iconic Hippie Cars of the 60s and 70s_.jpg', 'BAM SHIFTS Handcrafted Shift Knobs and Accessories.jpg', 'download.jpg', 1, 1, NULL, NULL, 1, '2024-12-07 14:10:47', 'AVAILABLE', 'PICK-UP'),
(165, 'STRADA ATHLETE 4x4', 73, '', 'Untitled design_20240703_092344_0000 (1).png', 1500, 'Diesel', 'Manual', 5, '_Groovy Rides_ Exploring the Iconic Hippie Cars of the 60s and 70s_.jpg', 'TikTok · Elyse Janes.jpg', 'download.jpg', 1, 1, 1, 1, 1, '2024-12-07 14:12:21', 'AVAILABLE', 'PICK-UP'),
(166, 'HILUX 4x2', 69, '', 'Untitled design_20240703_090502_0000.png', 1500, 'Diesel', 'Manual', 5, '_Groovy Rides_ Exploring the Iconic Hippie Cars of the 60s and 70s_.jpg', 'TikTok · Elyse Janes.jpg', 'download.jpg', 1, 1, NULL, NULL, 1, '2024-12-07 14:15:14', 'AVAILABLE', 'PICK-UP'),
(167, 'COMMUTER DELUX', 69, '', 'Untitled design_20240703_085504_0000.png', 4000, 'Diesel', 'Manual', 15, 'download23.jpg', '_Groovy Rides_ Exploring the Iconic Hippie Cars of the 60s and 70s_.jpg', 'BAM SHIFTS Handcrafted Shift Knobs and Accessories.jpg', 1, 1, 1, 1, 1, '2024-12-07 14:20:19', 'MAINTENANCE', 'VAN'),
(168, 'GL GRANDIA', 69, '', 'Untitled design_20240703_090250_0000.png', 3500, 'Diesel', 'Manual', 12, 'download23.jpg', '_Groovy Rides_ Exploring the Iconic Hippie Cars of the 60s and 70s_.jpg', 'BAM SHIFTS Handcrafted Shift Knobs and Accessories.jpg', 1, 1, 1, 1, 1, '2024-12-07 14:22:29', 'AVAILABLE', 'VAN'),
(170, 'GL GRANDIA', 69, '', 'Untitled design_20240703_090126_0000.png', 3500, 'Diesel', 'Manual', 12, 'BAM SHIFTS Handcrafted Shift Knobs and Accessories.jpg', '_Groovy Rides_ Exploring the Iconic Hippie Cars of the 60s and 70s_.jpg', 'download.jpg', 1, 1, 1, 1, 1, '2024-12-07 14:26:01', 'AVAILABLE', 'VAN'),
(173, 'XPANDER CROSS', 73, '', 'Untitled design_20240703_091931_0000.png', 1400, 'Gasoline', 'Automatic', 7, '_Groovy Rides_ Exploring the Iconic Hippie Cars of the 60s and 70s_.jpg', 'BAM SHIFTS Handcrafted Shift Knobs and Accessories.jpg', 'download.jpg', 1, 1, NULL, NULL, 1, '2024-12-07 15:31:39', 'AVAILABLE', 'MPV'),
(174, 'XPANDER CROSS', 73, '', 'Untitled design_20240703_091931_0000.png', 1400, 'Gasoline', 'Automatic', 7, '_Groovy Rides_ Exploring the Iconic Hippie Cars of the 60s and 70s_.jpg', 'BAM SHIFTS Handcrafted Shift Knobs and Accessories.jpg', 'download.jpg', 1, 1, NULL, NULL, 1, '2024-12-07 15:31:49', 'AVAILABLE', 'MPV'),
(179, 'HIACECOMMUTER', 69, '', 'Untitled design_20240703_090011_0000.png', 3500, 'Diesel', 'Manual', 12, 'TikTok · Elyse Janes.jpg', '_Groovy Rides_ Exploring the Iconic Hippie Cars of the 60s and 70s_.jpg', 'BAM SHIFTS Handcrafted Shift Knobs and Accessories.jpg', 1, 1, NULL, NULL, 1, '2024-12-07 15:47:31', 'AVAILABLE', 'VAN'),
(180, 'HIACECOMMUTER', 69, '', 'Untitled design_20240703_090011_0000.png', 3500, 'Diesel', 'Manual', 12, 'TikTok · Elyse Janes.jpg', '_Groovy Rides_ Exploring the Iconic Hippie Cars of the 60s and 70s_.jpg', 'BAM SHIFTS Handcrafted Shift Knobs and Accessories.jpg', 1, 1, NULL, NULL, 1, '2024-12-07 15:47:42', 'AVAILABLE', 'VAN'),
(181, 'HIACECOMMUTER', 69, '', 'Untitled design_20240703_090011_0000.png', 3500, 'Diesel', 'Manual', 12, 'TikTok · Elyse Janes.jpg', '_Groovy Rides_ Exploring the Iconic Hippie Cars of the 60s and 70s_.jpg', 'BAM SHIFTS Handcrafted Shift Knobs and Accessories.jpg', 1, 1, NULL, NULL, 1, '2024-12-07 15:47:56', 'AVAILABLE', 'VAN'),
(183, 'HIACECOMMUTER', 69, '', 'Untitled design_20240703_085659_0000.png', 3500, 'Diesel', 'Manual', 12, 'download23.jpg', '_Groovy Rides_ Exploring the Iconic Hippie Cars of the 60s and 70s_.jpg', 'BAM SHIFTS Handcrafted Shift Knobs and Accessories.jpg', 1, 1, 1, 1, 1, '2024-12-07 15:53:59', 'AVAILABLE', 'VAN');

-- --------------------------------------------------------

--
-- Table structure for table `friztann_walkin`
--

CREATE TABLE `friztann_walkin` (
  `walk_id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `phonenumber` varchar(20) DEFAULT NULL,
  `fromdate` date DEFAULT NULL,
  `todate` date DEFAULT NULL,
  `BookingPrice` decimal(10,2) DEFAULT NULL,
  `pickuptime` varchar(20) DEFAULT NULL,
  `returntime` varchar(20) DEFAULT NULL,
  `Location` varchar(255) NOT NULL,
  `LocationPrice` decimal(10,2) NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `location_id` int(11) NOT NULL,
  `age` int(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friztann_walkin`
--

INSERT INTO `friztann_walkin` (`walk_id`, `vehicle_id`, `phonenumber`, `fromdate`, `todate`, `BookingPrice`, `pickuptime`, `returntime`, `Location`, `LocationPrice`, `totalPrice`, `booking_date`, `location_id`, `age`, `firstname`, `middlename`, `lastname`, `address`) VALUES
(55, 160, '9759723328', '2024-12-08', '2024-12-09', 1300.00, '03:39:00', '03:39:00', 'General Santos City', 1300.00, 2600.00, '2024-12-08 07:39:42', 34, 21, 'jisha', 'cruz', 'laroza', 'Koronadal City, South Cotabato');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friztann_booking`
--
ALTER TABLE `friztann_booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `vehicle_id` (`vehicle_id`),
  ADD KEY `userEmail` (`userEmail`);

--
-- Indexes for table `friztann_bookinginfo`
--
ALTER TABLE `friztann_bookinginfo`
  ADD PRIMARY KEY (`booking_info_id`),
  ADD KEY `location_id_idx` (`location_id`),
  ADD KEY `DriverId` (`DriverId`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `friztann_brands`
--
ALTER TABLE `friztann_brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `friztann_contactinfo`
--
ALTER TABLE `friztann_contactinfo`
  ADD PRIMARY KEY (`contactusinfo_id`);

--
-- Indexes for table `friztann_contactus`
--
ALTER TABLE `friztann_contactus`
  ADD PRIMARY KEY (`contactuquery_id`);

--
-- Indexes for table `friztann_drivers`
--
ALTER TABLE `friztann_drivers`
  ADD PRIMARY KEY (`driver_id`);

--
-- Indexes for table `friztann_feedback`
--
ALTER TABLE `friztann_feedback`
  ADD PRIMARY KEY (`testimonial_id`),
  ADD KEY `UserEmail` (`UserEmail`);

--
-- Indexes for table `friztann_gender`
--
ALTER TABLE `friztann_gender`
  ADD PRIMARY KEY (`GenderId`);

--
-- Indexes for table `friztann_location`
--
ALTER TABLE `friztann_location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `friztann_noaccbooking`
--
ALTER TABLE `friztann_noaccbooking`
  ADD PRIMARY KEY (`noaccbooking_ID`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `friztann_noaccbookinginfo`
--
ALTER TABLE `friztann_noaccbookinginfo`
  ADD PRIMARY KEY (`noaccbookinginfo_ID`),
  ADD UNIQUE KEY `noaccbooking_ID` (`noaccbooking_ID`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `friztann_pages`
--
ALTER TABLE `friztann_pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `friztann_payments`
--
ALTER TABLE `friztann_payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk_booking` (`booking_id`);

--
-- Indexes for table `friztann_promo`
--
ALTER TABLE `friztann_promo`
  ADD PRIMARY KEY (`promo_id`);

--
-- Indexes for table `friztann_users`
--
ALTER TABLE `friztann_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `EmailId_2` (`EmailId`),
  ADD KEY `EmailId` (`EmailId`),
  ADD KEY `Gender` (`Gender`);

--
-- Indexes for table `friztann_vehicles`
--
ALTER TABLE `friztann_vehicles`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD KEY `friztann_vehicles_ibfk_1` (`VehiclesBrand`);

--
-- Indexes for table `friztann_walkin`
--
ALTER TABLE `friztann_walkin`
  ADD PRIMARY KEY (`walk_id`),
  ADD KEY `VehicleId` (`vehicle_id`),
  ADD KEY `location_id` (`location_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `friztann_booking`
--
ALTER TABLE `friztann_booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `friztann_bookinginfo`
--
ALTER TABLE `friztann_bookinginfo`
  MODIFY `booking_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `friztann_brands`
--
ALTER TABLE `friztann_brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `friztann_contactinfo`
--
ALTER TABLE `friztann_contactinfo`
  MODIFY `contactusinfo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `friztann_contactus`
--
ALTER TABLE `friztann_contactus`
  MODIFY `contactuquery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `friztann_drivers`
--
ALTER TABLE `friztann_drivers`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `friztann_feedback`
--
ALTER TABLE `friztann_feedback`
  MODIFY `testimonial_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `friztann_gender`
--
ALTER TABLE `friztann_gender`
  MODIFY `GenderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `friztann_location`
--
ALTER TABLE `friztann_location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `friztann_noaccbooking`
--
ALTER TABLE `friztann_noaccbooking`
  MODIFY `noaccbooking_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `friztann_noaccbookinginfo`
--
ALTER TABLE `friztann_noaccbookinginfo`
  MODIFY `noaccbookinginfo_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `friztann_pages`
--
ALTER TABLE `friztann_pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `friztann_payments`
--
ALTER TABLE `friztann_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `friztann_promo`
--
ALTER TABLE `friztann_promo`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `friztann_users`
--
ALTER TABLE `friztann_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `friztann_vehicles`
--
ALTER TABLE `friztann_vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `friztann_walkin`
--
ALTER TABLE `friztann_walkin`
  MODIFY `walk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `friztann_booking`
--
ALTER TABLE `friztann_booking`
  ADD CONSTRAINT `fk_user_email` FOREIGN KEY (`userEmail`) REFERENCES `friztann_users` (`EmailId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friztann_booking_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `friztann_vehicles` (`vehicle_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `friztann_bookinginfo`
--
ALTER TABLE `friztann_bookinginfo`
  ADD CONSTRAINT `fk_driver_id` FOREIGN KEY (`DriverId`) REFERENCES `friztann_drivers` (`driver_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_location_id` FOREIGN KEY (`location_id`) REFERENCES `friztann_location` (`location_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friztann_bookinginfo_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `friztann_booking` (`booking_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `friztann_feedback`
--
ALTER TABLE `friztann_feedback`
  ADD CONSTRAINT `friztann_feedback_ibfk_1` FOREIGN KEY (`UserEmail`) REFERENCES `friztann_users` (`EmailId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `friztann_noaccbooking`
--
ALTER TABLE `friztann_noaccbooking`
  ADD CONSTRAINT `friztann_noaccbooking_ibfk_2` FOREIGN KEY (`vehicle_id`) REFERENCES `friztann_vehicles` (`vehicle_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `friztann_noaccbookinginfo`
--
ALTER TABLE `friztann_noaccbookinginfo`
  ADD CONSTRAINT `fk_bookinginfo` FOREIGN KEY (`noaccbooking_ID`) REFERENCES `friztann_noaccbooking` (`noaccbooking_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `friztann_noaccbookinginfo_ibfk_1` FOREIGN KEY (`noaccbooking_ID`) REFERENCES `friztann_noaccbooking` (`noaccbooking_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friztann_noaccbookinginfo_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `friztann_location` (`location_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `friztann_payments`
--
ALTER TABLE `friztann_payments`
  ADD CONSTRAINT `fk_booking` FOREIGN KEY (`booking_id`) REFERENCES `friztann_bookinginfo` (`booking_id`) ON DELETE CASCADE;

--
-- Constraints for table `friztann_vehicles`
--
ALTER TABLE `friztann_vehicles`
  ADD CONSTRAINT `friztann_vehicles_ibfk_1` FOREIGN KEY (`VehiclesBrand`) REFERENCES `friztann_brands` (`brand_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `friztann_walkin`
--
ALTER TABLE `friztann_walkin`
  ADD CONSTRAINT `friztann_walkin_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `friztann_vehicles` (`vehicle_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friztann_walkin_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `friztann_location` (`location_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
