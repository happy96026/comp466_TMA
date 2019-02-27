using System;
using System.Net;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.IO;
using Newtonsoft.Json;

namespace TMA3.part1
{
    public partial class WebForm1 : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (Session["hits"] == null)
            {
                Session["hits"] = 1;
            } else
            {
                Session["hits"] = (int) Session["hits"] + 1;
            }
            Hits.Text = Session["hits"].ToString();
            IPAddress.Text = Request.UserHostAddress;
            var request = (HttpWebRequest)WebRequest.Create("http://ip-api.com/json/" + IPAddress.Text);
            var response = (HttpWebResponse)request.GetResponse();
            var responseString = new StreamReader(response.GetResponseStream()).ReadToEnd();
            dynamic json = JsonConvert.DeserializeObject(responseString);
            TimeZone.Text = json.timezone;
        }
    }
}