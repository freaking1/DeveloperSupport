
namespace DomainInfo
{
    using System;
    using System.Text;
    using System.Xml;
    using System.Xml.Linq;

    class Program
    {
        static int Main(string[] args)
        {
            // Make sure all needed parameters were provided
            // if not, show a message and exit
            if (args.Length != 4)
            {
                ShowHelp();
                return -1;
            }
            else
            {
                // Gather parameters
                string username = args[0];
                string password = args[1];
                string sld = args[2];
                string tld = args[3];

                // URL for API request
                string baseURL = System.Configuration.ConfigurationManager.AppSettings["BaseURL"];
                string url = string.Format("{0}/interface.asp?command=GetDomainInfo&responsetype=xml&uid={1}&pw={2}&sld={3}&tld={4}", baseURL, username, password, sld, tld);

                // Load the API results into an XmlDocument object
                var xmlDoc = new XmlDocument();
                xmlDoc.Load(url);

                // Read the results
                var errorCount = xmlDoc.SelectSingleNode("/interface-response/ErrCount").InnerText;

                // Display results
                if (errorCount.Trim() == "0")
                {
                    Console.Write(PrettyXml(xmlDoc.InnerXml));

                    return 0;
                }
                else
                {
                    Console.WriteLine("Error retrieving list: " + xmlDoc.SelectSingleNode("/interface-response/errors/Err1").InnerText);
                    return -1;
                }

            }
        }

        /// <summary>
        /// Displays usage details
        /// </summary>
        /// <param name="message"></param>
        private static void ShowHelp(string message = "")
        {
            Console.WriteLine("Usage: EnomDomainRedirector [username] [password] [sourceSLD] [sourceTLD] [targetURL]");

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
