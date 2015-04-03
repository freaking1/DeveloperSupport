// <copyright file="Program.cs" company="Rightside">
// Copyright (c) 2015 All Rights Reserved
// </copyright>
// <author>Sean Ottey</author>
// <email>sean.ottey@rightside.rocks</email>

namespace Enom.API.Examples.DomainInfo
{
    using System;
    using System.Net;
    using System.Text;
    using System.Xml;
    using System.Xml.Linq;

    /// <summary>
    /// This application demonstrates how to get information on a domain.
    /// It simply takes 4 arguments, then calls the API and displays the 
    /// to the results to the screen
    /// </summary>
    class Program
    {
        static void Main(string[] args)
        {
            // Gather parameters
            string username = "resellid";
            string password = "resellpw";
            string command = "GetDomainInfo";
            string sld = "SecondLevelDomain";
            string tld = "com";

            // Template for url we will call
            string baseURL = "https://resellertest.enom.com/interface.asp?command={0}&responsetype=xml&uid={1}&pw={2}&sld={3}&tld={4}";

            // URL for API request               
            string url = string.Format(baseURL, command, username, password, sld, tld);

            try
            {
                // Specify security protocol if https may be used
                ServicePointManager.SecurityProtocol = SecurityProtocolType.Tls12;

                // Load the API results into an XmlDocument object
                var xmlDoc = new XmlDocument();
                xmlDoc.Load(url);

                // Determine if errors ocurred
                var errorCount = xmlDoc.SelectSingleNode("/interface-response/ErrCount").InnerText;

                // If no errors, display results
                if (errorCount.Trim() == "0")
                {
                    Console.Write(xmlDoc.InnerXml);
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
            catch (System.Exception ex)
            {
                Console.WriteLine(ex.Message);
            }
        }
    }
}
