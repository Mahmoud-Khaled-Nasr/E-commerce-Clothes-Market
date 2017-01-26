using NoAdapterAPI.Models;
using NoAdapterAPI.Models.Fillers;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Web.Http;

namespace NoAdapterAPI.Controllers.ModelContollers
{
    /// <summary>
    /// Logic Controller for Branch class
    /// </summary>
    [RoutePrefix("api/Branch")]
    public class BranchController : ApiController
    {
        /// <summary>
        /// Gets ALL Branches from the Database
        /// </summary>
        /// <returns>a List of Branches</returns>
        [HttpGet]
        public List<Branch> Get()
        {
            var temp = DatabaseManager.ExecuteReader("Select * From Brand");
            return Filler.FillList<Branch>(temp);
        }

        /// <summary>
        /// Gets a Branch with a specific Name
        /// </summary>
        /// <param name="BranchID"></param>
        /// <returns>Branch with this Name or null if none exists</returns>
        [HttpGet]
        public Branch Get([FromUri]int BranchID)
        {
            var temp = DatabaseManager.ExecuteReader(string.Format("Select * from Branch where BranchID = {0}", BranchID));
            var list = Filler.FillList<Branch>(temp);
            if (list.Count == 0)
                return null;
            return list.First();
        }

        /// <summary>
        /// Adds a Branch
        /// </summary>
        /// <param name="temp">Branch Data to Add</param>
        /// <returns>A number more than ZERO if successful and -1 if failed</returns>
        [HttpPost]
        public int Post([FromBody]Branch temp)
        {
            return DatabaseManager.ExecuteNonQuery(string.Format("Insert into Branch(BranchID, Sales, Profit, ProductListID) Values({0}, {1}, {2}, {3})",
              temp.BranchID,
              temp.Sales,
              temp.Profit,
              temp.ProductListID));
        }

        /// <summary>
        /// Edits a Branch with This Name
        /// </summary>
        /// <param name="BranchID">Branch Name</param>
        /// <param name="temp">Branch Data</param>
        /// <returns>A number more than ZERO if successful and -1 if failed</returns>
        [HttpPut]
        public int Put([FromUri]int BranchID, [FromBody]Branch temp)
        {
            return DatabaseManager.ExecuteNonQuery(string.Format("UPDATE Branch set Sales = {1}, Profit = {2}, ProductListID ={3} where BranchID ={0}",
           temp.BranchID,
           temp.Sales,
           temp.Profit,
           temp.ProductListID));
        }

        /// <summary>
        /// Delets a Branch with This Name
        /// </summary>
        /// <param name="BranchID"></param>
        /// <returns>A number more than ZERO if successful and -1 if failed</returns>
        [HttpDelete]
        public int Delete(int BranchID)
        {
            return DatabaseManager.ExecuteNonQuery(string.Format("Delete from Branch where BranchID = {0}", BranchID));
        }
       
        /// <summary>
        /// Checks if a Branch exists
        /// </summary>
        /// <param name="BranchID">Branch Name</param>
        /// <returns>Boolean</returns>
        [HttpPatch]
        public bool Check(int BranchID)
        {
            return (int)DatabaseManager.ExecuteScalar(string.Format("Select Count(*) from [Branch] where BranchID = {0}", BranchID)) > 0 ? true : false;
        }
    }
}
