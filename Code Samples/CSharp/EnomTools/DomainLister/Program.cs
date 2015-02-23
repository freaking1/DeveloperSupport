// <copyright file="Program.cs" company="Rightside">
// Copyright (c) 2015 All Rights Reserved
// </copyright>
// <author>Sean Ottey</author>

namespace Enom.tools
{
    using System;
    using System.Xml;

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
                int count;
                
                // Validate the count parameter
                if (!int.TryParse(args[2], out count))
                {
                    ShowHelp("\nInvalid count parameter");
                    return -1;
                }
                else if (count < 1 || count > 100)
                {
                    ShowHelp("\nInvalid range for count parameter. Must be between 1 and 100");
                    return -1;
                }


                // URL for API request
                string baseURL = System.Configuration.ConfigurationManager.AppSettings["BaseURL"];
                string url = string.Format("{0}/interface.asp?command=GetDomains&responsetype=xml&uid={1}&pw={2}&display={3}", baseURL, username, password, count);

                // Load the API results into an XmlDocument object
                var xmlDoc = new XmlDocument();
                xmlDoc.Load(url);

                // Read the results
                var errorCount = xmlDoc.SelectSingleNode("/interface-response/ErrCount").InnerText;

                // Display results
                if (errorCount.Trim() == "0")
                {
                    XmlNodeList domains = xmlDoc.SelectNodes("//domain");

                    Console.WriteLine("Domain - Exp. Date - AutoRenew?");

                    foreach (XmlNode domain in domains)
                    {
                        string tld = domain.SelectSingleNode("tld").InnerText;
                        string sld = domain.SelectSingleNode("sld").InnerText;
                        string expDate = domain.SelectSingleNode("expiration-date").InnerText;
                        string autoRenew = domain.SelectSingleNode("auto-renew").InnerText;

                        Console.WriteLine(string.Format("{0}.{1} - {2} - {3}", sld, tld, expDate, autoRenew));
                    }
                    
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
    }
}
