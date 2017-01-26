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
    [RoutePrefix("api/BranchWindow")]
    public class BranchWindowController : ApiController
    {
  
      [HttpGet]
        public List<ALL_BRANCH_DATA> Get()
        {
            var temp = DatabaseManager.ExecuteReader("Select * From ALL_BRANCH_DATA");
            return Filler.FillList<ALL_BRANCH_DATA>(temp);
        }

		/// <summary>
        /// ALL BRANCH DATA
        /// </summary>
        /// <param name="BranchID"></param>
        /// <returns></returns>
        [HttpGet]
        public List<ALL_BRANCH_DATA> Get([FromUri] int BranchID)
        {
            var temp = DatabaseManager.ExecuteReader("Select * From ALL_BRANCH_DATA where BranchID = " + BranchID);
            return Filler.FillList<ALL_BRANCH_DATA>(temp);
        }

        /// <summary>
        /// Products in Branch
        /// </summary>
        /// <param name="BranchID"></param>
        /// <returns></returns>
        [HttpPost]
        public List<PRODUCTS_IN_BRANCH> Post([FromUri] int BranchID)
        {
            var temp = DatabaseManager.ExecuteReader("Select * From PRODUCTS_IN_BRANCH where BranchID = "+ BranchID);
            return Filler.FillList<PRODUCTS_IN_BRANCH>(temp);
        }

        /// <summary>
        /// Employee Working Place ID
        /// </summary>
        /// <param name="WorkingPlaceID"></param>
        /// <returns></returns>
        [HttpPut]
        public List<EMPLOYEE_WORKING_IN_WORKING_PLACE> Put([FromUri] int WorkingPlaceID)
        {
            var temp = DatabaseManager.ExecuteReader("Select * From EMPLOYEE_WORKING_IN_WORKING_PLACE where WorkingPlaceID = " + WorkingPlaceID);
            return Filler.FillList<EMPLOYEE_WORKING_IN_WORKING_PLACE>(temp);
        }

        /// <summary>
        /// Count
        /// </summary>
        /// <param name="BranchID"></param>
        /// <returns>Product, Employee</returns>
        [HttpDelete]
        public KeyValuePair<int, int> Delete([FromUri] int BranchID)
        {
            var x = (int)DatabaseManager.ExecuteScalar("Select * From COUNT_PRODUCT_BRANCH where BranchID =" + BranchID);
            var y = (int)DatabaseManager.ExecuteScalar("Select * From NUMBER_OF_EMPLOYEE_IN_WORKING_PLACE where WORKING_PLACE = " + BranchID);
            return new KeyValuePair<int, int>(x, y);
        }

    }
}
