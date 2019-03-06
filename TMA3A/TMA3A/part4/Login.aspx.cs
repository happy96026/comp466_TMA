using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace TMA3.part4
{
	public partial class Login : System.Web.UI.Page
	{
		protected void Page_Load(object sender, EventArgs e)
		{

		}

		protected void Login_Click(object sender, EventArgs e)
		{
			Validate();
			if (IsValid)
			{
				Session["username"] = Username.Text;
				Response.Redirect("Default.aspx");
			}
		}

		protected void ValidateUser(object source, ServerValidateEventArgs args)
		{
			linq_to_sql.DataClasses1DataContext db = new linq_to_sql.DataClasses1DataContext();
			var query = from a in db.Auths
						where String.Equals(a.Username, Username.Text) && String.Equals(a.Password, Password.Text)
						select a;
			args.IsValid = query.Any();
		}
	}
}