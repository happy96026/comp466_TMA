using System;
using System.Collections.Specialized;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace TMA3.part3.Models
{
	[Serializable]
	public class Order
	{
		public int OrderID { get; }
		public DateTime Date { get; set; }
		public OrderedDictionary OrderList { get; set; }

		public Order()
		{
			Date = new DateTime();
			OrderList = new OrderedDictionary();
		}
	}
}