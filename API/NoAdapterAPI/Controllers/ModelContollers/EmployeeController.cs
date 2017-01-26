using NoAdapterAPI.Models;
using NoAdapterAPI.Models.Fillers;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web.Http;

namespace NoAdapterAPI.Controllers.ModelContollers
{
    /// <summary>
    /// Logic Controller for Employee Class
    /// </summary>
    [RoutePrefix("api/Employee")]
    public class EmployeeController : ApiController
    {
        /// <summary>
        /// Gets ALL Employees from the Database
        /// </summary>
        /// <returns>A List of Employee Objects</returns>
        [HttpGet]
        public List<Employee> Get()
        {
            var temp = DatabaseManager.ExecuteReader("Select * From Employee");
            return Filler.FillList<Employee>(temp);
        }

        /// <summary>
        /// Gets an Employee with This ID
        /// </summary>
        /// <param name="EmployeeID">Employee ID</param>
        /// <returns>Employee with this ID or null if none exists</returns>
        [HttpGet]
        public Employee Get([FromUri]int EmployeeID)
        {
            var temp = DatabaseManager.ExecuteReader(string.Format("SELECT * FROM Employee WHERE EmployeeID = '{0}'", EmployeeID));
            var list = Filler.FillList<Employee>(temp);
            if (list.Count == 0)
                return null;
            return list.First();
        }

        /// <summary>
        /// Adds an Employee to the Database
        /// </summary>
        /// <param name="temp">Employee Data to Add</param>
        /// <returns>A number more than ZERO if successful or -1 if failed</returns>
        [HttpPost]
        public int Post([FromBody]Employee temp)
        {
            return DatabaseManager.ExecuteNonQuery(string.Format("INSERT INTO Employee VALUES ('{0}','{1}','{2}',{3},{4},'{5}','{6}','{7}',{8},{9},{10})",
                temp.SSN,
                temp.Name,
                temp.Gender,
                temp.BaseSalary,
                temp.Extra,
                temp.Classification,
                temp.PhoneNumber,
                temp.Address,
                temp.WorkingHours,
                temp.WorkingAt,
                temp.SupervisorID));
        }

        /// <summary>
        /// Updates an Employee
        /// </summary>
        /// <param name="EmployeeID">EmployeeId to Update</param>
        /// <param name="temp">Employee Data</param>
        /// <returns>A number more than ZERO if successful or -1 if failed</returns>
        [HttpPut]
        public int Put([FromUri]int EmployeeID, [FromBody]Employee temp)
        {
            return DatabaseManager.ExecuteNonQuery(string.Format("Update Employee set SSN ='{1}', Name = '{2}', Gender = '{3}', BaseSalary ={4}, Extra={5}, Classification ='{6}', PhoneNumber ='{7}', Address='{8}', WorkingHours ={9}, WorkingAt ={10}, SupervisorID={11} where EmployeeID = {0}",
                EmployeeID,
                temp.SSN,
                temp.Name,
                temp.Gender,
                temp.BaseSalary,
                temp.Extra,
                temp.Classification,
                temp.PhoneNumber,
                temp.Address,
                temp.WorkingHours,
                temp.WorkingAt,
                temp.SupervisorID));
        }

        /// <summary>
        /// Deletes an Employee
        /// </summary>
        /// <param name="EmployeeID">ID to Delete</param>
        /// <returns>A number more than ZERO if successful or -1 if failed</returns>
        [HttpDelete]
        public int Delete([FromUri]int EmployeeID)
        {
            return DatabaseManager.ExecuteNonQuery(string.Format("Delete from Employee where EmployeeID = {0}", EmployeeID));
        }

        /// <summary>
        /// Checks if an Employee Exists
        /// </summary>
        /// <param name="EmployeeID">Employee ID to Delete</param>
        /// <returns></returns>
        [HttpPatch]
        public bool Check([FromUri]int EmployeeID)
        {
            return (int)DatabaseManager.ExecuteScalar(string.Format("Select Count(*) from Employee where EmployeeID = {0}", EmployeeID)) > 0 ? true : false;
        }
    }
}
