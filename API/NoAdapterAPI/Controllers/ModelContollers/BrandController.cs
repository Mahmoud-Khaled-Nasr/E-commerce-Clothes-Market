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
    /// Logic Controller for Brand class
    /// </summary>
    [RoutePrefix("api/Brand")]
    public class BrandController : ApiController
    {
        /// <summary>
        /// Gets ALL Brands from the Database
        /// </summary>
        /// <returns>a List of Brands</returns>
        [HttpGet]
        public List<Brand> Get()
        {
            var temp = DatabaseManager.ExecuteReader("Select * From Brand");
            return Filler.FillList<Brand>(temp);
        }

        /// <summary>
        /// Gets Brand with a specific Name
        /// </summary>
        /// <param name="BrandName"></param>
        /// <returns>Brand with this Name or null if none exists</returns>
        [HttpGet]
        public Brand Get([FromUri]string BrandName)
        {
            var temp = DatabaseManager.ExecuteReader(string.Format("Select *from Brand where BrandName = '{0}'", BrandName));
            var list = Filler.FillList<Brand>(temp);
            if (list.Count == 0)
                return null;
            return list.First();
        }

        /// <summary>
        /// Adds a Brand
        /// </summary>
        /// <param name="temp">Brand Data to Add</param>
        /// <returns>A number more than ZERO if successful and -1 if failed</returns>
        [HttpPost]
        public int Post([FromBody]Brand temp)
        {
            return DatabaseManager.ExecuteNonQuery(string.Format("Insert into Brand(BrandName, GenderSales, Description) Values('{0}', '{1}', '{2}')",
                temp.BrandName,
                temp.GenderSales,
                temp.Description));
        }

        /// <summary>
        /// Edits a Brand with This Name
        /// </summary>
        /// <param name="BrandName">Brand Name</param>
        /// <param name="temp">Brand Data</param>
        /// <returns>A number more than ZERO if successful and -1 if failed</returns>
        [HttpPut]
        public int Put([FromUri]string BrandName, [FromBody]Brand temp)
        {
            return DatabaseManager.ExecuteNonQuery(string.Format("Update Brand set GenderSales = '{1}', Description '{2}' where BrandName = '{0}')",
                temp.BrandName,
                temp.GenderSales,
                temp.Description));
        }

        /// <summary>
        /// Delets a Brand with This Name
        /// </summary>
        /// <param name="BrandName"></param>
        /// <returns>A number more than ZERO if successful and -1 if failed</returns>
        [HttpDelete]
        public int Delete(string BrandName)
        {
            return DatabaseManager.ExecuteNonQuery(string.Format("Delete from Brand where BrandName = '{0}'", BrandName));
        }

        /// <summary>
        /// Checks if a Brand exists
        /// </summary>
        /// <param name="BrandName">Brand Name</param>
        /// <returns>Boolean</returns>
        [HttpPatch]
        public bool Check(string BrandName)
        {
            return (int)DatabaseManager.ExecuteScalar(string.Format("Select Count(*) from [Brand] where BrandName = '{0}'", BrandName)) > 0 ? true : false;
        }
    }
}
