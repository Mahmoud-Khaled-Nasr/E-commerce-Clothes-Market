using NoAdapterAPI.Models;
using NoAdapterAPI.Models.Fillers;
using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Web.Http;

namespace NoAdapterAPI.Controllers.ModelContollers
{
    /// <summary>
    /// Logic Controller for Order Class
    /// </summary>
    [RoutePrefix("api/Order")]
    public class OrderController : ApiController
    {
        /// <summary>
        /// Gets ALL Orders from the Database
        /// </summary>
        /// <returns>A List of Order Objects</returns>
        [HttpGet]
        public List<Order> Get()
        {
            var temp = DatabaseManager.ExecuteReader("SELECT * FROM [ORDER]");
            return Filler.FillList<Order>(temp);
        }

        /// <summary>
        /// Gets the Order Corrosponding to this ID 
        /// </summary>
        /// <param name="OrderID">Order ID</param>
        /// <returns>Order with this ID or null if none exists</returns>
        [HttpGet]
        public Order Get([FromUri]int OrderID)
        {
            var temp = DatabaseManager.ExecuteReader(string.Format("SELECT * FROM [Order] WHERE OrderID = {0}", OrderID));
            var list = Filler.FillList<Order>(temp);
            if (list.Count == 0)
                return null;
            return list.First();
        }

        /// <summary>
        /// Starts a new Order //Note: This Only Starts the Order.... to add Products, Call the PUT method.
        /// </summary>
        /// <param name="temp">Order data from the Request Body</param>
        /// <returns>Order ID to add Products to</returns>
        [HttpPost]
        public int Post([FromBody]Order temp)
        {
            var param = new Dictionary<string, object>();
            param.Add("Customer", temp.CustomerID);
            param.Add("WarehouseID", temp.WarehouseID);
            param.Add("Delivery", temp.DeliveryID);
            return (int)DatabaseManager.ExecuteProcedure("CREATE_ORDER", param);
        }

        /// <summary>
        /// Adds a Product to an Order
        /// </summary>
        /// <param name="OrderID">Order ID to add the Product to</param>
        /// <param name="BarCode">Product Barcode</param>
        /// <param name="Quantity">Quantity of The Prodct</param>
        /// <returns>A number more than ZERO if successful or -1 if failed</returns>
        [HttpPut]
        public int Put([FromUri]int OrderID, [FromUri]int BarCode, [FromUri]int Quantity)
        {
            var param = new Dictionary<string, object>();
            param.Add("@ProductList_ID", OrderID);
            param.Add("@Product_BarCode", BarCode);
            param.Add("@Quantity", Quantity);
            return (int)DatabaseManager.ExecuteProcedure("Populate_ProductList", param);
        }
        /// <summary>
        /// Deletes an Order
        /// </summary>
        /// <param name="OrderID">OrderID to delete</param>
        /// <returns>A number more than ZERO if successful or -1 if failed</returns>
        [HttpDelete]
        public int Delete([FromUri]int OrderID)
        {
            return DatabaseManager.ExecuteNonQuery(string.Format("Delete from [Order] where OrderID = {0}", OrderID));
        }

        /// <summary>
        /// Check if an Order exists
        /// </summary>
        /// <param name="OrderID">OrderID to check</param>
        /// <returns>Boolean</returns>
        [HttpPatch]
        public bool check([FromUri]int OrderID)
        {
            return (int) DatabaseManager.ExecuteScalar(string.Format("Select Count(*) from [Order] where OrderID = {0}", OrderID)) > 0 ? true : false;
        }
        /// <summary>
        /// Gets The Count in the database
        /// </summary>
        /// <returns>Integer</returns>
        [HttpDelete]
        public int Count()
        {
            return (int)DatabaseManager.ExecuteScalar("Select Count(*) from [Order]");
        }

    }
}
