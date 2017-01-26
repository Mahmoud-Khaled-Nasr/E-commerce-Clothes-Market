namespace NoAdapterAPI.Models
{
    /// <summary>
    /// Customer Data
    /// </summary>
    public partial class Customer
    {
        /// <summary>
        /// The ID of the Customer (Auto-generated)
        /// </summary>
        public int CustomerID { get; set; }
        /// <summary>
        /// Login Username
        /// </summary>
        public string UserName { get; set; }
        /// <summary>
        /// Login Password
        /// </summary>
        public string Password { get; set; }
        /// <summary>
        /// Social Security Number String of (14) (Unique)
        /// </summary>
        public string SSN { get; set; }
        /// <summary>
        /// Actual Name
        /// </summary>
        public string Name { get; set; }
        /// <summary>
        /// M or F only
        /// </summary>
        public string Gender { get; set; }
        /// <summary>
        /// Age
        /// </summary>
        public int Age { get; set; }
    }
}
