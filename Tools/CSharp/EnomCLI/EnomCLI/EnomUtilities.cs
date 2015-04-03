// <copyright file="EnomUtilities.cs" company="Rightside"> //
// Copyright (c) 2015 All Rights Reserved            // 
// </copyright>                                      //
// <author>Sean Ottey</author>                       //

namespace Enom.Tools.EnomCLI
{
    using System;
    using System.Collections.Generic;
    using System.Linq;
    using System.Text;
    using System.Xml;
    using System.Net;
    using System.IO;
    using System.Xml.Linq;
    using System.Threading.Tasks;

    public static class EnomUtilities
    {
        /// <summary>
        /// Utility class to "Prettify" the xml
        /// </summary>
        /// <param name="xml">String containing the XML</param>
        /// <returns>Prettified XML</returns>
        public static string PrettyXml(string xml)
        {
            var stringBuilder = new StringBuilder();

            var element = XElement.Parse(xml);

            var settings = new XmlWriterSettings();
            settings.OmitXmlDeclaration = true;
            settings.Indent = true;

            using (var xmlWriter = XmlWriter.Create(stringBuilder, settings))
            {
                element.Save(xmlWriter);
            }

            return stringBuilder.ToString();
        }

        /// <summary>
        /// Executes the query and returns the XML string
        /// </summary>
        /// <param name="url">Complete URL string for the API call</param>
        /// <returns>String representation of the XML response</returns>
        public static string GetResponse(string url)
        {
            string ret = String.Empty;
            HttpWebRequest request = HttpWebRequest.CreateHttp(url);
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

        /// <summary>
        /// 
        /// </summary>
        /// <param name="paramName"></param>
        /// <returns></returns>
        public static string GetParamFromURL(string paramName)
        {
            string ret = string.Empty;

            paramName = paramName.ToLower();

            string[] parameters = paramName.Split('&');

            for (int i = 0; i < parameters.Length; i++)
            {
                if (parameters[i].ToLower().StartsWith("&" + paramName))
                {
                    string[] items = parameters[i].Split('=');
                    return items[1];
                }
            }

            return ret;
        }

        /// <summary>
        /// Builds the entire API Query string
        /// </summary>
        /// <param name="input">The entered command line (e.g. check sld=example tld=com</param>
        /// <param name="username">reseller username</param>
        /// <param name="password">reseller password</param>
        /// <param name="baseURL">Base URL for query (e.g. https://resellertest.enom.com/interface.asp?command=)</param>
        /// <returns>Complete API Query string</returns>
        public static string BuildURL(string input, string username, string password, string baseURL, string responseType)
        {
            string[] commandLine = input.Split(' ');

            // The first item is always the command
            string command = commandLine[0];

            string errors = string.Empty;

            // Build the initial Query string
            string finalURL = baseURL + command + "&uid=" + username + "&pw=" + password;

            for (int i = 1; i < commandLine.Length; i++)
            {
                // If there is no '=' sign, this argument is invalid
                if (!commandLine[i].Contains('='))
                {
                    errors += "Invalid argument: " + commandLine[i] + Environment.NewLine;
                }
                else
                {
                    // Add the argument
                    finalURL += "&" + commandLine[i];
                }
            }

            if (!finalURL.ToLower().Contains("responsetype="))
            {
                finalURL += "&responseType=" + responseType;
            }

            // If we have errors, bubble these up with an exception
            if (!string.IsNullOrEmpty(errors))
            {
                throw new ApplicationException(errors);
            }
            // Return the completed URL
            else
            {
                return finalURL;
            }
        }

        public static string GetValueFromUser(string title)
        {
            Console.Write("\nPlease enter the " + title + ": ");
            string response = Console.ReadLine();

            if (string.IsNullOrEmpty(response))
            {
                throw new Exception("No " + title + " provided. Exiting.");
            }
            else
            {
                return response;
            }
        }

        public static string[] GetInternalCommandList()
        {
            return new string[]
            {
	            "addcontact",
	            "adddomainfolder",
	            "adddomainheader",
	            "addhostheader",
	            "addtocart",
	            "advanceddomainsearch",
	            "am_autorenew",
	            "am_configure",
	            "am_getaccountdetail",
	            "am_getaccounts",
	            "assigntodomainfolder",
	            "authorizetld",
	            "calculateallhostpackagepricing",
	            "calculatehostpackagepricing",
	            "cancelhostaccount",
	            "cancelorder",
	            "certchangeapproveremail",
	            "certconfigurecert",
	            "certgetapproveremail",
	            "certgetcertdetail",
	            "certgetcerts",
	            "certmodifyorder",
	            "certparsecsr",
	            "certreissuecert",
	            "certpurchasecert",
	            "certresendapproveremail",
	            "certresendfulfillmentemail",
	            "check",
	            "checklogin",
	            "checknsstatus",
	            "commissionaccount",
	            "contacts",
	            "createaccount",
	            "createhostaccount",
	            "createsubaccount",
	            "deleteallpoppaks",
	            "deletecontact",
	            "deletecustomerdefineddata",
	            "deletedomainfolder",
	            "deletedomainheader",
	            "deletefromcart",
	            "deletehosteddomain",
	            "deletehostheader",
	            "deletenameserver",
	            "deletepop3",
	            "deletepoppak",
	            "deleteregistration",
	            "deletesubaccount",
	            "disablefolderapp",
	            "disableservices",
	            "enablefolderapp",
	            "enableservices",
	            "extend",
	            "extend_rgp",
	            "extenddomaindns",
	            "forwarding",
	            "getaccountinfo",
	            "getaccountpassword",
	            "getaccountvalidation",
	            "getaddressbook",
	            "getagreementpage",
	            "getallaccountinfo",
	            "getalldomains",
	            "getallhostaccounts",
	            "getallresellerhostpricing",
	            "getbalance",
	            "getcartcontent",
	            "getcatchall",
	            "getcerts",
	            "getconfirmationsettings",
	            "getcontacts",
	            "getcuspreferences",
	            "getcustomerdefineddata",
	            "getcustomerpaymentinfo",
	            "getdns",
	            "getdnsstatus",
	            "getdomaincount",
	            "getdomainexp",
	            "getdomainfolderdetail",
	            "getdomainfolderlist",
	            "getdomainheader",
	            "getdomaininfo",
	            "getdomainnameid",
	            "getdomains",
	            "getdomainservices",
	            "getdomainsldtld",
	            "getdomainsrvhosts",
	            "getdomainstatus",
	            "getdomainsubservices",
	            "getdotnameforwarding",
	            "getexpireddomains",
	            "getextattributes",
	            "getextendinfo",
	            "getfilepermissions",
	            "getforwarding",
	            "getglobalchangestatus",
	            "getglobalchangestatusdetail",
	            "gethomedomainlist",
	            "gethostaccount",
	            "gethostaccounts",
	            "gethostheader",
	            "gethosts",
	            "getidncodes",
	            "getipresolver",
	            "getmailhosts",
	            "getmetatag",
	            "getnamesuggestions",
	            "getnews",
	            "getorderdetail",
	            "getorderlist",
	            "getpasswordbit",
	            "getpop3",
	            "getpopexpirations",
	            "getpopforwarding",
	            "getproductnews",
	            "getproductselectionlist",
	            "getreghosts",
	            "getregistrationstatus",
	            "getreglock",
	            "getrenew",
	            "getreport",
	            "getresellerhostpricing",
	            "getresellerinfo",
	            "getservicecontact",
	            "getspfhosts",
	            "getstorageusage",
	            "getsubaccountdetails",
	            "getsubaccountpassword",
	            "getsubaccounts",
	            "getsubaccountsdetaillist",
	            "gettlddetails",
	            "gettldlist",
	            "gettranshistory",
	            "getwebhostingall",
	            "getwhoiscontact",
	            "getwppsinfo",
	            "gm_cancelsubscription",
	            "gm_checkdomain",
	            "gm_getcancelreasons",
	            "gm_getcontrolpanelloginurl",
	            "gm_getredirectscript",
	            "gm_getstatuses",
	            "gm_getsubscriptiondetails",
	            "gm_getsubscriptions",
	            "gm_reactivatesubscription",
	            "gm_renewsubscription",
	            "gm_updatebillingcycle",
	            "gm_updatesubscriptiondetails",
	            "hostpackagedefine",
	            "hostpackagedelete",
	            "hostpackagemodify",
	            "hostpackageview",
	            "hostparkingpage",
	            "insertneworder",
	            "isfolderenabled",
	            "listdomainheaders",
	            "listhostheaders",
	            "listwebfiles",
	            "metabasegetvalue",
	            "metabasesetvalue",
	            "modifydomainheader",
	            "modifyhostheader",
	            "modifyns",
	            "modifynshosting",
	            "modifypop3",
	            "mysql_getdbinfo",
	            "namespinner",
	            "nm_cancelorder",
	            "nm_extendorder",
	            "nm_getpremiumdomainsettings",
	            "nm_getsearchcategories",
	            "nm_processorder",
	            "nm_search",
	            "nm_setpremiumdomainsettings",
	            "parsedomain",
	            "pe_getcustomerpricing",
	            "pe_getdomainpricing",
	            "pe_geteappricing",
	            "pe_getpopprice",
	            "pe_getpremiumpricing",
	            "pe_getproductprice",
	            "pe_getresellerprice",
	            "pe_getretailprice",
	            "pe_getretailpricing",
	            "pe_getrocketprice",
	            "pe_gettldid",
	            "pe_setpricing",
	            "pp_cancelsubscription",
	            "pp_checkupgrade",
	            "pp_getcancelreasons",
	            "pp_getcontrolpanelloginurl",
	            "pp_getstatuses",
	            "pp_getsubscriptiondetails",
	            "pp_getsubscriptions",
	            "pp_reactivatesubscription",
	            "pp_updatesubscriptiondetails",
	            "pp_validatepassword",
	            "portal_getdomaininfo",
	            "portal_getawardeddomains",
	            "portal_gettoken",
	            "portal_updateawardeddomains",
	            "preconfigure",
	            "purchase",
	            "purchasehosting",
	            "purchasepopbundle",
	            "purchasepreview",
	            "purchaseservices",
	            "pushdomain",
	            "queue_getinfo",
	            "queue_getextattributes",
	            "queue_domainpurchase",
	            "queue_getdomains",
	            "queue_getorders",
	            "queue_getorderdetail",
	            "raa_getinfo",
	            "raa_resendnotification",
	            "rc_cancelsubscription",
	            "rc_freetrialcheck",
	            "rc_getlogintoken",
	            "rc_getsubscriptiondetails",
	            "rc_getsubscriptions",
	            "rc_rebillsubscription",
	            "rc_resetpassword",
	            "rc_setbillingcycle",
	            "rc_setpassword",
	            "rc_setsubscriptiondomain",
	            "rc_setsubscriptionname",
	            "refillaccount",
	            "registernameserver",
	            "removetld",
	            "removeunsynceddomains",
	            "renewpopbundle",
	            "renewservices",
	            "rpt_getreport",
	            "sendaccountemail",
	            "serviceselect",
	            "setcatchall",
	            "setcustomerdefineddata",
	            "setdnshost",
	            "setdomainsrvhosts",
	            "setdomainsubservices",
	            "setdotnameforwarding",
	            "setfilepermissions",
	            "sethosts",
	            "setipresolver",
	            "setpakrenew",
	            "setpassword",
	            "setpopforwarding",
	            "setreglock",
	            "setrenew",
	            "setresellerservicespricing",
	            "setresellertldpricing",
	            "setspfhosts",
	            "setuppop3user",
	            "sl_autorenew",
	            "sl_configure",
	            "sl_getaccountdetail",
	            "sl_getaccounts",
	            "statusdomain",
	            "subaccountdomains",
	            "synchauthinfo",
	            "tel_addcthuser",
	            "tel_getcthuserinfo",
	            "tel_getcthuserlist",
	            "tel_getprivacy",
	            "tel_iscthuser",
	            "tel_updatecthuser",
	            "tel_updateprivacy",
	            "tld_addwatchlist",
	            "tld_deletewatchlist",
	            "tld_gettld",
	            "tld_getwatchlist",
	            "tld_getwatchlisttlds",
	            "tld_overview",
	            "tld_portalgetaccountinfo",
	            "tld_portalupdateaccountinfo",
	            "tm_check",
	            "tm_getnotice",
	            "tm_updatecart",
	            "tp_cancelorder",
	            "tp_createorder",
	            "tp_getdetailsbydomain",
	            "tp_getorder",
	            "tp_getorderdetail",
	            "tp_getorderreview",
	            "tp_getordersbydomain",
	            "tp_getorderstatuses",
	            "tp_gettldinfo",
	            "tp_resendemail",
	            "tp_resubmitlocked",
	            "tp_submitorder",
	            "tp_updateorderdetail",
	            "ts_autorenew",
	            "ts_configure",
	            "ts_getaccountdetail",
	            "ts_getaccounts",
	            "updateaccountinfo",
	            "updateaccountpricing",
	            "updatecart",
	            "updatecuspreferences",
	            "updatedomainfolder",
	            "updateexpireddomains",
	            "updatehostpackagepricing",
	            "updatemetatag",
	            "updatenameserver",
	            "updatenotificationamount",
	            "updatepushlist",
	            "updaterenewalsettings",
	            "validatepassword",
	            "wblconfigure",
	            "wblgetcategories",
	            "wblgetfields",
	            "wblgetstatus",
	            "webhostcreatedirectory",
	            "webhostcreatepopbox",
	            "webhostdeletepopbox",
	            "webhostgetcartitem",
	            "webhostgetoverageoptions",
	            "webhostgetoverages",
	            "webhostgetpackagecomponentlist",
	            "webhostgetpackageminimums",
	            "webhostgetpackages",
	            "webhostgetpopboxes",
	            "webhostgetresellerpackages",
	            "webhostgetstats",
	            "webhosthelpinfo",
	            "webhostsetcustompackage",
	            "webhostsetoverageoptions",
	            "webhostupdatepassword",
	            "webhostupdatepoppassword",
	            "wsb_cancelaccount",
	            "wsb_createaccount",
	            "wsb_getcurrencies",
	            "wsb_getdetails",
	            "wsb_getlanguages",
	            "wsb_getlogintoken",
	            "wsb_getoverview",
	            "wsb_reactivateaccount",
	            "wsb_updateaccount",
	            "wsc_getaccountinfo",
	            "wsc_getallpackages",
	            "wsc_getpricing",
	            "wsc_update_ops",
	            "xxx_getmemberid",
	            "xxx_removememberid",
	            "xxx_setmemberid"
            };
        }
    }
}
