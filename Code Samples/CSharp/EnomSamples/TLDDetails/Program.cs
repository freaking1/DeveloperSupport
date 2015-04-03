// <copyright file="Program.cs" company="Rightside">
// Copyright (c) 2015 All Rights Reserved
// </copyright>
// <author>Sean Ottey</author>
// <email>sean.ottey@rightside.rocks</email>

namespace TLDDetails
{
    using System;
    using System.Text;
    using System.Collections.Generic;
    using System.Xml;
    using System.Net;
    using System.Xml.Linq;

    /// <summary>
    /// This application gathers details about a specific TLD with
    /// information about registration, renewal and transfer 
    /// policies
    /// </summary>
    class Program
    {
        static void Main(string[] args)
        {
            // Gather parameters
            string username = "resellid";
            string password = "resellpw";
            string command = "GetTLDDetails";
            string baseURL = "https://resellertest.enom.com/interface.asp?command={0}&responsetype=xml&uid={1}&pw={2}&tld={3}";
            string tld = "social";        

            try
            {
                string url = string.Format(baseURL, command, username, password, tld);

                // Load the API results into an XmlDocument object
                var xmlDoc = new XmlDocument();
                xmlDoc.Load(url);

                // Read the results
                var errorCount = xmlDoc.SelectSingleNode("/interface-response/ErrCount").InnerText;

                // Display results
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
            catch (System.ApplicationException ex)
            {
                Console.WriteLine(ex.Message);
            }
        }      
    }
}
