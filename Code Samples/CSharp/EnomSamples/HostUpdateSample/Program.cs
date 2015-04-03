// <copyright file="Program.cs" company="Rightside">
// Copyright (c) 2015 All Rights Reserved
// </copyright>
// <author>Sean Ottey</author>
// <email>sean.ottey@rightside.rocks</email>

namespace enom.API.Examples.GetAndSetHosts
{
    using System;
    using System.Collections.Generic;
    using System.Net;
    using System.Xml;

    /// <summary>
    /// This application demonstrates how to get and set host file entries.
    /// NOTE: SetHosts resets all host entries to the provided hosts. The
    /// best practice (as seen below) is to do a "GetHosts", then alter the 
    /// collection and use the same collection for SetHosts.
    /// 
    /// - For an example of how to use GetHosts, see the GetHosts method.
    /// 
    /// - For an example of how to use SetHosts, see the GetHosts method.
    /// 
    /// - Both of these methods use the HostEntry class (below) to store 
    ///   the host info.
    ///   
    /// To simplify the code, no argument validation is done here and
    /// a hardcoded baseURL for resellertest.enom.com is used.
    /// 
    /// Alter the strings below, inserting your username, password, sld
    /// and tld. You may also change the baseURL if you want to use the
    /// live API
    /// </summary>
    class Program
    {
        static void Main(string[] args)
        {
            // Set up parameters for the call
            const string username = "resellid";
            const string password = "resellpw";
            const string sld = "SecondLevelDomain";
            const string tld = "com";
            string baseURL = string.Format("https://resellertest.enom.com/interface.asp?responsetype=xml&uid={0}&pw={1}", username, password);

            // Specify security protocol if https is used
            ServicePointManager.SecurityProtocol = SecurityProtocolType.Tls12;

            // See GetHosts method for an example of how to use this call
            List<HostEntry> hosts = GetHosts(baseURL, sld, tld);

            // Iterate through the host records setting any A records to 127.0.0.1      
            for (int i = 0; i < hosts.Count; i++)
            {
                if (hosts[i].RecordType.ToLower() == "a")
                {
                    hosts[i].Address = "127.0.0.1";
                }
            }
                                                        
            // See SetHosts method for an example of how to use this call */
            bool success = SetHosts(baseURL, sld, tld, hosts);  
                    
            if (success)
            {
                Console.WriteLine("Hosts set successfully");
            }
            else
            {
                Console.WriteLine("Error setting hosts");
            }

            Console.WriteLine("\nAny key to exit...");
            Console.ReadKey();
        }

        /// <summary>
        /// Method demonstrating the use of the GetHosts API call
        /// </summary>
        /// <param name="baseURL">the base URL of the API service</param>
        /// <param name="sld">SLD to use (e.g. enom of enom.com)</param>
        /// <param name="tld">TLD to use (e.g. com of enom.com)</param>
        /// <returns>List of <see cref="HostEntry"/> objects</returns>
        private static List<HostEntry> GetHosts(string baseURL, string sld, string tld)
        {
            List<HostEntry> hostList = new List<HostEntry>();
            string result = string.Empty;

            // Append the necessary arguments
            string completeURL = baseURL + string.Format("&command=GetHosts&sld={0}&tld={1}", sld, tld);

            // Load the API results into an XmlDocument object
            var xmlDoc = new XmlDocument();
            xmlDoc.Load(completeURL);


            // Determine if errors ocurred
            var errorCount = xmlDoc.SelectSingleNode("/interface-response/ErrCount").InnerText;

            // If no errors, display results
            if (errorCount.Trim() == "0")
            {
                XmlNodeList hosts = xmlDoc.SelectNodes("//host");

                // Iterate the hosts returned and gether them
                // up into a collection of objects
                foreach (XmlNode host in hosts)
                {
                    HostEntry entry = new HostEntry();
                    entry.Name = host.SelectSingleNode("name").InnerText;
                    entry.RecordType = host.SelectSingleNode("type").InnerText;
                    entry.Address = host.SelectSingleNode("address").InnerText;

                    hostList.Add(entry);
                }
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

            return hostList;
            
        }

        /// <summary>
        /// Method demonstrating the use of the SetHosts API call
        /// </summary>
        /// <param name="baseURL">the base URL of the API service</param>
        /// <param name="sld">SLD to use (e.g. enom of enom.com)</param>
        /// <param name="tld">TLD to use (e.g. com of enom.com)</param>
        /// <param name="hosts">List of <see cref="HostEntry"/> objects to use</param>
        /// <returns>True if successful</returns>
        private static bool SetHosts(string baseURL, string sld, string tld, List<HostEntry> hosts)
        {
            string result = string.Empty;

            // Append the necessary arguments
            string completeURL = baseURL + string.Format("&command=SetHosts&sld={0}&tld={1}", sld, tld);

            // Iterate through the hosts  we retrieved, adding
            // them to the url using an ordinal (hostname1=,hostname2, etc.)
            for (int i = 0; i < hosts.Count; i++)
            {
                // We need this because hosts is 0 based, but the params are 1 based
                string number = (i + 1).ToString();

                // Add name parameter
                completeURL += "&hostname" + number + "=" + hosts[i].Name;

                // Add name parameter
                completeURL += "&recordtype" + number + "=" + hosts[i].RecordType;

                // Add name parameter
                completeURL += "&address" + number + "=" + hosts[i].Address;
            }

            // Load the API results into an XmlDocument object
            var xmlDoc = new XmlDocument();
            xmlDoc.Load(completeURL);

            var errorCount = xmlDoc.SelectSingleNode("/interface-response/ErrCount").InnerText;

            // True if no errors
            if (errorCount.Trim() == "0")
            {
                return true;
            }
            else
            {
                // There were errors, display them
                XmlNodeList errors = xmlDoc.SelectNodes("/interface-response/errors/*");
                foreach (XmlNode node in errors)
                {
                    Console.WriteLine("Error retrieving list: " + node.InnerText);
                }

                return false;
            }
        }
    }

    /// <summary>
    /// Utility class to hold returned host information
    /// </summary>
    public class HostEntry
    {
        /// <summary>
        /// Name of the host
        /// </summary>
        public string Name { get; set; }

        // Type of host record
        public string RecordType { get; set; }

        //Host address
        public string Address { get; set; }
    }
}
