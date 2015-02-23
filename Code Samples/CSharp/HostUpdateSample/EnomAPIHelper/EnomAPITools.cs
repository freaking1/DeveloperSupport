
namespace Enom.API.EnomAPIHelper
{
    using System;
    using System.Collections;
    using System.Collections.Generic;
    using System.IO;
    using System.Xml;
    using System.Text;
    using System.Net;
    using System.Text.RegularExpressions;
    using System.Net.Security;
    using System.Web;
    using System.Security.Cryptography;
    using System.Security.Cryptography.X509Certificates;

    public class EnomAPITools
    {
        Dictionary<String, String> Params;
        public XmlDocument XmlResponse;
        public ArrayList Errors;
        protected Byte[] ResponseBytes;
        protected Byte[] SendBytes;
        public Int32 Timeout = 120000; // In milliseconds

        //Constructor
        public EnomAPITools()
        {
            Params = new Dictionary<String, String>();
            XmlResponse = new XmlDocument();
            Errors = new ArrayList();
            m_rawUrl = new StringBuilder();
            //m_rawUrl.AppendFormat("{0}", Global.ClassicInterfaceRoot);
        }

        /// <summary>
        /// Runs the specified command - make sure you set the CommandName param first!
        /// </summary>
        public void Execute()
        {
            Execute(m_CommandName);
        }

        private static String GetCallingLocation()
        {
            String machineName = Environment.MachineName;
            String location = machineName.Substring(0, 3);
            String boxNumber = String.Empty;
            String caller = machineName;

            try
            {
                Regex regex = new Regex("[\\d]+");
                MatchCollection matches = regex.Matches(machineName);

                if (matches.Count > 1)
                    boxNumber = matches[1].Value;
                else
                {
                    if (String.IsNullOrEmpty(matches[0].Value) || !IsNumeric(matches[0].Value))
                        boxNumber = "01";
                    else
                        boxNumber = matches[0].Value;
                }

                caller = String.Format("IRWEB-{0}-{1}", boxNumber, location);
                if (machineName.ToLower().Contains("pci"))
                    caller = String.Format("{0}-PCI", caller);
            }
            catch { }
            return caller.ToUpper();
        }
        private static Boolean ValidateRemoteCertificate(Object sender, X509Certificate certificate, X509Chain chain, SslPolicyErrors policyErrors)
        {
            return policyErrors == SslPolicyErrors.None;
        }


        /// <summary>
        /// Runs a specified command
        /// </summary>
        /// <param name="commandName"></param>
        public void Execute(String commandName)
        {
            Boolean bSite = false;
            Boolean bAccountID = false;
            m_CommandName = commandName;

            try
            {
                m_rawUrl.AppendFormat("Command={0}&", commandName);

                if (String.IsNullOrEmpty(m_username))
                    if (Params.ContainsKey("uid"))
                        m_username = Params["uid"];

                if (String.IsNullOrEmpty(m_password))
                    if (Params.ContainsKey("pw"))
                        m_password = Params["pw"];

                m_rawUrl.AppendFormat("uid={0}&", UrlEncode(m_username));
                m_rawUrl.AppendFormat("pw={0}&", UrlEncode(m_password));
                m_rawUrl.AppendFormat("responsetype={0}&", "xml");

                foreach (String key in Params.Keys)
                {
                    try
                    {
                        m_rawUrl.AppendFormat("{0}={1}&", key, UrlEncode(Params[key]));
                        if (key.Equals("site", StringComparison.CurrentCultureIgnoreCase))
                            bSite = true;
                        else if (key.Equals("AccountId", StringComparison.CurrentCultureIgnoreCase))
                            bAccountID = true;
                    }
                    catch { }
                }


                String data = m_rawUrl.ToString().Replace(Global.ClassicInterfaceRoot, "");
                SendBytes = Encoding.GetEncoding("iso-8859-1").GetBytes(data);

                var request = (HttpWebRequest)WebRequest.Create(Global.ClassicInterfaceRoot);
                request.Method = "POST";
                request.ContentType = "application/x-www-form-urlencoded";
                request.ContentLength = SendBytes.Length;
                request.Timeout = Timeout;

                //Places like Rcom API in STG throw a bad cert error, so we need to check this - when debug mode is on we dont care about certs.
                ServicePointManager.ServerCertificateValidationCallback += new RemoteCertificateValidationCallback(ValidateRemoteCertificate);
                using (Stream postdataStream = request.GetRequestStream())
                {
                    postdataStream.Write(SendBytes, 0, SendBytes.Length);
                }

                using (HttpWebResponse webResponse = (HttpWebResponse)request.GetResponse())
                {
                    using (var responseStream = new StreamReader(webResponse.GetResponseStream()))
                    {
                        m_rawResponse = responseStream.ReadToEnd();
                    }
                }

                if (!String.IsNullOrEmpty(m_rawResponse))
                {
                    XmlResponse = ConvertToXmlDoc(m_rawResponse);
                    if (XmlResponse != null)
                    {
                        m_errorCount = GetErrorCount(XmlResponse);
                        if (m_errorCount != 0)
                            AddErrors(GetErrors(XmlResponse));
                    }
                }
                else
                {
                    Errors.Add("An error occurred, please try again later");
                    m_errorCount++;
                }
            }
            catch (System.Threading.ThreadAbortException)
            { }
            catch (Exception ex)
            {
                Errors.Add(ex.Message);
            }
        }

        #region Get Node values as [Data Type]

        /// <summary>
        /// Get the value of a Node
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <returns></returns>
        public String GetNodeValue(String xmlNode)
        {
            return ParseResponse(XmlResponse.SelectSingleNode(xmlNode));
        }
        /// <summary>
        /// Get the value of a Node with a default value
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <param name="defaultValue"></param>
        /// <returns></returns>
        public String GetNodeValue(String xmlNode, String defaultValue)
        {
            if (XmlResponse.SelectSingleNode(xmlNode) == null)
                return defaultValue;
            else
                return ParseResponse(XmlResponse.SelectSingleNode(xmlNode));
        }

        /// <summary>
        /// Get the value of a Node
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <returns></returns>
        public Int16? GetNodeValueAsInt16(String xmlNode)
        {
            return GetNodeValueAsInt16(xmlNode, null);
        }
        /// <summary>
        /// Get the value of a Node with a default value
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <param name="defaultValue"></param>
        /// <returns></returns>
        public Int16? GetNodeValueAsInt16(String xmlNode, Int16? defaultValue)
        {
            if (XmlResponse.SelectSingleNode(xmlNode) == null)
                return defaultValue;
            else
            {
                Int16? result = defaultValue;
                String value = ParseResponse(XmlResponse.SelectSingleNode(xmlNode));

                if (!String.IsNullOrEmpty(value))
                {
                    Int16 tmp;
                    if (Int16.TryParse(value, out tmp))
                        result = (Int16?)tmp;
                }

                return result;
            }
        }

        /// <summary>
        /// Get the value of a Node
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <returns></returns>
        public Int32? GetNodeValueAsInt32(String xmlNode)
        {
            return GetNodeValueAsInt32(xmlNode, null);
        }
        /// <summary>
        /// Get the value of a Node with a default value
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <param name="defaultValue"></param>
        /// <returns></returns>
        public Int32? GetNodeValueAsInt32(String xmlNode, Int32? defaultValue)
        {
            if (XmlResponse.SelectSingleNode(xmlNode) == null)
                return defaultValue;
            else
            {
                Int32? result = defaultValue;
                String value = ParseResponse(XmlResponse.SelectSingleNode(xmlNode));

                if (!String.IsNullOrEmpty(value))
                {
                    Int32 tmp;
                    if (Int32.TryParse(value, out tmp))
                        result = (Int32?)tmp;
                }

                return result;
            }
        }

        /// <summary>
        /// Get the value of a Node
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <returns></returns>
        public Int64? GetNodeValueAsInt64(String xmlNode)
        {
            return GetNodeValueAsInt64(xmlNode, null);
        }
        /// <summary>
        /// Get the value of a Node with a default value
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <param name="defaultValue"></param>
        /// <returns></returns>
        public Int64? GetNodeValueAsInt64(String xmlNode, Int64? defaultValue)
        {
            if (XmlResponse.SelectSingleNode(xmlNode) == null)
                return defaultValue;
            else
            {
                Int64? result = defaultValue;
                String value = ParseResponse(XmlResponse.SelectSingleNode(xmlNode));

                if (!String.IsNullOrEmpty(value))
                {
                    Int64 tmp;
                    if (Int64.TryParse(value, out tmp))
                        result = (Int64?)tmp;
                }

                return result;
            }
        }

        /// <summary>
        /// Get the value of a Node
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <returns></returns>
        public Boolean? GetNodeValueAsBool(String xmlNode)
        {
            return GetNodeValueAsBool(xmlNode, null);
        }
        /// <summary>
        /// Get the value of a Node with a default value
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <param name="defaultValue"></param>
        /// <returns></returns>
        public Boolean? GetNodeValueAsBool(String xmlNode, Boolean? defaultValue)
        {
            if (XmlResponse.SelectSingleNode(xmlNode) == null)
                return defaultValue;
            else
            {
                Boolean? result = defaultValue;
                String value = ParseResponse(XmlResponse.SelectSingleNode(xmlNode));

                if (!String.IsNullOrEmpty(value.ToString()))
                {
                    Boolean tmp;
                    tmp = GlobalFunctions.ConvertToBoolean(value);
                    result = (Boolean?)tmp;
                }

                return result;
            }
        }

        /// <summary>
        /// Get the value of a Node
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <returns></returns>
        public Decimal? GetNodeValueAsDecimal(String xmlNode)
        {
            return GetNodeValueAsDecimal(xmlNode, null);
        }
        /// <summary>
        /// Get the value of a Node with a default value
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <param name="defaultValue"></param>
        /// <returns></returns>
        public Decimal? GetNodeValueAsDecimal(String xmlNode, Decimal? defaultValue)
        {
            if (XmlResponse.SelectSingleNode(xmlNode) == null)
                return defaultValue;
            else
            {
                Decimal? result = defaultValue;
                String value = ParseResponse(XmlResponse.SelectSingleNode(xmlNode));

                if (!String.IsNullOrEmpty(value))
                {
                    Decimal tmp;
                    if (Decimal.TryParse(value, out tmp))
                        result = (Decimal?)tmp;
                }

                return result;
            }
        }

        /// <summary>
        /// Get the value of a Node
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <returns></returns>
        public Double? GetNodeValueAsDouble(String xmlNode)
        {
            return GetNodeValueAsDouble(xmlNode, null);
        }
        /// <summary>
        /// Get the value of a Node with a default value
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <param name="defaultValue"></param>
        /// <returns></returns>
        public Double? GetNodeValueAsDouble(String xmlNode, Double? defaultValue)
        {
            if (XmlResponse.SelectSingleNode(xmlNode) == null)
                return defaultValue;
            else
            {
                Double? result = defaultValue;
                String value = ParseResponse(XmlResponse.SelectSingleNode(xmlNode));

                if (!String.IsNullOrEmpty(value))
                {
                    Double tmp;
                    if (Double.TryParse(value, out tmp))
                        result = (Double?)tmp;
                }

                return result;
            }
        }


        /// <summary>
        /// Get the value of a Node
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <returns></returns>
        public Guid? GetNodeValueAsGuid(String xmlNode, XmlDocument XmlResponse)
        {
            return GetNodeValueAsGuid(xmlNode, null, XmlResponse);
        }
        /// <summary>
        /// Get the value of a Node with a default value
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <param name="defaultValue"></param>
        /// <returns></returns>
        public Guid? GetNodeValueAsGuid(String xmlNode, Guid? defaultValue, XmlDocument XmlResponse)
        {
            if (XmlResponse.SelectSingleNode(xmlNode) == null)
                return defaultValue;
            else
            {
                Guid? result = defaultValue;
                String value = ParseResponse(XmlResponse.SelectSingleNode(xmlNode));

                if (!String.IsNullOrEmpty(value))
                {
                    try
                    {
                        Guid tmp;
                        tmp = new Guid(value);
                        result = (Guid?)tmp;
                    }
                    catch
                    {
                        result = null;
                    }
                }

                return result;
            }
        }
        /// <summary>
        /// Get the value of a Node with a default value
        /// </summary>
        /// <param name="node"></param>
        /// <returns></returns>
        public Guid? GetNodeValueAsGuid(XmlNode node)
        {
            return GetNodeValueAsGuid(node, null);
        }
        /// <summary>
        /// Get the value of a Node with a default value
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <param name="defaultValue"></param>
        /// <returns></returns>
        public Guid? GetNodeValueAsGuid(XmlNode node, Guid? defaultValue)
        {
            if (node == null)
                return defaultValue;
            else
            {
                Guid? result = defaultValue;
                String value = ParseResponse(node);

                if (!String.IsNullOrEmpty(value))
                {
                    try
                    {
                        Guid tmp;
                        tmp = new Guid(value);
                        result = (Guid?)tmp;
                    }
                    catch
                    {
                        result = null;
                    }
                }

                return result;
            }
        }


        #region DateTime

        /// <summary>
        /// Get the value of a Node
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <returns></returns>
        public DateTime? GetNodeValueAsDateTime(String xmlNode, XmlDocument XmlResponse)
        {
            return GetNodeValueAsDateTime(xmlNode, null, XmlResponse);
        }
        /// <summary>
        /// Get the value of a Node with a default value
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <param name="defaultValue"></param>
        /// <returns></returns>
        public DateTime? GetNodeValueAsDateTime(String xmlNode, DateTime? defaultValue, XmlDocument XmlResponse)
        {
            if (XmlResponse == null || XmlResponse.SelectSingleNode(xmlNode) == null)
                return defaultValue;
            else
            {
                DateTime? result = defaultValue;
                String value = ParseResponse(XmlResponse.SelectSingleNode(xmlNode));

                if (!String.IsNullOrEmpty(value))
                {
                    DateTime tmp;
                    if (DateTime.TryParse(value, out tmp))
                        result = (DateTime?)tmp;
                }

                return result;
            }
        }
        /// <summary>
        /// Get the value of a Node
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <returns></returns>
        public DateTime? GetNodeValueAsDateTime(XmlNode node)
        {
            return GetNodeValueAsDateTime(node, null);
        }
        /// <summary>
        /// Get the value of a Node with a default value
        /// </summary>
        /// <param name="xmlNode"></param>
        /// <param name="defaultValue"></param>
        /// <returns></returns>
        public DateTime? GetNodeValueAsDateTime(XmlNode node, DateTime? defaultValue)
        {
            if (node == null)
                return defaultValue;
            else
            {
                DateTime? result = defaultValue;
                String value = ParseResponse(node);

                if (!String.IsNullOrEmpty(value))
                {
                    DateTime tmp;
                    if (DateTime.TryParse(value, out tmp))
                        result = (DateTime?)tmp;
                }

                return result;
            }
        }

        #endregion


        #endregion


        #region Local and Public Variables

        private StringBuilder m_rawUrl;
        public String RawUrl
        {
            get { return m_rawUrl.ToString(); }
        }

        private String m_rawResponse;
        public String RawResponse
        {
            get { return m_rawResponse; }
            set { m_rawResponse = value; }
        }

        private String m_CommandName;
        public String CommandName
        {
            get { return m_CommandName; }
            set { m_CommandName = value; }
        }

        private Int32 m_errorCount;
        public Int32 ErrorCount
        {
            get { return m_errorCount; }
            set { m_errorCount = value; }
        }

        private Boolean? m_debugMode;
        public Boolean? DebugMode
        {
            get { return m_debugMode; }
            set { m_debugMode = value; }
        }

        private String m_username;
        public String Username
        {
            get { return m_username; }
            set { m_username = value; }
        }

        private String m_password;
        public String Password
        {
            get { return m_password; }
            set { m_password = value; }
        }

        #endregion


        #region Params
        public void AddParam(String name, String value)
        {
            if (Params == null)
                Params = new Dictionary<String, String>();

            name = name.ToLowerInvariant();

            if (Params.ContainsKey(name)) Params[name] = value;
            else Params.Add(name, value);
        }
        public void AddParam(String name, Int32 value)
        {
            AddParam(name, value.ToString());
        }
        public void AddParam(String name, Decimal value)
        {
            AddParam(name, value.ToString());
        }
        public void AddParam(String name, Boolean value)
        {
            AddParam(name, value.ToString());
        }

        public NameValue NewParam(String name, String value)
        {
            NameValue nv = new NameValue();
            nv.Name = name;
            nv.Value = value;
            return nv;
        }

        #endregion


        #region Private Helpers

        private void AddError(String err)
        {
            if (Errors == null)
                Errors = new ArrayList();

            Errors.Add(err);
        }
        private void AddErrors(List<String> errs)
        {
            if (Errors == null)
                Errors = new ArrayList();

            foreach (String err in errs)
                AddError(err);
        }

        /// <summary>
        /// Convert the String XML Response from the .Net API into an XML Document for parsing
        /// </summary>
        /// <param name="xmlResponse"></param>
        /// <returns></returns>
        private XmlDocument ConvertToXmlDoc(String xmlResponse)
        {
            XmlDocument doc = new XmlDocument();
            doc.LoadXml(xmlResponse);
            return doc;
        }

        /// <summary>
        /// Gets a Generic String List of all the API Errors based on the XML Response
        /// </summary>
        /// <param name="xmlResponse"></param>
        /// <returns></returns>
        private List<String> GetErrors(XmlDocument xmlResponse)
        {
            List<String> errors = new List<String>();

            foreach (XmlNode node in xmlResponse.SelectNodes("//interface-response/errors"))
            {
                if ((Object)node != null)
                {
                    foreach (XmlNode errorNode in node.ChildNodes)
                    {
                        if (!String.IsNullOrEmpty(errorNode.InnerText))
                            errors.Add(errorNode.InnerText);
                    }
                }
            }

            return errors;
        }

        /// <summary>
        /// Gets a count of all the API Errors based on the XML Response
        /// </summary>
        /// <param name="xmlResponse"></param>
        /// <returns></returns>
        private Int16 GetErrorCount(XmlDocument xmlResponse)
        {
            Int16 m_errorCount = 0;
            XmlNode node = xmlResponse.SelectSingleNode("//interface-response/ErrCount");
            if ((Object)node != null)
            {
                if (!GlobalFunctions.IsNullorEmptyNumeric(node.InnerText))
                    Int16.TryParse(node.InnerText, out m_errorCount);
            }

            return m_errorCount;

        }

        /// <summary>
        /// Checks to see if a node exists
        /// </summary>
        /// <param name="xmlResponse"></param>
        /// <param name="nodeName"></param>
        /// <returns>True/False</returns>
        private Boolean DoesNodeExist(XmlDocument xmlResponse, String nodeName)
        {
            XmlNode node = xmlResponse.SelectSingleNode(nodeName);
            if ((Object)node != null)
                return true;
            else
                return false;
        }

        /// <summary>
        /// Checks to see if there was any errors from GetErrorCount, and if not then checks for the existance of a Success node in the XML Output and if that exists then returns the true/false.  Defaults to TRUE if the success node doesnt exist.
        /// </summary>
        /// <param name="xmlResponse"></param>
        /// <returns></returns>
        private Boolean WasRequestSuccesfull(XmlDocument xmlResponse)
        {
            Int32 m_errorCount = GetErrorCount(xmlResponse);
            String successNode = String.Empty;

            if (m_errorCount == 0)
            {
                if (DoesNodeExist(xmlResponse, "//interface-response/success"))
                    successNode = "//interface-response/success";
                else if (DoesNodeExist(xmlResponse, "//interface-response/successfull"))
                    successNode = "//interface-response/successfull";

                if (!String.IsNullOrEmpty(successNode))
                {
                    if (0 == String.Compare(xmlResponse.SelectSingleNode(successNode).InnerText, "true", true))
                        return true;
                    else
                        return false;
                }
                else
                {
                    //default to return true since there are no errors, and there is a posibility
                    //that not all commands may have these nodes as a success indicator
                    return true;
                }
            }
            else
            {
                //There was an error since reror count is not zero 
                return false;
            }
        }

        /// <summary>
        /// Gets the value of an XML Node
        /// </summary>
        /// <param name="node"></param>
        /// <returns></returns>
        private String ParseResponse(XmlNode node)
        {
            if ((Object)node != null)
            {
                return node.InnerText.Trim();
            }

            return String.Empty;
        }

        /// <summary>
        /// 
        /// Validates a String is numeric
        /// <param name="str"></param>
        /// <returns></returns>
        public static Boolean IsNumeric(String str)
        {
            double result;
            return double.TryParse(str, out result);
        }

        /// <summary>
        /// URL Encodes a value
        /// </summary>
        /// <param name="Value"></param>
        /// <returns></returns>
        public static String UrlEncode(String Value)
        {
            return HttpUtility.UrlEncode(Value);
        }


        /// <summary>
        /// URL Decodes a value
        /// </summary>
        /// <param name="Value"></param>
        /// <returns></returns>
        public static String UrlDecode(String Value)
        {
            return HttpUtility.UrlDecode(Value);
        }
        #endregion

    }

}