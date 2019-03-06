using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Diagnostics;
using TMA3.part3.Models;

namespace TMA3.part3
{
	public partial class ProductList : System.Web.UI.Page
	{
		private List<string> labelList = new List<string>(new string[] { "Home", "Gaming", "Business" });
		private List<string> brandList = new List<string>(new string[] { "Lenovo", "HP"});

		protected void Page_Init(object sender, EventArgs e)
		{
			foreach (string label in labelList)
			{
				ComputerLabel.Items.Add(new ListItem(label, label));
			}
			foreach (string brand in brandList)
			{
				ComputerBrand.Items.Add(new ListItem(brand, brand));
			}
		}
		
		protected void Page_Load(object sender, EventArgs e)
		{
			string[] categories = { "Desktop", "Laptop" };
			if (Request.QueryString["category"] == null && !categories.Contains(Request.QueryString["category"]) )
			{
				Response.StatusCode = 403;
				Response.End();
			}
			ComputerCategory.Text = Request.QueryString["category"];
			
			if (Session["data"] == null)
			{
				SessionData data = new SessionData();
				data.LabelList = new List<string>(labelList);
				data.BrandList = new List<string>(brandList);
				Session["data"] = data;
			}
		}
		
		protected void Label_Change(object sender, EventArgs e)
		{
			List<string> list = new List<string>();
			foreach (ListItem item in ComputerLabel.Items)
			{
				if (item.Selected)
				{
					list.Add(item.Value);
				}
			}
			if (list.Count == 0)
			{
				list = new List<string>(labelList);
			}
			SessionData data = (SessionData) Session["data"];
			data.LabelList = list;
			Session["data"] = data;
			ComputerList.DataBind();
		}

		protected void Brand_Change(object sender, EventArgs e)
		{
			List<string> list = new List<string>();
			foreach (ListItem item in ComputerBrand.Items)
			{
				if (item.Selected)
				{
					list.Add(item.Value);
				}
			}
			if (list.Count == 0)
			{
				list = new List<string>(brandList);
			}
			SessionData data = (SessionData) Session["data"];
			data.BrandList = list;
			Session["data"] = data;
			ComputerList.DataBind();
		}

		public IEnumerable<Computer> GetComputers()
		{
			List<Computer> computerList = new List<Computer>();
			Computer computer;

			computer = Computer.GetComputer(1);
			computer.setPartIDs(1, 2, 3, 4, 5);
			computerList.Add(computer);

			computer = Computer.GetComputer(1);
			computer.setPartIDs(1, 2, 3, 4, 5);
			computerList.Add(computer);

			computer = Computer.GetComputer(1);
			computer.setPartIDs(1, 2, 3, 4, 5);
			computerList.Add(computer);

			SessionData data = (SessionData) Session["data"];
			Debug.WriteLine(data.LabelList[0]);
			var computers =
				from c in computerList
				where c.Type == Request.QueryString["category"] 
				&& data.LabelList.Contains(c.Label)
				&& data.BrandList.Contains(c.Brand)
				select c;

			return computers;
		}

		[Serializable]
		public class SessionData
		{
			public List<string> LabelList { get; set; }
			public List<string> BrandList { get; set; }
		}
	}
}