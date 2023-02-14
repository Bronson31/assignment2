SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_enrollment`
--

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`rid`, `title`) VALUES
(1, 'Administrator'),
(2, 'Educator'),
(3, 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rid` int(11) NOT NULL,
  PRIMARY KEY (`username`),
  KEY `rid` (`rid`)
) ENGINE=InnoDB AUTO_INCREMENT=206 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `email`, `rid`) VALUES
('admin1', 'password1', 'admin1@email.com', 1),
('educator1', 'password2', 'educator1@email.com', 2),
('student1', 'password3', 'student1@email.com', 3);

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
CREATE TABLE IF NOT EXISTS `subject` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lecturer` varchar(255) NOT NULL,
  `venue` varchar(255) NOT NULL,
  `student_number` int(11) NOT NULL,
  `subject_status` varchar(255) NOT NULL,
  `lecture_date` date NOT NULL,
  `lecture_time` time NOT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_code`, `name`, `lecturer`, `venue`, `student_number`, `subject_status`, `lecture_date`, `lecture_time`) VALUES
(1, 'SUBJ001', 'Introduction to Computer Science', 'Jonah Ng', 'Room 101', 25, 'active', '2022-05-01', '13:00:00'),
(2, 'SUBJ002', 'Data Structures and Algorithms', 'Jane Doe', 'Room 102', 30, 'inactive', '2022-05-02', '14:00:00'),
(3, 'SUBJ003', 'Database Systems', 'Jim Smith', 'Room 103', 35, 'removed', '2022-05-03', '15:00:00');


--
-- Table structure for table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
CREATE TABLE IF NOT EXISTS `administrator` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000;


--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`username`, `admin_id`, `name`, `phone`, `email`, `position`) VALUES
('admin1', 1000, 'Johnny', '5555551212', 'admin1@email.com', 'Senior Administrator');


--
-- Table structure for table `educator`
--

DROP TABLE IF EXISTS `educator`;
CREATE TABLE IF NOT EXISTS `educator` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `teaching_subjects` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2000;

--
-- Dumping data for table `educator`
--

INSERT INTO `educator` (`username`, `staff_id`, `name`, `phone`, `email`, `teaching_subjects`) VALUES
('educator1', 2000, 'Jonah Ng', '5555551213', 'educator1@email.com', 'Introduction to Computer Science');



--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `enrolled_subjects` varchar(255) NOT NULL,
  `student_status` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3000;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`username`, `student_id`, `name`, `phone`, `email`, `enrolled_subjects`, `student_status`) VALUES
('student1', 3000, 'Charlie', '5555551214', 'student1@email.com', 'Introduction to Computer Science', 'active');


--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `role` (`rid`) ON UPDATE CASCADE;
COMMIT;

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `administrator_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON UPDATE CASCADE;
COMMIT;


--
-- Constraints for table `educator`
--
ALTER TABLE `educator`
  ADD CONSTRAINT `educator_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON UPDATE CASCADE;
COMMIT;


--
-- Constraints for table `educator`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;