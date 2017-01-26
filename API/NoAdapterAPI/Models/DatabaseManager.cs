using System;
using System.Collections.Generic;
using System.Configuration;
using System.Data;
using System.Data.SqlClient;
using System.Linq;
using System.Web;

namespace NoAdapterAPI.Models
{
    public class DatabaseManager
    {
        DatabaseManager() { }
        static SqlConnection Connection;

        /// <summary>
        /// Initiates the Database Connection based on the ConnectionString Named "DatabaseAdaptedModel"
        /// </summary>
        /// <returns>A Boolean to indicate if Connection Succeded</returns>
        /// <remarks>Throws Data to Log File</remarks>
        public static bool InitiateConnection()
        {

            Connection = new SqlConnection(ConfigurationManager.ConnectionStrings["DatabaseAdaptedModel"].ConnectionString);
            try
            {
                Connection.Open();
                System.Diagnostics.Trace.TraceInformation("The DB Connection Opened Successfully");
                return true;
            }
            catch (Exception e)
            {
                System.Diagnostics.Trace.TraceError("The DB connection is failed");
                System.Diagnostics.Trace.TraceError(e.ToString());
                return false;
            }
        }

        /// <summary>
        /// Executes Update, Insert, Delete Queries
        /// </summary>
        /// <param name="Query">Transact-SQL Query String</param>
        /// <returns>Amount of Rows Affected</returns>
        public static int ExecuteNonQuery(string Query)
        {
            try
            {
                SqlCommand Command = new SqlCommand(Query, Connection);
                var temp = Command.ExecuteNonQuery();
                if (temp == -1)
                    throw new Exception("No Rows Affected.... Stored Procedure error.... I think :D");
                System.Diagnostics.Trace.TraceInformation("NonQuery Executed Successfully");
                return temp;
            }
            catch (Exception ex)
            {
                System.Diagnostics.Trace.TraceError(ex.Message);
                return -1;
            }
        }

        /// <summary>
        /// Executes Reader Command using The Transact-SQL Query
        /// </summary>
        /// <param name="Query">The Transact-SQL Query String</param>
        /// <returns>Datatable Containing the Result of the Select Query</returns>
        public static DataTable ExecuteReader(string Query)
        {
            try
            {
                SqlCommand Command = new SqlCommand(Query, Connection);
                SqlDataReader Reader = Command.ExecuteReader();
                if (Reader.HasRows)
                {
                    DataTable DataTableObject = new DataTable();
                    DataTableObject.Load(Reader);
                    Reader.Close();
                    System.Diagnostics.Trace.TraceInformation("Reader Executed Successfully");
                    return DataTableObject;
                }
                else
                {
                    Reader.Close();
                    System.Diagnostics.Trace.TraceWarning("Empty Reader Executed");
                    return null;
                }
            }
            catch (Exception ex)
            {
                System.Diagnostics.Trace.TraceError(ex.Message);
                return null;
            }
        }

        /// <summary>
        ///  Executes the query, and returns the first column of the first row in the result set returned by the query. Additional columns or rows are ignored.        
        /// </summary>
        /// <param name="Query">The Transact-SQL Query String</param>
        /// <returns>
        /// The first column of the first row in the result set, or a null reference if the result set is empty. Returns a maximum of 2033 characters.
        /// </returns>
        public static object ExecuteScalar(string Query)
        {
            try
            {
                SqlCommand Command = new SqlCommand(Query, Connection);
                return Command.ExecuteScalar();
            }
            catch (Exception ex)
            {
                System.Diagnostics.Trace.TraceError(ex.Message);
                return 0;
            }
        }

        public static object ExecuteProcedure(string StoredProcedure, Dictionary<string, object> Parameters, int x = 0)
        {
            SqlCommand Command= new SqlCommand(StoredProcedure, Connection);
            Command.CommandType = CommandType.StoredProcedure;

            foreach (var Param in Parameters)
            {
                Command.Parameters.Add(new SqlParameter(Param.Key, Param.Value));
            }
            if (x == 0)
                return Command.ExecuteNonQuery();
            if(x == 1)
                return Command.ExecuteScalar();
            else
                return Command.ExecuteReader();
        }

        /// <summary>
        /// Closes The SQL Server Connection
        /// </summary>
        /// <returns>A Boolean to indicate if Connection Termination Succeded</returns>
        public static bool CloseConnection()
        {
            try
            {
                Connection.Close();
                return true;
            }
            catch (Exception e)
            {
                System.Diagnostics.Trace.TraceError(e.Message);
                return false;
            }
        }

    }
}