// <copyright file="program.cs" company="Rightside"> //
// Copyright (c) 2015 All Rights Reserved            // 
// </copyright>                                      //
// <author>Sean Ottey</author>                       //

namespace Enom.Tools.EnomCLI
{
    using System;
    using System.Linq;
    using System.Net;

    class Program
    {

        // http://www.codeproject.com/Articles/816301/Csharp-Building-a-Useful-Extensible-NET-Console-Ap

        public static void Main(string[] args)
        {
            try
            {
                string username = string.Empty;
                string password = string.Empty;
                string baseURL = string.Empty;
                string[] commandList;

                // Three Arguments are required: username, password and base url. If not there, ask for them
                if (args.Count() != 3)
                {
                    Console.Write("Usage: EnomCLI [username] [password] [baseurl]\n(Example BaseURL: 'https://resellertest.enom.com/interface.asp?command=' )\n");

                    username = EnomUtilities.GetValueFromUser("Username");
                    password = EnomUtilities.GetValueFromUser("Password");
                    baseURL = EnomUtilities.GetValueFromUser("BaseURL");
                }
                else
                {
                    username = args[0];
                    password = args[1];
                    baseURL = args[2];
                }

                // Set up SSL Support
                ServicePointManager.SecurityProtocol = SecurityProtocolType.Tls12;

                // Load up valid enom commands.   
                if (System.IO.File.Exists("CommandList.txt"))
                {
                    commandList = System.IO.File.ReadAllLines("CommandList.txt");
                }
                else
                {
                    commandList = EnomUtilities.GetInternalCommandList();
                }

                CommandProcessor processor = new CommandProcessor();
                processor.Run(baseURL, username, password, commandList, "xml");
            }
            catch(System.Exception ex)
            {
                Console.WriteLine("\nError encountered: " + ex.Message);
            }
        }
    }
}
