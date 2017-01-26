namespace NoAdapterAPI.Models
{
    /// <summary>
    /// An Order done by a Customer
    /// </summary>
    public partial class Order
    {
        /// <summary>
        /// Order of ID (Auto-generated)
        /// </summary>
        public int OrderID { get; set; }
        /// <summary>
        /// ID of Customer (Foreign)
        /// </summary>
        public int CustomerID { get; set; }
        /// <summary>
        /// ID of Order's Products' deatils (Foreign)
        /// </summary>
        public int ProductListID { get; set; }
        /// <summary>
        /// ID of Warehouse to address Order (Foreign)
        /// </summary>
        public int WarehouseID { get; set; }
        /// <summary>
        /// ID of Delivery Department/Employee (Foreign)
        /// </summary>
        public int DeliveryID { get; set; }

    }
}
