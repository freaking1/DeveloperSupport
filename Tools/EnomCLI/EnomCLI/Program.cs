// <copyright file="program.cs" company="Rightside"> //
// Copyright (c) 2015 All Rights Reserved            // 
// </copyright>                                      //
// <author>Sean Ottey</author>                       //

namespace Enom.Tools.EnomCLI
{
    using System;
    using System.Linq;
    using System.Text;
    using System.Xml;
    using System.Xml.Linq;

    class Program
    {
        static void Main(string[] args)
        {

            string username = string.Empty;
            string password = string.Empty;            
            string baseURL = string.Empty;

            // Three Arguments are required: username, password and base url
            if (args.Count() != 3)
            {
                Console.Write("Usage: EnomCLI [username] [password] [baseurl]");
                return;
            }

            username = args[0];
            password = args[1];
            baseURL = args[2];            

            string input = string.Empty;

            while (true)
            {
                Console.Write("enom>");
                input = Console.ReadLine().ToLower();

                // If the user types exit, close the command line
                if (input == "exit")
                {
                    return;
                }

                // If we have a valid command line, process
                if (!string.IsNullOrWhiteSpace(input))
                {
                    try
                    {
                        // Build the URL
                        string url = BuildURL(input, username, password, baseURL);

                        // Load the result
                        string response = GetResponse(url);

                        // Display result to the screen
                        Console.WriteLine(PrettyXml(response + Environment.NewLine));   
                    }
                    catch(System.ApplicationException ae)
                    {
                        Console.WriteLine(ae.Message);
                    }
                    catch(System.Exception ex)
                    {
                        Console.WriteLine("Error: " + ex.Message);
                    }
                    
                }
            }
        }

        /// <summary>
        /// Executes the query and returns the XML string
        /// </summary>
        /// <param name="url">Complete URL string for the API call</param>
        /// <returns>String representation of the XML response</returns>
        private static string GetResponse(string url)
        {
            // Load the API results into an XmlDocument object
            var xmlDoc = new XmlDocument();
            xmlDoc.Load(url);
            return xmlDoc.InnerXml;
        }

        /// <summary>
        /// Builds the entire API Query string
        /// </summary>
        /// <param name="input">The entered command line (e.g. check sld=example tld=com</param>
        /// <param name="username">reseller username</param>
        /// <param name="password">reseller password</param>
        /// <param name="baseURL">Base URL for query (e.g. https://resellertest.enom.com/interface.asp?command=)</param>
        /// <returns>Complete API Query string</returns>
        private static string BuildURL(string input, string username, string password, string baseURL)
        {
            string[] commandLine = input.Split(' ');

            // The first item is always the command
            string command = commandLine[0];

            // If the command is not known, throw exception
            if (!commands.Contains(command))
            {
                throw new ApplicationException("Invalid Command: '" + command + "'");
            }

            string errors = string.Empty;

            // Build the initial Query string
            string finalURL = baseURL + command + "&uid=" + username + "&pw=" + password + "&responseType=xml";

            for ( int i = 1; i < commandLine.Length; i++)
            {  
                // If there is no '=' sign, this argument is invalid
                if (!commandLine[i].Contains('='))
                {
                    errors += "Invalid argument: " + commandLine[i] + Environment.NewLine;                        
                }
                // If responseType is specified, let the user know we only do XML
                else if (commandLine[i].Contains("responsetype"))
                {
                    Console.WriteLine("ResponseType is always XML. Changing specified type");
                }
                else
                {
                    // Add the argument
                    finalURL += "&" + commandLine[i];
                }
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

        /// <summary>
        /// Utility class to "Prettify" the xml
        /// </summary>
        /// <param name="xml">String containing the XML</param>
        /// <returns>Prettified XML</returns>
        static string PrettyXml(string xml)
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

        #region Commands List
        public static string[] commands = 
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
        #endregion commands
    }
}
