using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace TMA3.part4
{
	public partial class Layout : System.Web.UI.MasterPage
	{
		protected void Page_Load(object sender, EventArgs e)
		{
			if (Session["username"] == null)
			{
				LoginLink.Visible = true;
				Dropdown.Visible = false;
			}
			else
			{
				LoginLink.Visible = false;
				Dropdown.Visible = true;
			}
		}

		protected void Logout_Click(object sender, EventArgs e)
		{
			Session["username"] = null;
			Response.Redirect("Default.aspx");
		}
	}
}