namespace NoAdapterAPI.Models
{
    public partial class Shipment
    {
        public int ShipmentID { get; set; }
        public int ProductListID { get; set; }
        public int? SupplierID { get; set; }
        public int? WarehouseID { get; set; }
    }
}
