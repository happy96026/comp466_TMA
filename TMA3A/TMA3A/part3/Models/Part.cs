using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Newtonsoft.Json;

namespace TMA3.part3.Models
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
			switch (partID)
			{
				case 1:
					return new Part(1, "i5 3.2 Ghz", 240, "Intel", "cpu");
				case 2:
					return new Part(2, "DDR4 4GB", 240, "G.Skill", "ram");
				case 3:
					return new Part(3, "SSD 860 EVO 250GB", 240, "Samsung", "hard_drive");
				case 4:
					return new Part(4, "27\" UHD 4K HDR Monitor", 240, "LG", "display");
				case 5:
					return new Part(5, "Windows 10 Home 64-bit", 240, "Microsoft", "os");
				case 6:
					return new Part(6, "i7 4.3 Ghz", 400, "Intel", "cpu");
				default:
					return new Part(1, "i5 3.2 Ghz", 240, "Intel", "cpu");
			}

		}
	}
}