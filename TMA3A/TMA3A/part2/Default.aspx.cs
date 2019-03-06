using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Diagnostics;

namespace TMA3.part2
{
	public partial class Default : System.Web.UI.Page
	{
		private SlideshowSessionData sessionData;

		protected void Page_Load(object sender, EventArgs e)
		{
			if (Session["sessionData"] != null)
			{
				sessionData = (SlideshowSessionData)Session["sessionData"];
			}
			else
			{
				sessionData = new SlideshowSessionData();
				Session["sessionData"] = sessionData;
			}
			string path = sessionData.JsonData[sessionData.Index]["path"];
			string caption = sessionData.JsonData[sessionData.Index]["caption"];
			SetImage(SlideImage, path, caption);
		}

        protected void Random_Click(object sender, EventArgs e)
        {
			bool random = sessionData.Random;
			RandomButton.Text = random ? "'Random" : "Sequential";
			sessionData.Random = !random;
			if (sessionData.Random)
			{
				PrevButton.Visible = false;
				NextButton.Visible = false;
			} else
			{
				PrevButton.Visible = true;
				NextButton.Visible = true;
			}
		}

        protected void Play_Click(object sender, EventArgs e)
        {
			bool play = sessionData.Play;
			PlayButton.Text = play ? "Play" : "Stop";
			sessionData.Play = !play;
			SlideshowTimer.Enabled = sessionData.Play ? true : false;
		}

        protected void Prev_Click(object sender, EventArgs e)
        {
			sessionData.Index--;
			string path = sessionData.JsonData[sessionData.Index]["path"];
			string caption = sessionData.JsonData[sessionData.Index]["caption"];
            SetImage(SlideImage, path, caption);
		}

        protected void Next_Click(object sender, EventArgs e)
        {
			sessionData.Index++;
			string path = sessionData.JsonData[sessionData.Index]["path"];
			string caption = sessionData.JsonData[sessionData.Index]["caption"];
            SetImage(SlideImage, path, caption);
        }

		protected void SetRandomImage(object sender, EventArgs e)
		{
			int index = sessionData.GetRandomNumber();
			string path = sessionData.JsonData[index]["path"];
			string caption = sessionData.JsonData[index]["caption"];
            SetImage(SlideImage, path, caption);
		}

		protected void SetNextImage(object sender, EventArgs e)
		{
			if (sessionData.Random)
				SetRandomImage(sender, e);
			else
				Next_Click(sender, e);
		}

		private void SetImage(Image img, string imgPath, string caption)
		{
			string currDir = HttpContext.Current.Server.MapPath(".");
			string relPath = Path.Combine("img", imgPath);
            System.Drawing.Image systemImg = System.Drawing.Image.FromFile(Path.Combine(currDir, relPath));
            if (systemImg.Height/Panel.Height.Value > systemImg.Width/Panel.Width.Value)
                img.Height = new Unit("100%");
            else
                img.Width = new Unit("100%");

			systemImg.Dispose();
            SlideImage.ImageUrl = relPath;
			Caption.Text = caption;
        }
    }
}