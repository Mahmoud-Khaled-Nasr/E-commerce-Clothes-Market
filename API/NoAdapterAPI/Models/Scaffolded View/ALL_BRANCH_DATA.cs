namespace NoAdapterAPI.Models
{
    public partial class ALL_BRANCH_DATA
    {     
        public int BranchID { get; set; }

        public string Location { get; set; }

        public decimal Sales { get; set; }

        public decimal Profit { get; set; }

        public int MangerID { get; set; }

        public string Name { get; set; }

        public int ProductListID { get; set; }

        public string ProductListName { get; set; }
    }
}
