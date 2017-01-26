using NoAdapterAPI.Models;
using NoAdapterAPI.Models.Fillers;
using System.Collections.Generic;
using System.Linq;
using System.Web.Http;

namespace NoAdapterAPI.Controllers.ModelContollers
{
    /// <summary>
    /// Logic Controller for Season Class
    /// </summary>
    [RoutePrefix("api/Season")]
    public class SeasonController : ApiController
    {
        /// <summary>
        /// Gets ALL Seasons from the Database
        /// </summary>
        /// <returns>A List of Season Objects</returns>
        [HttpGet]
        public List<Season> Get()
        {
            var temp = DatabaseManager.ExecuteReader("SELECT * FROM SEASON");
            return Filler.FillList<Season>(temp);
        }

        /// <summary>
        /// Gets the Season with this ID
        /// </summary>
        /// <param name="SeasonName">Season Name</param>
        /// <returns>Season Object with this ID or null if none exists</returns>
        [HttpGet]
        public Season Get([FromUri]string SeasonName)
        {
            var temp = DatabaseManager.ExecuteReader(string.Format("SELECT * FROM SEASON WHERE SeasonName = '{0}'", SeasonName));
            var list = Filler.FillList<Season>(temp);
            if (list.Count == 0)
                return null;
            return list.First();
        }

        /// <summary>
        /// Adds a Season
        /// </summary>
        /// <param name="temp">Season data to add</param>
        /// <returns>A number more than ZERO if successful or -1 if failed</returns>
        [HttpPost]
        public int Post([FromBody]Season temp)
        {
          // Season temp = Newtonsoft.Json.JsonConvert.DeserializeObject<Season>(JSON);
           return DatabaseManager.ExecuteNonQuery(string.Format("INSERT INTO SEASON(SeasonName, StartDate, EndDate) VALUES('{0}', '{1}', '{2}')",
               temp.SeasonName, 
               temp.StartDate.ToShortDateString(), 
               temp.EndDate.ToShortDateString()));
        }

        /// <summary>
        /// Edits a Season
        /// </summary>
        /// <param name="SeasonName">Season Name to Edit</param>
        /// <param name="temp">Season Data</param>
        /// <returns>A number more than ZERO if successful or -1 if failed</returns>
        [HttpPut]
        public int Put([FromUri]string SeasonName, [FromBody]Season temp)
        {
            return DatabaseManager.ExecuteNonQuery(string.Format("Update SEASON set StartDate = '{1}', EndDate = '{2}'  where SeasonName = '{0}'", 
                SeasonName, 
                temp.StartDate.ToShortDateString(), 
                temp.EndDate.ToShortDateString()));
        }

        /// <summary>
        /// Deletes a Season
        /// </summary>
        /// <param name="SeasonName">Season Name to Delete</param>
        /// <returns>A number more than ZERO if successful or -1 if failed</returns>
        [HttpDelete]
        public int Delete([FromUri]string SeasonName)
        {
            return DatabaseManager.ExecuteNonQuery(string.Format("Delete from Season where SeasonName = '{0}'", SeasonName));
        }

        /// <summary>
        /// Checks if a Season exists or not
        /// </summary>
        /// <param name="SeasonName">Season Name to Check</param>
        /// <returns>Boolean</returns>
        [HttpPatch]
        public bool check([FromUri]string SeasonName)
        {
            return (int)DatabaseManager.ExecuteScalar(string.Format("Select Count(*) from Season where SeasonName = '{0}'",SeasonName)) > 0 ? true : false ;
        }
    }
}