-- MySQL dump 10.13  Distrib 8.0.45, for Win64 (x86_64)
--
-- Host: localhost    Database: student_dashboard
-- ------------------------------------------------------
-- Server version	8.0.45

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `assignments`
--

DROP TABLE IF EXISTS `assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assignments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `file` varchar(255) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignments`
--

LOCK TABLES `assignments` WRITE;
/*!40000 ALTER TABLE `assignments` DISABLE KEYS */;
INSERT INTO `assignments` VALUES (1,'Python Programming','Write factorial program','python_assignment.txt','2026-04-10','2026-04-04 10:09:11'),(2,'HTML Project','Create responsive webpage','html_assignment.txt','2026-04-12','2026-04-04 10:09:11'),(3,'DBMS Questions','Solve SQL queries','dbms_assignment.txt','2026-04-15','2026-04-04 10:09:11');
/*!40000 ALTER TABLE `assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,'Python Programming','Learn Python from basics to advanced'),(2,'Web Development','HTML, CSS, JS, PHP full stack'),(3,'Compiler Design','Basics of compiler and parsing'),(4,'Computer Networks','Networking fundamentals'),(5,'Open Source Technologies','Git, Linux, Open source tools');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_courses`
--

DROP TABLE IF EXISTS `student_courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  `course_id` int DEFAULT NULL,
  `status` enum('pending','completed') DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_courses`
--

LOCK TABLES `student_courses` WRITE;
/*!40000 ALTER TABLE `student_courses` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_progress`
--

DROP TABLE IF EXISTS `student_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_progress` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  `course_id` int DEFAULT NULL,
  `step` int DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_progress`
--

LOCK TABLES `student_progress` WRITE;
/*!40000 ALTER TABLE `student_progress` DISABLE KEYS */;
INSERT INTO `student_progress` VALUES (1,2,2,1,'completed'),(2,2,2,2,'completed'),(3,2,2,3,'completed'),(4,2,1,1,'completed'),(5,2,4,1,'completed'),(6,2,2,2,'completed'),(7,2,1,2,'completed'),(8,2,1,3,'completed'),(9,3,1,1,'completed'),(10,3,1,2,'completed'),(11,3,1,3,'completed'),(12,3,2,1,'completed'),(13,4,1,1,'completed'),(14,4,1,2,'completed'),(15,4,1,3,'completed'),(16,3,3,1,'completed'),(17,3,3,2,'completed'),(18,3,3,3,'completed'),(19,3,4,1,'completed'),(20,3,4,2,'completed'),(21,3,4,3,'completed'),(26,5,3,1,'completed'),(27,5,3,2,'completed'),(28,5,3,3,'completed'),(35,7,2,1,'completed'),(36,7,2,2,'completed'),(37,7,2,3,'completed'),(38,7,1,1,'completed'),(39,8,2,1,'completed'),(40,8,2,2,'completed'),(41,8,2,3,'completed'),(42,9,1,1,'completed'),(43,9,1,2,'completed'),(44,9,1,3,'completed'),(53,11,1,1,'completed'),(54,12,1,1,'completed'),(55,12,1,2,'completed'),(56,12,1,3,'completed'),(57,12,2,1,'completed'),(58,12,2,2,'completed');
/*!40000 ALTER TABLE `student_progress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,'Arun Kumar','arun','$2y$10$examplehash123456789','2026-04-03 06:48:52'),(2,'dhanalax','dhanlax','$2y$10$XXyR72rpHEbEIRIe0lJMcuFYHnsBjvLLQEQiEnqa50Gk95rrMkuDO','2026-04-03 06:50:27'),(3,'kathirvel','kathir','$2y$10$Eg3/dtAWE7LkJgUj4D4wneA.vvhX8H/OTHrJYdujwh/VL5QoELvkK','2026-04-04 07:31:29'),(4,'RAM SABEE','SARA','$2y$10$kd7fOezeXQr7qhCwINtkouL3lH16yZDdaMY3Dyv9pZW.Af4u.EZ02','2026-04-04 15:33:04'),(5,'pooja','pooja','$2y$10$8cUpbtWWHHRYmUueVH/3/.BEFjaJjPskLY6GCeBS9/HjbYAMi84Qm','2026-04-05 07:23:11'),(6,'gundu','gundu','$2y$10$Qr5rw1JXwMRBBu/L/HF/heQh6eljz4ZNh/UOPPXw9H9t1e6FyPS8m','2026-04-06 05:40:35'),(7,'bratheeswari','panda','$2y$10$zcdSCRhO2vJkr87cyxzrROn/0mElJe3i2pXo4NjKSpZf8ioWsnKOm','2026-04-06 09:00:06'),(8,'reka','reka','$2y$10$T9E3Ffvwny3gYw73flIZmu0FlZvfQuQW/UUcSJaRGIHg2UTm6GXpm','2026-04-06 09:35:25'),(9,'subhashree','subhashree','$2y$10$YQzoxpNF/UJ5QcBkRD.B6.YnoxZ3sK/j0d5dNGXJMkinq8IjuotnO','2026-04-06 09:40:53'),(10,'srinithi','sri','$2y$10$/QqvItYNvyN9XHqra1baS.hcydN92IyQRW3pNQQqQSe9OlbAVFRpG','2026-04-06 14:18:20'),(11,'adhi','adhi','$2y$10$By0FUNOTYFxdV7o/k9PrPOGcPexTkWfeSMXsdoMPMJNiSvqUvIIFG','2026-04-07 07:04:57'),(12,'lavanya','lavanya','$2y$10$mKvaahCETpUqXN.7mEaMbuoyAKrH5xGYabwKMa1QXEfGRVlQg7UFa','2026-04-13 13:21:21');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submissions`
--

DROP TABLE IF EXISTS `submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  `assignment_id` int DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Submitted',
  `marks` int DEFAULT NULL,
  `feedback` text,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `assignment_id` (`assignment_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`),
  CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  CONSTRAINT `submissions_ibfk_3` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`),
  CONSTRAINT `submissions_ibfk_4` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submissions`
--

LOCK TABLES `submissions` WRITE;
/*!40000 ALTER TABLE `submissions` DISABLE KEYS */;
INSERT INTO `submissions` VALUES (1,3,1,'files.zip','Submitted',NULL,NULL,'2026-04-04 10:12:12'),(2,3,1,'ChatGPT Image Apr 3, 2026, 12_38_52 PM.png','Submitted',NULL,NULL,'2026-04-04 10:12:39'),(3,4,1,'files.zip','Submitted',NULL,NULL,'2026-04-04 15:37:36'),(4,3,2,'files.zip','Submitted',NULL,NULL,'2026-04-05 05:58:11'),(5,3,3,'files.zip','Submitted',NULL,NULL,'2026-04-05 05:58:25'),(10,6,1,'DBMS.txt','Submitted',NULL,NULL,'2026-04-06 07:54:32'),(11,7,1,'DBMS.txt','Submitted',NULL,NULL,'2026-04-06 09:08:37'),(12,8,1,'DBMS.txt','Submitted',NULL,NULL,'2026-04-06 09:37:30'),(13,9,1,'DBMS.txt','Submitted',NULL,NULL,'2026-04-06 09:43:53'),(15,12,1,'DBMS.txt','Submitted',NULL,NULL,'2026-04-13 13:25:30');
/*!40000 ALTER TABLE `submissions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-26 19:52:05
