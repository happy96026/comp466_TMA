using Newtonsoft.Json.Linq;
using System;
using System.Collections;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.Diagnostics;
using System.Linq;
using System.Web;

namespace TMA3.part4.Models
{
	[Serializable]
	public class Cart
	{
		public IOrderedDictionary Dict { get; set; }
		public Cart()
		{
			Dict = new OrderedDictionary();
		}

		public Cart(List<Computer> computerList)
		{
			Dict = new OrderedDictionary();
			foreach(Computer computer in computerList)
			{
				EditComputer(computer);
			}
		}

		public bool ComputerExists(Computer computer)
		{
			return Dict.Contains(computer.GetString());
		}

		public void AddComputer(Computer computer)
		{
			if (ComputerExists(computer))
			{
				Dict[computer.GetString()] = Convert.ToInt32(Dict[computer.GetString()]) + computer.Quantity;
			}
			else
			{
				Dict[computer.GetString()] = computer.Quantity;
			}
		}

		public void EditComputer(Computer computer)
		{
			Dict[computer.GetString()] = computer.Quantity;
		}

		public void RemoveComputer(Computer computer)
		{
			Dict.Remove(computer.GetString());
		}

		public double GetTotal()
		{
			double totalPrice = 0;
			List<Computer> computerList = GetComputerList();
			foreach(Computer computer in computerList)
			{
				totalPrice += computer.GetPrice();
			}
			return totalPrice;
		}

		public List<Computer> GetComputerList()
		{
			List<Computer> computerList = new List<Computer>();
			foreach(DictionaryEntry entry in Dict)
			{
				string strRep = Convert.ToString(entry.Key);
				int qty = Convert.ToInt32(entry.Value);
				string[] partIDStrs = strRep.Split(',');
				int[] partIDs = Array.ConvertAll<string, int>(partIDStrs, int.Parse);
				Computer computer = Computer.GetComputer(partIDs[0]);
				computer.setPartIDs(partIDs[1], partIDs[2], partIDs[3], partIDs[4], partIDs[5]);
				computer.Quantity = qty;
				computerList.Add(computer);
			}

			return computerList;
		}

		public string GetTotalStr()
		{
			return String.Format("${0:0.00}", GetTotal());
		}

		public static string Serialize(Cart cart)
		{
			List<Computer> computerList = cart.GetComputerList();
			foreach(Computer computer in computerList)
			{
				cart.EditComputer(computer);
			}
			string json = Newtonsoft.Json.JsonConvert.SerializeObject(cart);
			return json;
		}

		public static Cart Deserialize(string json)
		{
			Cart cart = Newtonsoft.Json.JsonConvert.DeserializeObject<Cart>(json);
			return cart;
		}
	}
}