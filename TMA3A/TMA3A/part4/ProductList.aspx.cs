using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Diagnostics;
using TMA3.part4.Models;

namespace TMA3.part4
{
	public partial class ProductList : System.Web.UI.Page
	{
		private List<string> labelList = new List<string>(new string[] { "Home", "Gaming", "Business" });
		private List<string> brandList = new List<string>(new string[] { "Lenovo", "HP"});

		protected void Page_Init(object sender, EventArgs e)
		{
			foreach (string label in getLabelList())
			{
				ComputerLabel.Items.Add(new ListItem(label, label));
			}
			foreach (string brand in getBrandList())
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
			
			if (!IsPostBack)
			{
				SessionData data = new SessionData();
				data.LabelList = new List<string>(getLabelList());
				data.BrandList = new List<string>(getBrandList());
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
				list = new List<string>(getLabelList());
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
				list = new List<string>(getBrandList());
			}
			SessionData data = (SessionData) Session["data"];
			data.BrandList = list;
			Session["data"] = data;
			ComputerList.DataBind();
		}

		public IEnumerable<Computer> GetComputers()
		{
			List<Computer> computerList = new List<Computer>();

			linq_to_sql.DataClasses1DataContext db = new linq_to_sql.DataClasses1DataContext();
			string category = Request.QueryString["category"];
			var query = from c in db.Computers
						where String.Equals(c.Type, category)
						select c;

			foreach (linq_to_sql.Computer dbComputer in query)
			{
				Computer computer = Computer.GetComputer(dbComputer.ComputerID);
				Dictionary<string, int> dict = new Dictionary<string, int>();
				var q2 = from p in db.Parts
						from cp in db.ComputerParts
						where p.PartID == cp.PartID && cp.ComputerID == computer.ComputerID && cp.Standard == true
						select p;
				foreach (linq_to_sql.Part part in q2)
				{
					dict[part.Type] = part.PartID;
				}
				computer.setPartIDs(dict["CPU"], dict["RAM"], dict["Hard Drive"], dict["Display"], dict["Operating System"]);
				computerList.Add(computer);
			}

			SessionData data = (SessionData) Session["data"];
			var computers =
				from c in computerList
				where data.LabelList.Contains(c.Label) && data.BrandList.Contains(c.Brand)
				select c;

			return computers;
		}

		private List<string> getLabelList()
		{
			string category = Request.QueryString["category"];
			linq_to_sql.DataClasses1DataContext db = new linq_to_sql.DataClasses1DataContext();
			var query = from c in db.Computers
						where c.Type == category
						select c.Label;

			return query.ToList();
		}

		private List<string> getBrandList()
		{
			string category = Request.QueryString["category"];
			linq_to_sql.DataClasses1DataContext db = new linq_to_sql.DataClasses1DataContext();
			var query = from c in db.Computers
						where c.Type == category
						select c.Brand;

			return query.ToList();
		}

		[Serializable]
		public class SessionData
		{
			public List<string> LabelList { get; set; }
			public List<string> BrandList { get; set; }
		}
	}
}