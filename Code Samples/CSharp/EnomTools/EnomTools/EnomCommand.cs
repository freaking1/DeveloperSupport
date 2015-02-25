
namespace Enom.Tools
{
    using System.Collections.Generic;

    public class EnomCommand
    {
        public readonly string BaseURL { get; set; }
        public string Command { get; set; }
        public Dictionary<string, string> Parameters { get; set; }

        public string GetFullURL
        {
            get
            {
                return BuildFullURL();
            }
        }

        private string BuildFullURL()
        {
            string ret = BaseURL;

            if (!ret.EndsWith("/"))
            {
                ret += "/";
            }

            // Add the command
            ret += "interface.asp?command=" + Command;

            foreach (KeyValuePair<string, string> entry in Parameters)
            {
                ret += "&" + entry.Key + "=" + entry.Value;
            }

            return ret;
        }
    }
}
