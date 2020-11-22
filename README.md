# Faculty-Evaluation-System
Faculty Evaluation System is a system that evaluate faculties to let them know and improve their performances.

Disclaimer: This project is made within short time only and not developed well, as you can see the project is made with
pure PHP,bootstrap and CSS only and no fancy frameworks were used. This means that the project was made by me and I'm just an
absolute beginner trying to enhance my skills.

# Tools used in this project;
- Xampp
- PHP
- Bootstrap
- CSS
- JS
- Windows 10 OS


# Note: 
if you want to try the system you should create a database first in your localhost definitely in Xampp PhpMyAdmin,
I have pasted all of the queries for my database below so you can just copy and paste it in your phpmyadmin SQL. remember to
change your DB connection in the code I'm using this information to connect to my localhost;

host: localhost
username: root
password:
database: faculty_evaluation

# SQL query to create database used in this system

CREATE DATABASE Faculty_Evaluation;

use Faculty_Evaluation;

create table Admin(
	ID int(3) not null AUTO_INCREMENT,
    username varchar(30) not null,
    password varchar(3) not null,
    PRIMARY KEY(ID)
);

CREATE TABLE Student(
	ID VARCHAR(15) NOT NULL UNIQUE,
    First_name VARCHAR(30) NOT NULL,
    Middle_name VARCHAR(30) NOT NULL,
    Last_name VARCHAR(30) NOT NULL,
    Major VARCHAR(30) NOT NULL,
    Gender VARCHAR(6) NOT NULL,
    Present_Address VARCHAR(150) NOT NULL,
    Contact_Number VARCHAR(15) NOT NULL,
    Guardian VARCHAR(50) NOT NULL,
    Guardian_Contact_Number VARCHAR(15),
    Username VARCHAR(30) NOT NULL,
    Password VARCHAR(30) NOT NULL,
    Admin_ID INT(3) NOT NULL,
    CONSTRAINT FK_Admin FOREIGN KEY(Admin_ID) REFERENCES Admin(ID) ON DELETE SET NULL ON UPDATE CASCADE  
);

CREATE TABLE Faculty(
    ID VARCHAR(15) NOT NULL UNIQUE,
    First_name VARCHAR(25) NOT NULL,
    Middle_name VARCHAR(25) NOT NULL,
    Last_name VARCHAR(25) NOT NULL,
    Department VARCHAR(30) NOT NULL,
    Gender VARCHAR(6) NOT NULL,
    Present_Address VARCHAR(150) NOT NULL,
    Contact_Number VARCHAR(15) NOT NULL,
    Admin_ID INT(3),
   PRIMARY KEY(ID),
    CONSTRAINT FK_Admin_ID FOREIGN KEY(Admin_ID) REFERENCES Admin(ID) ON DELETE SET NULL ON UPDATE CASCADE  
);

CREATE TABLE Evaluate(
	  ID INT(10) NOT NULL,
    Date_Evaluated DATE NOT NULL,
    Status  VARCHAR(10) NOT NULL,
    Student_ID VARCHAR(15),
    Faculty_ID VARCHAR(15),
    Subject_Code VARCHAR(15),
    Course_Code VARCHAR(15),
    PRIMARY KEY(ID),
    CONSTRAINT FOREIGN KEY(Student_ID) REFERENCES Student(ID) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY(Faculty_ID) REFERENCES faculty(ID) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY(Subject_Code) REFERENCES Subject(Subject_Code) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY(Course_Code) REFERENCES Course(Course_Code) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE Questioner(
	  ID INT(3) NOT NULL AUTO_INCREMENT,
    Question VARCHAR(100) NOT NULL,
    Date_Added DATE NOT NULL,
    Admin_ID INT(3),
    PRIMARY KEY(ID),
    CONSTRAINT FOREIGN KEY(Admin_ID) REFERENCES Admin(ID) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE Course(
	Course_Code VARCHAR(15) NOT NULL,
    Course_Description VARCHAR(100) NOT NULL,
    Date_Added DATE NOT NULL,
    Admin_ID INT(3),
    PRIMARY KEY(Course_Code),
    CONSTRAINT FOREIGN KEY(Admin_ID) REFERENCES Admin(ID)
);

CREATE TABLE Subject(
	Subject_Code VARCHAR(15) NOT NULL,
    Subject_Description VARCHAR(100) NOT NULL,
    Date_Added DATE NOT NULL,
    Admin_ID INT(3),
    PRIMARY KEY(Subject_Code),
    CONSTRAINT FOREIGN KEY(Admin_ID) REFERENCES Admin(ID)
);
CREATE TABLE Schedule(
   ID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Semester VARCHAR(3) NOT NULL,
    Section VARCHAR(15) NOT NULL,
    Year_Level VARCHAR(3) NOT NULL,
    Faculty_ID VARCHAR(15),
    Subject_Code VARCHAR(15),
    Course_Code VARCHAR(15),
    Admin_ID INT(3),
    CONSTRAINT FOREIGN KEY(Faculty_ID) REFERENCES Faculty(ID) ON DELETE CASCADE ON UPDATE CASCADE,
     CONSTRAINT FOREIGN KEY(Subject_Code) REFERENCES Subject(Subject_Code) ON DELETE CASCADE ON UPDATE CASCADE,
     CONSTRAINT FOREIGN KEY(Course_Code) REFERENCES Course(Course_Code) ON DELETE CASCADE ON UPDATE CASCADE,
     CONSTRAINT FOREIGN KEY(Admin_ID) REFERENCES Admin(ID) ON DELETE CASCADE ON UPDATE CASCADE
 );

