// <copyright file="program.cs" company="Rightside">
// Copyright (c) 2015 All Rights Reserved
// </copyright>
// <author>Sean Ottey</author>
// <email>sean.ottey@rightside.rocks</email>

namespace enom.API.Examples.GetAndSetHosts
{
    using System.Xml;
    using System.Collections.Generic;

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
    /// </summary>
    class Program
    {
        /// <summary>
        /// Primary entry point for the application.
        /// 
        /// To simplify the code, no argument validation is done here and
        /// a hardcoded baseURL for resellertest.enom.com is used.
        /// 
        /// Alter the strings below, inserting your username, password, sld
        /// and tld. You may also change the baseURL if you want to use the
        /// live API
        /// </summary>
        static void Main(string[] args)
        {
            /**********************************/
            /* Set up parameters for the call */
            /**********************************/
            const string username = "enomtest_reseller";
            const string password = "tester";
            const string sld = "seanottey";
            const string tld = "com";
            string baseURL = "https://resellertest.enom.com/interface.asp?" + "&uid=" + username + "&pw=" + password + "&responsetype=xml";



            /**************************************************************/
            /* See GetHosts method for an example of how to use this call */
            /**************************************************************/
            List<HostEntry> hosts = GetHosts(baseURL, sld, tld);



            /**************************************************************/
            /*       Update MX Records in the existing hosts              */
            /**************************************************************/
            for (int i = 0; i < hosts.Count; i++)
            {
                if (hosts[i].RecordType.ToLower() == "a")
                {
                    hosts[i].Address = "127.0.0.1";
                }
            }
                                                        


            /**************************************************************/
            /* See SetHosts method for an example of how to use this call */
            /**************************************************************/
            bool success = SetHosts(baseURL, sld, tld, hosts);  
                      
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

            string completeURL = baseURL + string.Format("&command=GetHosts&sld={0}&tld={1}", sld, tld);

            using (var client = new System.Net.WebClient())
            {
                result = client.DownloadString(completeURL);
            }

            XmlDocument dom = new XmlDocument();
            dom.LoadXml(result);

            XmlNodeList hosts = dom.SelectNodes("//host");

            foreach (XmlNode host in hosts)
            {
                HostEntry entry = new HostEntry();
                entry.Name = host.SelectSingleNode("name").InnerText;
                entry.RecordType = host.SelectSingleNode("type").InnerText;
                entry.Address = host.SelectSingleNode("address").InnerText;

                hostList.Add(entry);
            }

            return hostList;
            
        }

        /// <summary>
        /// Method demonstrating the use of the SetHosts API call
        /// </summary>
        /// <param name="baseURL">the base URL of the API service</param>
        /// <param name="sld">SLD to use (e.g. enom of enom.com)</param>
        /// <param name="tld">TLD to use (e.g. com of enom.com)</param>
        /// <param name=hosts>List of <see cref="HostEntry"/> objects to use</param>
        /// <example>
        ///     This method uses the provided parameters to build a string 
        ///     similar to the following:
        ///     
        /// </example>
        private static bool SetHosts(string baseURL, string sld, string tld, List<HostEntry> hosts)
        {
            string result = string.Empty;

            string completeURL = baseURL + string.Format("&command=SetHosts&sld={0}&tld={1}", sld, tld);

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

            using (var client = new System.Net.WebClient())
            {
                result = client.DownloadString(completeURL);
            }

            return result.Contains("<ErrCount>0</ErrCount>");
        }
    }

    public class HostEntry
    {
        public string Name { get; set; }
        public string RecordType { get; set; }
        public string Address { get; set; }
    }
}
