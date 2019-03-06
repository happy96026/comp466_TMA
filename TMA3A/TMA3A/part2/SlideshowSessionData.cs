using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.IO;

namespace TMA3.part2
{
	[Serializable]
	public class SlideshowSessionData
	{
		private int index;
		private Random rnd;

		public dynamic JsonData { get; set; }
		public int Index
		{
			get
			{
				return index;
			}
			set
			{
				int n = value;
				int m = JsonData.Count;
				index = ((n % m) + m) % m;
			}
		}
		public bool Random { get; set; }
		public bool Play { get; set; }

		public SlideshowSessionData()
		{
			string currDir = HttpContext.Current.Server.MapPath(".");
			string content = File.ReadAllText(Path.Combine(currDir, "images.json"));
			//JsonData = Newtonsoft.Json.JsonConvert.DeserializeObject<List<Object>>(content);
			JsonData = Newtonsoft.Json.JsonConvert.DeserializeObject(content);
			Index = 0;
			Random = false;
			Play = true;
			rnd = new Random();
		}

		public int GetRandomNumber()
		{
			return rnd.Next(0, JsonData.Count);
		}
	}
}