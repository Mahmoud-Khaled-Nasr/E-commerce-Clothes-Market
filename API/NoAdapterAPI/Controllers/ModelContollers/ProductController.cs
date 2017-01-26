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
    /// Logic Controller for Product Class
    /// </summary>
    [RoutePrefix("api/Product")]
    public class ProductController : ApiController
    {
        /// <summary>
        /// Gets ALL Products from the Database
        /// </summary>
        /// <returns>A List of Product Objects</returns>
        [HttpGet]
        public List<Product> Get()
        {
            var temp = DatabaseManager.ExecuteReader("SELECT * FROM [Product]");
            return Filler.FillList<Product>(temp);
        }

        /// <summary>
        /// Gets Product by Barcode
        /// </summary>
        /// <param name="BarCode">Product's Barcode</param>
        /// <returns>Product with this Barcode or null if none exists</returns>
        [HttpGet]
        public Product Get([FromUri]int BarCode)
        {
            var temp = DatabaseManager.ExecuteReader(string.Format("Select * From [Product] where BarCode = {0}", BarCode));
            var list = Filler.FillList<Product>(temp);
            if (list.Count == 0)
                return null;
            return list.First();
        }

        /// <summary>
        /// Inserts a Product
        /// </summary>
        /// <param name="temp">Product Data</param>
        /// <returns>A number more than ZERO if successful or -1 if failed</returns>
        [HttpPost]
        public int Post([FromBody]Product temp)
        {
            string s;
            if (temp.Image != null)
                s = temp.Image.ToString();
            else
                s = "";
            return DatabaseManager.ExecuteNonQuery(string.Format("Insert into" +
                " Product(Size, Color, Gender, Price, ProductStatus, Image, CategoryID, BrandName)" +
                " Values({0}, '{1}', '{2}', {3}, '{4}', '{5}', {6}, '{7}')",
                temp.Size,
                temp.Color,
                temp.Gender,
                temp.Price,
                temp.ProductStatus,
                s,
                temp.CategoryID,
                temp.BrandName));
        }

        /// <summary>
        /// Updates a Product
        /// </summary>
        /// <param name="BarCode">Barcode to Update</param>
        /// <param name="temp">Data</param>
        /// <returns>A number more than ZERO if successful or -1 if failed</returns>
        [HttpPut]
        public int Put([FromUri]int BarCode, [FromBody]Product temp)
        {
            string s;
            if (temp.Image != null)
                s = temp.Image.ToString();
            else
                s = "";
            return DatabaseManager.ExecuteNonQuery(string.Format("Update Product" +
                " set Size = {1}, Color = '{2}', Gender = '{3}', Price = {4}, ProductStatus = '{5}', Image = '{6}', CategoryID = {7}, BrandName = '{8}' where BarCode = {0}",
                BarCode,
                temp.Size,
                temp.Color,
                temp.Gender,
                temp.Price,
                temp.ProductStatus,
                s,
                temp.CategoryID,
                temp.BrandName));
        }

        /// <summary>
        /// Deletes a Product
        /// </summary>
        /// <param name="BarCode">Barcode to Delete</param>
        /// <returns>A number more than ZERO if successful or -1 if failed</returns>
        [HttpDelete]
        public int Delete([FromUri]int BarCode)
        {
            return DatabaseManager.ExecuteNonQuery(string.Format("Delete from Product where Barcode = {0}", BarCode));
        }
        /// <summary>
        /// Checks if a Product Exists
        /// </summary>
        /// <param name="BarCode">Product to Check</param>
        /// <returns>Boolean</returns>
        [HttpPatch]
        public bool Check([FromUri] int BarCode)
        {
            return (int)DatabaseManager.ExecuteScalar(string.Format("Select Count(*) from [Product] where Barcode = {0}", BarCode)) > 0 ? true : false;
        }
        /// <summary>
        /// Gets The Count in the database
        /// </summary>
        /// <returns>Integer</returns>
        [HttpDelete]
        public int Count()
        {
            return (int)DatabaseManager.ExecuteScalar("Select Count(*) from Product");
        }

    }
}
