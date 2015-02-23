An Introduction to the eNom Reseller Interface

eNom provides resellers with the ability to register names from their 
own web site in real time.  We provide a COM object for Windows users, 
Perl scriptand PHP for Unix and other users, as well as documentation 
for writing your own client interface if you need to.  This diagram 
shows the functionality of the system:


  +-------------+------------------+                +------------------+
  | Your Server |-ASP/COM Object   |<---INTERNET--->|   Our Reseller   |
  +-------------+-Perl script      |                | Interface Server |
        |       |-Custom client    |                +------------------+
        |       |Etc.              |                         |
    INTERNET    +------------------+                         |
        |                                            +---------------------+
  +---------------+                                  |  Our Domain Name    |
  |  Web Browser  |                                  | Registration System |
  | (Your Client) |                                  +---------------------+
  +---------------+

One thing to keep in mind is that the connection to the eNom server 
must always come from your server, not the client.  For this reason it 
is not allowable to do a FORM POST to our server from your web page.  
You need to create a connection in the background from a script on your 
server.

------------------------------------------------------------------------------
How to Set Up an Account With eNom

Follow this step by step process to create an account and set up your 
site to register domain names with eNom:

* Go to http://www.enom.com/ and set up a new account.  Then call us 
  to convert your account to a reseller account.

* Go to http://www.enom.com/resellers.asp.  Click on "Automated registration 
  software", then "Login to your account".  You will then be prompted to log 
  in using your eNom username and password.  After you log in click the 
  "Create an account" link, then "Setup your account on the testing server".  
  This will copy your account information to the test server.  Then click on 
  "Reset your account balance in the test environment to $5000" to be sure 
  that your test account has some funny money to test with.

* Access to both the test and live servers is restricted by IP.  Click on 
  the link "Add/Edit/Delete IP addresses that are allowed to access your 
  account on the test server" and enter the IP(s) of the server(s) that 
  will be connecting to eNom.  This will only effect the test environment.

* Look in the Contents.txt file to find the location of the software for 
  your system.

* When you have the sample site or your site up and running, test it by 
  using our test site as the server (use the host resellertest.enom.com).
  This softer uses the test server by default.

* When you are ready to go live with your site, change the server you are 
  connecting to from "resellertest.enom.com" to "reseller.enom.com".
  You can do this in the script EnomInterface_inc.php

* You will need to register the IP address(es) you will be connecting from 
  into our system. Please login to your enom account, click HELP - SUPPORT 
  CENTER and create a new case. One of our technical support will verify 
  and process the request within 24 hours.

------------------------------------------------------------------------------

Please read the file "Contents.txt" for the contents of this distribution.
