-- ID format CXXX
create table company(
	companyID varchar(4) primary key,
	companyName varchar(50),
	companyOwner varchar(50)
);
-- ID format DXXX
-- A company can have many departments
create table department(
	departmentID varchar(4) primary key,
	departmentName varchar(50),
	departmentManager varchar(50),
	departmentLocation varchar(125),
	companyID varchar(4),
	foreign key (companyID) references company(companyID) on delete cascade
);
-- ID format AXXX
create table admin(
    adminID varchar(4) PRIMARY Key,
    firstName varchar(25),
    lastName varchar(25),
    companyID varchar(4),
    password varchar(255),
	foreign key (companyID) references company(companyID) on delete cascade
);
-- ID format EXXX
create table employee(
    employeeID varchar(4) PRIMARY KEY,
    companyID varchar(4),
    position varchar(25),
    departmentID varchar(4),
    firstName varchar(25),
    lastName varchar(25),
    phone varchar(20),
    email varchar(50),
    username varchar(29),
    password varchar(255),
    baseSalary decimal(9,2),
    rate decimal (5,2),
	foreign key (companyID) references company(companyID) on delete cascade,
	foreign key (departmentID) references department(departmentID) on delete set null
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
-- Each employee scheduled gets a row on the table allows multiple inputs for employees working extra shifts for the day
-- Best to organize whos working by ordering it by shiftDate
-- sample ID WXXX
create table workSchedule(
	scheduleID varchar(4) primary key,
    employeeID varchar(4),
    shiftDate date,
    shiftBegin time,
    shiftEnd time,
    foreign key (employeeID) REFERENCES employee(employeeID) 
    on delete cascade
);
-- leave requests have an id and an attached employee ID and have three options of approval approvedBy will be the adminID of whoever approves the request
-- ID Format LXXXX
create table leaverequests(
    leaveRecordID varchar(5) primary key,
    employeeID varchar(4),
    startDate date,
    endDate date,
    approval enum('Approved','Pending','Rejected') default 'Pending',
    approvedBy varchar(4),
    FOREIGN KEY (employeeID) references employee(employeeID)
    on delete cascade
);
