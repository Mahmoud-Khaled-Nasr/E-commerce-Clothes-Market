using System;
using System.Collections.Generic;
using System.Data;
using System.Reflection;

namespace NoAdapterAPI.Models.Fillers
{
    public class Filler
    {
        public static List<T> FillList<T>(DataTable data) where T : new()
        {
            List<T> list = new List<T>();
            if (data == null)
                return list;
            foreach (DataRow Row in data.Rows)
            {
                list.Add((T)FillFromDataRow<T>(Row));
            }
            return list;
        }
        static object FillFromDataRow<T>(DataRow Row) where T : new()
        {
            T temp = new T(); 
            Dictionary<string, PropertyInfo> Map = new Dictionary<string, PropertyInfo>();
            foreach (PropertyInfo Properties in temp.GetType().GetProperties())
                Map.Add(Properties.Name, Properties);
            foreach (DataColumn col in Row.Table.Columns)
            {
                string name = col.ColumnName;
                if (Row[name] != DBNull.Value && Map.ContainsKey(name))
                {
                    object item = Row[name];
                    PropertyInfo p = Map[name];
                    if (p.PropertyType != col.DataType)
                        item = Convert.ChangeType(item, p.PropertyType);
                    p.SetValue(temp, item, null);
                }
            }
            return temp;
        }
        public static Dictionary<string, object> FillDictionary<T>(T temp)
        {
            Dictionary<string, object> param = new Dictionary<string, object>();
            foreach (var item in temp.GetType().GetProperties())
            {
                param.Add("@" + item.Name, item.GetValue(temp));
            }
            return param;
        }
    }
}
        