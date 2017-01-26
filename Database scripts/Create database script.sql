--CREATE DATABASE Project
GO
USE Project
GO

IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='WorkingPlace')
CREATE TABLE  [WorkingPlace]
(
	[WorkingPlaceID] INT IDENTITY(1,1) PRIMARY KEY,
    [Location] VARCHAR(100) NOT NULL UNIQUE,
	[Classification] VARCHAR (10) CHECK (Classification IN('WAREHOUSE','BRANCH','DELIVERY'))
)

GO
CREATE TRIGGER DELETE_WORKINGPLACE ON WorkingPlace
INSTEAD OF DELETE
AS
	DECLARE @ID INT;
	DECLARE @TYPE VARCHAR(10);
	SELECT @ID =D.WorkingPlaceID FROM deleted D;
	SELECT @TYPE = D.Classification FROM deleted D;
BEGIN
	IF (@ID NOT IN (SELECT WorkingPlaceID FROM WorkingPlace WHERE WorkingPlaceID=@ID))
		BEGIN
			RAISERROR ('THIS ISNOT A VALID ID',16,1);
			ROLLBACK
		END
	IF (@TYPE='BRANCH')
		BEGIN
			DELETE FROM Supply WHERE @ID=BranchID;
		END
	IF (@TYPE='DELIVERY')
		BEGIN
			UPDATE [Order]
			SET DeliveryID =NULL 
			WHERE @ID=DeliveryID;
		END
	IF (@TYPE='WAREHOUSE')
		BEGIN
			DELETE FROM Supply WHERE @ID=WarehouseID;

			UPDATE [Order]
			SET WarehouseID =NULL 
			WHERE @ID=WarehouseID;

			UPDATE Shipment 
			SET WarehouseID =NULL 
			WHERE @ID=WarehouseID;
		END
	DELETE FROM Employee WHERE WorkingAt=@ID;
	DELETE FROM WorkingPlace WHERE @ID=WorkingPlaceID;;
END
GO



IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='Brand') 
CREATE TABLE  [Brand]
(
  [BrandName] VARCHAR(20) PRIMARY KEY,
  [GenderSales] nchar(1) CHECK(GenderSales IN('M','F','B')) NOT NULL,
  [Description] VARCHAR(100) NULL
)

--DEFAULT BRAND
INSERT INTO Brand (BrandName,GenderSales)
VALUES ('UNBRANDED','B');

IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='Category') 
CREATE TABLE  [Category]
(
  [CategoryID] INT IDENTITY(1,1) PRIMARY KEY,
  [CategoryName] NVARCHAR(50) NOT NULL UNIQUE
)

--DEFAULT CATEGORY
SET IDENTITY_INSERT Category ON; 
INSERT INTO Category (CategoryID,CategoryName)
VALUES (0,'UNCATEGORIZIED');
SET IDENTITY_INSERT Category OFF; 


IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='Season') 
CREATE TABLE  [Season]
(
  [SeasonName] NVARCHAR(50) PRIMARY KEY,
  [StartDate] DATE NOT NULL,
  [EndDate] DATE NOT NULL
)

--DEFAULT SEASON
INSERT INTO Season (SeasonName,StartDate,EndDate)
VALUES ('FREE_SEASON','20000101','20001229');

IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='Supplier') 
CREATE TABLE  [Supplier]
(
  [SupplierID] INT IDENTITY(1,1) PRIMARY KEY,
  [Name] VARCHAR(100) NOT NULL
)

IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='Customer') 
CREATE TABLE  [Customer]
(
  [CustomerID] INT IDENTITY(1,1) PRIMARY KEY,
  [UserName] VARCHAR(30) NOT NULL UNIQUE,
  [Password] VARCHAR(30) NOT NULL ,
  [SSN] NCHAR(14) NOT NULL UNIQUE,
  [Name] VARCHAR(50) NOT NULL,
  [Gender] nchar(1) CHECK(gender IN('M','F')) NOT NULL,
  [Age] INT CHECK(age>0) NOT NULL
)

-- Dependant Tables

/*ASSUMPTIONS
 *IF A DEPARTMENT IS DELETED SO ITS EMPLOYEES AND MANGER
 *DELETING A SUPERVISOR MOVES HIS SUPERVISEE TO A TEMP TABLE WITH DEFALUT SUPERVISOR UNTIL THEY ARE ASIGNED TO 
 *	NEW SUPERVISOR
 */
IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='Employee')
CREATE TABLE  [Employee]
(
	[EmployeeID] INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	[SSN] nchar(14) NOT NULL UNIQUE,
    [Name] VARCHAR(100) NOT NULL,
	[Gender] nchar(1) CHECK(Gender IN('M','F')) NOT NULL,
	[BaseSalary] DECIMAL check (BaseSalary>=0)  NOT NULL,
	[Extra] DECIMAL check (Extra>=0) NOT NULL,
	[Classification] nchar(10) CHECK(Classification IN('MANGER','CASHIER','ACCOUNTANT','DELIVERY')) NOT NULL,
	[PhoneNumber] nchar(11) NOT NULL,
	[Address] VARCHAR(100) NOT NULL,
	[WorkingHours] float check (WorkingHours>=0) NOT NULL,
    --THE FOREIGN KEY
	[WorkingAt] INT NOT NULL REFERENCES WorkingPlace(WorkingPlaceID),
	[SupervisorID] INT NULL REFERENCES Employee(EmployeeID)
)


IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='Unsupervisied')
CREATE TABLE Unsupervisied
(
	[EmployeeID] INT PRIMARY KEY REFERENCES Employee(EmployeeID)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
	[LastSupervisorSSN] NCHAR (14) UNIQUE
)
GO
CREATE TRIGGER DELETE_EMPLOYEE ON Employee
INSTEAD OF DELETE 
AS
	DECLARE @ID INT;
	DECLARE @TYPE VARCHAR(10);
	SELECT @ID=E.EmployeeID FROM deleted E;
	SELECT @TYPE=E.Classification FROM deleted E;
	
	BEGIN
		IF (@ID NOT IN (SELECT EmployeeID FROM Employee WHERE EmployeeID=@ID))
		BEGIN
			RAISERROR ('THIS ISNOT A VALID ID',16,1);
			ROLLBACK
		END
		IF (@TYPE='MANGER')
			BEGIN
				DELETE FROM Manges WHERE @ID=MangerID;
			END
		IF (@ID IN (SELECT DISTINCT E.EmployeeID FROM Employee AS E,EMPLOYEE AS S WHERE E.EmployeeID=S.SupervisorID ))
			BEGIN
				INSERT INTO Unsupervisied (EmployeeID,LastSupervisorSSN)
				( SELECT E.EmployeeID , S.SSN FROM Employee AS E,Employee AS S WHERE E.SupervisorID=@ID AND S.EmployeeID=@ID );
				SET IDENTITY_INSERT Employee ON;
				UPDATE Employee
				SET SupervisorID=NULL WHERE SupervisorID=@ID;
				SET IDENTITY_INSERT Employee OFF;
				PRINT ('THE EMPLOYEES WITHOUT SUPERVISOR ARE MOVED TO UNSUPERVISED TABLE');
			END
		DELETE FROM Employee WHERE EmployeeID=@ID;
	END 
GO


IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='Manges')
CREATE TABLE [Manges]
(
	[MangerID] INT NOT NULL UNIQUE REFERENCES Employee(EmployeeID),
	[WorkingPlaceID] INT NOT NULL UNIQUE REFERENCES WorkingPlace(WorkingPlaceID)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
	PRIMARY KEY (MangerID,WorkingPlaceID)
)


IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='Product') 
CREATE TABLE  [Product] 
(
    [BarCode] INT IDENTITY(1,1) PRIMARY KEY,
    [Size] INT CHECK(Size >0) NOT NULL,
    [Color] nchar(6) NOT NULL,
    [Gender] nchar(1) CHECK(Gender IN('M','F')) NOT NULL,
    [Price] DECIMAL NOT NULL,
    [ProductStatus] nchar(7) CHECK(ProductStatus IN('Stored', 'OnSale', 'NotAvilable')) NOT NULL,
	[Image] Image NULL,
    --FOREIGN KEY
    [CategoryID] INT NOT NULL DEFAULT 0 REFERENCES Category(CategoryID)
	ON DELETE SET DEFAULT
	ON UPDATE CASCADE,
    [BrandName] VARCHAR(20) NOT NULL DEFAULT 0 REFERENCES Brand(BrandName)
	ON DELETE SET DEFAULT
	ON UPDATE CASCADE
)

IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='ProductList') 
CREATE TABLE  [ProductList]
(
	[ProductListID] INT IDENTITY(1,1) PRIMARY KEY,
	[ProductListName] VARCHAR(20) NULL
)

IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='Branch') 
CREATE TABLE  [Branch]
(
  [BranchID] INT PRIMARY KEY REFERENCES WorkingPlace(WorkingPlaceID)
	ON DELETE CASCADE
	ON UPDATE CASCADE, 
  [Sales] DECIMAL NOT NULL,
  [Profit] DECIMAL NOT NULL,
  [ProductListID] INT UNIQUE REFERENCES ProductList(ProductListID)
	ON DELETE NO ACTION
	ON UPDATE CASCADE
)

IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='Warehouse') 
CREATE TABLE  [Warehouse]
(
  [WarehouseID] INT PRIMARY KEY REFERENCES WorkingPlace(WorkingPlaceID)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
  --FOREIGN KEY
  [ProductListID] INT UNIQUE REFERENCES ProductList(ProductListID)
	ON DELETE NO ACTION
	ON UPDATE CASCADE 
 )

IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='DeliveryDepartment') 
CREATE TABLE  [DeliveryDepartment] 
(
  [DeliveryID] INT PRIMARY KEY REFERENCES WorkingPlace(WorkingPlaceID)
	ON DELETE CASCADE
	ON UPDATE CASCADE
)

IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='BelongsTo') 
CREATE TABLE  [BelongsTo]
(
	[SeasonName] NVARCHAR(50) NOT NULL DEFAULT 'FREE_SEASON' REFERENCES Season(SeasonName)
	ON DELETE SET DEFAULT
	ON UPDATE CASCADE,
    [BarCode] INT NOT NULL REFERENCES Product(BarCode)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
    PRIMARY KEY (SeasonName, BarCode)
)

IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='Supply') 
CREATE TABLE  [Supply]
(
	[WarehouseID] INT REFERENCES Warehouse(WarehouseID),
    [BranchID] INT REFERENCES Branch(BranchID),
	[Date] DATE NOT NULL,
    PRIMARY KEY (WarehouseID, BranchID)
)

IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='Order') 
CREATE TABLE  [Order]
(
	[OrderID] INT IDENTITY(1,1) PRIMARY KEY,
	--FORGEIN KEY
	[CustomerID] INT NOT NULL REFERENCES Customer(CustomerID)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	[ProductListID] INT NOT NULL REFERENCES ProductList(ProductListID)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
   	[WarehouseID] INT NULL REFERENCES Warehouse(WarehouseID),
	[DeliveryID] INT NULL REFERENCES DeliveryDepartment(DeliveryID)
)

IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='Shipment') 
CREATE TABLE  [Shipment]
(
	[ShipmentID] INT IDENTITY(1,1) PRIMARY KEY,
	[ProductListID] INT NOT NULL UNIQUE REFERENCES ProductList(ProductListID)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
    [SupplierID] INT NULL REFERENCES Supplier(SupplierID)
	ON DELETE SET NULL
	ON UPDATE CASCADE,
	[WarehouseID] INT NULL REFERENCES Warehouse(WarehouseID)
)

IF NOT EXISTS (SELECT * FROM sys.tables WHERE NAME ='Contains') 
CREATE TABLE  [Contain]
(
	Quntity INT NOT NULL DEFAULT 1,
	[ProductListID] INT NOT NULL REFERENCES ProductList(ProductListID)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
	[BarCode] INT NOT NULL REFERENCES Product(BarCode)
	ON DELETE CASCADE
	ON UPDATE CASCADE, 
	PRIMARY KEY (ProductListID,BarCode)
)
