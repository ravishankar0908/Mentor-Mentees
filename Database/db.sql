CREATE DATABASE IF NOT EXISTS mentorship;

USE mentorship;

CREATE TABLE IF NOT EXISTS registration(
    id int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fname varchar(20) NOT NULL,
    lname varchar(20),
    dob varchar(10) NOT NULL,
    email varchar(50) NOT NULL,
    pass varchar(100) NOT NULL,
    cpass varchar(100) NOT NULL,
    category int(10) NOT NULL
);

CREATE TABLE IF NOT EXISTS students(
    stuid int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fname varchar(20) NOT NULL,
    lname varchar(20),
    dob varchar(10) NOT NULL,
    gender varchar(20) NOT NULL,
    email varchar(50) NOT NULL,
    dp varchar(100) NULL
);

CREATE TABLE IF NOT EXISTS mentor(
    menid int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fname varchar(20) NOT NULL,
    lname varchar(20),
    dob varchar(10) NOT NULL,
    gender varchar(20) NOT NULL,
    email varchar(50) NOT NULL,
    designation varchar(20) NULL,
    dp varchar(100) NULL
);

CREATE TABLE IF NOT EXISTS task(
    taskid int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    taskname varchar(20) NOT NULL,
    startdate varchar(20) NOT NULL,
    enddate varchar(10) NOT NULL,
    taskdesc varchar(250) NOT NULL,
    menid int(10) NOT NULL,
    CONSTRAINT fk_mentor_task FOREIGN KEY (menid) REFERENCES mentor(menid)
);


CREATE TABLE IF NOT EXISTS mentormenteeslist(
    mmid int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    menid int(10) NOT NULL,
    stuid int(10) NOT NULL,
    CONSTRAINT fk_mentor_id FOREIGN KEY (menid) REFERENCES mentor(menid),
    CONSTRAINT fk_student_id FOREIGN KEY (stuid) REFERENCES students(stuid)
);

CREATE TABLE IF NOT EXISTS taskstatus(
    taskstatusid int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    taskid int(10) NOT NULL,
    stuid int(10) NOT NULL,
    taskpdf varchar(200) NOT NULL,
    mark int(20) NULL,
    CONSTRAINT fk_task_id FOREIGN KEY (taskid) REFERENCES task(taskid),
    CONSTRAINT fk_stuid_id FOREIGN KEY (stuid) REFERENCES students(stuid)
);

CREATE TABLE IF NOT EXISTS taskduerequest(
    taskduerequestid int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    taskid int(10) NOT NULL,
    stuid int(10) NOT NULL,
    requestdate varchar(20) NOT NULL,
    CONSTRAINT fk_task_id_requesttask FOREIGN KEY (taskid) REFERENCES task(taskid),
    CONSTRAINT fk_stuid_id_requesttask FOREIGN KEY (stuid) REFERENCES students(stuid)
);

CREATE TABLE IF NOT EXISTS request(
    requestid int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fromname varchar(30) NOT NULL,
    toname varchar(30) NOT NULL,
    subjects varchar(200) NOT NULL,
    messages varchar(200) NOT NULL,
    stuid int(10) NOT NULL,
    request_date varchar(20) NOT NULL,
    collegename varchar(100) NOT NULL,
    city varchar(100) NOT NULL,
    zipcode int(50) NOT NULL,
    ack_hod varchar(10) NOT NULL,
    ack_date varchar(20) NOT NULL,
    years varchar(20) NOT NULL,
    CONSTRAINT fk_stuid_request FOREIGN KEY (stuid) REFERENCES students(stuid)
);


CREATE TABLE IF NOT EXISTS feedback(
    fbid int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    menid int(10) NOT NULL,
    stuid int(10) NOT NULL,
    feedbacks varchar(200) NOT NULL,
    sentdetails varchar(50) NOT NULL,
    CONSTRAINT fk_mentor_feedback_id FOREIGN KEY (menid) REFERENCES mentor(menid),
    CONSTRAINT fk_student_feedback_id FOREIGN KEY (stuid) REFERENCES students(stuid)
);