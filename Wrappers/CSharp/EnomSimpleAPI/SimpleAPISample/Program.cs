// <copyright file="Program.cs" company="Rightside">
// Copyright (c) 2015 All Rights Reserved
// </copyright>
// <author>Sean Ottey</author>
// <email>sean.ottey@rightside.rocks</email>

namespace Enom.Tools.API.SimpleAPISample
{
    using System;
    using Enom.Tools.API.EnomSimpleAPI;    

    /// <summary>
    /// Sample console application which uses the
    /// EnomSimpleAPI wrapper to check if a 
    /// domain is available
    /// </summary>
    class Program
    {
        static void Main(string[] args)
        {
            // Create a new instance with the default constructor
            EnomAPI api = new EnomAPI();

            // Populating Constructor can alternatively be used
            // EnomAPI enomApi = new EnomAPI("https://resellertest.enom.com/interface.asp?", "resellid", "resellpw", "check");

            // Set the base of the URL to call
            api.BaseURL = "https://resellertest.enom.com/interface.asp?";

            // Set the command to use
            api.CommandName = "check";

            // Set the authentication information
            api.Username = "resellid";
            api.Password = "resellpw";

            // Add any needed parameters 
            // If responsetype is not specified, the
            // wrapper defaults to XML
            api.AddParam("sld", "SecondLevelDomain");
            api.AddParam("tld", "com");

            api.ResponseType = "xml";

            if (api.Execute() && api.Errors.Count == 0)
            {
                // Call was successful, show the message
                Console.WriteLine(api.RawResponse);
            }
            else
            {
                // Executing the command failed or succeeded with errors
                foreach (string error in api.Errors)
                {
                    Console.WriteLine(error);
                }
            }

            // Wait for user input
            Console.WriteLine("Any key to exit...");
            Console.ReadKey();
        }
    }
}
