
namespace Enom.API.Utilities
{
    using System;
    using System.Collections.Generic;
    using System.Collections.Specialized;
    using System.Linq;
    using System.Web;
    using System.Configuration;
    using System.Collections;
    using System.Data;
    using System.Xml;
    using System.IO;

    /// <summary>
    /// Summary description for EnomUtilities
    /// </summary>
    public class EnomUtilities
    {


        #region Properties

        //public static String DomainName
        //{
        //    get
        //    {
        //        String sld, tld;
        //        GlobalFunctions.SplitDomain(HttpContext.Current.Request.Url.Host, out sld, out tld);

        //        if (String.IsNullOrEmpty(sld) || String.IsNullOrEmpty(tld))
        //            return HttpContext.Current.Request.Url.Host;

        //        return String.Format("{0}.{1}", sld, tld);
        //    }
        //}
        public static String ServerName
        {
            get { return Environment.MachineName; }
        }

        #region Passwords/Api

        private static String m_PasswordHash;
        public static String PasswordHash
        {
            get { return m_PasswordHash; }
        }

        private static String m_SiteID;
        public static String SiteID
        {
            get { return m_SiteID; }
        }

        //This is to ensure we dont have to change all the API calls
        private static String m_EnomMainUser;
        public static String EnomMainUser
        {
            get { return m_EnomMainUser; }
        }

        //This is to ensure we dont have to change all the API calls
        private static String m_EnomMainPass;
        public static String EnomMainPass
        {
            get { return m_EnomMainPass; }
        }

        //Can still access the Rcom user stuff independantly
        private static String m_RcomMainUser;
        public static String RcomMainUser
        {
            get { return m_RcomMainUser; }
        }

        //Can still access the Rcom user stuff independantly
        private static String m_RcomMainPass;
        public static String RcomMainPass
        {
            get { return m_RcomMainPass; }
        }

        private static String m_ClassicInterfaceRoot;
        public static String ClassicInterfaceRoot
        {
            get { return m_ClassicInterfaceRoot; }
        }

        private static String m_RcomClassicInterfaceRoot;
        public static String RcomClassicInterfaceRoot
        {
            get { return m_RcomClassicInterfaceRoot; }
        }


        #endregion

        #region Email

        private static String m_ErrorEmailSendTo;
        public static String ErrorEmailSendTo
        {
            get { return m_ErrorEmailSendTo; }
        }

        private static Boolean m_SendErrorEmails;
        public static Boolean SendErrorEmails
        {
            get { return m_SendErrorEmails; }
        }

        private static String m_SMTPHost;
        public static String SMTPHost
        {
            get { return m_SMTPHost; }
        }

        private static String m_ErrorEmailSubject;
        public static String ErrorEmailSubject
        {
            get { return m_ErrorEmailSubject; }
        }

        #endregion

        #region Contact Data

        private static String m_EnomPhone;
        public static String EnomPhone
        {
            get { return m_EnomPhone; }
        }

        private static String m_RcomPhone;
        public static String RcomPhone
        {
            get { return m_RcomPhone; }
        }

        private static String m_EnomEmail;
        public static String EnomEmail
        {
            get { return m_EnomEmail; }
        }

        private static String m_RcomEmail;
        public static String RcomEmail
        {
            get { return m_RcomEmail; }
        }

        #endregion

        #region Site Settings

        private static String m_SharedSSLDomain;
        public static String SharedSSLDomain
        {
            get { return m_SharedSSLDomain; }
        }

        private static String m_EncryptedStringKey;
        public static String EncryptedStringKey
        {
            get { return m_EncryptedStringKey; }
        }

        private static Boolean m_UseSSL;
        public static Boolean UseSSL
        {
            get { return m_UseSSL; }
        }

        private static Boolean m_DebugMode;
        public static Boolean DebugMode
        {
            get { return m_DebugMode; }
        }

        private static DateTime? m_LastTime;

        //private static List<IRAccountWithDomainAndContactData> m_IRAccounts;
        //public static List<IRAccountWithDomainAndContactData> IRAccounts
        //{
        //    get { return m_IRAccounts; }
        //}

        #endregion


        #endregion


        #region Constructors

        public EnomUtilities() { }

        //static EnomUtilities()
        //{
        //    if (m_IRAccounts == null)
        //        m_IRAccounts = new List<IRAccountWithDomainAndContactData>();
        //}

        #endregion



        #region Application Settings

        void Application_BeginRequest(Object sender, EventArgs e)
        {
            //Dont process AXD resource requests, and anything that isnt the main default.aspx page
            String localPath = HttpContext.Current.Request.Url.LocalPath;
            if (localPath.EndsWith(".axd", StringComparison.CurrentCultureIgnoreCase))
                return;

            if (localPath.EndsWith(".aspx", StringComparison.CurrentCultureIgnoreCase) && !localPath.Equals("/default.aspx", StringComparison.CurrentCultureIgnoreCase))
                HttpContext.Current.RewritePath("/default.aspx");

            if (m_LastTime == null || m_IRAccounts.Count == 0)
            {
                //WE dont know how old it is, or we dont have any accounts, try again.
                ReLoadSitesFromAPI();

                //^^ this could get dangerous becuase every request may call the API - if the API is having issuses this will get called on every web request.
            }
            else
            {
                if (GlobalFunctions.DateDiff(m_LastTime.Value, DateTime.Now, DateTimePeriod.MINUTES) > 30)
                {
                    //What we do have is older than 30 minutes, so lets refresh
                    ReLoadSitesFromAPI();
                }
            }
        }

        public void ReLoadSitesFromAPI()
        {
            lock (this)
            {
                lock (m_IRAccounts)
                {
                    ArrayList errors;
                    m_LastTime = null;
                    Boolean success = ApiCommands.RS_GetAccountsWithDomain(out m_IRAccounts, out errors);
                    if (success)
                        m_LastTime = DateTime.Now;
                }
            }
        }

        void Application_Start(object sender, EventArgs e)
        {
            // Code that runs on application startup
            NameValueCollection nvc = null;

            lock (this)
            {
                if (null == (nvc = ConfigurationManager.AppSettings))
                    return;

                m_EncryptedStringKey = nvc["EncryptedStringKey"];
                m_SiteID = nvc["SiteID"];
                m_PasswordHash = nvc["PasswordHash"];
                m_DebugMode = GlobalFunctions.ConvertToBoolean(nvc["DebugMode"]);
                m_SharedSSLDomain = nvc["SharedSSLDomain"];

                m_EnomMainUser = GlobalFunctions.Decrypt(nvc["ENOMMAINUSER"]);
                m_EnomMainPass = GlobalFunctions.Decrypt(nvc["ENOMMAINPASS"]);
                m_ClassicInterfaceRoot = nvc["INTERFACEROOT"];

                m_EnomEmail = nvc["ENOMEMAIL"];
                m_EnomPhone = nvc["ENOMPHONE"];

                m_RcomMainUser = GlobalFunctions.Decrypt(nvc["RCOMMAINUSER"]);
                m_RcomMainPass = GlobalFunctions.Decrypt(nvc["RCOMMAINPASS"]);
                m_RcomClassicInterfaceRoot = nvc["RCOMINTERFACEROOT"];

                m_RcomEmail = nvc["RCOMEMAIL"];
                m_RcomPhone = nvc["RCOMPHONE"];

                m_SendErrorEmails = GlobalFunctions.ConvertToBoolean(nvc["SendErrorEmails"]);
                m_SMTPHost = nvc["EmailServer"];
                m_ErrorEmailSubject = nvc["ErrorEmailSubject"];
                m_ErrorEmailSendTo = nvc["ErrorEmailAddress"];

                ReLoadSitesFromAPI();
            }
        }

        void Application_End(object sender, EventArgs e)
        {
            //  Code that runs on application shutdown

        }

        void Application_Error(object sender, EventArgs ev)
        {
            // Code that runs when an unhandled error occurs
            HttpContext context = HttpContext.Current;
            Boolean sendMail = true;

            if (Server != null)
            {
                Exception ex = Server.GetLastError();
                Exception e = null;

                if (ex.InnerException != null)
                    e = ex.InnerException;

                //Dont send an error email on a 404 page - redirect instead
                if (ex is HttpException || (e != null && e is HttpException))
                {
                    if (((HttpException)ex).GetHttpCode() == 404)
                    {
                        context.Response.StatusCode = 404;
                        context.Response.Status = "404 Not Found";
                        context.Response.Redirect("/default.aspx", true);

                        //unless your in debug mode, we dont care about 404 error emails
                        if (!m_DebugMode)
                            return;
                    }
                }
                else if (ex is ViewStateException || (e != null && e is ViewStateException))
                {
                    //dont care about viewstate errors
                    sendMail = false;
                }
                else if (ex is HttpRequestValidationException || (e != null && e is HttpRequestValidationException))
                {
                    //dont care these errors
                    sendMail = false;
                }
                else if (ex.Message.Equals("Request timed out.", StringComparison.CurrentCultureIgnoreCase) || (e != null && e.Message.Equals("Request timed out.", StringComparison.CurrentCultureIgnoreCase)))
                {
                    //dont care these errors
                    sendMail = false;
                }
                else if (ex.Message.Equals("The client disconnected.", StringComparison.CurrentCultureIgnoreCase) || (e != null && e.Message.Equals("The client disconnected.", StringComparison.CurrentCultureIgnoreCase)))
                {
                    //dont care these errors
                    sendMail = false;
                }
                else if (ex.Message.Contains("viewstate") || (e != null && e.Message.Contains("viewstate")))
                {
                    //dont care these errors
                    sendMail = false;
                }

                //see if its a script resource error, if so ignore it
                if (context.Request.Url.ToString().EndsWith(".axd", StringComparison.CurrentCultureIgnoreCase))
                    sendMail = false;

                // dont send email caused by google bots
                if (context.Request.ServerVariables["HTTP_USER_AGENT"].ToLower().IndexOf("google") > -1 || context.Request.ServerVariables["HTTP_USER_AGENT"].ToLower().IndexOf("bot") > -1)
                    sendMail = false;

                //send error email
                if (m_SendErrorEmails && sendMail)
                    Diagnostics.SendErrorEmail(ex, context.Request.Path);

                if (m_DebugMode)
                {
                    //if debug mode is enabled, display the exception on the page
                    //instead of doing a general error page redirection
                }
                else
                {
                    //Do not display the error, redirect to a general error page
                    context.Server.ClearError();

                    //try
                    //{
                    //    String refer = GlobalFunctions.GetHttpReferer();
                    //    //try and prevent never ending loops - ie there is a compile error on the general error page
                    //    if (!refer.Equals("/system-errors/general-error.aspx", StringComparison.CurrentCultureIgnoreCase))
                    //        context.Response.Redirect("/system-errors/general-error.aspx", true);
                    //}
                    //catch
                    //{
                    //    context.Response.Redirect("/system-errors/general-error.aspx", true);
                    //}
                }
            }
        }

        #endregion


        #region Session Settings

        void Session_Start(object sender, EventArgs e) { }
        void Session_End(object sender, EventArgs e) { }

        #endregion

    }
}