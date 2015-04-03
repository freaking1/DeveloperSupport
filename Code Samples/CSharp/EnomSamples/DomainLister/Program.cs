// <copyright file="Program.cs" company="Rightside">
// Copyright (c) 2015 All Rights Reserved
// </copyright>
// <author>Sean Ottey</author>
// <email>sean.ottey@rightside.rocks</email>

namespace Enom.API.Examples.DomainLister
{
    using System;
    using System.Net;
    using System.Xml;

    /// <summary>
    /// This application demonstrates how to get a list of the
    /// domains this account owns.
    /// </summary>
    class Program
    {
        static void Main(string[] args)
        {
            // Gather parameters
            string username = "resellid";
            string password = "resellpw";
            string command = "GetDomains";
            int count = 20;

            // URL for API request
            string baseURL = "https://resellertest.enom.com/interface.asp?command={0}&responsetype=xml&uid={1}&pw={2}&display={3}";
            string url = string.Format(baseURL, command, username, password, count);

            // Specify security protocol if https is used
            ServicePointManager.SecurityProtocol = SecurityProtocolType.Tls12;
                
            // Load the API results into an XmlDocument object
            var xmlDoc = new XmlDocument();
            xmlDoc.Load(url);

            // Read the results
            var errorCount = xmlDoc.SelectSingleNode("/interface-response/ErrCount").InnerText;

            // Display results if no errors
            if (errorCount.Trim() == "0")
            {
                XmlNodeList domains = xmlDoc.SelectNodes("//domain");

                Console.WriteLine("Domain - Exp. Date - AutoRenew?");

                // Iterate through the returned domains
                foreach (XmlNode domain in domains)
                {
                    string tld = domain.SelectSingleNode("tld").InnerText;
                    string sld = domain.SelectSingleNode("sld").InnerText;
                    string expDate = domain.SelectSingleNode("expiration-date").InnerText;
                    string autoRenew = domain.SelectSingleNode("auto-renew").InnerText;

                    Console.WriteLine(string.Format("{0}.{1} - {2} - {3}", sld, tld, expDate, autoRenew));
                }                   
            }
            else
            {
                // There were errors, display them
                XmlNodeList errors = xmlDoc.SelectNodes("/interface-response/errors/*");
                foreach (XmlNode node in errors)
                {
                    Console.WriteLine("Error retrieving domain list: " + node.InnerText);
                }
            }

            Console.WriteLine("\nAny key to exit...");
            Console.ReadKey();
        }
    }
}
