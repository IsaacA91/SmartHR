-- ID format AXXX
create table admin(
    adminID varchar(4) PRIMARY Key,
    firstName varchar(25),
    lastName varchar(25),
    company varchar(50),
    password varchar(12)
);
-- ID format EXXX
create table employee(
    employeeID varchar(4) PRIMARY KEY,
    company varchar(50),
    position varchar(25),
    department varchar(50),
    firstName varchar(25),
    lastName varchar(25),
    phone int,
    email varchar(50),
    username varchar(29),
    password varchar(12),
    baseSalary decimal(9,2),
    rate decimal (5,2),
);

-- total pay is calculated using the info from employee table
-- ID Format SXXXX
create table payslip(
    slipID varchar (5) PRIMARY KEY,
    employeeID varchar(4),
    payPeriodBeginning date,
    payPeriodEnd date,
    overtimeHours decimal(3,1),
    totalPayForPeriod decimal (10,2),
    FOREIGN KEY (employeeID) references employee(employeeID)
    on delete cascade
);
-- attendenceRecord keeps track of the information when an employee clocks in and then time out is filled when they clock out
-- ID Format RXXXXX
create table attendancerecord(
    recordID varchar(6) primary key,
    employeeID varchar(4),
    workDay date,
    hoursWorked decimal(3,1),
    timeIn time,
    timeOut time,
    FOREIGN KEY (employeeID) references employee(employeeID)
    on delete cascade
);
-- leave requests have an id and an attached employee ID and have three options of approval approvedBy will be the adminID of whoever approves the request
-- ID Format LXXXX
create table leaverequests(
    leaveRecordID varchar(5) primary key,
    employeeID varchar(4),
    startDate date,
    endDate date,
    approval enum('Approved','Pending','Rejected'),
    approvedBy varchar(4),
    FOREIGN KEY (employeeID) references employee(employeeID)
    on delete cascade
);
