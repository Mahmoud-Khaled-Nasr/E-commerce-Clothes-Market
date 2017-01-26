namespace NoAdapterAPI.Models
{
    /// <summary>
    /// Employee Class
    /// </summary>
    public partial class Employee
    {       
        /// <summary>
        /// EmployeeID (Auto-generated)
        /// </summary>
        public int EmployeeID { get; set; }
        /// <summary>
        /// SSN
        /// </summary>
        public string SSN { get; set; }
        /// <summary>
        /// Employee Full Name
        /// </summary>
        public string Name { get; set; }
        /// <summary>
        /// M or F only
        /// </summary>
        public string Gender { get; set; }
        /// <summary>
        /// Employee Base Salary
        /// </summary>
        public decimal BaseSalary { get; set; }
        /// <summary>
        /// Extra Salary
        /// </summary>
        public decimal Extra { get; set; }
        /// <summary>
        /// Manger, Cashier, Accountant or Delivery only
        /// </summary>
        public string Classification { get; set; }
        /// <summary>
        /// Employee Phone Number
        /// </summary>
        public string PhoneNumber { get; set; }
        /// <summary>
        /// Employee Address
        /// </summary>
        public string Address { get; set; }
        /// <summary>
        /// Working Hours
        /// </summary>
        public double WorkingHours { get; set; }
        /// <summary>
        /// Working At
        /// </summary>
        public int WorkingAt { get; set; }
        /// <summary>
        /// Supervisor ID
        /// </summary>
        public int SupervisorID { get; set; }
    }
}
