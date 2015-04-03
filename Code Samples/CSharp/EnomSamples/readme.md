# Enom Samples

These code examples all demonstrate ways to use the API without the EnomSimpleAPI wrapper for those of you who want to roll your own. Each one is a stand alone command line application with a focus on demonstration and clarifying comments.

These projects also are part of the EnomTools bundle, as each one has value as an application as well.

###Projects
  - DomainInfo: This project retrieves information for a domain and displays it to the screen
  - DomainLister: This application will retrieve a list of owned domains for the account
  - DomainRedirector: This application allows the user to point an owned domain at another location using a redirect host record
  - GetAndSetHosts: This application demonstrates how to update the host records of a domain, keeping existing host records intact
  - TLDDetails: This application demonstrates how to retrieve the details for a TLD (Top Level Domain) including registration, transfer and renewal policies
  
###Notes
- Each application has debugging configured to use the default (demo) credentials so you can run each one in debug mode and it will successfully execute the call against the resellertest.enom.com API
- For clarity, the base url for the API is hard coded in the source. This is a bad idea for your code :-)