// <copyright file="Program.cs" company="Rightside">
// Copyright (c) 2015 All Rights Reserved
// </copyright>
// <author>Sean Ottey</author>
// <email>sean.ottey@rightside.rocks</email>

namespace Enom.tools
{
    using System;
    using System.Net;
    using System.Xml;

    /// <summary>
    /// This application demonstrates how set a domain to redirect
    /// to another URL by setting the host records to a single URL
    /// record.
    /// NOTE: If you run this it will wipe all host records for the URL
    ///       and replace them with a singele redirection entry
    /// </summary>    
    class Program
    {
        static void Main(string[] args)
        {
            // Gather parameters
            string username = "resellid";
            string password = "resellpw";
            string command = "SetHosts";
            string sld = "SecondLevelDomain";
            string tld = "com";
            string targetURL = "http://www.enom.com";

            // URL for API request
            string baseURL = "https://resellertest.enom.com/interface.asp?command={0}&responsetype=xml&uid={1}&pw={2}&sld={3}&tld={4}&hostname1=*&RecordType1=URL&address1={5}";
            string url = string.Format(baseURL, command, username, password, sld, tld, targetURL);

            // Specify security protocol if https is used
            ServicePointManager.SecurityProtocol = SecurityProtocolType.Tls12;

            // Load the API results into an XmlDocument object
            var xmlDoc = new XmlDocument();
            xmlDoc.Load(url);

            // Read the results
            var errorCount = xmlDoc.SelectSingleNode("/interface-response/ErrCount").InnerText;                
                
            // Display results
            if (errorCount.Trim() == "0")
            {
                Console.WriteLine(string.Format("{0}.{1} successfully pointed at {2}", sld, tld, targetURL));
                Console.WriteLine(xmlDoc.InnerXml);
            }
            else
            {
                // There were errors, display them
                XmlNodeList errors = xmlDoc.SelectNodes("/interface-response/errors/*");
                foreach (XmlNode node in errors)
                {
                    Console.WriteLine("Error retrieving list: " + node.InnerText);
                }
            }

            Console.WriteLine("\nAny key to exit...");
            Console.ReadKey();
        }
    }
}
