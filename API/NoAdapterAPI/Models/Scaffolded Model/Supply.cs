using System;

namespace NoAdapterAPI.Models
{
    public partial class Supply
    {
        public int WarehouseID { get; set; }
        public int BranchID { get; set; }
        public DateTime Date { get; set; }
        public virtual Branch Branch { get; set; }
        public virtual Warehouse Warehouse { get; set; }
    }
}
