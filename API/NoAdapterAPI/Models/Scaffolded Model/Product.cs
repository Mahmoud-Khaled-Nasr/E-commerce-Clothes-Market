namespace NoAdapterAPI.Models
{ 
    /// <summary>
    /// Products' Data
    /// </summary>
    public partial class Product
    {
        /// <summary>
        /// Product's Barcode....(Auto-generated)
        /// </summary>
        public int BarCode { get; set; }
        /// <summary>
        /// Size
        /// </summary>
        public int Size { get; set; }
        /// <summary>
        /// Color
        /// </summary>
        public string Color { get; set; }
        /// <summary>
        /// Gender..... M or F Only
        /// </summary>
        public string Gender { get; set; }
        /// <summary>
        /// Price
        /// </summary>
        public decimal Price { get; set; }
        /// <summary>
        /// Stored....OnSale.....NotAvailable only
        /// </summary>
        public string ProductStatus { get; set; }
        /// <summary>
        /// Product's Image.... Byte[]
        /// </summary>
        public byte[] Image { get; set; }
        /// <summary>
        /// Category ID
        /// </summary>
        public int CategoryID { get; set; }
        /// <summary>
        /// Brand Name
        /// </summary>
        public string BrandName { get; set; }
    }
}
