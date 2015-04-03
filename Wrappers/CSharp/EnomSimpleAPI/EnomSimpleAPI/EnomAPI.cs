// <copyright file="EnomAPI.cs" company="Rightside">
// Copyright (c) 2015 All Rights Reserved
// </copyright>
// <author>Sean Ottey</author>
// <email>sean.ottey@rightside.rocks</email>

namespace Enom.Tools.API.EnomSimpleAPI
{
    using System;
    using System.Collections;
    using System.Collections.Generic;
    using System.IO;
    using System.Net;
    using System.Text;
    using System.Text.RegularExpressions;
    using System.Web;
    using System.Xml;

    public class EnomAPI
    {
        #region public properties
        /// <summary>
        /// Gets or sets a value which is the Base URL used for building the query URL
        /// </summary>
        public string BaseURL { get; set; }

        /// <summary>
        /// Gets or sets the value which indicates the command to execute
        /// </summary>
        public string CommandName { get; set; }

        /// <summary>
        /// Gets or sets the username used for queries
        /// </summary>
        public string Username { get; set; }

        /// <summary>
        /// Gets or sets the password used for queries
        /// </summary>
        public string Password { get; set; }

        /// <summary>
        /// Gets or sets the response type wanted
        /// </summary>
        public string ResponseType { get; set; }

        /// <summary>
        /// Gets or sets the parameters used for queries
        /// </summary>
        public Dictionary<string, string> Params { get; private set; }

        /// <summary>
        /// Gets the url built using the parameters
        /// </summary>
        public string CompleteQueryURL { get; private set; }

        /// <summary>
        /// Gets the raw xml response string
        /// </summary>
        public string RawResponse { get; private set; }

        /// <summary>
        /// Gets a collection of errors logged during query
        /// </summary>
        public ArrayList Errors { get; private set; }
        #endregion public properties

        #region private properties
        /// <summary>
        /// Holds XmlResponse dom if responsetype xml was used
        /// </summary>
        private XmlDocument XmlResponse = new XmlDocument();
        #endregion private properties

        #region constructors
        /// <summary>
        /// Populating Constructor
        /// </summary>
        /// <param name="baseURL">BaseURL to use for the call</param>
        /// <param name="username">Reseller username</param>
        /// <param name="password">Reseller password</param>
        /// <param name="command">API Command to use</param>
        public EnomAPI(string baseURL = "", string username = "", string password = "", string command = "")
        {
            Params = new Dictionary<string, string>();
            Errors = new ArrayList();
            BaseURL = baseURL;
            Username = username;
            Password = password;
            CommandName = command;

            ConfigureTsl();
        }
        #endregion constructors

        #region public methods
        /// <summary>
        /// Runs a specified command using the object's credentials
        /// baseURL and parameters
        /// </summary>
        /// <returns>True if successful, else false</returns>
        public bool Execute()
        {
            try
            {
                VerifyParameters();

                CompleteQueryURL = BuildQueryURL();

                switch (ResponseType.ToLower())
                {
                    case "xml":
                        {
                            XmlDocument XmlResponse = new XmlDocument();
                            XmlResponse.Load(CompleteQueryURL);
                            RawResponse = XmlResponse.OuterXml;
                            break;
                        }
                    case "text":
                        {
                            RawResponse = GetQueryResult(CompleteQueryURL);
                            break;
                        }
                    case "html":
                        {
                            RawResponse = GetQueryResult(CompleteQueryURL);
                            break;
                        }
                }

                if (string.IsNullOrEmpty(RawResponse))
                {
                    // Nothing returned
                    Errors.Add("No response from server");
                    return false;
                }
                else
                {
                    // Check for errors
                    if (GetErrorCount() > 0)
                    {
                        AddErrors(GetErrors());
                    }

                    return true;
                }
            }
            catch (Exception ex)
            {
                Errors.Add(ex.Message);
                return false;
            }
        }

        public int GetErrorCount()
        {
            if (!string.IsNullOrEmpty(RawResponse))
            {
                switch (ResponseType.ToLower())
                {
                    case "html":
                        return GetHtmlErrorCount();
                    case "xml":
                        return GetXMLErrorCount();
                    case "text":
                        return GetTextErrorCount();
                    default:
                        return 0;
                }
            }
            else
            {
                return 0;
            }
        }

        public List<string> GetErrors()
        {
            if (!string.IsNullOrEmpty(RawResponse))
            {
                switch (ResponseType.ToLower())
                {
                    case "html":
                        return GetHtmlErrors();
                    case "xml":
                        return GetXMLErrors();
                    case "text":
                        return GetTextErrors();
                    default:
                        return new List<string>();
                }
            }
            else
            {
                return new List<string>();
            }
        }

        /// <summary>
        /// Add a parameter to the collection. If param already exists, entry is updated with new value
        /// </summary>
        /// <param name="key">Value key</param>
        /// <param name="value">Value</param>
        public void AddParam(string key, object value)
        {
            if (Params == null)
            {
                Params = new Dictionary<string, string>();
            }

            key = key.ToLowerInvariant();

            if (Params.ContainsKey(key))
            {
                Params[key] = value.ToString();
            }
            else
            {
                Params.Add(key, value.ToString());
            }
        }

        public void RemoveParam(string key)
        {
            if (Params == null)
            {
                Params = new Dictionary<string, string>();
            }

            key = key.ToLowerInvariant();

            if (Params.ContainsKey(key))
            {
                Params.Remove(key);
            }
        }
        #endregion public methods

        #region private methods
        private string GetQueryResult(string CompleteQueryURL)
        {
            string ret = String.Empty;
            HttpWebRequest request = HttpWebRequest.CreateHttp(CompleteQueryURL);
            request.Method = "GET";

            WebResponse response = request.GetResponse();

            using (Stream data = response.GetResponseStream())
            {
                using (StreamReader sr = new StreamReader(data))
                {
                    ret = sr.ReadToEnd();
                }
            }

            return ret;
        }

        private string BuildQueryURL()
        {
            StringBuilder raw = new StringBuilder();
            raw.Append(BaseURL);
            raw.AppendFormat("Command={0}", CommandName);
            raw.AppendFormat("&uid={0}", HttpUtility.UrlEncode(Username));
            raw.AppendFormat("&pw={0}", HttpUtility.UrlEncode(Password));

            // If ResponseType is set, set it in the object
            if (String.IsNullOrEmpty(ResponseType))
            {
                if (Params.ContainsKey("responsetype"))
                {
                    ResponseType = Params["responsetype"];
                    RemoveParam("responsetype");
                }
                else
                {
                    ResponseType = "xml";
                }
            }

            if (!("xml text html").Contains(ResponseType))
            {
                throw new ApplicationException("Invalid ResponseType: '" + ResponseType + "'");
            }
            else
            {
                raw.AppendFormat("&responsetype={0}", ResponseType);
            }

            foreach (String key in Params.Keys)
            {
                raw.AppendFormat("&{0}={1}", key, HttpUtility.UrlEncode(Params[key]));
            }

            return raw.ToString();
        }


        /// <summary>
        /// Verifies that baseURL, Username and password are set
        /// </summary>
        private void VerifyParameters()
        {
            // If the baseURL isn't set...
            if (String.IsNullOrEmpty(BaseURL))
            {
                throw new ApplicationException("BaseURL was not specified");
            }

            // If the CommandName not set...
            if (String.IsNullOrEmpty(CommandName))
            {
                throw new ApplicationException("CommandName was not specified");
            }

            // If the username isn't set, try to get it from the params collection
            if (String.IsNullOrEmpty(Username))
            {
                if (Params.ContainsKey("uid"))
                {
                    Username = Params["uid"];
                    RemoveParam("uid");
                }
                else
                {
                    throw new ApplicationException("Username not specified in parameters or programatically");
                }
            }

            // If the password isn't set, try to get it from the params collection
            if (String.IsNullOrEmpty(Password))
            {
                if (Params.ContainsKey("pw"))
                {
                    Password = Params["pw"];
                    RemoveParam("pw");
                }
                else
                {
                    throw new ApplicationException("Password not specified in parameters or programatically");
                }
            }
        }

        /// <summary>
        /// Gets a Generic String List of all the API Errors based on the XML Response
        /// </summary>
        /// <returns>Collection of error strings</returns>
        private List<string> GetXMLErrors()
        {
            List<string> errors = new List<string>();

            foreach (XmlNode node in XmlResponse.SelectNodes("//interface-response/errors"))
            {
                if (node != null)
                {
                    foreach (XmlNode errorNode in node.ChildNodes)
                    {
                        if (!String.IsNullOrEmpty(errorNode.InnerText))
                        {
                            errors.Add(errorNode.InnerText);
                        }
                    }
                }
            }

            return errors;
        }

        /// <summary>
        /// Gets a count of all the API Errors based on the XML Response
        /// </summary>
        /// <returns>Total count of errors</returns>
        private int GetXMLErrorCount()
        {
            int errorCount = 0;
            XmlNode node = XmlResponse.SelectSingleNode("//interface-response/ErrCount");
            if (node != null)
            {
                if (int.TryParse(node.InnerText, out errorCount))
                {
                    return errorCount;
                }
            }

            return 0;
        }

        /// <summary>
        /// Gets a Generic String List of all the API Errors based on the Text Response
        /// </summary>
        /// <returns>Collection of error strings</returns>
        private List<string> GetTextErrors()
        {
            List<string> ret = new List<string>();
            Regex regex = new Regex(@"Err\d=.*");
            MatchCollection matches = regex.Matches(RawResponse);

            foreach (Match match in matches)
            {
                ret.Add(match.Value);
            }

            return ret;
        }

        /// <summary>
        /// Gets a count of all the API Errors based on the XML Response
        /// </summary>
        /// <returns>Total count of errors</returns>
        private int GetTextErrorCount()
        {
            Regex regex = new Regex(@"ErrCount=\d");
            Match match = regex.Match(RawResponse);

            if (match != null)
            {
                string count = match.Value.Substring(match.Value.IndexOf("=") + 1).Trim();
                int ret;
                if (int.TryParse(count, out ret))
                {
                    return ret;
                }
            }

            return 0;
        }

        /// <summary>
        /// Gets a Generic String List of all the API Errors based on the Text Response
        /// </summary>
        /// <returns>Collection of error strings</returns>
        private List<string> GetHtmlErrors()
        {
            List<string> ret = new List<string>();

            // TODO: Better regex
            Regex regex = new Regex(@"Err1: </STRONG>.*<BR /><STRONG>ResponseCount:");
            MatchCollection matches = regex.Matches(RawResponse);

            foreach (Match match in matches)
            {
                ret.Add(match.Value.Replace("</STRONG>", string.Empty).Replace("<BR /><STRONG>ResponseCount:", string.Empty));
            }

            return ret;
        }

        /// <summary>
        /// Gets a count of all the API Errors based on the HTML Response
        /// </summary>
        /// <returns>Total count of errors</returns>
        private int GetHtmlErrorCount()
        {
            Regex regex = new Regex(@"ErrCount: </STRONG>\d");
            Match match = regex.Match(RawResponse);

            if (match != null)
            {
                string count = match.Value.Substring(match.Value.IndexOf(">") + 1).Trim();
                int ret;
                if (int.TryParse(count, out ret))
                {
                    return ret;
                }
            }

            return 0;
        }

        /// <summary>
        /// Adds a collection of strings to Errors collection
        /// </summary>
        /// <param name="errors">Collection of error strings</param>
        private void AddErrors(List<string> errors)
        {
            if (Errors == null)
            {
                Errors = new ArrayList();
            }

            foreach (string error in errors)
            {
                Errors.Add(error);
            }
        }

        /// <summary>
        /// Checks to see if a node exists
        /// </summary>
        /// <param name="nodeName">Node to check</param>
        /// <returns>True if node exists, else false</returns>
        private bool DoesNodeExist(string nodeName)
        {
            XmlNode node = XmlResponse.SelectSingleNode(nodeName);

            return (node != null);
        }

        /// <summary>
        /// Gets the value of an XML Node
        /// </summary>
        /// <param name="node">Node to interrogate</param>
        /// <returns>Node's inner text or, if the node is null, String.Empty</returns>
        private string ParseResponse(XmlNode node)
        {
            if (node != null)
            {
                return node.InnerText.Trim();
            }
            else
            {
                return String.Empty;
            }
        }

        private void ConfigureTsl()
        {
            //if (this.BaseURL.ToLower().StartsWith("https"))
            //{
                ServicePointManager.SecurityProtocol = SecurityProtocolType.Tls12;
                ServicePointManager.ServerCertificateValidationCallback = delegate { return true; };
            //}
        }
        #endregion private methods
    }
}
