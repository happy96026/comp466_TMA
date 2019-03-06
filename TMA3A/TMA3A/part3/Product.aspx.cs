using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using TMA3.part3.Models;

namespace TMA3.part3
{
	public partial class Product : System.Web.UI.Page
	{
		private Computer computer;

		protected void Page_Init(object sender, EventArgs e)
		{
			checkGetParams();

			Computer computer = Computer.GetComputer(Int32.Parse(Request.QueryString["productID"]));
			// Should be changed when DB is connected
			computer.setPartIDs(1, 2, 3, 4, 5);

			setCpuList(computer);
			setRamList(computer);
			setHardDriveList(computer);
			setDisplayList(computer);
			setOsList(computer);
			BrandLabel.Text = computer.Brand;
			NameLabel.Text = computer.Name;
			PriceLabel.Text = computer.GetPriceStr();

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

			//	Debug.WriteLine(Request.Cookies["computer"].Value);

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
			List<Part> partList = new List<Part>();
			Part cpu = Part.GetPart(1);
			partList.Add(cpu);
			cpu = Part.GetPart(6);
			partList.Add(cpu);

			setList(computer.GetCpu(), CpuDropDown, partList);
		}

		private void setRamList(Computer computer)
		{
			List<Part> partList = new List<Part>();
			Part ram = Part.GetPart(2);
			partList.Add(ram);

			setList(computer.GetRam(), RamDropDown, partList);
		}

		private void setHardDriveList(Computer computer)
		{
			List<Part> partList = new List<Part>();
			Part hardDrive = Part.GetPart(3);
			partList.Add(hardDrive);

			setList(computer.GetHardDrive(), HardDriveDropDown, partList);
		}

		private void setDisplayList(Computer computer)
		{
			List<Part> partList = new List<Part>();
			Part display = Part.GetPart(4);
			partList.Add(display);

			setList(computer.GetDisplay(), DisplayDropDown, partList);
		}

		private void setOsList(Computer computer)
		{
			List<Part> partList = new List<Part>();
			Part os = Part.GetPart(5);
			partList.Add(os);

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