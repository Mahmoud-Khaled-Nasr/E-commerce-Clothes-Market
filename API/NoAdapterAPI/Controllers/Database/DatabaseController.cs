using NoAdapterAPI.Models;
using System;
using System.Web.Http;

namespace NoAdapterAPI.Controllers.Database
{
    /// <summary>
    /// Database Logic Controller
    /// </summary>
    public class DatabaseController : ApiController
    {
        /// <summary>
        /// Initiates The Database Connection
        /// </summary>
        /// <returns>Nothing</returns>
        [HttpGet, Route("api/Database/Initiate")]
        public IHttpActionResult Initiate()
        {
            if (DatabaseManager.InitiateConnection())
                
                return Ok();
            else
                return InternalServerError(new Exception("Database Connection Failed\nCheck Log File.\nP.S. Sameh Rocks"));
        }

        /// <summary>
        /// Terminates The Database Connection
        /// </summary>
        /// <returns>Nothing</returns>
        [HttpGet, Route("api/Database/Terminate")]
        public IHttpActionResult Terminate()
        {
            if (DatabaseManager.CloseConnection())
                return Ok();
            else
                return InternalServerError(new Exception("Database Connection Termination Failed\nCheck Log File.\nP.S. Sameh Rocks"));
        }

    }
}