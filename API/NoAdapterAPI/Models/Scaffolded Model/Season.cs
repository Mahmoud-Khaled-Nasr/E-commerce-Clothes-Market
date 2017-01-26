using System;

namespace NoAdapterAPI.Models
{
    /// <summary>
    /// Season Class
    /// </summary>
    public partial class Season
    {
        /// <summary>
        /// Season Name
        /// </summary>
        public string SeasonName { get; set; }
        /// <summary>
        /// Start Date
        /// </summary>
        public DateTime StartDate { get; set; }
        /// <summary>
        /// End Date
        /// </summary>
        public DateTime EndDate { get; set; }

    }
}
