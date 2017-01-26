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
    /// Logic Controller for Category class
    /// </summary>
    public class CategoryController : ApiController
    {
        /// <summary>
        /// Gets ALL Categories from the Database
        /// </summary>
        /// <returns>a List of Categories</returns>
        [HttpGet]
        public List<Category> Get()
        {
            var temp = DatabaseManager.ExecuteReader("Select * From Category");
            return Filler.FillList<Category>(temp);
        }

        /// <summary>
        /// Gets Category with a specific Name
        /// </summary>
        /// <param name="CategoryID"></param>
        /// <returns>Category with this Name or null if none exists</returns>
        [HttpGet]
        public Category Get([FromUri]int CategoryID)
        {
            var temp = DatabaseManager.ExecuteReader(string.Format("Select * From Category where CategoryID = {0}",CategoryID));
            var list = Filler.FillList<Category>(temp);
            if (list.Count == 0)
                return null;
            return list.First();
        }

        /// <summary>
        /// Adds a Category
        /// </summary>
        /// <param name="temp">Category Data to Add</param>
        /// <returns>A number more than ZERO if successful and -1 if failed</returns>
        [HttpPost]
        public int Post([FromBody]Category temp)
        {
            return DatabaseManager.ExecuteNonQuery(string.Format("Insert into Category(CategoryName) Values('{1}')",
            temp.CategoryID,
            temp.CategoryName));
        }

        /// <summary>
        /// Edits a Category with This Name
        /// </summary>
        /// <param name="CategoryID">Category Name</param>
        /// <param name="temp">Category Data</param>
        /// <returns>A number more than ZERO if successful and -1 if failed</returns>
        [HttpPut]
        public int Put([FromUri]int CategoryID, [FromBody]Category temp)
        {
            return DatabaseManager.ExecuteNonQuery(string.Format("Update Category set CategoryName = '{1}' where CategoryID = {0}",
                CategoryID,
                temp.CategoryName));
        }

        /// <summary>
        /// Delets a Category with This Name
        /// </summary>
        /// <param name="CategoryID"></param>
        /// <returns>A number more than ZERO if successful and -1 if failed</returns>
        [HttpDelete]
        public int Delete(int CategoryID)
        {
            return DatabaseManager.ExecuteNonQuery(string.Format("Delete from Category where CategoryID = {0}", CategoryID));
        }

        /// <summary>
        /// Checks if a Category exists
        /// </summary>
        /// <param name="CategoryID">Category Name</param>
        /// <returns>Boolean</returns>
        [HttpPatch]
        public bool Check(int CategoryID)
        {
            return (int)DatabaseManager.ExecuteScalar(string.Format("Select Count(*) from [Category] where CategoryID = {0}", CategoryID)) > 0 ? true : false;
        }
    }
}
