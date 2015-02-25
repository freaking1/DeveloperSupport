// <copyright file="Program.cs" company="Rightside">
// Copyright (c) 2015 All Rights Reserved
// </copyright>
// <author>Sean Ottey</author>
// <email>sean.ottey@rightside.rocks</email>

namespace Enom.Tools.API.APITester
{
    using Enom.Tools.API;
    using System;

    class Program
    {
        static void Main(string[] args)
        {
            // // Default constructor
            //EnomAPI enomApi = new EnomAPI();
            //enomApi.CommandName = "check";
            //enomApi.BaseURL = "https://resellertest.enom.com/interface.asp?";
            //enomApi.Username = "USERNAME";
            //enomApi.Password = "PASSWORD";
            
            // Populating Constructor
            EnomAPI enomApi = new EnomAPI("https://resellertest.enom.com/interface.asp?", "USERNAME", "PASSWORD", "check");

            // Add parameters
            enomApi.AddParam("sld", "sean");
            enomApi.AddParam("tld", "com");
            enomApi.ResponseType = "xml";
            
            // Execute the call
            enomApi.Execute();

            // Display any errors
            if (enomApi.Errors.Count > 0)
            {
                Console.WriteLine("{0} Error(s) returned: ", enomApi.Errors.Count);
                foreach (string error in enomApi.Errors)
                {
                    Console.WriteLine(error);
                }
            }

            // Display the raw result
            Console.WriteLine("\nRaw Result: ");
            Console.Write(enomApi.RawResponse);

            // Wait for use input
            Console.ReadLine();
        }
    }
}
