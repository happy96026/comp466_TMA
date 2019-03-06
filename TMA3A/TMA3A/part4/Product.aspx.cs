using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using TMA3.part4.Models;

namespace TMA3.part4
{
	public partial class Product : System.Web.UI.Page
	{
		private Computer computer;

		protected void Page_Init(object sender, EventArgs e)
		{
			checkGetParams();

			Computer computer = Computer.GetComputer(Int32.Parse(Request.QueryString["productID"]));

			linq_to_sql.DataClasses1DataContext db = new linq_to_sql.DataClasses1DataContext();
			var query = from cp in db.ComputerParts
						from p in db.Parts
						where cp.ComputerID == computer.ComputerID && p.PartID == cp.PartID && cp.Standard == true
						select p;

			Dictionary<string, int> dict = new Dictionary<string, int>();
			foreach (linq_to_sql.Part part in query)
			{
				dict[part.Type] = part.PartID;
			}
			computer.setPartIDs(dict["CPU"], dict["RAM"], dict["Hard Drive"], dict["Display"], dict["Operating System"]);

			setCpuList(computer);
			setRamList(computer);
			setHardDriveList(computer);
			setDisplayList(computer);
			setOsList(computer);
			BrandLabel.Text = computer.Brand;
			NameLabel.Text = computer.Name;
			PriceLabel.Text = computer.GetPriceStr();
			ProductImage.ImageUrl = computer.ImagePath;

			this.computer = computer;
		}

		protected void Page_Load(object sender, EventArgs e)
		{
			checkGetParams();
			if (computer == null)
			{
				Computer computer = getComputerFromDropDown();
				this.computer = computer;
			}
			ProductListLink.Text = this.computer.Type;
			ProductListLink.NavigateUrl = "ProductList.aspx?category=" + this.computer.Type;
		}

		private void checkGetParams()
		{
			if (Request.QueryString["productID"] == null)
			{
				Response.StatusCode = 403;
				Response.End();
			}
		}

		protected void DropDown_Change(object sender, EventArgs e)
		{
			Computer computer = getComputerFromDropDown();
			string price = computer.GetPriceStr();
			PriceLabel.Text = price;
			Session["Computer"] = computer;
		}
		
		protected void AddToCart_Cick(object sender, EventArgs e)
		{
			Cart cart;
			cart = new Cart();
			if (Request.Cookies["computer"] == null)
				cart = new Cart();
			else
				cart = Cart.Deserialize(Request.Cookies["computer"].Value);


			Computer computer = getComputerFromDropDown();
			cart.AddComputer(computer);

			Response.Cookies["computer"].Value = Cart.Serialize(cart);
			Response.Redirect("MyCart.aspx");
		}

		private Computer getComputerFromDropDown()
		{
			int cpuID = Int32.Parse(CpuDropDown.SelectedItem.Value);
			int ramID = Int32.Parse(RamDropDown.SelectedItem.Value);
			int hardDriveID = Int32.Parse(HardDriveDropDown.SelectedItem.Value);
			int displayID = Int32.Parse(DisplayDropDown.SelectedItem.Value);
			int osID = Int32.Parse(OsDropDown.SelectedItem.Value);

			Computer computer = Computer.GetComputer(Int32.Parse(Request.QueryString["productID"]));
			computer.setPartIDs(cpuID, ramID, hardDriveID, displayID, osID);

			int qty = Convert.ToInt32(QuantityDropDown.SelectedItem.Value);
			computer.Quantity = qty;

			return computer;
		}

		private void setCpuList(Computer computer)
		{
			linq_to_sql.DataClasses1DataContext db = new linq_to_sql.DataClasses1DataContext();
			var query = from p in db.Parts
						from cp in db.ComputerParts
						where cp.ComputerID == computer.ComputerID && cp.PartID == p.PartID && String.Equals(p.Type, "CPU")
						select p.PartID;

			List <Part> partList = new List<Part>();
			foreach (int id in query.ToList())
			{
				partList.Add(Part.GetPart(id));
			}

			setList(computer.GetCpu(), CpuDropDown, partList);
		}

		private void setRamList(Computer computer)
		{
			linq_to_sql.DataClasses1DataContext db = new linq_to_sql.DataClasses1DataContext();
			var query = from p in db.Parts
						from cp in db.ComputerParts
						where cp.ComputerID == computer.ComputerID && cp.PartID == p.PartID && String.Equals(p.Type, "RAM")
						select p.PartID;

			List <Part> partList = new List<Part>();
			foreach (int id in query.ToList())
			{
				partList.Add(Part.GetPart(id));
			}

			setList(computer.GetRam(), RamDropDown, partList);
		}

		private void setHardDriveList(Computer computer)
		{
			linq_to_sql.DataClasses1DataContext db = new linq_to_sql.DataClasses1DataContext();
			var query = from p in db.Parts
						from cp in db.ComputerParts
						where cp.ComputerID == computer.ComputerID && cp.PartID == p.PartID && String.Equals(p.Type, "Hard Drive")
						select p.PartID;

			List <Part> partList = new List<Part>();
			foreach (int id in query.ToList())
			{
				partList.Add(Part.GetPart(id));
			}

			setList(computer.GetHardDrive(), HardDriveDropDown, partList);
		}

		private void setDisplayList(Computer computer)
		{
			linq_to_sql.DataClasses1DataContext db = new linq_to_sql.DataClasses1DataContext();
			var query = from p in db.Parts
						from cp in db.ComputerParts
						where cp.ComputerID == computer.ComputerID && cp.PartID == p.PartID && String.Equals(p.Type, "Display")
						select p.PartID;

			List <Part> partList = new List<Part>();
			foreach (int id in query.ToList())
			{
				partList.Add(Part.GetPart(id));
			}

			setList(computer.GetDisplay(), DisplayDropDown, partList);
		}

		private void setOsList(Computer computer)
		{
			linq_to_sql.DataClasses1DataContext db = new linq_to_sql.DataClasses1DataContext();
			var query = from p in db.Parts
						from cp in db.ComputerParts
						where cp.ComputerID == computer.ComputerID && cp.PartID == p.PartID && String.Equals(p.Type, "Operating System")
						select p.PartID;

			List <Part> partList = new List<Part>();
			foreach (int id in query.ToList())
			{
				partList.Add(Part.GetPart(id));
			}

			setList(computer.GetOs(), OsDropDown, partList);
		}

		private void setList(Part computerPart, DropDownList dropDown, List<Part> partList)
		{
			int index = 0;
			for (int i = 0; i < partList.Count; i++)
			{
				Part part = partList[i];
				string fullName = part.Brand + " " + part.Name;
				string id = part.PartID.ToString();
				ListItem li = new ListItem(fullName, id);
				dropDown.Items.Add(new ListItem(fullName, id));
				if (computerPart.PartID == part.PartID)
					index = i;
			}
			dropDown.Items[index].Selected = true;
		}
	}
}