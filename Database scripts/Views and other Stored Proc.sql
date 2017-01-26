DROP VIEW ALL_BRANCH_DATA;
GO
CREATE VIEW ALL_BRANCH_DATA 
AS
SELECT BranchID,Location,Sales,Profit,MangerID,E.Name,P.ProductListID, P.ProductListName
FROM Branch B,WorkingPlace W,Manges M,Employee E,ProductList P
WHERE B.BranchID=W.WorkingPlaceID AND E.EmployeeID=M.MangerID AND M.WorkingPlaceID=B.BranchID
		AND B.BranchID=E.WorkingAt AND P.ProductListID=B.ProductListID
GO

DROP VIEW ALL_WAREHOUSE_DATA;
GO

CREATE VIEW ALL_WAREHOUSE_DATA 
AS
SELECT WarehouseID,Location,MangerID,E.Name,P.ProductListID,P.ProductListName
FROM Warehouse B,WorkingPlace W,Manges M,Employee E,ProductList P
WHERE B.WarehouseID=W.WorkingPlaceID AND E.EmployeeID=M.MangerID AND M.WorkingPlaceID=B.WarehouseID
		AND B.WarehouseID=E.WorkingAt AND P.ProductListID=B.ProductListID
		
GO

DROP VIEW ALL_DELIVERY_DATA;
GO

CREATE VIEW ALL_DELIVERY_DATA 
AS
SELECT DeliveryID,Location,MangerID,E.Name
FROM DeliveryDepartment B,WorkingPlace W,Manges M,Employee E
WHERE B.DeliveryID=W.WorkingPlaceID AND E.EmployeeID=M.MangerID AND M.WorkingPlaceID=B.DeliveryID
		AND B.DeliveryID=E.WorkingAt
GO

--CREATE VIEW ALL_CUSTOMER_DATA
--AS



GO 
DROP PROCEDURE GET_QUANTITY;
GO
CREATE PROCEDURE GET_QUANTITY
		@BAR_CODE INT
AS
DECLARE @QUANTITY INT
BEGIN
	SET @QUANTITY=-2;
	IF (EXISTS (	SELECT BarCode
					FROM Product
					WHERE BarCode=@BAR_CODE))
		BEGIN
			SET @QUANTITY=(	SELECT SUM(Quntity)
							FROM Contain C,Warehouse W
							WHERE @BAR_CODE=BarCode AND W.ProductListID=C.ProductListID )
			RETURN @QUANTITY
		END
	ELSE
		RETURN -1;
END
GO

DROP PROCEDURE REMOVE_MANGER
GO

CREATE PROCEDURE REMOVE_MANGER 
		@MANGER_ID INT 
AS
BEGIN
	IF (	EXISTS (	SELECT MangerID
						FROM Manges
						WHERE @MANGER_ID=MangerID) )
	BEGIN
		DELETE FROM Manges WHERE MangerID=@MANGER_ID
		UPDATE Employee 
		SET Classification='ACCOUNTANT'
		INSERT INTO Unsupervisied VALUES (@MANGER_ID,NULL);
	END
	ELSE
		RETURN -1
END
GO

DROP VIEW COUNT_OF_CUSTOMER_ORDERS;
GO
--HOW MANY ORDERS ARE MADE BY THE CUSTOMER
CREATE VIEW COUNT_OF_CUSTOMER_ORDERS
AS
SELECT O.CustomerID,COUNT(*) AS [Number of orders]
FROM [Order] O 
GROUP BY O.CustomerID
GO

DROP VIEW NUMBER_OF_EMPLOYEE_IN_WORKING_PLACE;
GO
CREATE VIEW NUMBER_OF_EMPLOYEE_IN_WORKING_PLACE
AS
SELECT WorkingAt AS WORKING_PLACE,COUNT(*)AS EMPLOYEE_COUNT
FROM Employee
GROUP BY WorkingAt 
GO

DROP VIEW EMPLOYEE_WORKING_IN_WORKING_PLACE;
GO
CREATE VIEW EMPLOYEE_WORKING_IN_WORKING_PLACE
AS
SELECT WorkingPlaceID,EmployeeID
FROM Employee,WorkingPlace
WHERE WorkingAt=WorkingPlaceID
GO

DROP VIEW PRODUCTS_IN_BRANCH
GO
CREATE VIEW PRODUCTS_IN_BRANCH
AS
SELECT BranchID,BarCode AS ProductBarCode,Quntity
FROM Contain C,Branch B
WHERE B.ProductListID=C.ProductListID
GO

DROP VIEW PRODUCTS_IN_WAREHOUSE
GO
CREATE VIEW PRODUCTS_IN_WAREHOUSE
AS
SELECT WarehouseID,BarCode AS ProductBarCode,Quntity
FROM Contain C,Warehouse W
WHERE W.ProductListID=C.ProductListID
GO

DROP VIEW COUNT_PRODUCT_BRANCH
GO
CREATE VIEW COUNT_PRODUCT_BRANCH
AS
SELECT BranchID,COUNT(*)AS ProducQuantity
FROM Contain C,Branch B
WHERE B.ProductListID=C.ProductListID
GROUP BY BranchID
GO

DROP VIEW COUNT_PRODUCT_WAREHOUSE
GO
CREATE VIEW COUNT_PRODUCT_WAREHOUSE
AS
SELECT WarehouseID,COUNT(*)AS ProducQuantity
FROM Contain C,Warehouse W
WHERE W.ProductListID=C.ProductListID
GROUP BY WarehouseID
GO

DROP VIEW ALL_CUSTOMER_DATA;
GO
CREATE VIEW ALL_CUSTOMER_DATA
AS
SELECT C.CustomerID, C.Name,C.Gender,C.Age,OrderCont
FROM Customer c INNER JOIN (SELECT COUNT(*) AS OrderCont, o.CustomerID AS tempID from [Order] o GROUP BY o.CustomerID) as tempTable
ON c.CustomerID = tempTable.tempID
GO

CREATE PROCEDURE WAREHOUSE_SUPPLY_BRANCH
		@BRANCH_ID INT,
		@WAREHOUSE_ID INT
AS
BEGIN
	IF (	EXISTS(	SELECT BranchID
					FROM Branch
					WHERE BranchID=@BRANCH_ID)
			AND EXISTS (	SELECT WarehouseID
							FROM Warehouse
							WHERE WarehouseID=@WAREHOUSE_ID) )
			INSERT INTO Supply VALUES (@WAREHOUSE_ID,@BRANCH_ID,GETDATE()) ;
	ELSE
		RETURN -1;
END
GO

CREATE PROCEDURE PRODUCT_FROM_WAREHOUSE_TO_BRANCH
		@BRANCH_ID INT,
		@WAREHOUSE_ID INT,
		@PRODUCT_BAR_CODE INT,
		@QUANTITY INT
AS
DECLARE @TEMP_BRANCH_LIST INT,
		@TEMP_WAREHOUSE_LIST INT
BEGIN
	IF (	EXISTS(	SELECT BranchID 
					FROM Branch
					WHERE @BRANCH_ID=BranchID)
			AND EXISTS (	SELECT WarehouseID
							FROM Warehouse
							WHERE @WAREHOUSE_ID=WarehouseID)
			AND @QUANTITY<= (	SELECT C.Quntity 
								FROM Contain C,Warehouse W
								WHERE W.WarehouseID=@WAREHOUSE_ID AND W.ProductListID=C.ProductListID AND C.BarCode=@PRODUCT_BAR_CODE) )
			BEGIN
				SET @TEMP_BRANCH_LIST=(	SELECT ProductListID
										FROM Branch
										WHERE BranchID=@BRANCH_ID);
										
				SET @TEMP_WAREHOUSE_LIST=(	SELECT ProductListID
											FROM Warehouse
											WHERE WarehouseID=@WAREHOUSE_ID);
				UPDATE Contain 
				SET Quntity=Quntity-@QUANTITY
				WHERE @TEMP_WAREHOUSE_LIST=ProductListID AND BarCode=@PRODUCT_BAR_CODE;
				UPDATE Contain 
				SET Quntity=Quntity+@QUANTITY
				WHERE @TEMP_BRANCH_LIST=ProductListID AND BarCode=@PRODUCT_BAR_CODE;
			END
		ELSE 
			RETURN -1;
END
GO

CREATE PROCEDURE SELL_ITEM
	@BRANCH_ID INT,
	@BAR_CODE INT,
	@QUANTITY INT
AS
DECLARE @TEMP_BRANCH_LIST INT
BEGIN
	IF (	EXISTS (	SELECT BranchID
						FROM Branch
						WHERE @BRANCH_ID=BranchID)
			AND EXISTS (	SELECT BarCode 
							FROM Contain C,Branch B
							WHERE B.ProductListID=C.ProductListID AND @BAR_CODE=C.BarCode)
			AND @QUANTITY<= (	SELECT Quntity 
								FROM Contain C,Branch B
								WHERE B.ProductListID=C.ProductListID AND @BAR_CODE=C.BarCode ))
			BEGIN
				UPDATE Branch
				SET Profit=Profit+ (@QUANTITY * (SELECT Price FROM Product WHERE BarCode=@BAR_CODE))
				WHERE BranchID=@BRANCH_ID
				SET @TEMP_BRANCH_LIST= (	SELECT ProductListID
											FROM Branch
											WHERE BranchID=@BRANCH_ID)
				UPDATE Contain
				SET Quntity=Quntity-@QUANTITY
				WHERE @TEMP_BRANCH_LIST=ProductListID AND BarCode=@BAR_CODE
			END	 
END