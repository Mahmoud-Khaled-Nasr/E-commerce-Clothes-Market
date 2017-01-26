namespace NoAdapterAPI.Models
{
    /// <summary>
    /// Product's Brand
    /// </summary>
    public partial class Brand
    { 
        /// <summary>
        /// Brand's Official Name (20)
        /// </summary>
        public string BrandName { get; set; }
        /// <summary>
        /// M, F or B only
        /// </summary>
        public string GenderSales { get; set; }
        /// <summary>
        /// a 100-char Description
        /// </summary>
        public string Description { get; set; }
    }
}
