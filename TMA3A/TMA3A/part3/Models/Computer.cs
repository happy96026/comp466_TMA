using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Web;

namespace TMA3.part3.Models
{
	[Serializable]
	public class Computer
	{
		private int quantity;

		public int ComputerID { get; }
		public string Name { get; }
		public string Brand { get; }
		public string Type { get; }
		public string Label { get; }
		public int CpuID { get; set; }
		public int RamID { get; set; }
		public int HardDriveID { get; set; }
		public int DisplayID { get; set; }
		public int OsID { get; set; }
		public string ImagePath { get; }
		public double ExtraCost { get; }
		public int Quantity
		{
			get { return quantity; }
			set
			{
				quantity = value;
				if (quantity > 5)
				{
					quantity = 5;
				}
			}
		}

		public Computer(int computerID, string name, string brand, string type, string label, string imagePath)
		{
			ComputerID = computerID;
			Name = name;
			Brand = brand;
			Type = type;
			Label = label;
			ImagePath = imagePath;
			ExtraCost = 0;
			Quantity = 1;
		}

		[JsonConstructor]
		public Computer(int computerID, string name, string brand, string type, string label, string imagePath, double extraCost)
		{
			ComputerID = computerID;
			Name = name;
			Brand = brand;
			Type = type;
			Label = label;
			ImagePath = imagePath;
			ExtraCost = extraCost;
			Quantity = 1;
		}

		public void setPartIDs(int cpuID, int ramID, int hdID, int displayID, int osID)
		{
			CpuID = cpuID;
			RamID = ramID;
			HardDriveID = hdID;
			DisplayID = displayID;
			OsID = osID;
		}

		public double GetPrice()
		{
			Part cpu = GetCpu();
			Part ram = GetRam();
			Part hd = GetHardDrive();
			Part display = GetDisplay();
			Part os = GetOs();
			double price = (cpu.Price + ram.Price + hd.Price + display.Price + os.Price + ExtraCost)*Quantity;

			return price;
		}

		public string GetPriceStr()
		{
			return String.Format("${0:0.00}", GetPrice());
		}

		public double GetUnitPrice()
		{
			Part cpu = GetCpu();
			Part ram = GetRam();
			Part hd = GetHardDrive();
			Part display = GetDisplay();
			Part os = GetOs();
			double price = (cpu.Price + ram.Price + hd.Price + display.Price + os.Price + ExtraCost);

			return price;
		}

		public string GetUnitPriceStr()
		{
			return String.Format("${0:0.00}", GetUnitPrice());
		}

		public string GetString()
		{
			return ComputerID.ToString() + 
				"," + CpuID.ToString() + 
				"," + RamID.ToString() + 
				"," + HardDriveID.ToString() + 
				"," + DisplayID.ToString() + 
				"," + OsID.ToString();
		}

		public Part GetCpu()
		{
			return Part.GetPart(CpuID);
		}

		public Part GetRam()
		{
			return Part.GetPart(RamID);
		}

		public Part GetHardDrive()
		{
			return Part.GetPart(HardDriveID);
		}

		public Part GetDisplay()
		{
			return Part.GetPart(DisplayID);
		}

		public Part GetOs()
		{
			return Part.GetPart(OsID);
		}

		public static Computer GetComputer(int partID)
		{
			return new Computer(1, "ThinkPad 1090", "Lenovo", "Laptop", "Gaming", "img/laptop.png");
		}

	}
}