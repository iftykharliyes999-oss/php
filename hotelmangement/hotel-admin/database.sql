-- ===========================================
-- LISORA GRAND - Hotel Admin Pro Database
-- MySQL 5.7+ / 8.0
-- ===========================================
CREATE DATABASE IF NOT EXISTS hotel_admin
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hotel_admin;

-- ---------- USERS (staff) ----------
DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  phone VARCHAR(40),
  role ENUM('Manager','Moderator','Receptionist','Housekeeping') NOT NULL,
  password VARCHAR(255) NOT NULL,
  status ENUM('Active','Inactive') DEFAULT 'Active',
  joined DATE DEFAULT (CURRENT_DATE)
);

-- ---------- ROOMS ----------
DROP TABLE IF EXISTS rooms;
CREATE TABLE rooms (
  id INT AUTO_INCREMENT PRIMARY KEY,
  no VARCHAR(20) NOT NULL UNIQUE,
  type ENUM('Single','Double','Deluxe','Suite','Family','Presidential') NOT NULL,
  floor INT DEFAULT 0,
  cap INT DEFAULT 1,
  price DECIMAL(10,2) NOT NULL,
  bed VARCHAR(40),
  amenities VARCHAR(255),
  status ENUM('available','occupied','maintenance','cleaning') DEFAULT 'available',
  description TEXT
);

-- ---------- CUSTOMERS (guests) ----------
DROP TABLE IF EXISTS customers;
CREATE TABLE customers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(160),
  phone VARCHAR(40),
  nid VARCHAR(60),
  nationality VARCHAR(60) DEFAULT 'Bangladeshi',
  address VARCHAR(255),
  vip TINYINT(1) DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ---------- BOOKINGS ----------
DROP TABLE IF EXISTS bookings;
CREATE TABLE bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  guest VARCHAR(120) NOT NULL,
  phone VARCHAR(40) NOT NULL,
  email VARCHAR(160),
  nid VARCHAR(60),
  nationality VARCHAR(60),
  room_no VARCHAR(20) NOT NULL,
  room_type VARCHAR(40),
  rate DECIMAL(10,2) NOT NULL,
  guests INT DEFAULT 1,
  check_in DATE NOT NULL,
  check_out DATE NOT NULL,
  source VARCHAR(40) DEFAULT 'Walk-In',
  extras TEXT,
  discount DECIMAL(5,2) DEFAULT 0,
  total DECIMAL(10,2) DEFAULT 0,
  method VARCHAR(40) DEFAULT 'Cash',
  pay_status ENUM('paid','partial','unpaid') DEFAULT 'unpaid',
  status ENUM('pending','confirmed','checked-in','checked-out','cancelled') DEFAULT 'pending',
  notes TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ---------- TRANSACTIONS (payments / finance) ----------
DROP TABLE IF EXISTS transactions;
CREATE TABLE transactions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  type ENUM('income','expense','salary','service') NOT NULL,
  category VARCHAR(60) NOT NULL,
  description VARCHAR(255) NOT NULL,
  person VARCHAR(120),
  amount DECIMAL(12,2) NOT NULL,
  method VARCHAR(40) DEFAULT 'Cash',
  txn_date DATE NOT NULL,
  status ENUM('Paid','Pending','Failed') DEFAULT 'Paid'
);

-- ---------- SETTINGS ----------
DROP TABLE IF EXISTS settings;
CREATE TABLE settings (
  k VARCHAR(60) PRIMARY KEY,
  v TEXT
);

-- ---------- SAMPLE DATA ----------
INSERT INTO users (name,email,phone,role,password,status,joined) VALUES
('Rahim Uddin','rahim@lisora.com','+8801711111111','Manager',     SHA2('admin123',256),'Active','2025-01-12'),
('Karim Hasan','karim@lisora.com','+8801822222222','Moderator',   SHA2('admin123',256),'Active','2025-02-08'),
('Sabbir Ahmed','sabbir@lisora.com','+8801933333333','Receptionist',SHA2('admin123',256),'Inactive','2025-03-15'),
('Nusrat Jahan','nusrat@lisora.com','+8801644444444','Housekeeping',SHA2('admin123',256),'Active','2025-04-02'),
('Tanvir Khan','tanvir@lisora.com','+8801555555555','Manager',    SHA2('admin123',256),'Active','2025-04-22');

INSERT INTO rooms (no,type,floor,cap,price,bed,amenities,status,description) VALUES
('101','Single',1,1,2500,'Single Bed','AC, WiFi, TV','available','Cozy single room with city view'),
('102','Double',1,2,4500,'Double Bed','AC, WiFi, TV, Mini Bar','occupied','Spacious double room'),
('201','Deluxe',2,2,6500,'Queen','AC, WiFi, TV, Mini Bar, Balcony','available','Deluxe room with balcony'),
('202','Deluxe',2,3,7000,'King','AC, WiFi, TV, Mini Bar, Bathtub','maintenance','Under repair - AC fix'),
('301','Suite',3,4,12000,'King','AC, WiFi, TV, Living Room, Kitchen','occupied','Premium suite with living area'),
('302','Suite',3,4,12500,'King','AC, WiFi, TV, Jacuzzi, Balcony','available','Suite with jacuzzi'),
('401','Family',4,5,9500,'Twin Beds','AC, WiFi, TV, 2 Bathrooms','cleaning','Family room - 2 bedrooms'),
('501','Presidential',5,6,25000,'King','AC, WiFi, TV, Pool, Butler, Bar','available','Top-tier presidential suite');

INSERT INTO customers (name,email,phone,nid,nationality,address,vip) VALUES
('Rahim Ahmed','rahim@gmail.com','+8801711111111','1234567890','Bangladeshi','Dhanmondi, Dhaka',1),
('Sarah Khan','sarah@yahoo.com','+8801822222222','9876543210','Bangladeshi','Gulshan, Dhaka',1),
('John Smith','john@gmail.com','+1234567890','P12345678','American','New York, USA',1),
('Lopa Begum',NULL,'+8801933333333','5556667770','Bangladeshi','Mirpur, Dhaka',0),
('Imran Hossain','imran@hotmail.com','+8801544444444','1112223330','Bangladeshi','Uttara, Dhaka',0),
('Tom Wilson','tom@uk.com','+447700900111','P88991122','British','London, UK',0);

INSERT INTO bookings (guest,phone,email,nid,nationality,room_no,room_type,rate,guests,check_in,check_out,source,extras,discount,total,method,pay_status,status,notes) VALUES
('Rahim Ahmed','+8801711111111','rahim@gmail.com','1234567890','Bangladeshi','201','Deluxe',6500,2,'2026-05-04','2026-05-07','Website','Breakfast',5,22000,'Card','paid','checked-in','Late check-in around 11 PM'),
('Sarah Khan','+8801822222222','sarah@yahoo.com','9876543210','Bangladeshi','301','Suite',12000,2,'2026-05-05','2026-05-09','Booking.com','Airport Pickup, Spa',10,52000,'bKash','paid','confirmed','Honeymoon couple'),
('John Smith','+1234567890','john@gmail.com','P12345678','American','501','Presidential',25000,3,'2026-05-10','2026-05-15','Travel Agent','Breakfast, Mini Bar',0,140000,'Bank Transfer','partial','confirmed','VIP guest - butler service'),
('Lopa Begum','+8801933333333',NULL,'5556667770','Bangladeshi','102','Double',4500,2,'2026-05-03','2026-05-04','Walk-In','',0,4500,'Cash','paid','checked-out',''),
('Imran Hossain','+8801544444444','imran@hotmail.com','1112223330','Bangladeshi','401','Family',9500,5,'2026-05-08','2026-05-12','Phone Call','Breakfast',0,40000,'Cash','unpaid','pending','Family with 2 kids'),
('XYZ Corp Event','+8801666666666','event@xyz.com','CORP-001','Corporate','301','Suite',12000,4,'2026-04-18','2026-04-20','Corporate','',15,21000,'Bank Transfer','paid','checked-out','Conference event'),
('Tom Wilson','+447700900111','tom@uk.com','P88991122','British','202','Deluxe',7000,2,'2026-05-15','2026-05-18','Agoda','Airport Pickup',0,21000,'Card','unpaid','cancelled','Cancelled by guest');

INSERT INTO transactions (type,category,description,person,amount,method,txn_date,status) VALUES
('income','Booking','Room 101 - Rahim Ahmed','Rahim Ahmed',8500,'Card','2026-05-01','Paid'),
('income','Booking','Room 205 - Sarah Khan','Sarah Khan',12000,'bKash','2026-05-02','Paid'),
('income','Restaurant','Dinner Buffet x4','Walk-in',3200,'Cash','2026-05-02','Paid'),
('service','Service Charge','Laundry service - Room 305','Mr. Hasan',600,'Cash','2026-05-03','Paid'),
('service','Service Charge','Spa booking','Mrs. Lopa',2500,'Card','2026-05-03','Paid'),
('salary','Salary','April Salary - Karim (Receptionist)','Karim',18000,'Bank Transfer','2026-05-01','Paid'),
('salary','Salary','April Salary - Nasir (Manager)','Nasir',35000,'Bank Transfer','2026-05-01','Paid'),
('salary','Salary','April Salary - Rina (Housekeeping)','Rina',12000,'Cash','2026-05-01','Paid'),
('expense','Utility','Electricity Bill - April','DESCO',24500,'Bank Transfer','2026-05-04','Paid'),
('expense','Utility','Water & Gas - April','WASA/Titas',8200,'Cash','2026-05-04','Paid'),
('expense','Maintenance','AC repair - 3 rooms','Cool Tech',6500,'Cash','2026-04-28','Paid'),
('expense','Supplies','Toiletries restock','ABC Suppliers',9800,'Bank Transfer','2026-04-25','Paid'),
('expense','Marketing','Facebook ads campaign','Meta',5000,'Card','2026-04-22','Paid'),
('income','Booking','Conference Hall - Corp event','XYZ Corp',45000,'Bank Transfer','2026-04-18','Paid'),
('income','Booking','Room 410 - Family stay','Mr. Imran',15000,'Card','2026-04-15','Paid'),
('expense','Other','Office stationery','Local shop',1200,'Cash','2026-04-10','Paid'),
('income','Restaurant','Lunch orders - week','Various',18500,'Cash','2026-04-08','Paid'),
('service','Service Charge','Airport pickup','Mr. Tom',1500,'Cash','2026-04-05','Paid');

INSERT INTO settings (k,v) VALUES
('hotel_name','Lisora Grand'),
('hotel_email','info@lisora.com'),
('hotel_phone','+880 1700-000000'),
('hotel_address','Banani, Dhaka, Bangladesh'),
('currency','BDT'),
('vat_percent','15'),
('service_percent','10'),
('timezone','Asia/Dhaka');
