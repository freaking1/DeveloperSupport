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
            if (args.Length != 5)
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
                string targetURL = args[4];

                // Verify the target URL is a value URL
                // if not, show message and exit
                Uri uri;
                if (!Uri.TryCreate(targetURL, UriKind.RelativeOrAbsolute, out uri))
                {
                    ShowHelp("\nInvalid target URL specified!");
                    return -1;
                }

                // URL for API request
                string baseURL = System.Configuration.ConfigurationManager.AppSettings["BaseURL"];
                string url = string.Format("{0}/interface.asp?command=sethosts&responsetype=xml&uid={1}&pw={2}&sld={3}&tld={4}&hostname1=*&RecordType1=URL&address1={5}", baseURL, username, password, sld, tld, targetURL);

                // Load the API results into an XmlDocument object
                var xmlDoc = new XmlDocument();
                xmlDoc.Load(url);

                // Read the results
                var errorCount = xmlDoc.SelectSingleNode("/interface-response/ErrCount").InnerText;                
                
                // Display results
                if (errorCount.Trim() == "0")
                {
                    Console.WriteLine(string.Format("{0}.{1} successfully pointed at {2}", sld, tld, targetURL));
                    return 0;
                }
                else
                {
                    Console.WriteLine("Error making change: " + xmlDoc.SelectSingleNode("/interface-response/errors/Err1").InnerText);
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
