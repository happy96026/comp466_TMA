using Newtonsoft.Json.Linq;
using System;
using System.Collections;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using TMA3.part4.Models;

namespace TMA3.part4
{
	public partial class MyCart : System.Web.UI.Page
	{
		private List<Computer> computerList;

		protected void Page_Init(object sender, EventArgs e)
		{
			computerList = GetComputers();
			Cart cart = new Cart(computerList);
			PriceLabel.Text = cart.GetTotalStr();
			CartList.DataSource = computerList;
			CartList.DataBind();
			for (int i = 0; i < CartList.Items.Count; i++)
			{
				Computer computer = computerList[i];
				ListViewItem item = CartList.Items[i];
				DropDownList ddList = (DropDownList) item.FindControl("QuantityDropDown");
				ddList.Items[computer.Quantity - 1].Selected = true;
			}
		}

		public List<Computer> GetComputers()
		{
			Cart cart = Cart.Deserialize(Request.Cookies["computer"].Value);
			List<Computer> computerList = cart.GetComputerList();
			Response.Cookies["computer"].Value = Cart.Serialize(cart);

			return computerList;
		}

		protected void OnItemCommand(object sender, ListViewCommandEventArgs e)
		{
			if (String.Equals(e.CommandName, "Remove"))
			{
				computerList = GetComputers();
				computerList.RemoveAt(0);
				CartList.DataSource = computerList;
				CartList.DataBind();
				Cart cart = new Cart(computerList);
				Response.Cookies["computer"].Value = Cart.Serialize(cart);
				Quantity_Change(null, null);
			}
		}

		protected void Quantity_Change(object sender, EventArgs e)
		{
			for (int i = 0; i < CartList.Items.Count; i++)
			{
				DropDownList ddList = (DropDownList) CartList.Items[i].FindControl("QuantityDropDown");
				Computer computer = computerList[i];
				int qty = Int32.Parse(ddList.SelectedValue);
				computer.Quantity = qty;
			}
			Cart cart = new Cart(computerList);
			Response.Cookies["computer"].Value = Cart.Serialize(cart);
			PriceLabel.Text = cart.GetTotalStr();
		}

	}
}