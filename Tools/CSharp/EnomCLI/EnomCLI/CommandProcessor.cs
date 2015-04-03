

namespace Enom.Tools.EnomCLI
{
    using System;
    using System.Collections.Generic;
    using System.Linq;
    using System.Text;
    using System.Threading.Tasks;

    public class CommandProcessor
    {
        public void Run(string baseURL, string username, string password, string[] commandList, string responseType)
        {
            string input = string.Empty;

            ShowHelp();

            while (true)
            {                

                // Create the prompt
                Console.Write("enom>");
                input = Console.ReadLine().ToLower();
                
                // If the user types exit, close the command line
                if (input == "exit")
                {
                    return;
                }
                else if (input == "cls")
                {
                    Console.Clear();
                }
                else if (input == "help")
                {
                    ShowHelp();
                }
                else if (input.StartsWith("responsetype "))
                {
                    // User is changing the response type
                    string[] commands = input.Split(' ');
                    responseType = commands[1];
                }
                else
                {
                    // If we have a valid command line, process
                    if (!string.IsNullOrWhiteSpace(input))
                    {
                        // Verify this is a valid command
                        string commandName = input.Split(' ')[0];
                        if (!commandList.Contains(commandName))
                        {
                            Console.Write("Invalid command.\n");
                        }
                        else
                        {
                            try
                            {
                                // Build the URL
                                string url = EnomUtilities.BuildURL(input, username, password, baseURL, responseType);

                                // Load the result
                                string response = EnomUtilities.GetResponse(url);

                                if (responseType.ToLower() == "xml")
                                {
                                    // Display result to the screen with formatting
                                    Console.WriteLine(EnomUtilities.PrettyXml(response + Environment.NewLine));
                                }
                                else
                                {
                                    // Display result to the screen without formatting
                                    Console.WriteLine(response + Environment.NewLine);
                                }
                            }
                            catch (System.ApplicationException ae)
                            {
                                Console.WriteLine(ae.Message);
                            }
                            catch (System.Exception ex)
                            {
                                Console.WriteLine("Error: " + ex.Message);
                            }
                        }
                    }
                }
            }
        }

        private void ShowHelp()
        {
            Console.WriteLine("Enter in a command with arguments in the format of PARAMNAME=PARAMVALUE. \nOther commands available are: help, clear, responsetype [type] and exit.\n");
        }
    }
}
