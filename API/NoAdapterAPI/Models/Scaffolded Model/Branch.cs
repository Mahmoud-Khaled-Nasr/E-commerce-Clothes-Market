namespace NoAdapterAPI.Models
{
    /// <summary>
    /// Branch Entity
    /// </summary>
    public partial class Branch
    {
        /// <summary>
        /// Branch ID
        /// </summary>
        public int BranchID { get; set; }
        /// <summary>
        /// Branch Yearly Sales
        /// </summary>
        public decimal Sales { get; set; }
        /// <summary>
        /// Branch Annual Profit
        /// </summary>
        public decimal Profit { get; set; }
        /// <summary>
        /// Productss in the Branch
        /// </summary>
        public int ProductListID { get; set; }
    }
}
