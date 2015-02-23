

namespace TLDDetails
{
    using System;
    using System.Text;
    using System.Collections.Generic;
    using System.Xml;
    using System.Xml.Linq;

    class Program
    {
        static int Main(string[] args)
        {
            // Make sure all needed parameters were provided
            // if not, show a message and exit
            if (args.Length != 3)
            {
                ShowHelp();
                return -1;
            }
            else
            {
                // Gather parameters
                string username = args[0];
                string password = args[1];
                string tld = args[2];
                List<string> tldList = new List<string>();

                string details = string.Empty;

                // URL for API request
                string baseURL = System.Configuration.ConfigurationManager.AppSettings["BaseURL"];

                if (tld.ToLower() == "all")
                {
                    // Get a list of all TLD's
                    tldList = GetAllAvailableTLDs(baseURL, username, password);
                }
                else
                {
                    tldList.Add(tld);
                }

                try
                {
                    details = GetTLDInfo(baseURL, username, password, tldList);

                    System.IO.File.WriteAllText("output.xml", PrettyXml(details));
                    // Console.WriteLine(details);
                    return 0;
                }
                catch (System.ApplicationException ex)
                {
                    Console.WriteLine(ex.Message);
                    return -1;
                }
            }
        }

        private static List<string> GetAllAvailableTLDs(string baseURL, string username, string password)
        {
            List<string> ret = new List<string>();

            string url = string.Format("{0}/interface.asp?command=GetTLDList&responsetype=xml&uid={1}&pw={2}", baseURL, username, password);

            // Load the API results into an XmlDocument object
            var xmlDoc = new XmlDocument();
            xmlDoc.Load(url);

            // Read the results
            var errorCount = xmlDoc.SelectSingleNode("/interface-response/ErrCount").InnerText;

            // Display results
            if (errorCount.Trim() == "0")
            {
                XmlNodeList tldNodes = xmlDoc.SelectNodes("//tldlist/tld/tld");

                foreach (XmlNode node in tldNodes)
                {
                    ret.Add(node.InnerText);
                }

                return ret;
            }
            else
            {
                throw new ApplicationException("Error retrieving tld List: " + xmlDoc.SelectSingleNode("/interface-response/errors/Err1").InnerText);
            }            
        }       

        private static string GetTLDInfo(string baseURL, string username, string password, List<string> tldList)
        {
            string ret = "<tldList start='" + DateTime.Now + "'>";

            foreach (string tld in tldList)
            {
                string url = string.Format("{0}/interface.asp?command=GetTLDDetails&responsetype=xml&uid={1}&pw={2}&tld={3}", baseURL, username, password, tld);

                // Load the API results into an XmlDocument object
                var xmlDoc = new XmlDocument();
                xmlDoc.Load(url);

                // Read the results
                var errorCount = xmlDoc.SelectSingleNode("/interface-response/ErrCount").InnerText;

                // Display results
                if (errorCount.Trim() == "0")
                {
                    ret += xmlDoc.SelectSingleNode("//tlds").InnerXml;
                }
                else
                {
                    throw new ApplicationException("Error retrieving details: " + xmlDoc.SelectSingleNode("/interface-response/errors/Err1").InnerText);
                }
            }

            return ret + "</tldList>";
        }
        

        /// <summary>
        /// Displays usage details
        /// </summary>
        /// <param name="message"></param>
        private static void ShowHelp(string message = "")
        {
            Console.WriteLine("Usage: TLDDetails [username] [password] [TLD|'All']");

            if (message != null)
            {
                Console.WriteLine(message);
            }
        }

        static string PrettyXml(string xml)
        {
            var stringBuilder = new StringBuilder();

            var element = XElement.Parse(xml);

            var settings = new XmlWriterSettings();
            settings.OmitXmlDeclaration = true;
            settings.Indent = true;
            // settings.NewLineOnAttributes = true;

            using (var xmlWriter = XmlWriter.Create(stringBuilder, settings))
            {
                element.Save(xmlWriter);
            }

            return stringBuilder.ToString();
        }

    }
}
