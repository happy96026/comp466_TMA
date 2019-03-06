using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace TMA3.part4
{
	public partial class Register : System.Web.UI.Page
	{
		protected void Page_Load(object sender, EventArgs e)
		{

		}

		protected void ConfirmPassword(object source, ServerValidateEventArgs args)
		{
			args.IsValid = String.Equals(Password.Text, Confirm.Text);
		}

		protected void UserExists(object source, ServerValidateEventArgs args)
		{
			linq_to_sql.DataClasses1DataContext db = new linq_to_sql.DataClasses1DataContext();
			var query = from a in db.Auths
						where String.Equals(a.Username, Username.Text)
						select a;

			args.IsValid = !query.Any();
		}

		protected void Signup_Click(object sender, EventArgs e)
		{
			Validate();
			if (IsValid)
			{
				linq_to_sql.Auth auth = new linq_to_sql.Auth
				{
					Username = Username.Text,
					Password = Password.Text,
					Email = Email.Text
				};
				linq_to_sql.DataClasses1DataContext db = new linq_to_sql.DataClasses1DataContext();
				db.Auths.InsertOnSubmit(auth);
				db.SubmitChanges();
				
				Session["username"] = Username.Text;
				Response.Redirect("Default.aspx");
			}
		}
	}
}