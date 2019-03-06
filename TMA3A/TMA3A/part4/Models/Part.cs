using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Newtonsoft.Json;
using TMA3.part4;

namespace TMA3.part4.Models
{
	[Serializable]
	public class Part
	{
		public int PartID { get; }

		public string Name { get;  }

		public double Price { get; }

		public string Brand { get; }

		public string Type { get; }

		public Part(int id, string name, double price, string brand, string type)
		{
			PartID = id;
			Name = name;
			Price = price;
			Brand = brand;
			Type = type;
		}

		public string GetFullName()
		{
			return Brand + " " + Name;
		}

		public static Part GetPart(int partID)
		{
			linq_to_sql.DataClasses1DataContext db = new linq_to_sql.DataClasses1DataContext();
			var query = from p in db.Parts
						where p.PartID == partID
						select p;

			if (query.Count() == 0)
			{
				throw new Exception("Could not find computerID");
			}
			linq_to_sql.Part dbPart = query.First();

			double price = (dbPart.Price.HasValue) ? dbPart.Price.Value : 0;

			return new Part(dbPart.PartID, dbPart.Name, price, dbPart.Brand, dbPart.Type);
		}
	}
}