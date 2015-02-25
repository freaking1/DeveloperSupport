import logging
from urlparse import urlparse
from restkit.resource import Resource
import xml.etree.ElementTree as ET
from xml.etree.ElementTree import ParseError
import re

logger = logging.getLogger('service.enom')
error_logger = logging.getLogger('error.service.enom')
uri_sanitizer = re.compile(r'PW=.*?&|PW=.*?$', re.IGNORECASE)

# query parameter names
COMMAND = 'Command'
SLD = 'SLD'
TLD = 'TLD'
SLD1 = 'SLD1'
TLD1 = 'TLD1'
EmailEPP = 'EmailEPP'
RunSynchAutoInfo = 'RunSynchAutoInfo'
QUEUE_NAME1 = 'QName1'
PRODUCT_TYPE = 'ProductType'
USE_DNS = 'UseDNS'
NumYears = 'NumYears'

# xml element names
DOMAIN_NAME = 'DomainName'
DOMAIN_DELETED = 'DomainDeleted'


class EnomEntityConverter():

    """
    Helper that converts data, such as contacts,
    from jetlaunch JSON dict to enom GET parameters, and
    from enom XML response to jetlaunch JSON dict
    """

    MAPPING_CONTACT_TYPE_JSON_TO_ENOM = {
        'billing': 'AuxBilling',
        'account_billing': 'Billing',
        'admin': 'Admin',
        'tech': 'Tech',
        'registrant': 'Registrant'
    }
    MAPPING_JSON_TO_ENOM = {
        'organization': 'Organization',
        'job_title': 'JobTitle',
        'first_name': 'FirstName',
        'last_name': 'LastName',
        'address_1': 'Address1',
        'address_2': 'Address2',
        'city': 'City',
        'postal_code': 'PostalCode',
        'state_province': 'StateProvince',
        'state_province_choice': 'StateProvinceChoice',
        'country': 'Country',
        'full_country': 'FullCountry',
        'email_address': 'EmailAddress',
        'phone': 'Phone',
        'phone_ext': 'PhoneExt',
        'fax': 'Fax',
    }
    MAPPING_JSON_TO_ENOM_SUBACCOUNT = {
        'organization': 'OrgName',
        'job_title': 'RoleTitle',
        'first_name': 'FName',
        'last_name': 'LName',
        'address_1': 'Address1',
        'address_2': 'Address2',
        'city': 'City',
        'postal_code': 'PostalCode',
        'state_province': 'StateProvince',
        'state_province_choice': 'StateProvinceChoice',
        'country': 'Country',
        'full_country': 'FullCountry',
        'email_address': 'EmailContact',
        'phone': 'Phone',
        'phone_ext': 'PhoneExt',
        'fax': 'Fax',
    }
    MAPPING_JSON_TO_ENOM_SUBACCOUNT_UPD = {
        'organization': 'OrganizationName',
        'job_title': 'JobTitle',
        'first_name': 'Fname',
        'last_name': 'Lname',
        'address_1': 'Address1',
        'address_2': 'Address2',
        'city': 'City',
        'postal_code': 'PostalCode',
        'state_province': 'StateProvince',
        'state_province_choice': 'StateProvinceChoice',
        'country': 'Country',
        'full_country': 'FullCountry',
        'email_address': 'EmailAddress',
        'phone': 'Phone',
        'phone_ext': 'PhoneExt',
        'fax': 'Fax',
    }
    MAPPING_ENOM_TO_JSON = dict((v, k) for k, v in MAPPING_JSON_TO_ENOM.iteritems())
    CONTACT_TYPES_JSON = set(MAPPING_CONTACT_TYPE_JSON_TO_ENOM.keys())
    CONTACT_TYPES = ['registrant', 'billing', 'admin', 'tech']  #  preferred order in which contact to use as default
    ALL_CONTACT_FIELDS_JSON = set(MAPPING_JSON_TO_ENOM.keys())
    CORE_CONTACT_FIELDS_JSON = set(['first_name', 'last_name', 'address_1', 'city', 'postal_code', 'country', 'email_address', 'phone'])
    UN_CAMEL_CASE = re.compile(r'(?!^)([A-Z]+)')

    # price type mapping - first item is the regular domain product type, the second is the premium product type
    PRICE_TYPE_MAPPING = {'register': ('10', 'Register'), 'renew': ('16', 'Renew'), 'transfer': ('19', 'Transfer')}
    ALLOWED_PRICE_TYPES = PRICE_TYPE_MAPPING.keys()

    def __init__(self):
        pass

    def _json(self, enom):
        if enom not in EnomEntityConverter.MAPPING_ENOM_TO_JSON:
            raise ValueError('Enom property {enom} has not been mapped to JSON'.format(enom=enom))
        return EnomEntityConverter.MAPPING_ENOM_TO_JSON.get(enom)

    def _enom(self, json):
        if json not in EnomEntityConverter.MAPPING_JSON_TO_ENOM:
            raise ValueError('JSON property {json} has not been mapped to enom'.format(json=json))
        return EnomEntityConverter.MAPPING_JSON_TO_ENOM.get(json)

    def _to_string(self, collection):
        return ', '.join([str(item) for item in collection])

    def is_valid_price_type(self, price_type):
        return price_type and price_type.lower() in EnomEntityConverter.ALLOWED_PRICE_TYPES

    def get_product_type(self, price_type, is_premium):
        product_types = EnomEntityConverter.PRICE_TYPE_MAPPING.get(price_type.lower())
        return product_types[int(is_premium)]

    def get_subaccount_contact_as_json(self, enom_response):
        contact = self.get_contact_as_json(enom_response,
                                       'SubAccountsManage',
                                       EnomEntityConverter.MAPPING_JSON_TO_ENOM_SUBACCOUNT)
        ##FIXME Added this b/c enom error: "You must use 'S' for RegistrantStateProvinceChoice to have USA as your country"
        ##FIXME Reason is that GetSubaccountsDetail does not return StateProvinceChoice
        if contact.get('state_province_choice') is None:
            contact['state_province_choice'] = 'S' if contact['country'] == 'US' else 'P'
        return contact

    def get_contact_as_json(self, enom_reponse, xpath, mapping):
        """
        Take the enom subaccount contact response and convert it to a JSON dict
        """
        contact = enom_reponse.find(xpath)
        json_contact = {}
        if contact is not None:
            for json_field, enom_field in mapping.iteritems():
                tag_name = enom_field
                tag = contact.find(tag_name)
                if tag is None:
                    json_contact[json_field] = None
                    logger.debug('Missing tag: ' + tag_name)
                else:
                    json_contact[json_field] = tag.text
        return json_contact

    def get_contacts_as_json(self, enom_response):
        """
        Take the enom contact response and convert it to a JSON dict
        """
        json_contacts = {}
        for json_type, enom_type in EnomEntityConverter.MAPPING_CONTACT_TYPE_JSON_TO_ENOM.iteritems():
            contact = enom_response.find('GetContacts/{enom_type}'.format(enom_type=enom_type))
            if contact is not None:
                json_contact = {}
                for json_field, enom_field in EnomEntityConverter.MAPPING_JSON_TO_ENOM.iteritems():
                    tag_name = enom_type + enom_field
                    tag = contact.find(tag_name)
                    if tag is None:
                        json_contact[json_field] = None
                        logger.debug('Missing tag: ' + tag_name)
                    else:
                        json_contact[json_field] = tag.text
                json_contacts[json_type] = json_contact
        return json_contacts

    def get_contacts_as_enom_parameters(self, contacts_json):
        """
        Take the contact JSON dict and convert it to eNom API parameter naming convention
        e.g. { "admin": { "first_name": "Steve" } } becomes { "AdminFirstName": "Steve"}
        """
        enom_parameters = {}
        for contact_type, contact in contacts_json.iteritems():
            enom_type = EnomEntityConverter.MAPPING_CONTACT_TYPE_JSON_TO_ENOM[contact_type]
            for field, value in contact.iteritems():
                tag_name = enom_type + self._enom(field)
                enom_parameters[tag_name] = value
        return enom_parameters

    def validate_contacts(self, contacts_json):
        """
        Validate the contact json structure
        """
        if not contacts_json:
            raise ValueError('No contacts provided')
        invalid_contact_types = set(contacts_json.keys()) - EnomEntityConverter.CONTACT_TYPES_JSON
        if invalid_contact_types:
           raise ValueError('Unsupported contact type(s): {contacts}'.format(contacts=self._to_string(invalid_contact_types)))
        for contact_type, contact in contacts_json.iteritems():
            try:
                self.validate_contact(contact)
            except ValueError as ve:
                raise ValueError('Error in {0}: {1}'.format(contact_type, ve.message))
        return True

    def validate_contact(self, contact):
        fields = set(contact.keys())
        invalid_fields = fields - EnomEntityConverter.ALL_CONTACT_FIELDS_JSON
        if invalid_fields:
            raise ValueError('Unsupported field(s): {fields}'.format(
                fields=self._to_string(invalid_fields)))
        missing_core_fields = EnomEntityConverter.CORE_CONTACT_FIELDS_JSON.difference(fields)
        if missing_core_fields:
            raise ValueError('Missing core field(s): {fields}'.format(
                    fields=self._to_string(missing_core_fields)))
        for core_field in EnomEntityConverter.CORE_CONTACT_FIELDS_JSON:
            value = contact[core_field]
            if value is None or not unicode(value):
                raise ValueError('Required field {field} is empty'.format(field=core_field))

    def get_contacts_difference(self, base_contacts_json, new_contacts_json):
        """
        Find the differences (changes) between the base and the version of the contacts_json structures
        Only return dict{ contact_type : { field, values} } for values that are different
        """
        diff = {}
        new_contact_types = set(new_contacts_json) - set(base_contacts_json)
        # new, unique contact types
        for new_contact_type in new_contact_types:
            diff[new_contact_type] = new_contacts_json.pop(new_contact_type)
        for contact_type, contact in new_contacts_json.iteritems():
            diff_contact = {}
            base_contact = base_contacts_json[contact_type]
            # does NOT support nested dicts
            for field, value in contact.iteritems():
                if value != base_contact.get(field):
                    diff_contact[field] = value
            diff[contact_type] = diff_contact
        return diff

    def get_xml_as_json(self, xml):
        _json = {}
        # create json structure
        if xml is not None:
            for element in xml:
                _json[self.un_camel_case(element.tag)] = element.text
        return _json

    def get_host_records_as_json(self, enom_response):
        enom_host_records = enom_response.find('host', True)
        host_records = []
        # create json structure
        for enom_host_record in enom_host_records:
            host_record = {}
            for element in enom_host_record:
                if element.tag != 'hostid':
                    host_record[element.tag] = element.text
            host_records.append(host_record)
        return host_records

    def get_domain_data_as_json(self, enom_response):
        entered_by = enom_response.text('CustomerData/EnteredBy')
        value = enom_response.text('CustomerData/Value')
        # TODO: convert last_updated to a datetime
        last_updated = enom_response.text('CustomerData/LastUpdatedDate')
        return dict(entered_by=entered_by, value=value, updated_at=last_updated)

    def un_camel_case(self, text):
        return EnomEntityConverter.UN_CAMEL_CASE.sub(r'_\1', text).lower()

    def sanitize_uri(self, uri):
        return uri_sanitizer.sub('PW=xxxxx&', uri)

    def get_default_contact(self, json_contacts):
        default_contact = None
        for contact_type in EnomEntityConverter.CONTACT_TYPES:
            default_contact = json_contacts.get(contact_type)
            if default_contact:
                break
        return default_contact

    def get_registrant(self, default_contact):
        registrant_json = {'registrant': default_contact}
        registrant = self.get_contacts_as_enom_parameters(registrant_json)
        return registrant

    def set_missing_contacts(self, json_contacts, default_contact):
        for contact_type in EnomEntityConverter.CONTACT_TYPES_JSON - set(json_contacts.keys()):
            json_contacts[contact_type] = default_contact


class EnomAPIError(StandardError):
    pass


class EnomAPIResponse():
    """
    Generic handling of the XML response from the enom API
    """
    def __init__(self, response):
        self.success = response.status_int == 200
        self.message = response.status  # or response.body_string()
        if not self.success:
            # http error
            return
        try:
            xml = response.body_string()
            self._root = ET.fromstring(xml)
            self._errors = []
            self.success = self.text('ErrCount') == '0'
            # enom api error
            if not self.success:
                for element in self.find('errors'):
                    self._errors.append(element.text)
                    self.message = ', '.join(self._errors)
        except ParseError as p:
            # parse error
            self.success = False
            self.message = p.message.message

    def __repr__(self):
        return ET.tostring(self._root)

    def __getitem__(self, item):
        return self.text(item)

    def __nonzero__(self):
        return self.success

    def text(self, element_tag):
        """
        Return the text for the first element that matches the element_tag
        """
        element = self._root.find(element_tag)
        return element.text if element is not None else None

    def find(self, element_tag, all=False):
        """
        Return the first element (all=False) or all elements (all=True) that matches the element_tag
        """
        if not element_tag:
            return self._root
        if all:
            return self._root.findall(element_tag)
        return self._root.find(element_tag)

    @property
    def rrp_code(self):
        return self.text('RRPCode')

    @property
    def rrp_text(self):
        return self.text('RRPText')


class EnomDomainAPIClient():
    """
    Wraps core Commands from the Enom API
    All methods returns an instance of EnomAPIResponse or raises an EnomAPIError

    Please note that it is NOT possible to use subaccount credentials when creating an instance.
    The reason is that Enom does not permit a retail subaccount to use the API. This error will result:
      "User not permitted from this IP address - 4"

    This error will also occur when your external IP address has not been whitelisted by Enom.
    The solution is to contact Enom support (or dev Ron West) and add your public IP.
    Here is an example for the UPDATEACCOUNTINFO command:

        <StatusEditContact>Successful</StatusEditContact>
        <StatusDetailEditContact>Successfully updated</StatusDetailEditContact>
        <PendingVerification />
        <Command>UPDATEACCOUNTINFO</Command>
        <APIType>API</APIType>
        <Language>eng</Language>
        <ErrCount>2</ErrCount>
        <errors>
        <Err1>User not permitted from this IP address - 4</Err1>
        <Err2>Account not found in database.</Err2>
        ...
    """
    def __init__(self, test=True, user='USERNAME', password='PASSWORD'):
        self.test = test
        if self.test:
            self.server = 'resellertest.enom.com'
        else:
            self.server = 'reseller.enom.com'
        self._user = user
        self._password = password
        self._base_uri = 'https://{server}/interface.asp'.format(server=self.server)
        self._base_parameters = {'UID': self._user, 'PW': self._password, 'ResponseType': 'XML'}
        self._resource = Resource(self._base_uri)
        self._converter = EnomEntityConverter()

    def _all_params(self, params):
        # create a new dictionary so we do not expose the credentials (in self.base_parameters) in "params"
        all_params = dict(params)
        all_params.update(self._base_parameters)
        return all_params

    def _get_response(self, params):
        response = self._resource.get(params_dict=self._all_params(params))
        sanitized_uri = self._converter.sanitize_uri(response.final_url)
        logger.info('GET %s: %s', params[COMMAND].upper(), sanitized_uri)
        enom_response = EnomAPIResponse(response)
        enom_response.request = sanitized_uri
        # log at the appropriate level
        if not enom_response:
            logger.error('Response %s: %s', enom_response.text('Command'), enom_response.message)
            # dump the xml response to the error log
            error_logger.error('Response body: %s', enom_response)
            error = EnomAPIError(enom_response.message)
            error.response = enom_response
            raise error
        logger.info('Response %s: %s', enom_response.text('Command'), enom_response.message)
        logger.debug('Response body: %s', enom_response)
        return enom_response

    def _get(self, command, sld, tld, **kwargs):
        parameters = {COMMAND: command, SLD: sld, TLD: tld}
        parameters.update(kwargs)
        return self._get_response(parameters)

    def to_domain(self, sld, tld):
        return sld + '.' + tld

    def to_sld_tld(self, domain):
        # if there is no dot, treat the domain as the sld
        if not '.' in domain:
            return domain, None
        # split on the first dot. Will handle xyz.co.uk correctly.
        return domain.split('.', 1)

    def suggestions(self, search_term, tld):
        """
        Checks for name suggestions based on a search term
        """
        parameters = {COMMAND: 'GetNameSuggestions', 'SearchTerm': search_term, 'MaxResults': 200}
        response = self._get_response(parameters)
        suggestions = []
        if response:
            for suggestion in response.find('DomainSuggestions/Domain', True):
                # TODO: Add a threshold score?
                if not tld or suggestion.attrib.get('tld') == tld:
                    suggestions.append(suggestion.text)
        response.suggestions = suggestions
        return response

    def is_available_domain_list(self, domains):
        """
        Checks if multiple domains are available
          domains is a list of domains to check
        """
        parameters = {COMMAND: 'Check', 'DomainList': ','.join(domains)}
        response = self._get_response(parameters)
        domain_count = int(response.text('DomainCount'))
        domain_availability = []
        for domain_index in range(1, domain_count + 1):
            index = str(domain_index)
            domain = {
                'domain': response.text('Domain'+index),
                'available': response.text('RRPCode'+index) == '210',
                'message': response.text('RRPText'+index),
                'is_premium': response.text('IsPremiumName'+index) == 'true'}
            domain_availability.append(domain)
        response.domain_availability = domain_availability
        return response

    def is_available(self, sld, tld):
        """
        Checks if a domain is available for purchase
        """
        parameters = {COMMAND: 'Check', SLD: sld, TLD: tld}
        response = self._get_response(parameters)
        rrp_code = response.rrp_code
        rrp_text = response.rrp_text
        response.is_premium = response.text('IsPremiumName') == 'true'
        response.price = response.text('PremiumPrice')
        response.registration_fee = response.text('RegistrationFee')
        if rrp_code == '210':
            response.message = rrp_text
        elif rrp_code == '211':
            response.success = False
            response.message = rrp_text
        else:
            response.success = False
            domain = response[DOMAIN_NAME]
            response.message = 'Domain "{domain}" not available: {text} ({code})'.format(
                domain=domain, code=rrp_code, text=rrp_text)
        return response

    def get_price(self, sld, tld, price_type):
        """
        Get the price for a domain (response.price)
        Valid price_type values are: register, renew, transfer
        Returns:
            response.is_premium
            response.price
            response.registration_fee
        """
        if not self._converter.is_valid_price_type(price_type):
            raise EnomAPIError('Price type "%s" not supported. Supported values: %s' % (price_type, ','.join(self._converter.ALLOWED_PRICE_TYPES)) )
        product_type = self._converter.get_product_type(price_type, True)
        parameters = {COMMAND: 'PE_GetPremiumPricing', PRODUCT_TYPE: product_type, SLD1: sld, TLD1: tld}
        response = self._get_response(parameters)
        is_premium = response.text('results/result/IsPremium').lower() == 'true'
        if is_premium:
            response.is_premium = is_premium
            response.price = response.text('results/result/Price')
            response.registration_fee = response.text('results/result/RegistrationFee')
            # response.message = response.rrp_text
        else:
            # retrieve registration fee for non-premium domains
            product_type = self._converter.get_product_type(price_type, False)
            parameters = {COMMAND: 'PE_GetRetailPrice', TLD: tld, 'ProductType': product_type}
            response = self._get_response(parameters)
            # populate response
            response.is_premium = False
            price = response.text('productprice/price')
            response.price = price
            response.registration_fee = price
        return response

    def renew(self, sld, tld, price=None):
        """
        Renews the domain. If it is a premium domain, a price must be supplied.
        Returns more information about the renewal in
            response.expiration_date
            response.order_ref
        """
        parameters = {COMMAND: 'Extend', SLD: sld, TLD: tld}
        domain = self.to_domain(sld, tld)
        if price:
            parameters['CustomerSuppliedPrice'] = str(price)
        response = self._get_response(parameters)
        response.expiration_date = response.text('DomainInfo/RegistryExpDate')
        response.order_ref = response.text('OrderID')
        if response.rrp_code == '200':
            response.success = True
            response.message = 'Domain "{domain}" was successfully renewed'.format(domain=domain)
        else:
            response.success = False
            response.message = 'Domain "{domain}" not be renewed: {text} ({code})'.format(
                domain=domain, code=response.rrp_code, text=response.rrp_text)
        return response

    def register(self, sld, tld, contacts_json=None, price=None):
        """
        Purchases and registers the domain. If it is a premium domain, a price must be supplied.
        Returns more information about the purchase in response.purchase
        """
        parameters = {COMMAND: 'Purchase', SLD: sld, TLD: tld, USE_DNS: 'default', NumYears: 1}
        domain = self.to_domain(sld, tld)
        if price:
            parameters['CustomerSuppliedPrice'] = str(price)
        if contacts_json:
            parameters.update(self._converter.get_contacts_as_enom_parameters(contacts_json))
        response = self._get_response(parameters)
        response.total_amount = response.text('TotalCharged')
        response.order_ref = response.text('OrderID')
        if response.rrp_code == '200':
            response.success = True
            response.message = 'Domain "{domain}" was successfully purchased'.format(domain=domain)
        else:
            # error: Domain not available
            # error: price is wrong (does not match)
            response.success = False
            response.message = 'Domain "{domain}" not purchased: {text} ({code})'.format(
                domain=domain, code=response.rrp_code, text=response.rrp_text)
        renew = self.set_auto_renew(sld, tld, False)
        return response

    def delete(self, sld, tld):
        """
        Deletes a domain registration
        Only allowed for test mode right now. Can be used for for unit testing
        NOTE: Deleting a domain is not always possible, for various reasons, example:
              "This domain's TLD is not allowed to be deleted." (.menu)
              Deletion needs to be done asap after creation, and prior to moving it to a subaccount
        """
        if not self.test:
            # For now, raise EnomAPIError()
            # TODO: return EnomAPIResponse?
            raise EnomAPIError('Delete Domain not implemented')
        parameters = {COMMAND: 'DeleteRegistration', SLD: sld, TLD: tld}
        response = self._get_response(parameters)
        response.message = response.rrp_text
        response.success = response.rrp_code == '200'
        return response

    def get_domain(self, sld, tld):
        """
        Get status information about the domain (response.status)
        Get verification information about the domain (response.verification)
        Raises EnomAPIError if the domain does not exist
        """
        parameters = {COMMAND: 'GetDomainInfo', SLD: sld, TLD: tld}
        response = self._get_response(parameters)
        response.status = self._converter.get_xml_as_json(response.find('GetDomainInfo/status'))
        response.verification = self._converter.get_xml_as_json(response.find('GetDomainInfo/services/entry/raasetting'))
        return response

    def get_account(self):
        """
        Get account information
        """
        parameters = {COMMAND: 'GetAccountInfo'}
        response = self._get_response(parameters)
        response.account_id = response.text('GetAccountInfo/Account')
        return response

    def get_subaccount(self, account_id):
        """
        Get subaccount information
        The contact information is returned as a contact dict in response.contact
        If the subaccount does not exist response.success is False
        """
        parameters = {COMMAND: 'GetSubaccountDetails', 'Account': account_id, 'Action': 'Info'}
        response = self._get_response(parameters)
        if response.find('SubAccountsManage/SubAccount') is None:
            response.success = False
            response.message = 'Could not find subaccount "{0}"'.format(account_id)
            response.contact = {}
        else:
            response.contact = self._converter.get_subaccount_contact_as_json(response)
        return response

    def add_subaccount(self, username, password, contacts_json):
        """
        Create a new subaccount that is accessed by the supplied username and password
        The registrant information from the contacts_json parameters is used as account owner
        The account_id for the new account is returned as response.account_id
        Error condition: (raises EnomAPIError): duplicate username (account already exists)
        """
        parameters = {COMMAND: 'CreateSubAccount', 'NewUID': username, 'NewPW': password, 'ConfirmPW': password}
        default_contact = self._converter.get_default_contact(contacts_json)
        parameters.update(self._converter.get_registrant(default_contact))
        response = self._get_response(parameters)
        response.account_id = response.text('NewAccount/Account')
        # TODO: This is the same contact that the user supplied, NOT what Enom has in its database
        response.contact = default_contact
        return response

    def update_subaccount(self, username, new_password, contacts_json):
        """
        Updates an existing subaccount with new password and new registrar contact information
        The account_id for the account is returned as response.account_id
        The contact for the account is returned as response.contact
        """
        parameters = {COMMAND: 'UpdateAccountInfo',
                      'NewUID': username,
                      'NewPW': new_password,
                      'ConfirmNewPW': new_password,
                      'AuthQuestionType': 'sbirth',
                      'AuthQuestionAnswer': 'nothere'}
        default_contact = self._converter.get_default_contact(contacts_json)
        parameters.update(self._converter.get_registrant(default_contact))
        response = self._get_response(parameters)
        response.account_id = response.text('GetAccountInfo/Account')
        response.contact = self._converter.get_contact_as_json(response,
                                                               None,
                                                               EnomEntityConverter.MAPPING_JSON_TO_ENOM_SUBACCOUNT_UPD)
        return response

    def move_domain_to_subaccount(self, sld, tld, username='Jetlaunch'):
        """
        Move a domain from its current account to the specified subaccount (username)
        If no username is specified, it moves it to the main account (Jetlaunch)
        """
        parameters = {COMMAND: 'PushDomain', SLD: sld, TLD: tld, 'AccountID': username, 'SendEmail':'No'}
        response = self._get_response(parameters)
        return response

    def get_subaccount_domains(self, account_id):
        """
        Get a list of all domains in this subaccount: response.domains
        """
        parameters = {COMMAND: 'SubAccountDomains', 'Account': account_id, 'Tab': 'iown'}
        response = self._get_response(parameters)
        response.domains = []
        for domain in response.find('GetDomains/domain-list/domain', True):
            sld = domain.find('sld').text
            tld = domain.find('tld').text
            response.domains.append(self.to_domain(sld, tld))
        return response

    def soft_delete_subaccount(self, account_id):
        """
        Soft delete the subdomain with the specified account_id
        All domains in the subaccount are set to not auto renew,
        and a 'status' flag on the domain is set to 'deleted'
        and a 'status' flag on the subaccount is set to 'deleted'
        """
        domains_response = self.get_subaccount_domains(account_id)
        for domain in domains_response.domains:
            self.soft_delete_domain(domain)
        return domains_response

    def soft_delete_domain(self, domain):
        """
        Soft delete the domain
        Set auto renew to False and set status=deleted on the domain
        """
        sld, tld = self.to_sld_tld(domain)
        # turn off auto renew
        renew = self.set_auto_renew(sld, tld, False)
        set_status = self.set_custom_domain_data(sld, tld, 'status', 'deleted')
        logger.info('Soft deleted %s', domain)
        return set_status

    def set_host_records(self, sld, tld, host_records):
        """
        Set the host records for a domain
        sld, tld: The host and domain name (host.sld.tld) that you want to update in the DNS. For example, www.resellerdocs.com
        host_records is a list of dictionaries with these keys:
            name: subdomain (e.g. www, *, ...)
            type: The record type (A, AAAA, CNET etc.)
            ip: The IP address to set the host record to.
        """
        if host_records is None or len(host_records) == 0:
            raise EnomAPIError('Cannot set host records: Missing hosts')
        parameters = {COMMAND: 'SetHosts', SLD: sld, TLD: tld}
        for index, host_record in enumerate(host_records, 1):
            host_type = host_record.get('type')
            host_address = host_record.get('address')
            # append dot if domain
            if host_type.lower() == 'url':
                scheme = urlparse(host_address).scheme
                if not scheme:
                    # scheme empty for domain and ip. Its http or https.
                    try:
                        isinstance(host_address.split('.')[0], int)
                    except ValueError:
                        # its domain
                        if not host_address.endswith('.'):
                            host_address = host_address + '.'
                else:
                    pass
            parameters.update({'RecordType' + str(index): host_type,
                               'HostName' + str(index): host_record.get('name'),
                               'Address' + str(index): host_address})
        response = self._get_response(parameters)
        response.message = 'Successfully set {count} host record(s) for "{sld}.{tld}"'.format(count=len(host_records),
                                                                                              sld=sld, tld=tld)
        return response

    def get_host_records(self, sld, tld):
        """
        Get the host records for a domain
        """
        parameters = {COMMAND: 'GetHosts', SLD: sld, TLD: tld}
        response = self._get_response(parameters)
        host_records = self._converter.get_host_records_as_json(response)
        response.host_records = host_records
        return response

    def set_name_servers(self, sld, tld, name_servers=[], default=False):
        """
        Set the name servers for a domain
          default = True sets it to eNoms name servers
          name_servers = None or [] sets it to no name server
          name_servers = ['ns1.nameserver.com', ...]  sets it to the user specified name servers
        """
        parameters = {COMMAND: 'ModifyNS', SLD: sld, TLD: tld}
        if default:
            parameters['UseDNS'] = 'Default'
        if not name_servers:
            parameters['NS1'] = None
        else:
            for index, name_server in enumerate(name_servers, start=1):
                parameters['NS'+str(index)] = name_server
        response = self._get_response(parameters)
        if response.rrp_code == '200':
            ns = 'default' if default else name_servers
            response.message = 'Successfully set "{sld}.{tld}" name server to {ns}'.format(sld=sld, tld=tld, ns=ns)
        return response

    def get_name_servers(self, sld, tld):
        """
        Get the name servers for a domain (response.name_servers)
        """
        parameters = {COMMAND: 'GetDNS', SLD: sld, TLD: tld}
        response = self._get_response(parameters)
        if response.text('RRPCodeGDNS') != '200':
            response.message = response.rrp_text
            response.success = False
            response.name_servers = []
            return response

        response.default = response.text('UseDNS') == 'default'
        dns = response.find('dns', True)
        if dns is None:
            response.name_servers = []
        else:
            name_servers = []
            for name_server in dns:
                name_servers.append(name_server.text)
            response.name_servers = name_servers
        return response

    def get_contacts(self, sld, tld):
        """
        Retrieve all contacts (response.contacts)
        """
        parameters = {COMMAND: 'GetContacts', SLD: sld, TLD: tld}
        response = self._get_response(parameters)
        json = self._converter.get_contacts_as_json(response)
        # remove the account billing address
        json.pop('account_billing', None)
        response.contacts = json
        return response

    def set_contacts(self, sld, tld, contacts_json):
        """
        Save contact information for registrant, admin, tech and aux billing in enom
        """
        # FOR NOW - DO NOT ALLOW UPDATING MAIN ACCOUNT BILLING ADDRESS
        # THERE IS ONLY ONE FOR ALL DOMAINS, IT USES 'UpdateAccountInfo'
        contacts_json.pop('account_billing', None)
        try:
            self._converter.validate_contacts(contacts_json)
        except ValueError as v:
            raise EnomAPIError(v.message)
        # billing (AuxBilling) is the billing contact at a domain level
        parameters = {COMMAND: 'Contacts', SLD: sld, TLD: tld}
        enom_parameters = self._converter.get_contacts_as_enom_parameters(contacts_json)
        parameters.update(enom_parameters)
        response = self._get_response(parameters)
        return response

    def set_custom_domain_data(self, sld, tld, key, value, entered_by=None):
        """
        Associate a key-value pair to the domain (sld, tld)
        entered_by is the person who set it - TBD
        """
        parameters = {COMMAND: 'SetCustomerDefinedData', 'ObjectID': '1', SLD: sld, TLD: tld,
                      'Type': '2', 'DisplayFlag': '0', 'EnteredBy': entered_by, 'Key': key, 'Value': value}
        response = self._get_response(parameters)
        return response

    def get_custom_domain_data(self, sld, tld, key):
        """
        Get the key-value pair associated
        with this domain (response.custom_data)
        """
        parameters = {COMMAND: 'GetCustomerDefinedData', 'ObjectID': '1', SLD: sld, TLD: tld,
                      'Type': '2', 'Key': key}
        response = self._get_response(parameters)
        if response:
            data = self._converter.get_domain_data_as_json(response)
            data['key'] = key
            if data['updated_at'] is not None:
                response.custom_data = data
            else:
                # return an empty dictionary if the key entry does not exist
                response.custom_data = {}
        return response

    def set_custom_account_data(self, key, value, entered_by=None):
        """
        Associate a key-value pair to the account
        entered_by is the person who set it - TBD
        """
        parameters = {COMMAND: 'SetCustomerDefinedData', 'ObjectID': '1',
                      'Type': '1', 'DisplayFlag': '0', 'EnteredBy': entered_by,
                      'Key': key, 'Value': value}
        response = self._get_response(parameters)
        return response

    def get_custom_account_data(self, key):
        """
        Get the key-value pair associated
        with this account (response.custom_data):
            response.custom_data['key']
            response.custom_data['value']
            response.custom_data['updated_at']
            response.custom_data['entered_by']

        Returns an empty dictionary if the key entry does not exist
        """
        parameters = {COMMAND: 'GetCustomerDefinedData', 'ObjectID': '1',
                      'Type': '1', 'Key': key}
        response = self._get_response(parameters)
        if response:
            data = self._converter.get_domain_data_as_json(response)
            data['key'] = key
            if data['updated_at'] is not None:
                response.custom_data = data
            else:
                # return an empty dictionary if the key entry does not exist
                response.custom_data = {}
        return response

    def set_auto_renew(self, sld, tld, auto_renew):
        """
        Set flag for domain auto-renewal; True if set for auto renewal, False otherwise
        response.auto_renew contains the latest flag value
        """
        parameters = {COMMAND: 'SetRenew', SLD: sld, TLD: tld, 'RenewFlag': int(bool(auto_renew))}
        response = self._get_response(parameters)
        response.success = bool(response.text('Success'))
        response.auto_renew = response.text('RenewName') == 'True'
        return response

    def get_auto_renew(self, sld, tld):
        """
        Get flag for domain auto-renewal
        response.auto_renew is True if set for auto-renewal, False otherwise.
        """
        parameters = {COMMAND: 'GetRenew', SLD: sld, TLD: tld}
        response = self._get_response(parameters)
        response.auto_renew = bool(int(response.text('auto-renew')))
        return response

    def set_lock(self, sld, tld, lock):
        """
        Set flag for domain lock; set lock = True if protected from being transferred to another registrar, False otherwise
        response.locked contains the latest flag value
        """
        # if lock=None is passed in (it shouldn't), it is interpreted as False
        parameters = {COMMAND: 'SetRegLock', SLD: sld, TLD: tld, 'UnlockRegistrar': int(not lock)}
        try:
            response = self._get_response(parameters)
        except EnomAPIError as e:
            response = e.response
            # 541 means that we tried to unlock when it is already unlocked (reg-lock='ACTIVE')
            if response.rrp_code != '541':
                raise e
        response.success = True
        response.locked = response.text('reg-lock') == 'REGISTRAR-LOCK'
        return response

    def get_lock(self, sld, tld):
        """
        Get flag for domain lock;
        response.locked is True if the domain is protected from being transferred to another registrar, False otherwise
        """
        parameters = {COMMAND: 'GetRegLock', SLD: sld, TLD: tld}
        response = self._get_response(parameters)
        response.locked = bool(int(response.text('reg-lock')))
        return response

    def synch_auth_info(self, sld, tld, email_epp=True, run_synch_auto_info=True):
        """
        Synch auth information for a domain
        response.done is True if the Synch is completed.
        """
        parameters = {COMMAND: 'SynchAuthInfo',
                      SLD: sld,
                      TLD: tld,
                      EmailEPP: email_epp,
                      RunSynchAutoInfo: run_synch_auto_info
                      }
        response = self._get_response(parameters)
        response.done = response.text('Done') == 'true'
        response.message = "Synchronized and mailed EPP successfully."
        return response

    def get_domain_status(self, sld, tld):
        """
        To get the status of domains.
        """
        parameters = {COMMAND: 'statusdomain', SLD: sld, TLD: tld}
        response = self._get_response(parameters)
        response.error_count = int(response.text('ErrCount'))
        if response.error_count:
            response.errors = self._converter.get_xml_as_json(response.find('errors'))
        response.rrp_code = int(response.text('RRPCode'))
        response.in_account = int(response.text('DomainStatus/InAccount')) == 1
        response.done = response.text('Done') == 'true'
        return response